@extends('layouts.base')

@section('content')
<div class="p-3">
  <h2>New transaction</h2>
   @if ($errors->any())

    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul> 
    </div>

    @endif

    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
  <form action="{{route('transactions.store')}}" method="POST">
    @csrf
    <input name="user_id" type="hidden" class="form-control" id="user_id" value="{{Auth::user()->id}}">
    <div class="card p-3">
    <h3>Mon solde : {{Auth::user()->account->solde}} € </h3>
    <div class="mb-3">
      <label class="form-label">Transaction type</label>
      <select name="type" class="form-select" aria-label="Default select example" id="type">
        <option value="" selected>Choose a transaction type</option>
        <option value="TRANSFERT">TRANSFERT</option>
        <option value="DEPOT">DEPOT</option>
      </select>
    </div>
    <div class="mb-3" id="contact">
      <label class="form-label">Choose a contact</label>
      <select name="iban" id="iban" class="form-select" aria-label="Default select example">
        <option value="">Select a contact from the list</option>
        @foreach ($contacts as $contact)
        <option  value="{{ $contact->id }}">{{ $contact->prenom }} {{ $contact->nom }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3" >
      <label for="amount" class="form-label">Amount</label>
      <input name="montant" type="number" class="form-control" id="amount" placeholder="Ex 5000">
    </div>
    <div class="mb-3" id="ibandiv">
      <label for="iban" class="form-label">Iban</label>
      <input name="destination_iban" type="text" class="form-control" id="ibans" placeholder="Ex AC45 1234 1234 1234">
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-link">
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

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#contact").hide();
     $("#ibandiv").hide();
  $("#type").change(function(){
    
    if($('#type').val()=="DEPOT" || $('#type').val()==""){
$("#contact").hide();
     $("#ibandiv").hide();
    }
    if($('#type').val()=="TRANSFERT"){
$("#contact").show();
     $("#ibandiv").show();
    }
    
    //$(this).css("background-color", "#D6D6FF");
  });
  $("#iban").change(function(){
     // alert($('#iban').val());
 
      let itemId = $('#iban').val();
      $.ajax({

           type:'GET',
           url: `/iban/${itemId}`,
           //url:"{{ route('contacts.iban',1) }}",

           //data:{name:name, password:password, email:email},

           success:function(data){

              //alert(data.success);
              const inputElement = document.getElementById('ibans');

// Set the value of the input element
inputElement.value = data.success;
                  inputElement.readOnly = true;


           }

        });
  });
});
</script>  
@endsection