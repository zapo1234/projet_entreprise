@extends('auth.layouts.app')

@section('content')
<div class="container" id="content1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img id="imj" src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto">
                <div class="card-header" style="text-align:center">Entrez votre adresse E-mail</div>

                <div class="card-body">
                    
                    <form method="POST" id ="form_reset" action="{{ route('auth.passwords.reset') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="width:200px">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
