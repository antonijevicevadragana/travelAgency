@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{__('Profil' ) }}</h3>
            <hr>
            @if (count($profil) == 0)
                <h3>{{__('Profil nije kreiran')}}</h3>

                <div class="d-grid gap-2">
                    </button><a href="{{ route('profile.create') }}" class="btn btn-md bg-blue">{{ __('Kriraj profil') }}</a>
                </div>
            @else
                <div class="row">
                    @foreach ($profil as $profil)
                        <div class="col-3 text-center my-5">
                            @php
                                if ($profil->avatar) {
                                    $path = asset('storage/' . $profil->avatar);
                                }
                                if (empty($profil->avatar) && $profil->gender == 'male') {
                                    $path = asset('img/male.png');
                                }
                                if (empty($profil->avatar) && $profil->gender == 'female') {
                                    $path = asset('img/female.jpg');
                                }
                                if (empty($profil->avatar) && $profil->gender == 'other') {
                                    $path = asset('img/other.jpg');
                                }
                            @endphp

                            <img src="{{ $path }}" class="mb-2 profileImg" alt="">
                        </div>
                        <div class="col-9">
                            <p>{{__('Nadimak')}}: {{ $profil->nickname }}</p>
                            <p>{{__('Ime')}}: {{ $profil->name }} {{ $profil->surname }}</p>
                            <p>{{__('Datum rodjenja')}}: {{ $profil->dateofBirth }}</p>
                            @if ($profil->hightlight)
                                <p>{{__('Poruka')}}: <i> {{ $profil->hightlight }}</i></p>
                            @else
                                <p><i>{{__('Nema poruke za prikaz')}}:<i></p>
                            @endif
                            {{-- podaci o rezervacijama  --}}
                            <div class="text-center">
                                <h4>{{__('Moje REZERVACIJE')}}</h4>
                            </div>
                            @if (count($reservation) == 0)
                                <p class="text-center">{{ 'nema podataka o rezervacijama' }}</p>
                            @else
                                <div class="table-responsive indextable ">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Datum rezervisanja') }}</th>
                                                <th>{{ __('Potvrda') }}</th>
                                                <th>{{ __('Destinacija') }}</th>
                                                <th>{{ __('☏') }}</th>
                                                <th>{{ __('Br. putnika') }}</th>
                                                <th>{{ __('Cena') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reservation as $res)
                                                @php
                                                    $create = $res->created_at;
                                                    $dateFormatted = date('d.m.Y h:i:sa', strtotime($create));
                                                    $e = '€';
                                                    $start = $res->destination->startDate;
                                                    $startFormatted = date('d.m.Y', strtotime($start));
                                                    $end = $res->destination->endDate;
                                                    $endFormatted = date('d.m.Y', strtotime($end));
                                                    $t = $res->destination->transportation;
                                                    if ($t == 'autobus') {
                                                        $t = '🚌';
                                                    } else {
                                                        $t = '🛪';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{  $dateFormatted }}</td>
                                                    <td>{{ $res->confirmationCode }}</td>
                                                    <td>
                                                        <h5><a href="{{ route('destination.show', ['destination' => $res->destination_id]) }}"
                                                                class="link">{{ $res->destination->city }}</a>
                                                            {{ $t }}
                                                        </h5>
                                                        {{ $startFormatted }} - {{ $endFormatted }}
                                                    </td>
                                                    <td>{{ $res->phoneNumber }}</td>
                                                    <td>{{ $res->passingerNumbers }}</td>
                                                    <td>{{ $res->reservationPrice }} {{ $e }}</td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            {{-- blogovi  --}}
                            <h4 class="text-center">{{__('Moji BLOGOVI')}}</h4>
                            @if (count($blog) == 0)
                            <p class="text-center"> {{__('Nema podataka o blogovima')  }}</p>
                            @else
                                @foreach ($blog as $b)
                                    <h4>{{ '❖' }} <a href="{{ route('blog.show', ['blog' => $b->id]) }}"
                                            class="link">{{ $b->title }}</a></h4>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <a type="button" class="btn btn-primary bg-blue"
                                href="{{ route('profile.edit', $profil) }}">{{__('Izmeni')}}
                               {{__('Profil') }}</a>
                        </div>
                    @endforeach


                </div>
            @endif
        </div>
    </div>

@endsection
