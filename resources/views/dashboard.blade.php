@extends('layouts.base')

@section('content')
  <div class="container">
        <div class="row">
            <div class="col">
                <div class="card bg-success text-white">
                    <div class="card-body">Solde : {{$solde}}</div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary text-white">
                    <div class="card-body">Transfert {{$transferts}}</div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger text-white">
                    <div class="card-body">Depot {{$depots}}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
