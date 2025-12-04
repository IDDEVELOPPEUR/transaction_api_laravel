<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::user()->id)->latest()->paginate(5);
        return view('contacts.index',compact('contacts'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required',
            'iban' => 'required',
        ]);
        Contact::create($request->all());
        return redirect()->route('contacts.index')
                ->with('success','Contact créé avec succees.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit',compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required',
            'iban' => 'required',
        ]);
        Contact::create($request->all());
        return redirect()->route('contacts.index')
                ->with('success','Contact créé avec succees.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }

    public function iban($id){
        $contact = Contact::find($id);
        return response()->json(['success'=>$contact->iban]);
    }
}
