@extends('layouts.base')
@section('content')
<div class="p-3">
    <h2>My contact list</h2>
    <div class="d-flex justify-content-end mb-3">
        
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Statut</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $usr)
            <tr>
                <th scope="row">{{$usr->prenom}}</th>
                <td>{{$usr->nom}}</td>
                <td>{{$usr->email}}</td>
                <td>{{$usr->active}}</td>
                <td>{{$usr->role}}</td>
                <td class="cursor-pointer">
                <form action="{{ route('users.maj',$usr->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Update</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>  
    <div class="pagination mt-4">
        {!! $users->links() !!}
    </div>
</div>
@endsection
