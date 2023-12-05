@extends('layouts.app')
@section('content')
<div class="row  p-2">
    <div class="col content">
    @if ($hotelId === null)
        @php
            $euro = '€';
            // echo $hotelId;  //provera
            

            $ukupnoMesta = $destination->number;
            $ukupnoRezervisano = 0; // Inicijalizujemo promenljivu za ukupno rezervisane
        @endphp

        @foreach ($destination->reservations as $reservation)
            @if ($reservation->destination_id === $destination->id)
                @php
                    $ukupnoRezervisano += $reservation->passingerNumbers; // Dodajemo broj rezervisanih
                @endphp
            @endif
        @endforeach
        @php
            $slobodno = $ukupnoMesta - $ukupnoRezervisano;
        @endphp

        <h2 class="text-center">{{ $destination->city }}</h2>
        <h2 class="text-center">{{ $prices }} {{ $euro }}</h2>
        <p class="text-center">{{__('Slobodnih mesta')}}: {{ $slobodno }}</p>
        <hr>
        <form method="POST" action="{{ route('reservation.store') }}">

            @csrf
            {{-- dugmici za potvrdu/odustajanje --}}
            <input type="hidden" name="hotel_id" value="{{ $hotelId }}">
            <input type="hidden" name="destination_id" value="{{ $destinationId }}">

            <div class="row p-2">
                <label for="name" class="col-lg-1 col-form-label ">{{ __('Ime') }}</label>
                <div class="col-lg-5 input-box">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="surname" class="col-lg-1 col-form-label ">{{ __('Prezime') }}</label>
                <div class="col-lg-5 input-box">
                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                        name="surname" value="{{ old('surname') }}">
                    @error('surname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="row p-2">
                <label for="phoneNumber" class="col-lg-1 col-form-label ">{{ __('Broj telefona') }}</label>
                <div class="col-lg-5 input-box">
                    <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                        id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="p-2 row">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <p class="col-sm-1 col-form-label">{{ __('Broj osoba')}}</p>
                    <div class="p-2 input-box">
                        <input type="radio" class="btn-check" name="passingerNumbers" id="1"
                            value="1" @if (old('passingerNumbers') === '1') checked @endif>
                        <label class="btn btn-outline-primary bg-label"
                            for="1">{{ __('1 (Rezervacija za sebe)') }} </label>

                        <input type="radio" class="btn-check" name="passingerNumbers" id="2"
                            value="2" @if (old('passingerNumbers') === '2') checked @endif>
                        <label class="btn btn-outline-primary bg-label"
                            for="2">{{ __('2 (Rezervacija za sebe i jos jednu osobu)') }}</label>

                        <input type="radio" class="btn-check" name="passingerNumbers" id="3"
                            value="3" @if (old('passingerNumbers') === '3') checked @endif>
                        <label class="btn btn-outline-primary bg-label"
                            for="3">{{ __('3 (Rezervacija za sebe i jos dve osobe)') }}</label>

                        <input type="radio" class="btn-check" name="passingerNumbers" id="4"
                            value="4" @if (old('passingerNumbers') === '4') checked @endif>
                        <label class="btn btn-outline-primary bg-label"
                            for="4">{{ __('4 (Rezervacija za sebe i jos dve osobe)') }}</label>

                        <input type="radio" class="btn-check" name="passingerNumbers" id="5"
                            value="5" @if (old('passingerNumbers') === '5') checked @endif>
                        <label class="btn btn-outline-primary bg-label"
                            for="5">{{ __('5 (Rezervacija za sebe i jos dve osobe)') }}</label>
                    </div>
                </div>
                <p>{{__('Sve sobe su 1/2 i 1/3. Ukoliko rezervisete za 1 osobu, bicete rasporedjeni u sobu po slobodnim kapacitetima')}}</p>
                <p>{{__('Obratite paznju na broj slobodnih mesta. Rezervacija je samo do broja slobodnih mesta')}}</p>
                <p>* {{__('Ako je slobodno 4 mesta a Vi pokusate da rezervisete 5, rezervisano ce biti 4 mesta')}}</p>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm bg-blue">
                    {{ __('Sacuvaj') }}
                </button><a href="{{ back()->getTargetUrl() }}"
                    class="btn btn-sm bg-grey">{{ __('Odustani') }}</a>
            </div>

        </form>
    </div>
</div>

    @else
        <div class="row  p-2">
            <div class="col content">
                @php
                    $euro = '€';
                    // echo $hotelId;  //provera
                    // echo $destinationId;

                    $ukupnoMesta = $resHotel->number;
                    $ukupnoRezervisano = 0; // Inicijalizujemo promenljivu za ukupno rezervisane
                @endphp

                @foreach ($resHotel->reservations as $reservation)
                    @if ($reservation->hotel_id === $resHotel->id)
                        @php
                            $ukupnoRezervisano += $reservation->passingerNumbers; // Dodajemo broj rezervisanih
                        @endphp
                    @endif
                @endforeach
                @php
                    $slobodno = $ukupnoMesta - $ukupnoRezervisano;
                @endphp

                <h2 class="text-center">{{ $resHotel->name }}</h2>
                <h2 class="text-center">{{ $p }} {{ $euro }}</h2>
                <p class="text-center">{{__('Slobodnih mesta')}}: {{ $slobodno }}</p>
                <hr>

                <form method="POST" action="{{ route('reservation.store') }}">

                    @csrf
                    {{-- dugmici za potvrdu/odustajanje --}}
                    <input type="hidden" name="hotel_id" value="{{ $hotelId }}">
                    <input type="hidden" name="destination_id" value="{{ $destinationId }}">

                    <div class="row p-2">
                        <label for="name" class="col-lg-1 col-form-label ">{{ __('Ime') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label for="surname" class="col-lg-1 col-form-label ">{{ __('Prezime') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                                name="surname" value="{{ old('surname') }}">
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row p-2">
                        <label for="phoneNumber" class="col-lg-1 col-form-label ">{{ __('Broj telefona') }}</label>
                        <div class="col-lg-5 input-box">
                            <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                                id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}">
                            @error('phoneNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="p-2 row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <p class="col-sm-1 col-form-label">{{ 'Broj osoba' }}</p>
                            <div class="p-2 input-box">
                                <input type="radio" class="btn-check" name="passingerNumbers" id="1"
                                    value="1" @if (old('passingerNumbers') === '1') checked @endif>
                                <label class="btn btn-outline-primary bg-label"
                                    for="1">{{__('1 (Rezervacija za sebe)')  }} </label>

                                <input type="radio" class="btn-check" name="passingerNumbers" id="2"
                                    value="2" @if (old('passingerNumbers') === '2') checked @endif>
                                <label class="btn btn-outline-primary bg-label"
                                    for="2">{{ __('2 (Rezervacija za sebe i jos jednu osobu)') }}</label>

                                <input type="radio" class="btn-check" name="passingerNumbers" id="3"
                                    value="3" @if (old('passingerNumbers') === '3') checked @endif>
                                <label class="btn btn-outline-primary bg-label"
                                    for="3">{{ __('3 (Rezervacija za sebe i jos dve osobe)') }}</label>

                                <input type="radio" class="btn-check" name="passingerNumbers" id="4"
                                    value="4" @if (old('passingerNumbers') === '4') checked @endif>
                                <label class="btn btn-outline-primary bg-label"
                                    for="4">{{ __('4 (Rezervacija za sebe i jos dve osobe)') }}</label>

                                <input type="radio" class="btn-check" name="passingerNumbers" id="5"
                                    value="5" @if (old('passingerNumbers') === '5') checked @endif>
                                <label class="btn btn-outline-primary bg-label"
                                    for="5">{{ __('5 (Rezervacija za sebe i jos dve osobe)') }}</label>
                            </div>
                        </div>
                        <p>{{__('Sve sobe su 1/2 i 1/3. Ukoliko rezervisete za 1 osobu, bicete rasporedjeni u sobu po slobodnim kapacitetima')}}</p>
                        <p>{{__('Obratite paznju na broj slobodnih mesta. Rezervacija je samo do broja slobodnih mesta')}}</p>
                        <p>* {{__('Ako je slobodno 4 mesta a Vi pokusate da rezervisete 5, rezervisano ce biti 4 mesta')}}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-sm bg-blue">
                            {{ __('Sacuvaj') }}
                        </button><a href="{{ back()->getTargetUrl() }}"
                            class="btn btn-sm bg-grey">{{ __('Odustani') }}</a>
                    </div>

                </form>
            </div>
        </div>
    @endif
@endsection
