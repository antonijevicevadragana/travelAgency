@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row d-flex">
            <div class="col-sm-4 d-flex justify-content-center align-self-center">
                <img src="{{ asset('img/laste.png') }}" alt="" class="LogoImg">
            </div>
            <div class="col-sm-8">
                <h2 class="text-center">{{__('O NAMA')}}</h2>
                <p><q>{{__('Zdravo')}},  
                {{__('mi smo turisticka agencija koja posluje u Srbiji. Agencija je osnovana da bi pruzila zanimljiva putovanja za svaciji dzep, da priblizimo lepotu sveta Vama') }}.</q></p>
                <p>{{__('Zahvaljujemo vam na dosadašnjem poverenju, u nadi da ćemo i dalje putovati zajedno')}}.</p>
                <h2 class="text-center">{{__('KONTAKT')}}</h2>

                <p><i class="fa-solid fa-location-dot"></i> Neka ulica, 11000 Beograd</p>
                <p><i class="fa-solid fa-phone-volume"></i> 011/000-111-111</p>
                <p><i class="fa-solid fa-mobile-screen-button"></i> 060/000-000</p>
            </div>

        </div>
    </div>
    <br>
    <div class="content">
        {{-- proverava da li ulogovani korisnik ima rezervacije. Ako ima pojavljuje se dugme za mogucnost ostavljanja feedbacka ako ne poruka --}}
        {{-- u kontroleru je uradjena provera da le je korisnik ulogovan --}}
        @if (count($Checkreservation) === 0)
            <p class="text-center">{{__('Da biste ostavili recenziju morate imati rezervacije')  }}</p>
        @else
            <div class="d-grid gap-2">
                </button><a href="{{ route('feedback.create') }}" class="btn btn-md bg-blue">{{ __('Ostavi feedback') }}</a>
            </div>
        @endif

        <h2 class="text-center">{{__('Šta naši putnici kazu o nama')}}</h2>

        @foreach ($data as $feedback)
            @php
                if ($feedback->star == 1) {
                    $s = '★☆☆☆☆';
                } elseif ($feedback->star == 2) {
                    $s = '★★☆☆☆';
                } elseif ($feedback->star == 3) {
                    $s = '★★★☆☆';
                } elseif ($feedback->star == 4) {
                    $s = '★★★★☆';
                } else {
                    $s = '★★★★★';
                }

                // provera profila i slike

                if ($feedback->user->profile === null) {
                    $path = asset('img/other.jpg');
                    $name = $feedback->user->name;
                } else {
                    $name = $feedback->user->profile->nickname;
                    if ($feedback->user->profile->avatar) {
                        $path = asset('storage/' . $feedback->user->profile->avatar);
                    } else {
                        if ($feedback->user->profile->gender == 'male') {
                            $path = asset('img/male.png');
                        } elseif ($feedback->user->profile->gender == 'female') {
                            $path = asset('img/female.jpg');
                        } else {
                            $path = asset('img/other.jpg');
                        }
                    }
                }

            @endphp
            <div class="feed">
                <div class="row">
                    <div class="col-sm-4 d-flex justify-content-center align-self-center">
                        <div><img src="{{ $path }}" class="mb-2 FeedImg" alt="">
                            <p>{{__('Autor')}}: <i>{{ $name }}</i> </p>
                        </div>

                    </div>

                    <div class="col-sm-8">
                        <p class="d-flex justify-content-end">{{__('Ocena')}}: {{ $s }}</p>
                        <hr>
                        <p> {{__('Utisak se odnosi na putovanje')}}: {{ $feedback->destination->state }} - {{ $feedback->destination->city }}
                            ({{ $feedback->destination->transportation }})</p>

                        <p>{{ $feedback->feedback }}</p>
                        <hr>
                        <p class="d-flex justify-content-end small ">
                            {{ date('d.m.Y h:i:sa', strtotime($feedback->created_at)) }}</p>
                    </div>
                </div>
               
            </div>
            <div>
                <br>
            </div>
            
        @endforeach
        {{$data->links()}} 
    </div>
@endsection