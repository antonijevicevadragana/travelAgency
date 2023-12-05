@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{ 'Izmena destinacije' }}</h3>
            <hr>

            <form method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')
              
                    {{-- izbor za prevoz radio dugmici --}}
                    {{-- Ovdje se koristi contains metoda kako bi se provjerilo postoji li uloga s određenim tipom u kolekciji uloga korisnika. Ako postoji, dodaje se atribut checked. U suprotnom, atribut ostaje prazan --}}
                    <div class="p-2 row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <p class="col-sm-2 col-form-label">{{ 'Tip uloge' }}</p>
                            <div class="p-2">
                                <input type="radio" class="btn-check" name="type" id="1" value="1"
                                    {{ $user->roles->contains('type', '1') ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary bg-label" for="1">{{ 'Admin' }}</label>
                    
                                <input type="radio" class="btn-check" name="type" id="2" value="2"
                                    {{ $user->roles->contains('type', '2') ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary bg-label" for="2">{{ __('Korisnik') }}</label>
                            </div>
                        </div>
                    </div>
                    
                        {{-- dugmici za registraciju/odustajanje --}}

                        <div class="d-grid gap-2">

                            <button type="submit" class="btn btn-md bg-blue">
                                {{ __('Sacuvaj izmene') }}
                            </button><a href="{{ back()->getTargetUrl() }}"
                                class="btn btn-md bg-grey">{{ __('Odustani') }}</a>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
