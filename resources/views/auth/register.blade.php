@extends('layouts.logreg')

@section('content')
    <div class="content">
        <div class="row justify-content-center frame">
            <h2 class="text-center">{{ __('Registacija') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-box">
                    <label for="name" class="col-form-label text-md-end">{{ __('Ime') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="&#xf007; " style="font-family: Arial, FontAwesome">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="input-box">
                    <label for="email" class="col-form-label text-md-end">{{ __('Email Adresa') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="&#xf0e0; " style="font-family: Arial, FontAwesome">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="password" class="col-form-label text-md-end">{{ __('Lozinka') }}</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="&#xf023;" style="font-family: Arial, FontAwesome">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="password-confirm" class="col-form-label text-md-end">{{ __('Potvrdi Lozinku') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password" placeholder="&#xf023;" style="font-family: Arial, FontAwesome">
                </div>

                
                    <div class="d-grid gap-2">
                        <br>
                        <button type="submit" class="btn btn-primary dugmic">
                            {{ __('Registacija') }}
                        </button>
                    </div>
                
            </form>

        </div>

        {{-- br ubaceno da se napravi razmak --}}
    @endsection
