<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('users.index',compact('users'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function maj($id){
        $user = User::find($id);
        if($user){
            if($user->active){
                $user->active = false;
                $user->save();
                return redirect()->route('users.index')
                ->with('success','Statut mis a jour.');
            }else{
                if($user->account){
                  $user->active = true;
                $user->save();
                }else{
                    $rib = 'SN';
        for ($i = 0; $i < 13; $i++) {
            $rib .= random_int(0, 11);
        }
$account = new Account();
$account->iban = $rib;
$account->user_id = $id;
$account->save();
                    $user->active = true;
                $user->save();
                }
                
                
                return redirect()->route('users.index')
                ->with('success','Statut mis a jour.');
            }
        }

    }
}
