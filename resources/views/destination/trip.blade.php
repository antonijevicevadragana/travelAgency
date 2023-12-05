@extends('layouts.app')
@section('content')
    <div class="container">
        @php
            use Carbon\Carbon; //da bi moglo manipulisati datumima
            $e = '€';

            $today = now();

        @endphp

        <form action="{{ route('destination.index') }}">
            @include('partials._search')
        </form>

        <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">

            @foreach ($destination as $dest)
                @php
                    if ($dest->transportation == 'autobus' || $dest->transportation == 'Autobus') {
                        $t = '🚌';
                    } elseif ($dest->transportation == 'avion' || $dest->transportation == 'Avion') {
                        $t = '🛪';
                    }
                    //racuna ukupan broj mesta za destinaciju
                    // $sumaMesta = $dest->hotels->sum('number');
                    $sumaMesta = $dest->number;  //za izlete nema nocenja, nema hotela zato se uzima broj iz destinacija
                    $start = $dest->startDate;
                    $startFormatted = date('d.m.Y', strtotime($start));
                    $end = $dest->endDate;
                    $endFormatted = date('d.m.Y', strtotime($end));

                @endphp
                @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($dest->startDate)->subDay())
                    {{-- nema prikaza ni poruke --}}
                @else
                    <div class="col content ">
                        <div class="row mb-2">
                            <a href="{{ route('destination.show', $dest) }}" type="button"
                                class="btn btn-sm bg-blue"><i class="fa fa-eye" aria-hidden="true"></i>
                                {{ __('Prikaz') }}</a>

                        </div>
                        <h2>{{ $dest->stateTranslate }} <a href="{{ route('destination.show', $dest) }}"
                                class="text-decoration-none">{{ $dest->cityTranslate }}</a></h2>
                           
        
                        <p>{{ __('Početak putovanja') }}: {{ $startFormatted }} {{ __('Kraj putovanja') }}: 
                            {{ $endFormatted }}</p>
                        <p>{{ __('Ukupan broj mesta') }}: {{ $sumaMesta }}</p>
                        <h2>{{ __(' Cena: ') }}{{ $dest->priceTrip}} {{$e}}</h2>
                       

                        <hr>
                        <p class=" text-center"> {{ $t }}
                            {{ $dest->transportation }}</p>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
   
@endsection
