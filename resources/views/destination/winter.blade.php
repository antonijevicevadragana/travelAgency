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
                @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($dest->startDate)->subDay())
                    {{-- nema prikaza ni poruke --}}
                @else
                    @php
                        if ($dest->transportation == 'autobus' || $dest->transportation == 'Autobus') {
                            $t = '🚌';
                        } elseif ($dest->transportation == 'avion' || $dest->transportation == 'Avion') {
                            $t = '🛪';
                        }
                        //racuna ukupan broj mesta za destinaciju
                        $sumaMesta = $dest->hotels->sum('number');
                        $start = $dest->startDate;
                        $startFormatted = date('d.m.Y', strtotime($start));
                        $end = $dest->endDate;
                        $endFormatted = date('d.m.Y', strtotime($end));

                    @endphp


                    <div class="col content ">
                        <div class="row mb-2">
                            <a href="{{ route('destination.show', $dest) }}" type="button"
                                class="btn btn-sm bg-blue"><i class="fa fa-eye" aria-hidden="true"></i>
                                {{ __('Prikaz') }}</a>

                        </div>
                        <h2>{{$dest->stateTranslate }} <a href="{{ route('destination.show', $dest) }}"
                                class="text-decoration-none">{{ $dest->cityTranslate }}</a></h2>
                                @if (count($dest->hotels) !== 0)
                                <div class="table-responsive indextable ">
                                    <table class="table table-bordered mb-0 indextable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Naziv') }}</th>
                                                <th>{{ __('Cena') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dest->hotels as $h)
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
        
                                                                $start = $dest->startDate; //datum polaska na putovanje
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
        
                            <p>{{ __('Početak putovanja') }}: {{ $startFormatted }} {{ __('Kraj putovanja') }}: 
                                {{ $endFormatted }}</p>
                            <p>{{ __('Ukupan broj mesta') }}: {{ $sumaMesta }}</p>

                        <hr>
                        <p class=" text-center"> {{ $t }}
                            {{ $dest->transportation }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div> 
@endsection
