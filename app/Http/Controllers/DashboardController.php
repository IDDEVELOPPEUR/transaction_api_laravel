<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Transaction;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $solde = Auth::user()->account->solde;// Account::all()->where('user_id', Auth::user()->id)->last()->solde;
       $depots = 0;
       $transferts = 0;
       $transactions = Transaction::all()->where('user_id', Auth::user()->id);
       foreach($transactions as $trans){
          if($trans->type=="DEPOT"){
            $depots = $depots + $trans->montant;
          }
          else{
            $transferts = $transferts + $trans->montant;
          }
       }
       $transferts = $transferts*(-1);

       return view('dashboard', compact('solde','transferts','depots'));
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
}
