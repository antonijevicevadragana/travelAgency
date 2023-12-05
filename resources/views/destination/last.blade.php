@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon; //da bi moglo manipulisati datumima
        $e = '€';
      
    @endphp
    <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">
        {{-- prolazimo kroz hotele i uzimamo podatke --}}
        @foreach ($hotelName as $hotel)
            @php
                if ($hotel->destination->transportation == 'autobus' || $hotel->destination->transportation == 'Autobus') {
                    $t = '🚌';
                } elseif ($hotel->destination->transportation == 'avion' || $hotel->destination->transportation == 'Avion') {
                    $t = '🛪';
                }
            @endphp

            @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($hotel->destination->startDate)->subDay())
                {{-- nema prikaza ni poruke --}}
            @else
                <div class="col content ">
                    <div class="d-grid gap-2">
                        <a href="{{ route('destination.show', $hotel->destination->id) }}" type="button"
                            class="btn btn-sm bg-blue"><i class="fa fa-eye" aria-hidden="true"></i>
                            {{ __('Prikaz') }}</a>
                        <a href="{{ route('reservation.create', ['hotel' => $hotel->id, 'destination' => $hotel->destination_id]) }}"
                            type="button" class="btn btn-sm bg-blue"><i class="fa fa-eye" aria-hidden="true"></i>
                            {{ __('Rezervisi') }}</a>
                    </div>

                    <h2 class="text-center"><a href="{{ route('destination.show', $hotel->destination->id) }}"
                        class="text-decoration-none ">{{ $hotel->destination->cityTranslate }}</a></h2>
                    
                    <h2 class="text-center"><a href="{{ route('hotel.show', $hotel->id) }}"  class="text-decoration-none text-center">{{ $hotel->name }}</a></h2>
                   

                    @foreach ($hotel->prices as $p)
                        <div class="table-responsive indextable">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <td>
                                        <h3><del>{{ $p->price }}{{ $e }}</del>{{ $p->lasteMin }}{{ $e }}
                                        </h3>
                                    </td>
                                    <td>
                                        @php
                                            $ukupnoMesta = $hotel->number;
                                            $ukupnoRezervisano = 0; // Inicijalizujemo promenljivu za ukupno rezervisane
                                        @endphp

                                        @foreach ($hotel->reservations as $reservation)
                                            @if ($reservation->hotel_id === $hotel->id)
                                                @php
                                                    $ukupnoRezervisano += $reservation->passingerNumbers; // Dodajemo broj rezervisanih
                                                @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            $slobodno = $ukupnoMesta - $ukupnoRezervisano;
                                        @endphp
                                        <h4>{{__('Slobodnih mesta')}}: {{ $slobodno }}</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                    <hr>
                    <p class="text-center">{{ $hotel->destination->transportation }} {{ $t }}</p>
                </div>
            @endif
        @endforeach
    </div>
@endsection
