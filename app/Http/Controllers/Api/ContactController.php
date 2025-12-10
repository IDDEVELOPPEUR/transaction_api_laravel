<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{




    public function index()
    {
        $contacts=Contact::all();
        if($contacts->isEmpty()){
            return response()->json([
                "message"=>"pas de contacts disponibles !",
            ]);
        }
        return response()->json([
            "message"=>"reussi !",
            "données"=>$contacts
        ],200
    );
    }


    public function show(string $id){

        $contact=Contact::find($id);
        if(!$contact){
            return response()->json([
                "message"=>"contact non trouvé !",
                "guide"=>"Veillez fournir un id existant !"
            ],404);
    
    } 
        return response()->json([
        "message"=>"contact trouvé !",
        "données"=>$contact
    ],200
);
    }

    public function store(Request $request)
    {

        //ici je verifie la validation 
        $request->validate([
            'user_id'=>['required'],
            'prenom'=>['required','string','max:100', 'min:2'],
            'nom'=>['required','string','max:100','min:2'],
            'solde'=>['required','min:1','max:2000000'],
            'email'=>['required' , 'string' , 'email' , 'max:100'],
        ]);
+
        //verification de l'email
        $emailExist=Contact::where('email',$request->email)->first();
        if($emailExist){
            return response()->json([
                'Erreur sur cet email: '=>$request->email,
                'message'=>'Cet email existe déjà dans la base de données, veillez changer d\'email'
            ],409);
            
        }
            //creation du iban
            do{ 
                $iban="SN";
                for($i=1;$i<=11;$i++){
                    $iban.=random_int(0,9);

            }
            
            $ibanVerif=Contact::where('iban',$iban)->exists();



        }while($ibanVerif);
    
        

        //je crée le contact
        $contact=Contact::create([
            'user_id'=>$request->user_id,
            'prenom'=>$request->prenom,
            'nom'=>$request->nom,
            'email'=>$request->email,
            'solde'=>$request->solde,
            'iban'=>$iban
        ]);

        if(!$contact){
              return response()->json([
                'message'=>"Désolé, une erreur est survenu lors de la création du compte",
                
            ],409);
        }

        if($contact){  
        return response()->json([
            'message'=>"votre compte a été créé avec succès !",
            'données'=>$contact
        ],201);

    }
}

    public function update(Request $request, string $id)
    {
    $request->validate([
        'prenom'=>['string','max:100','min:2'],
        'nom'=>['required','string','max:100','min:2'],
        'email'=>['required','string','max:100','email'],
      ]);
 
    $contactExiste=Contact::where('id',$id)->first();
    $emailExist=Contact::where('email',$request->email)->first();
    $ibanExist=Contact::where("iban",$request->iban)->first();


    if(!$contactExiste){
            return response()->json([
            'message erreur'=>'le contact avec cet id est introuvable !'
        ],404);

    }

    if($emailExist && $emailExist!=$contactExiste->email){
        return response()->json([
            "Erreur sur l'email:"=>$request->email,
            'message erreur'=>'cet email est déjà utilisé par un autre contact, veillez changer d\'email !'
        ],409);
  }


    if($ibanExist && $ibanExist!=$contactExiste->iban){
        return response()->json([
            "Erreur sur l'iban:"=>$request->iban,
            'message erreur'=>'cet iban est déjà utilisé par un autre contact, veillez changer d\'iban !'
        ],409);
    }
    $contactExiste->update([
        'prenom'=>$request->prenom,
        'iban'=>$request->iban,
        'nom'=>$request->nom,
        'email'=>$request->email,
    ]);


    if($contactExiste){
        return response()->json([
            'message'=>'Contact modifié avec succès !',
            'données:'=>$contactExiste,
            'info'=>"les  champs 'solde'et 'user_id' ne sont pas modifiables !"
            
        ],200);
        
    }
}
public function destroy(string $id)
    {
       $contact=Contact::find($id);
       if (!$contact) 
        {
            return response()->json([
                'message'=>"Le contact avec cet id est introuvable",
                'id'=>$id
            ],500);
       }
       $contactMess=$contact;
       $contact->delete();
       return response()->json([
        'message '=>'contact supprimé avec succès !',
        'données contact supprimé:'=>$contactMess
       ],200);
    }

    public function contactsUser(string $user_id){
        $contacts=Contact::where("user_id",$user_id)->get();
        if ($contacts->isEmpty()) {
            return response()->json(
                [
                    'message:'=>"aucun contact disponible pour cet utilisateur !"
                ],404
            );
        }
        return response()->json(
                [
                    'message:'=>"Voici la liste des contacts pour cet utilisateur :",
                    "données"=>$contacts
                ],200
            );
    }

}