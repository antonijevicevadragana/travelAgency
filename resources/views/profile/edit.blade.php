@extends('layouts.app')
@section('content')
<div class="row  p-2">
    <div class="col content">
        <h3 class="text-center">{{__( 'Imena') }} : {{__( 'Profil') }}</h3>
        <hr>

            <form method="POST" action="{{route('profile.update', $profile)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- avatar --}}
                <div class="row p-2 ">

                    <label for="avatar" class="col-lg-1 col-form-label">{{__( 'Avatar') }}</label>

                    <div class="col-lg-5 input-box">
                        <div class="input-group col-lg-4">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                id="avatar" name="avatar" value="{{ old('avatar') }}">
                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="p-2 row">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <p class="col-sm-2 col-form-label">{{__( 'Pol') }}</p>
                        <div class="p-2 input-box">
                            <input type="radio" class="btn-check" name="gender" id="male" value="male"
                                @if (old('gender',$profile->gender) === 'male') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="male">{{__('Muško') }}</label>
                
                            <input type="radio" class="btn-check" name="gender" id="female" value="female"
                                @if (old('gender',$profile->gender) === 'female') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="femile">{{__('Žensko') }}</label>

                            
                            <input type="radio" class="btn-check" name="gender" id="other" value="other"
                                @if (old('gender',$profile->gender) === 'other') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="other">{{__('Drugo') }}</label>

                        </div>
                    </div>
                </div>


                <div class="row p-2">

                    <label for="name" class="col-lg-1 col-form-label ">{{__('Ime') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $profile->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="surname" class="col-lg-1 col-form-label ">{{__('Prezime') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                            name="surname" value="{{$profile->surname }}">
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">

                    <label for="nickname" class="col-lg-1 col-form-label ">{{__('Nadimak') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('nickname') is-invalid @enderror" id="nickname"
                            name="nickname" value="{{ $profile->nickname }}" placeholder="{{__('Pod nadimkom ce se pojavljivati Vasi komentari')}}">
                        @error('nickname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="dateofBirth" class="col-lg-1 col-form-label ">{{__('Datum rodjenja') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="date" class="form-control @error('dateofBirth') is-invalid @enderror" id="dateofBirth"
                            name="dateofBirth" value="{{ $profile->dateofBirth}}">
                        @error('dateofBirth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                   
                        <textarea name="hightlight" id="hightlight" cols="15"
                            rows="5"class="form-control @error('hightlight') is-invalid @enderror" id="hightlight"
                            name="hightlight" placeholder="{{__('Napišite nešto o sebi, ili citat ili drugo što želite da se pojavljuje ispod Vašeg komentara. Polje nije obavezno')}}" style="background-color: transparent;color:white;">{{ $profile->hightlight }}</textarea>

                        @error('hightlight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-md bg-blue">
                        {{ __('Sačuvaj izmene') }}
                    </button><a href="{{ route('destination.index') }}"
                        class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                </div>

            </form>
        </div>
    </div>
@endsection
