@extends('layouts.app')
@section('content')
    @php
        $create = $reservation->created_at;
        $dateFormatted = date('d.m.Y h:i:sa', strtotime($create));

        if ($reservation->destination->transportation == 'autobus' || $reservation->destination->transportation == 'Autobus') {
            $t = '🚌';
        } elseif ($reservation->destination->transportation == 'avion' || $reservation->destination->transportation == 'Avion') {
            $t = '🛪';
        }

        $start = $reservation->destination->startDate;
        $startFormatted = date('d.m.Y', strtotime($start));
        $end = $reservation->destination->endDate;
        $endFormatted = date('d.m.Y', strtotime($end));

        $e = '€';
    @endphp
    <div class="container">
        <div class="blur text-center">
            <h2 class="text-light">{{__('Rezervacija')}}</h2>
            <div class="table-responsive indextable ">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Datum rezervacije') }}</th>
                            <th>{{ __('Potvrda') }}</th>
                            <th>{{ __('Destinacija') }}</th>
                            <th>{{__('Hotel')}}</th>
                            <th>{{ __('Ime') }} & {{__('Prezime')}}</th>
                            <th>{{ __('☏') }}</th>
                            <th>{{ __('Br. putnika') }}</th>
                            <th>{{ __('Cena') }}</th>
                            <th>{{ __('mail') }}</th>
                            <th> </th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $dateFormatted }}</td>
                            <td>{{ $reservation->confirmationCode }}</td>
                            <td>
                                <h5><a href="{{ route('destination.show', ['destination' => $reservation->destination_id]) }}"
                                        class="link">{{ $reservation->destination->city }}</a> {{ $t }}</h5>
                                {{ $startFormatted }} - {{ $endFormatted }}
                            </td>
                            @if ($reservation->destination->type==='izlet')
                            <td>{{'izlet'}}</td>
                            @else
                            <td><a href="{{ route('hotel.show', ['hotel' => $reservation->hotel_id]) }}"
                                class="link">{{ $reservation->hotel->name }}</a></td>  
                            @endif
                          
                            <td>{{ $reservation->name }} {{ $reservation->surname }}</td>
                            <td>{{ $reservation->phoneNumber }}</td>
                            <td>{{ $reservation->passingerNumbers }}</td>
                            <td>{{ $reservation->reservationPrice }} {{ $e }}</td>
                            <td>{{ $reservation->user->email }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form method="post" action="{{ route('reservation.destroy', $reservation) }}">
                                        @method('Delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
@endsection
