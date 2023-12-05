@extends('layouts.app')
@section('content')
    @php
        use Carbon\Carbon; //da bi moglo manipulisati datumima
        $e = '€';

        $today = now();

        //za paginaciju posto ima deo gde se proverava datum ispod. Tek kad se to proveri na te podatke raditi paginate,i kroz te podatke raditi foreach
        $filteredDestinations = $destination->filter(function ($dest) use ($today) {
            return Carbon::now() <= Carbon::parse($dest->startDate)->subDay();
        });

        $perPage = 6; // Number of items per page
        $currentPage = request()->input('page', 1);

        // paginate na filtrirane podatke (filtirno po datumu uz pomoc Carbon i tako smo dobili $filteredDestinations)
        $paginatedDestinations = new \Illuminate\Pagination\LengthAwarePaginator($filteredDestinations->forPage($currentPage, $perPage), $filteredDestinations->count(), $perPage, $currentPage, [
            'path' => url()->current() . '?page',
        ]);

    @endphp
    <form action="{{ route('destination.index') }}">
        @include('partials._search')
    </form>

    <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">
        {{-- prolazimo kroz svaku destinaciju ali filtriranu na koju je radjena paginacija --}}
        @foreach ($paginatedDestinations as $destination)
            @php
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

            <div class="col content ">

                <div class="row mb-2">
                    <a href="{{ route('destination.show', $destination) }}" type="button" class="btn btn-sm bg-blue"><i
                            class="fa fa-eye" aria-hidden="true"></i>
                        {{ __('Prikaz') }}</a>

                </div>

                <h2>{{ $destination->stateTranslate }} <a href="{{ route('destination.show', $destination) }}"
                        class="text-decoration-none">{{ $destination->cityTranslate }}</a></h2>

                @if (count($destination->hotels) !== 0)
                    <div class="table-responsive indextable ">
                        <table class="table table-bordered mb-0 indextable">
                            <thead>
                                <tr>
                                    <th>{{ __('Naziv') }}</th>
                                    <th>{{ __('Cena') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($destination->hotels as $h)
                                    <tr>

                                        <td>{{ $h->name }}</td>
                                        <td>
                                            @foreach ($h->prices as $priceModel)
                                                @php

                                                    $Standardprice = $priceModel->price;
                                                    $firstPrice = $priceModel->firstMin;
                                                    $lastPrice = $priceModel->lasteMin;
                                                    $ConditionFirstPrice = $priceModel->firstOnly;
                                                    $ConditionLastPrice = $priceModel->lastOnly;
                                                    $created = $priceModel->created_at;

                                                    $carbonFirstMinDate = Carbon::parse($created); //kreiran oglas za putpvanje
                                                    $ReservationFrstMin = $carbonFirstMinDate->addDays($ConditionFirstPrice);

                                                    $start = $destination->startDate; //datum polaska na putovanje
                                                    $carbonStart = Carbon::parse($start);
                                                    $startLastMin = $carbonStart->subDays($ConditionLastPrice);
                                                    if ($startLastMin->lessThanOrEqualTo($today)) {
                                                        $currentPrices = $lastPrice . $e . ' Last Minute';
                                                    } elseif ($today->lessThanOrEqualTo($ReservationFrstMin)) {
                                                        $currentPrices = $firstPrice . $e . ' First Minute';
                                                    } else {
                                                        $currentPrices = $Standardprice . $e;
                                                    }
                                                    echo $currentPrices;
                                                @endphp
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($destination->type === 'izlet')
                    <div class="table-responsive indextable ">
                        <table class="table table-bordered mb-0 indextable">
                            <thead>
                                <tr>
                                    <th>{{ __('Naziv') }}</th>
                                    <th>{{ __('Cena') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ __('Izlet') }}</td>
                                    <td>{{ $destination->priceTrip }} {{ $e }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif


                <p>{{ __('Početak putovanja') }}: {{ $startFormatted }} {{ __('Kraj putovanja') }}:
                    {{ $endFormatted }}</p>
                @if ($destination->type === 'izlet')
                    <p>{{ __('Ukupan broj mesta') }} : {{ $destination->number }}</p>
                @else
                    <p>{{ __('Ukupan broj mesta') }} : {{ $sumaMesta }}</p>
                @endif
                <hr>
                <p class=" text-center"> {{ $t }}
                    {{ $destination->transportation }}</p>
            </div>
        @endforeach
    </div>
    {{ $paginatedDestinations->links() }}
@endsection
