@extends('layouts.frontend')
@section('content')
<div class="container" style="margin-top:-30px">
    
    <div class="alert-warning">
        <p>Les champs en étoile rouge <span style="color: red">(*)</span> sont obligatoires</p>
    </div>
<div class="content-form" >

    <form action="{{ route('reset.password.post') }}" method="POST">

        @csrf
          
        <input type="hidden" name="token" value="{{ $token }}">



        <div class="form-group row">

            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

            <div class="col-md-6">

                <input type="text" id="email_address" class="form-control" name="email" required autofocus>

                @if ($errors->has('email'))

                    <span class="text-danger">{{ $errors->first('email') }}</span>

                @endif

            </div>

        </div>



        <div class="form-group row">

            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

            <div class="col-md-6">

                <input type="password" id="password" class="form-control" name="password" required autofocus>

                @if ($errors->has('password'))

                    <span class="text-danger">{{ $errors->first('password') }}</span>

                @endif

            </div>

        </div>



        <div class="form-group row">

            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

            <div class="col-md-6">

                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>

                @if ($errors->has('password_confirmation'))

                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

                @endif

            </div>

        </div>



        <div class="col-md-6 offset-md-4">

            <button type="submit" class="btn btn-primary">

                Reset Password

            </button>

        </div>

    </form>
</div>
</div>
@endsection
