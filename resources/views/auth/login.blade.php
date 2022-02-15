@extends('auth.layouts.app')

@section('content')
<div class="row justify-content-center">

    <div class="col-xl-8 col-lg-7 col-md-1">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
 
                    <div class="col-lg-6"><br/>
					<img id="imj" src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="85px";
					height="75px">
                        <div class="p-5">
                            <div class="text-center">
                                <h1>Accès au service</h1>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email Address.">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="customCheck" {{ old('remember') ? 'checked' : '' }}>

                                        
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block">
                                    Connectez-vous!
                                </button>
                            </form>
                            <hr>
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
	                       {{ session('error') }}
                          </div>
                           @elseif(session('failed'))
                           
                             @endif
                            <div class="text-center">
                                
                            </div>
                            <div class="text-center">
                               
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
