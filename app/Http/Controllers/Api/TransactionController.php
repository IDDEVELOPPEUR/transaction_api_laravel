<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function depot(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'montant'=>['required']
        ]);
        if ($request->montant<500) {
            return response()->json([
                "Erreur de montant"=>"Attention, le montant doit être suppérieux ou égal à 500 f !",
                'guide'=>"Mettez solde suppérieur à 400 f"
            ],404);
        }


        $user=User::where('id',$request->user_id)->first();
       
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }
        if ($user && $user->active==0) {
       
        return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
        }

        $compte=Account::where('id',$user->id)->first();
        $compte->solde= $compte->solde+$request->montant;
        $compte->save();
        $transaction=Transaction::create([
            'montant'=>$request->montant,
            'destination_iban'=>$compte->iban,
            'user_id'=>$user->id,
            'type'=>"Dépot",
            'date_transaction'=>carbon::now(),
        ]);

        if($transaction){

            return response()->json([
                'Message :'=>"Votre dépot a été effectué avec succès !",
                'Transaction :'=> $transaction,
                'Montant actuel :'=> $compte->solde
            ],201);
        }

    }


    public function solde(string $id)
    {
        $user=User::where('id',$id)->first();
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }


        if ($user && $user->active==0) {
       
        return response()->json([
                'Erreur'=>"Attention ,erreur de récuperation !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
        }
        $compte=Account::where('id',$user->id)->first();
        return response()->json([
            'Votre solde actuel est de : '=>$compte->solde." F"
        ],200);
        
    }


        public function totalDepots(string $id)
    {
        $user=User::where('id',$id)->first();
       
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }
        if ($user && $user->active==0) {
       
        return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
        }
        $transactions=Transaction::where('user_id',$user->id)->where('type','depot')->get();
        if (!$transactions) {
            return response()->json([
                'Erreur '=>"Attention ,Récuperation échoué !",
                'message'=>"Désolé , la récupération des dépots totaux a échoué !"
            ],500);
        }
        if ($transactions->isEmpty()) {
            return response()->json([
        
                'message'=>"Désolé, vous n'avez de dépots disponibles !"
            ],200);
        }
        
        $somme=0;
        foreach($transactions as $transaction){
            $somme+=$transaction->montant;
        }

        return response()->json([
        
            'message'=>"Récupération des dépots totaux  éffectuée avec succès !",
            "Dépots Totaux:"=>$somme." F"
            ],200);
        
    }
    public function totalTransferts(string $id)
    {
        $user=User::where('id',$id)->first();
       
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }
        if ($user && $user->active==0) {
       
        return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
        }
        $transactions=Transaction::where('user_id',$user->id)->where('type','transfert')->get();
        if (!$transactions) {
            return response()->json([
                'Erreur '=>"Attention ,Récuperation échoué !",
                'message'=>"Désolé , la récupération des transferts totaux a échoué !"
            ],500);
        }
        if ($transactions->isEmpty()) {
            return response()->json([
        
                'message'=>"Désolé, vous n'avez de transferts disponibles !"
            ],200);
        }
        
        $somme=0;
        foreach($transactions as $transaction){
            $somme+=$transaction->montant;
        }

        return response()->json([
        
            'message'=>"Récupération des transferts totaux éffectuée avec succès !",
            "Transferts Totaux:"=>$somme." F"
            ],200);
    }


    public function transfert(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'montant'=>'required',
            'destination_iban'=>'required'
        ]);
        
        $user=User::where('id',$request->user_id)->first();
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }
        if ($user && $user->active==0) {
            return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
    }

    $compte=Account::where('id',$request->user_id)->first();
    if ($compte->solde<$request->montant) {
            return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Votre solde est insuffisant",
                'guide'=>"Veuillez effectuer un dépot supérieur à ".$request->montant." F"
            ],409);
    }
    $contact=Contact::where('iban',$request->destination_iban)->first();

    
    //Un transfert vers son propre compte
    if($request->destination_iban==$compte->iban){
            return response()->json([
                'Erreur de transaction'=>"Attention ,transfert refusé !",
                'message'=>"Vous ne pouvez pas effectuer un transfert vers votre propre compte !",
                'guide'=>"Veuillez utiliser l'iban d'un autre contact existant !"
            ],409);
    }
    //contact existe pas
    if (!$contact) {
            return response()->json([
                'Erreur de transaction'=>"Attention ,transaction refusée !",
                'message'=>"Aucun contact avec l'iban : ".$request->destination_iban." n'a été trouvé !",
                'guide'=>"Veuillez utiliser un iban existant "
            ],409);
    }

    $transaction=Transaction::create([
        'user_id'=>$user->id,
        'destination_iban'=>$contact->iban,
        'montant'=>$request->montant,
        'type'=>"Transfert",
        'date_transaction'=>carbon::now()
    ]);
    if (!$transaction) {
            return response()->json([
                'Erreur de transaction'=>"Attention ,erreur de transaction!",
                'message'=>"Désolé on rencontré une erreur au cours de la transaction"
            ],500);
    }
    if($transaction){
    $contact->solde+=$request->montant;
    $compte->solde-=$request->montant;
    $contact->save();
    $compte->save();

    return response()->json([
        'message'=>"Transaction effectuée avec succès !",
        "Votre solde actuel est de :"=> $compte->solde." F",
        'Transaction:'=>$transaction
    ],201);
}

}


    public function transactionsUserType(string $id, string $type)
    {
        $user=User::where('id',$id)->first();
        if (!$user) {
            return response()->json([
                "Erreur d'utilisateur"=>"Attention, cet utilisateur est introuvable !",
                'guide'=>"veillez donnner un id existant svp !"
            ],404);
        }


        if ($user && $user->active==0) {
        return response()->json([
                'Erreur'=>"Attention ,erreur de récuperation !",
                'message'=>"Le compte de cet utilisateur est dèsactivé ,veillez l'activer"
            ],401);
        }
        $transactions=Transaction::where('user_id',$user->id)->where('type',$type)->get();
        if ($transactions && count($transactions)==0) {
            return response()->json([
                'Message : '=>"Aucune transaction de ce type n'a été trouvée pour cet utilisateur !"
            ],200);
        }
        return response()->json([
            'Voici la liste de vos transactions de type '.$type =>$transactions
        ],200);
        
    }
}