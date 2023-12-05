@extends('layouts.show')
@section('content')
    @php
        $e = '€';
        use Carbon\Carbon; //da bi moglo manipulisati datumima
        if ($destination->transportation == 'autobus' || $destination->transportation == 'Autobus') {
            $t = '🚌';
        } elseif ($destination->transportation == 'avion' || $destination->transportation == 'Avion') {
            $t = '🛪';
        }
        //racuna ukupan broj mesta za destinaciju
        $sumaMesta = $destination->hotels->sum('number');

        $start = $destination->startDate;
        $startFormatted = date('d.m.Y', strtotime($start));
        $end = $destination->endDate;
        $endFormatted = date('d.m.Y', strtotime($end));
    @endphp

    <div class="row p-2">
        @if ($destination->type === 'izlet')
      
         {{-- {{$destinationId}} --}}
         <div class="bg-image" style="background-image: url('{{ asset('storage/' . $destination->coverImage) }}');"></div>
         <a class="btn btn-secondary bg-grey " href="{{ back()->getTargetUrl() }}">{{ __('Nazad') }}</a>

         <div>
             <h2 class="text-center p-2">{{ $destination->stateTranslate }} : {{ $destination->cityTranslate }} </h2>
             <p class="text-center">{{__('Ukupan broj mesta')}} - {{ $totalNum }} <br> {{__('Početak putovanja')}}: {{ $startFormatted }} {{__('Kraj putovanja')}}:
                 {{ $endFormatted }}</p>
             <p class="text-center">{{__('Polasci')}}: {{ $destination->startCity }}</p>
         </div>
         <div class="justify">
             <h2>{{ __('Opis i program putovanja') }}</h2>
             {!! nl2br(e($destination->description)) !!}
         </div>

         <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="">
                    <tr>
                        <th>{{ __('Cena') }}</th>
                        <th>{{ __('Ukupan broj mesta') }}</th>
                        <th>{{__('Slobodno')}}</th>
                        <th>{{ __('Rezervacije') }}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                        <tr>
                            <td>
                                <p> {{ $destination->priceTrip }}</p>
                            </td>
                            <td> {{ $destination->number }}</td>

                            {{-- racunamo broj slobodnih mesta --}}
                            <td>
                                @php
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

                                {{ $ukupnoMesta - $ukupnoRezervisano }}
                            </td>
                            <td>
                                @php
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
                                {{-- nemogucnost rezervisanja ako nema slobodnih mesta ili je datum za 1 dan manji od pocetka putovanja --}}
                                @if ($slobodno == 0)
                                    {{ 'RASPRODATO ' }}


                                    {{-- <p>pocetak putovanja{{ $start }}</p> --}}
                                    {{-- @elseif(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($start)->subDay())
                                        {{ 'istekla mogucnost rezervacije' }} --}}
                                @elseif(isset($start))
                                    @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($start)->subDay())
                                        {{ 'istekla mogucnost rezervacije' }}
                                    @else
                                        @if (!$auth)
                                            {{ 'Ulogujte se da biste izvršili rezervaciju.' }}
                                        @else
                                            {{-- ako je ulogovan da moze da rezervise, u kontorleru je resenje ako je vec rezervisao neki od hotela za destinaciju --}}
                                            <a class="btn btn-primary bg-blue"
                                                href="{{ route('reservation.create', ['hotel' => null, 'destination' => $destination->id, ]) }}">
                                                {{ __('Rezerviši') }}

                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                   
                </tbody>
            </table>






         {{--  --}}



         {{-- za destinacije koje nisu izleti (vise dana/nocenja) --}}
        @else
            {{-- {{$destinationId}} --}}
            <div class="bg-image" style="background-image: url('{{ asset('storage/' . $destination->coverImage) }}');"></div>
            <a class="btn btn-secondary bg-grey " href="{{ back()->getTargetUrl() }}">{{ __('Nazad') }}</a>

            <div>
                <h2 class="text-center p-2">{{ $destination->stateTranslate }} : {{ $destination->cityTranslate }} </h2>
                <p class="text-center">{{__('Ukupan broj mesta')}}  - {{ $totalNum }} <br> {{__('Početak putovanja')}}: {{ $startFormatted }} {{__('Kraj putovanja')}}
                    {{ $endFormatted }}</p>
                <p class="text-center">{{__('Polasci')}}: {{ $destination->startCity }}</p>
            </div>
            <div class="justify">
                <h2>{{ __('Opis i program putovanja') }}</h2>
                {!! nl2br(e($destination->description)) !!}
            </div>

            {{-- u tabeli --}}
            <p><br>{{ __('Ponuda po hotelima') }}</p>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="">
                        <tr>
                            <th>{{ __('Hotel') }}</th>
                            <th>{{ __('Cena') }}</th>
                            <th>{{ __('Specijalne cene') }}</th>
                            <th>{{ __('Ukupan broj mesta') }}</th>
                            <th>{{ __('Slobodno') }}</th>
                            <th>{{__('Rezervacije') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- prolazi se kroz svaki hotel i prikazuju trazene vrednost --}}
                        @foreach ($hotels as $h)
                            <tr>


                                <td><a href="{{ route('hotel.show', $h) }}">{{ $h->name }}</a></td>
                                <td>
                                    {{-- u kontorleru je prolazeno kroz svaku cenu hotela, a cenu trenutnog hotela dobijamo kad pozovemo njen id --}}
                                    {{-- <p>{{ $price[$h->id] }} </p> --}}
                                    @if (isset($price[$h->id]))
                                        {{ $price[$h->id] }}
                                    @else
                                        {{ 'Nema dostupnih cena' }}
                                    @endif
                                </td>

                                <td>
                                    <p> {{ $currentPrices[$h->id] }}</p>
                                </td>
                                <td> {{ $h->number }}</td>

                                {{-- racunamo broj slobodnih mesta --}}
                                <td>
                                    @php
                                        $ukupnoMesta = $h->number;
                                        $ukupnoRezervisano = 0; // Inicijalizujemo promenljivu za ukupno rezervisane
                                    @endphp

                                    @foreach ($h->reservations as $reservation)
                                        @if ($reservation->hotel_id === $h->id)
                                            @php
                                                $ukupnoRezervisano += $reservation->passingerNumbers; // Dodajemo broj rezervisanih
                                            @endphp
                                        @endif
                                    @endforeach

                                    {{ $ukupnoMesta - $ukupnoRezervisano }}
                                </td>
                                <td>
                                    @php
                                        $ukupnoMesta = $h->number;
                                        $ukupnoRezervisano = 0; // Inicijalizujemo promenljivu za ukupno rezervisane
                                    @endphp

                                    @foreach ($h->reservations as $reservation)
                                        @if ($reservation->hotel_id === $h->id)
                                            @php
                                                $ukupnoRezervisano += $reservation->passingerNumbers; // Dodajemo broj rezervisanih
                                            @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        $slobodno = $ukupnoMesta - $ukupnoRezervisano;
                                    @endphp
                                    {{-- nemogucnost rezervisanja ako nema slobodnih mesta ili je datum za 1 dan manji od pocetka putovanja --}}
                                    @if ($slobodno == 0)
                                        {{ __('RASPRODATO') }}


                                        {{-- <p>pocetak putovanja{{ $start }}</p> --}}
                                        {{-- @elseif(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($start)->subDay())
                                            {{ 'istekla mogucnost rezervacije' }} --}}
                                    @elseif(isset($start))
                                        @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($start)->subDay())
                                            {{ __('Istekla mogucnost rezervacije') }}
                                        @else
                                            @if (!$auth)
                                                {{ __('Ulogujte se da biste izvršili rezervaciju') }}
                                            @else
                                                {{-- ako je ulogovan da moze da rezervise, u kontorleru je resenje ako je vec rezervisao neki od hotela za destinaciju --}}
                                                <a class="btn btn-primary bg-blue"
                                                    href="{{ route('reservation.create', ['hotel' => $h->id, 'destination' => $h->destination_id]) }}">
                                                    {{ __('Rezerviši') }}

                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
