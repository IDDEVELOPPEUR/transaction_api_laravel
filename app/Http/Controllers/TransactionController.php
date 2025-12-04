<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->latest()->paginate(5);
        return view('transactions.index',compact('transactions'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::all()->where('user_id', Auth::user()->id);
        //select * from contacts where user_id = $id
        return view('transactions.create', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'user_id' => 'required',
            'montant' => 'required',
        ]);
        $montant= 0;
        if($request->type=="DEPOT"){
            $montant = $request->montant;
        }else{
            $montant = -1*$request->montant;
            if(Auth::user()->account->solde<$request->montant){
                return redirect()->route('transactions.create')
                ->with('status','Solde insufissant.');
            }
        }
        //$request->get('montant') = -1;//*$request->get('montant');
        $transaction = Transaction::create($request->all());
        $transaction->montant = $montant;
        $transaction->save();
        $account= Auth::user()->account;
        $account->solde = $account->solde + $montant;
        $account->save();
        return redirect()->route('transactions.index')
                ->with('success','Contact créé avec succees.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
