@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{ __('Izmeni') }} {{__('Destinaciju')}}</h3>
            <hr>

            <form method="POST" action="{{ route('destination.update', $destination) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                {{-- pozadinska slika --}}
                @php
                    if ($destination->coverImage) {
                        $path = asset('storage/' . $destination->coverImage);
                    }

                @endphp
                <div class="row p-2">

                    <label for="coverImage" class="col-lg-1 col-form-label">{{__('Pozadinska slika')  }}</label>

                    <div class="col-lg-5 input-box">
                        <div class="input-group col-lg-4">
                            <input type="file" class="form-control @error('coverImage') is-invalid @enderror"
                                id="coverImage" name="coverImage" value="{{ old('coverImage') }}">
                            @error('coverImage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <img src="{{ $path }}" class="mb-2" style="width: 100px;" alt="...">
                    </div>

                    <div class="row p-2">

                        <label for="number" class="col-lg-1 col-form-label ">{{ __('Broj mesta') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="number" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ $destination->number }}" placeholder="{{ __('Popunjavati samo za izlete-putovanja bez nocenja') }}">
                            @error('number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        <label for="priceTrip" class="col-lg-1 col-form-label ">{{ __('Cena izleta') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="number" class="form-control @error('priceTrip') is-invalid @enderror" id="priceTrip"
                                name="priceTrip" value="{{ $destination->priceTrip }}" placeholder="{{ __('Popunjavati samo za izlete-putovanja bez nocenja') }}">
                            @error('priceTrip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                    </div>

                    <div class="row p-2">
                        <label for="startCity" class="col-lg-1 col-form-label ">{{ __('Polasci') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('startCity') is-invalid @enderror"
                                id="state" name="startCity" value="{{ $destination->startCity }}">
                            @error('startCity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                  
                    <div class="p-2 row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <p class="col-sm-2 col-form-label">{{__('Prevoz')  }}</p>
                            <div class="p-2">
                                <input type="radio" class="btn-check" name="transportation" id="autobus" value="autobus"
                                    @if (old('transportation', $destination->transportation) === 'autobus') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="autobus">{{__('Autobus') }}</label>

                                <input type="radio" class="btn-check" name="transportation" id="avion" value="avion"
                                    @if (old('transportation', $destination->transportation) === 'avion') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="avion">{{ __('Avion') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <p class="col-sm-2 col-form-label">{{__('Tip putovanja')  }}</p>
                            <div class="p-2">
                                <input type="radio" class="btn-check" name="type" id="letovanje" value="letovanje"
                                    @if (old('type', $destination->type) === 'letovanje') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="letovanje"
                                    style="padding: 5px 25px;">{{ __('Letovanje') }}</label>

                                <input type="radio" class="btn-check" name="type" id="zimovanje" value="zimovanje"
                                    @if (old('type', $destination->type) === 'zimovanje') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="zimovanje"
                                    style="padding: 5px 25px;">{{ __('Zimovanje') }}</label>


                                <input type="radio" class="btn-check" name="type" id="cityBreak" value="cityBreak"
                                    @if (old('type', $destination->type) === 'cityBreak') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="cityBreak"
                                    style="padding: 5px 25px;">{{ __('City Break') }}</label>

                                <input type="radio" class="btn-check" name="type" id="izlet" value="izlet"
                                    @if (old('type', $destination->type) === 'izlet') checked @endif>
                                <label class="btn btn-outline-primary bg-label" for="izlet"
                                    style="padding: 5px 25px;">{{ __('Izlet') }}</label>
                            </div>
                        </div>
                    </div>

               
                    <div class="row p-2">

                        <label for="state" class="col-lg-1 col-form-label ">{{ __('Drzava') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                id="state" name="state" value="{{ $destination->state }}">
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label for="stateEng" class="col-lg-1 col-form-label ">{{ __('Drzava') }} - {{__('Eng')}}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('stateEng') is-invalid @enderror"
                                id="sstateEng" name="stateEng" value="{{ $destination->stateEng }}">
                            @error('stateEng')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="row p-2">

                        <label for="city" class="col-lg-1 col-form-label ">{{ __('Grad') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                id="city" name="city" value="{{ $destination->city }}">
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label for="cityEng" class="col-lg-1 col-form-label ">{{ __('Grad') }}  - {{__('Eng')}}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                id="cityEng" name="cityEng" value="{{ $destination->cityEng }}">
                            @error('cityEng')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="row p-2">

                        <label for="startDate" class="col-lg-1 col-form-label ">{{ __('Početak putovanja') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="date" class="form-control @error('startDate') is-invalid @enderror"
                                id="startDate" name="startDate" value="{{ $destination->startDate }}">
                            @error('startDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label for="endDate" class="col-lg-1 col-form-label ">{{ __('Kraj putovanja') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="date" class="form-control @error('endDate') is-invalid @enderror"
                                id="endDate" name="endDate" value="{{ $destination->endDate }}">
                            @error('endDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row p-2">
                        <div class="row p-2">
                            <label for="descriptionSrb"
                                class="col-lg-1 col-form-label ">{{ __('Opis putovanja-Srpski') }}</label>
                            <div class="col-lg-11">
                                <textarea name="descriptionSrb" id="descriptionSrb" cols="15"
                                    rows="5"class="form-control @error('descriptionSrb') is-invalid @enderror" id="descriptionSrb"
                                    name="descriptionSrb" style="background-color: transparent;color:white;">{{ old('descriptionSrb', $destination->descriptionSrb) }}</textarea>

                                @error('descriptionSrb')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="row p-2">
                            <label for="descriptionEng"
                                class="col-lg-1 col-form-label ">{{ __('Opis putovanja-Engleski') }}</label>
                            <div class="col-lg-11">
                                <textarea name="descriptionEng" id="descriptionEng" cols="15" rows="5"
                                    class="form-control @error('descriptionEng') is-invalid @enderror" name="descriptionEng" style="background-color: transparent;color:white;">{{ old('descriptionEng', $destination->descriptionEng) }}</textarea>

                                @error('descriptionEng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        {{-- dugmici za registraciju/odustajanje --}}

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-md bg-blue">
                                {{ __('Sačuvaj izmene') }}
                            </button><a href="{{ route('all') }}"
                                class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
