@extends('layouts.base')
@section('content')
<div class="p-3">
    <h2>My contact list</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('transactions.create') }}" type="button" class="btn btn-success">
            <em class="fas fa-plus"></em>&nbsp; New transaction
        </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Iban</th>
                <th scope="col">Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <th scope="row">{{$transaction->date_transaction}}</th>
                <td>{{$transaction->montant}}</td>
                <td>{{$transaction->destination_iban}}</td>
                <td>{{$transaction->type}}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>  
    <div class="pagination mt-4">
        {!! $transactions->links() !!}
    </div>
</div>
@endsection
