@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">

            <h3 class="text-center">{{ __('Izmeni') }} {{ __('Hotel') }}</h3>
            <hr>
            <form method="POST" action="{{ route('hotel.update', $hotel) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row p-2">
                    <label for="destination_id">{{ __('Izbor destinacije') }}::</label>
                     <select class="form-select text-white @error('destination_id') is-invalid @enderror"
                        aria-label="Default select example" name="destination_id">
                        <option class="selected" value="">--</option>
                        @foreach ($destination as $d)
                            <option class="selected" value="{{ $d->id }}" @if ($hotel->destination_id === $d->id || old('destination_id') === $d->id) selected @endif>
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
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $hotel->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="location" class="col-lg-1 col-form-label ">{{ __('Lokacija') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ $hotel->location }}">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descript" class="col-lg-1 col-form-label ">{{ __('Opis hotela') }}</label>
                    <div class="col-lg-11">
                        <textarea name="descript" id="descript" cols="15"
                            rows="5"class="form-control @error('descript') is-invalid @enderror" id="descript" name="descript"
                            style="background-color: transparent;color:white;">{{ $hotel->descript }}</textarea>

                        @error('descript')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descriptEng" class="col-lg-1 col-form-label ">{{ __('Opis hotela') }}
                        {{ __('Eng') }}</label>
                    <div class="col-lg-11">
                        <textarea name="descriptEng" id="descriptEng" cols="15"
                            rows="5"class="form-control @error('descriptEng') is-invalid @enderror" id="descript" name="descriptEng"
                            style="background-color: transparent;color:white;">{{ $hotel->descriptEng }}</textarea>

                        @error('descriptEng')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">

                    <label for="link" class="col-lg-1 col-form-label ">{{ __('Link') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link"
                            name="link" value="{{ $hotel->link }}">
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row p-2">
                    <label for="img" class="col-lg-1 col-form-label">{{ __('Slike hotela') }}</label>
                    <div class="col-lg-5">
                        <div class="input-group col-lg-4 input-box">
                            <input type="file" class="form-control @error('img.*') is-invalid @enderror" id="img"
                                name="img[]" value="{{ old('img') }}" multiple>
                            @error('img.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <img src="{{ $path }}" class="mb-2" style="width: 100px;" alt="..."> --}}
                        @foreach ($images as $image)
                            <img src="{{ asset('storage/' . $image->path) }}" style="width: 100px;" alt="">
                        @endforeach
                    </div>
                    <div class="col-lg-3 input-box">
                        <input class="form-check-input" type="checkbox" value="1" id="keep_old_images"
                            name="keep_old_images">
                        <label for="keep_old_images">{{ __('Zadrzi stare slike') }}</label>

                        <p>{{ __('ako ste čekirali Zadrži stare slike, možete dodati nove slike bez brisanja prethodnih') }}
                        </p>
                    </div>
                </div>

                <div class="row p-2">

                    <label for="price" class="col-lg-1 col-form-label ">{{ __('Cena') }}</label>
                    <div class="col-lg-3 input-box">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            name="price"
                            @foreach ($hotel->prices as $price)
                            value="{{ $price->price }}" @endforeach>
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="firstMin" class="col-lg-1 col-form-label ">{{ __('First minute') }}</label>
                    <div class="col-lg-3 input-box">
                        <input type="number" class="form-control @error('firstMin') is-invalid @enderror" id="firstMin"
                            name="firstMin"
                            @foreach ($hotel->prices as $price)
                            value="{{ $price->firstMin }}" @endforeach>
                        @error('firstMin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="lasteMin" class="col-lg-1 col-form-label ">{{ __('Laste minute') }}</label>
                    <div class="col-lg-3 input-box">
                        <input type="number" class="form-control @error('lasteMin') is-invalid @enderror" id="lasteMin"
                            name="lasteMin"
                            @foreach ($hotel->prices as $price)
                            value="{{ $price->lasteMin }}" @endforeach>
                        @error('lasteMin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="firstOnly"
                        class="col-lg-1 col-form-label ">{{ __('Broj dana vazenja firstMinute') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="number" class="form-control @error('firstOnly') is-invalid @enderror"
                            id="firstOnly" name="firstOnly"
                            @foreach ($hotel->prices as $price)
                            value="{{ $price->firstOnly }}" @endforeach>
                        @error('firstOnly')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="lastOnly"
                        class="col-lg-1 col-form-label ">{{ __('Koliko dana pre putovanja je LastMinute') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="number" class="form-control @error('lastOnly') is-invalid @enderror"
                            id="lastOnly" name="lastOnly"
                            @foreach ($hotel->prices as $price)
                            value="{{ $price->lastOnly }}" @endforeach>
                        @error('lastOnly')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                {{-- broj mesta u hotelu --}}

                <div class="row p-2">

                    <label for="price" class="col-lg-1 col-form-label ">{{ __('Broj mesta u hotelu') }}</label>
                    <div class="col-lg-3 input-box">
                        <input type="number" class="form-control @error('number') is-invalid @enderror" id="number"
                            name="number" value="{{ $hotel->number }}">
                        @error('number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


                <div class="d-grid gap-2">

                    <button type="submit" class="btn btn-md bg-blue">
                        {{ __('Sačuvaj izmene') }}
                    </button><a href="{{ back()->getTargetUrl() }}" class="btn btn-md bg-grey">{{ __('Odustani') }}</a>

                </div>
            </form>
        </div>
    </div>

@endsection
