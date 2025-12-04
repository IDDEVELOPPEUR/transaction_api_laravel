@extends('layouts.base')
@section('content')
<div class="p-3">
    <h2>My contact list</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('contacts.create') }}" type="button" class="btn btn-success">
            <em class="fas fa-plus"></em>&nbsp; New contact
        </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Iban</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <th scope="row">{{$contact->prenom}}</th>
                <td>{{$contact->nom}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->iban}}</td>
                <td class="cursor-pointer">
                <form action="{{ route('contacts.destroy',$contact->id) }}" method="POST">
                <a class="btn btn-info" href="{{ route('contacts.show',$contact->id) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('contacts.edit',$contact->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>  
    <div class="pagination mt-4">
        {!! $contacts->links() !!}
    </div>
</div>
@endsection
