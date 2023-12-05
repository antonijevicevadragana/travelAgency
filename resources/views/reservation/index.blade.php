@extends('layouts.app')
@section('content')
    <form action="{{ route('reservation.index') }}">
        @include('partials._search')
    </form>
<div class="blur text-center">
        <h2 class="text-light">{{__('Rezervacije')}}</h2>
        <div class="table-responsive indextable ">
            <table class="table table-bordered mb-0 indextable">
                <thead>
                    <tr>

                        <th>{{ __('Potvrda') }}</th>
                        <th>{{ __('Ime') }}</th>
                        <th>{{ __('Prezime') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Datareservation as $reservation)
                        <tr>
                            <td><h4><a
                                    href="{{ route('reservation.show', $reservation) }}">{{ $reservation->confirmationCode }}</a></h4>
                            </td>
                            <td>{{ $reservation->name }}</td>
                            <td>{{ $reservation->surname }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form method="post" action="{{ route('reservation.destroy', $reservation) }}">
                                        @method('Delete')
                                        @csrf
                                        <a href="{{ route('reservation.show', $reservation) }}" type="button"
                                            class="btn bg-blue btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                            {{ __('Prikaz') }}</a>
                                            
                                        <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{$Datareservation->links()}}
@endsection
