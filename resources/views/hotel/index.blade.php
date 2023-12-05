@extends('layouts.app')
@section('content')
    <form action="{{ route('hotel.index') }}">
        @include('partials._search')
    </form>
    <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">
        @foreach ($dataHotel as $hotel)
            <div class="col content ">
                <div class="row mb-2">
                    <a href="{{ route('hotel.show', $hotel) }}" type="button" class="btn btn-sm bg-blue"><i class="fa fa-eye"
                            aria-hidden="true"></i>
                        {{__('Prikaz')  }}</a>
                </div>
                <div class="row mb-2">
                    <form method="POST" action="{{ route('hotel.destroy', $hotel) }}">
                        @method('delete')
                        @csrf
                        <a href="{{ route('hotel.edit', $hotel) }}" type="button" class="btn btn-info btn-sm"><i
                                class="fa-solid fa-pencil"></i>
                            {{__('Izmeni')  }}</a>
                        <button type="submit" class="btn btn-danger btn-sm delete-button"><i class="fa-solid fa-trash"></i>
                            {{__('Izbriši')  }}</button>

                    </form>

                </div>
                <h4>{{ $hotel->destination->stateTranslate }} <a
                        href="{{ route('destination.show', ['destination' => $hotel->destination->id]) }}">{{ $hotel->destination->cityTranslate }}</a>
                </h4>
                <h4>{{ __('Hotel: ') }} <a href="{{ route('hotel.show', $hotel) }}">{{ $hotel->name }}</a></h4>
                {{-- <h4><a
                        href="{{ route('destination.show', ['destination' => $hotel->destination->id]) }}">{{ $hotel->destination->DestinationInfo }}</a>
                </h4> --}}


                <p><i class="fa-solid fa-location-dot"></i> {{ $hotel->location }} </p>

                <p>{{ substr($hotel->descriptTranslate, 0, 80) }}...</p>
                @if ($hotel->link)
                <div class="row mb-2">
                    <a href="{{ $hotel->link }}" target="_blank" class="btn btn-sm bg-blue">
                        <i class="fa-solid fa-globe"></i>
                        {{ __('website hotela') }}</a>
                </div>

                @endif
               
            </div>
        @endforeach
    </div>
    {{$dataHotel->links()}}

@endsection
