@extends('layouts.show')
@section('content')
    @php
        $e = '€';
    @endphp
    <div class="row p-2">
        <div id="demo" class="carousel slide okvir" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @php
                    $slike = []; // prazan array za slike
                    $counter = 0;

                @endphp
                {{-- prolazimo kroz slike --}}
                @foreach ($images as $image)
                    @php
                        $slike[] = $image->path; // Dodajemo slike u $slike
                    @endphp
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $counter }}"
                        class="{{ $counter === 0 ? 'active' : '' }}"></button>
                    @php
                        $counter++; //za svaku ubacenu sliku coutner se povecava za jedan
                    @endphp
                @endforeach
            </div>

            <!-- The slideshow -->
            <div class="carousel-inner">
                @php
                    $counter = 0; // reseruje se counter za slijder.
                    //ako je prva slika odnosno $counter === 0 to je aktivna tj. div dobija classu acitve u suprotnom ce biti classa change-item
                @endphp

                @foreach ($slike as $key => $slika)
                    <div class="carousel-item{{ $counter === 0 ? ' active' : '' }} change-item">
                        <img src="{{ asset('storage/' . $slika) }}" alt="" class="d-block images">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__backInRight">{{ __('Slike izbaranog hotela') }}</h2>
                        </div>
                    </div>
                    @php
                        $counter++;
                    @endphp
                @endforeach
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

    </div>
    <div>
        <h2 class="text-center p-2">{{ $hotel->name }} </h2>
    </div>
    @if ($hotel->link)
        <div class="row mb-2">
            <a href="{{ $hotel->link }}" target="_blank" class="btn btn-sm  bg-blue">
                <i class="fa-solid fa-globe"></i>
                {{ __('website hotela') }}</a>
        </div>
    @endif

    <div class="justify">
        <h2>{{ __('Opis i program putovanja') }}</h2>
        {!! nl2br(e($hotel->descriptTranslate)) !!}
    </div>

    {{-- podaci o ceni i broju  u tabeli --}}

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('Naziv hotela') }}</th>
                <th>{{ __('Destinacija') }}</th>
                <th>{{ __('Adresa') }}</th>
                <th>{{ __('Broj mesta') }}</th>
                <th>{{ __('Slobodno') }}</th>
                <th>{{ __('Cena') }}</th>
                <th>{{ __('Specijalna cena') }}</th>
            </tr>
        </thead>
        <tbody>
            <td> {{ $hotel->name }}</td>
            <td> {{ $hotel->destination->state }} :{{ $hotel->destination->city }} </td>
            <td><i class="fa-solid fa-location-dot"></i> {{ $hotel->location }}</td>
            <td> {{ $hotel->number }}</td>
            <td>
                @php
                    $slobodno = $hotel->number;
                @endphp

                @foreach ($hotel->reservations as $r)
                    @php
                        if ($r) {
                            $zauzeto = $r->passingerNumbers;
                            $slobodno -= $zauzeto; // u slucaju da postoje rezervacije izracunaj broj slobodnih mesta
                        }
                    @endphp
                @endforeach

                {{ $slobodno }} 

            </td>
            <td> {{ $Standardprice }} {{ $e }}</td>

            <td> {{ $p }} {{ $e }}</td>
        </tbody>

    </table>

    <div class="row mb-2">
        <a class="btn btn-sm bg-blue"
            href="{{ route('reservation.create', ['hotel' => $hotel->id, 'destination' => $hotel->destination_id]) }}">
            {{ __('Rezerviši') }}
        </a>
        <a class="btn btn-sm bg-grey" href="{{ back()->getTargetUrl() }}">
            {{ __('Nazad') }}
        </a>
    </div>
@endsection
