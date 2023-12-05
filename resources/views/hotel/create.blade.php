@extends('layouts.app')
@section('content')
<div class="row  p-2">
    <div class="col content"> 
        <h3 class="text-center">{{ __('Dodaj') }} {{__('Hotel')}}</h3>
        <hr>
            <form method="POST" action="{{ route('hotel.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row p-2">
                    <label for="destination_id">{{ __('Izbor destinacije') }}:</label>
                    <select class="form-select text-white @error('destination_id') is-invalid @enderror" aria-label="Default select example" name="destination_id">
                        <option value="">--</option>
                        @foreach ($destination as $d)
                            <option value="{{ $d->id }}">
                                {{ $d->city }} {{ $d->transportation }} {{ $d->startDate }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                

                <div class="row p-2">

                    <label for="name" class="col-lg-1 col-form-label ">{{ __('Naziv hotela') }}</label>
                    <div class="col-lg-5  input-box">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="location" class="col-lg-1 col-form-label ">{{ __('Lokacija') }}</label>
                    <div class="col-lg-5  input-box">
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ old('location') }}">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descript"
                        class="col-lg-1 col-form-label ">{{ __('Opis hotela') }}</label>
                    <div class="col-lg-11">
                        <textarea name="descript" id="descript" cols="15"
                            rows="5"class="form-control @error('descript') is-invalid @enderror" id="descript"
                            name="descript" style="background-color: transparent;color:white;">{{ old('descript') }}</textarea>

                        @error('descript')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descriptEng"
                        class="col-lg-1 col-form-label ">{{ __('Opis hotela') }} -{{__('Eng')}}</label>
                    <div class="col-lg-11">
                        <textarea name="descriptEng" id="descriptEng" cols="15"
                            rows="5"class="form-control @error('descriptEng') is-invalid @enderror" id="descript"
                            name="descriptEng" style="background-color: transparent;color:white;">{{ old('descriptEng') }}</textarea>

                        @error('descriptEng')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


                <div class="row p-2">

                    <label for="link" class="col-lg-1 col-form-label ">{{ __('Link') }}</label>
                    <div class="col-lg-5  input-box">
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link"
                            name="link" value="{{ old('link') }}">
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="img" class="col-lg-1 col-form-label">{{ __('Slike hotela') }}</label>

                    <div class="col-lg-5 input-box">
                        <div class="input-group col-lg-4">
                            <input type="file" class="form-control @error('img.*') is-invalid @enderror"
                                id="img" name="img[]" value="{{ old('img') }}" multiple>
                            @error('img.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
               
                 <div class="row p-2">

                    <label for="price" class="col-lg-1 col-form-label ">{{ __('Cena') }}</label>
                    <div class="col-lg-3  input-box">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            name="price" value="{{ old('price') }}">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="firstMin" class="col-lg-1 col-form-label ">{{ __('First minute') }}</label>
                    <div class="col-lg-3  input-box">
                        <input type="number" class="form-control @error('firstMin') is-invalid @enderror" id="firstMin"
                            name="firstMin" value="{{ old('firstMin') }}">
                        @error('firstMin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="lasteMin" class="col-lg-1 col-form-label ">{{ __('Laste minute') }}</label>
                    <div class="col-lg-3  input-box">
                        <input type="number" class="form-control @error('lasteMin') is-invalid @enderror" id="lasteMin"
                            name="lasteMin" value="{{ old('lasteMin') }}">
                        @error('lasteMin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                 <div class="row p-2">


                    <label for="firstOnly" class="col-lg-1 col-form-label ">{{ __('Uslov First Minute') }}</label>
                    <div class="col-lg-5  input-box">
                        <input type="number" class="form-control @error('firstOnly') is-invalid @enderror" id="firstOnly"
                            name="firstOnly" value="{{ old('firstOnly') }}" placeholder="{{__('Koliko dana od kriranja vazi popust')}}">
                        @error('firstOnly')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="lastOnly" class="col-lg-1 col-form-label ">{{ __('Uslov Last Minute') }}</label>
                    <div class="col-lg-5  input-box">
                        <input type="number" class="form-control @error('lastOnly') is-invalid @enderror" id="lastOnly"
                            name="lastOnly" value="{{ old('lastOnly') }}" placeholder="{{__('Koliko dana do realizacije putovanja vazi popust')}}">
                        @error('lastOnly')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


                {{-- broj mesta u hotelu --}}
                <div class="row p-2">

                    <label for="price" class="col-lg-1 col-form-label ">{{__('Broj mesta u hotelu') }}</label>
                    <div class="col-lg-3  input-box">
                        <input type="number" class="form-control @error('number') is-invalid @enderror" id="number"
                            name="number" value="{{ old('number') }}">
                        @error('number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- dugmici za potvrdu/odustajanje --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-md bg-blue">
                            {{ __('Sacuvaj') }}
                        </button><a href="{{ route('hotel.index') }}"
                            class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                </div>

            </form>
        </div>
    </div>
@endsection
