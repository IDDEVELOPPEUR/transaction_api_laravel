@extends('layouts.base')
@section('content')
<div class="p-3">
  <h2>New contact</h2>
  
    @if ($errors->any())

    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul> 
    </div>

    @endif
  <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
      @csrf
      @method('PUT')
    <input name="user_id" type="hidden" class="form-control" id="user_id" value="{{ Auth::user()->id}}">
    <div class="card p-3">
    <div class="mb-3">
      <label for="prenom" class="form-label">Prenom</label>
      <input name="prenom" type="text" class="form-control" id="prenom" value="{{ $contact->prenom }}" placeholder="prenom">
    </div>
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input name="nom" type="text" class="form-control" id="nom" value="{{ $contact->nom }}" placeholder="nom">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input name="email" type="email" class="form-control" id="email" value="{{ $contact->email }}" placeholder="contact@isep.sn">
    </div>
    <div class="mb-3">
      <label for="iban" class="form-label">Iban</label>
      <input name="iban" type="text" class="form-control" id="iban" value="{{ $contact->iban }}" placeholder="Ex AC45 1234 1234 1234">
    </div>
    <div class="d-flex justify-content-end">
      <button (click)="cancel()" type="button" class="btn btn-link">
        <em class="fas fa-times"></em>&nbsp;Cancel
      </button>
      <button type="submit" class="btn btn-danger">
        <em class="fas fa-save"></em>&nbsp;Save
      </button>
    </div>
  </div>
</form>
</div>
@endsection