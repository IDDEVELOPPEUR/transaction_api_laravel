<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users= User::all();
        return response()->json(['success'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation des données
        $request->validate([
            'prenom'=> ['required', 'max:100' , 'string' ,'min:2'],
            'nom'=> ['required' , 'string' , 'max:100','min:2'],
            'email'=> ['required', 'max:100' , 'string' , 'email' , 'unique:users,email'],
            'password' => ['required' , 'string' , 'max:100', 'min:6']
        ]);
        
//ici je verifie si l'email de l'utilisateur existe déja d'abord
        $emailExistant=User::where('email',$request->email)->first(); 

            if($emailExistant){
                return response()->json([
                    'erreur sur:'=>$request->email,
                    'message'=>'Votre email existe déjà dans la base de données veillez changer d\'email'
            ],409);

            }
            
            $user=User::create([
                'prenom'=>$request->prenom,
                'nom'=>$request->nom,
                'email'=>$request->email,         
                'password'=>Hash::make($request->password)
            ]);
            
            //creation du rib
            $iban="SN";
            for($i=1;$i<=11;$i++){
                $iban.=random_int(0,9);

            }
            $compte=Account::create([
                'user_id'=>$user->id,
                'iban'=>$iban,
                'solde'=>1000.00
            ]);

            if(!$compte)
            {
                return response()->json([
                    'message:'=>"Un problème est survenu lors de la creation du compte "
                ],500);
            }

                
            return response()->json(
                [
                'message'=>'Utilisateur créé avec succès',
                'données utilisateur'=> $user,
                'données compte'=>$compte
                ],201);

        


    
}

    public function show(string $id)
    {
        
        $user=User::where('id',$id)->first();
        return response()-> json([
            'message'=>'Utilisateur trouvé avec succès',
            'données'=>$user
        ],200); 
    }

 


    public function statut(string $statut){
        $usersA=User::where('active',1)->get();
        $usersD=User::where('active',0)->get();
        if ($statut=='actif') {
            return response()->json([
                'message'=> "les utilisateurs dont leur status est actif :",
                "données"=>$usersA
            ],200);

            
        }else if($statut=='inactif'){ 
            return response()->json([
                'message'=> "les utilisateurs dont leur statut est inactif :",
                "données"=>$usersD
            ],200);

            }
            return response()->json([ 

                'message'=> "ce paramettre n'est pas autorisé !",
            ],500);
    }


    public function active_desactive(string $id){
        $user=User::where('id',$id)->first();
        if ($user->active==0) {
            $user->active=1;
            $user->save();
             return response()->json(
        [
                'message'=>'statut activé avec succès',
                "données"=>$user
        ]
        );

        } else {
            $user->active=0;
               $user->save();
             return response()->json(
        [
                'message'=>'status dèsactivé avec succès',
                "données"=>$user
        ]
        );
        }
       
    }

}