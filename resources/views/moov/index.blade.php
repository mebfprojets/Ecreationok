@extends('layouts.frontend')
@section('content')
@if(session('message'))
                    <center><div class="custom-alert" style="color: white;">
                        {{ session('message') }}
                    </div>
                    </center>
@endif
@if(session('error'))
                    <center><div class="custom-rouge" style="color: white;">
                        {{ session('error') }}
                    </div>
                    </center>
@endif
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Ajuste ici la largeur du formulaire -->
            <div class="text-center mb-4">
                <h3><strong>Paiement Par Moov Money</strong></h3>
            </div>
            @if($otp==0)
            <p class="text-center">Renseigner le numéro de Téléphone</p>

            <form action="{{ route('moov.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $demande_id }}">
                <input type="hidden" name="command" value="{{ $command }}">
                <input type="hidden" name="montant" value="{{ $montant }}">                

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Numéro de Paiement</label>
                            <input type="text" name="numero" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-success" value="Valider">
                </div>
            </form>
            @endif
            @if($otp==1)
            <p class="text-center">Renseigner le code OTP</p>
            <form action="{{ route('moov.otp') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $demande_id }}">
                <input type="hidden" name="command" value="{{ $requestId }}">
                <input type="hidden" name="transId" value="{{ $transId }}">
                <input type="hidden" name="numero" value="{{ $numero }}">

                <div class="row mt-4">                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Saisir OTP</label>                            
                            <input type="text" name="otp" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-success" value="Valider">
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection