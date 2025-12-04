@extends('layouts.base')

@section('content')
<div class="p-3">
  <h2>New transaction</h2>
  <div class="alert alert-danger"  role="alert" >
    <p > </p>
  </div>
  <div class="card p-3">
    <h3>Your account balance: 300000 € </h3>
    <div class="mb-3">
      <label class="form-label">Transaction type</label>
      <select  class="form-select" aria-label="Default select example" id="type">
        <option value="" selected>Choose a transaction type</option>
        <option value="TRANSFERT">TRANSFERT</option>
        <option value="DEPOT">DEPOT</option>
      </select>
    </div>
    <div class="mb-3" id="contact">
      <label class="form-label">Choose a contact</label>
      <select [(ngModel)]="transaction.destinationIban" class="form-select" aria-label="Default select example">
        <option value="">Select a contact from the list</option>
        <option  value=""></option>

      </select>
    </div>
    <div class="mb-3" >
      <label for="amount" class="form-label">Amount</label>
      <input [(ngModel)]="transaction.amount" type="number" class="form-control" id="amount" placeholder="Ex 5000">
    </div>
    <div class="mb-3" id="iban">
      <label for="iban" class="form-label">Iban</label>
      <input [(ngModel)]="transaction.destinationIban" type="text" class="form-control" id="iban" placeholder="Ex AC45 1234 1234 1234">
    </div>
    <div class="d-flex justify-content-end">
      <button (click)="cancel()" type="button" class="btn btn-link">
        <em class="fas fa-times"></em>&nbsp;Cancel
      </button>
      <button (click)="addTransaction()" type="button" class="btn btn-danger">
        <em class="fas fa-save"></em>&nbsp;Save
      </button>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#contact").hide();
     $("#iban").hide();
  $("#type").change(function(){
    
    if($('#type').val()=="DEPOT" || $('#type').val()==""){
$("#contact").hide();
     $("#iban").hide();
    }
    if($('#type').val()=="TRANSFERT"){
$("#contact").show();
     $("#iban").show();
    }
  });
});
</script>  
@endsection