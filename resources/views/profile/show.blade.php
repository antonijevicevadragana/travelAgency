@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{__('Profil')  }}</h3>
            <hr>
            <div class="row">

                <div class="col-3 text-center my-5">
                    @php
                        if ($profile->avatar) {
                            $path = asset('storage/' . $profile->avatar);
                        }
                        if (empty($profile->avatar) && $profile->gender == 'male') {
                            $path = asset('img/male.png');
                        }
                        if (empty($profile->avatar) && $profile->gender == 'female') {
                            $path = asset('img/female.jpg');
                        }
                        if (empty($profile->avatar) && $profile->gender == 'other') {
                            $path = asset('img/other.jpg');
                        }
                    @endphp

                    <img src="{{ $path }}" class="mb-2 profileImg" alt="">
                </div>
                <div class="col-9">
                    <p>{{__('Nadimak')}}: {{ $profile->nickname }}</p>
                    <p>{{__('Ime')}}: {{ $profile->name }} {{ $profile->surname }}</p>
                    <p>{{__('Datum rodjenja')}}: {{ $profile->dateofBirth }}</p>
                    @if ($profile->hightlight)
                        <p>{{__('Poruka')}}: <i> {{ $profile->hightlight }}</i></p>
                    @else
                        <p><i>{{__('Nema poruke za prikaz')}}:<i></p>
                    @endif


                    <div class="d-grid gap-2">
                        <a type="button" class="btn btn-primary bg-blue"
                            href="{{ route('profile.edit', $profile) }}">{{__('Izmeni')}}
                            {{__('Profil') }}</a>
                    </div>



                    <div class="text-center">
                        <br>
                        <h4>{{__('Rezervacije')}}</h4>
                    </div>
                    @if (count($profile->user->reservations) == 0)
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
                                    {{-- veza profil i reservations uspostavljena preko usera. U modelu dodata veza preko usera, a u controleru ukljucena --}}
                                    @foreach ($profile->user->reservations as $res)
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
                                            <td>{{ $dateFormatted }}</td>
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
                    <h4 class="text-center">{{__('Blogovi')}}</h4>
                    @if (count($profile->user->blogs) == 0)
                        <p class="text-center">{{ __('Nema podataka o blogovima') }}</p>
                    @else
                        @foreach ($profile->user->blogs as $b)
                            <h4>{{ '❖' }} <a href="{{ route('blog.show', ['blog' => $b->id]) }}"
                                    class="link">{{ $b->title }}</a></h4>
                        @endforeach
                    @endif
                    {{-- KOMENTARI --}}
                    <h4 class="text-center">{{__('Komentari')}} </h4>
                    @if (count($profile->user->comments) == 0)
                        <p class="text-center">{{ __('Nema podataka o komentarima') }}</p>
                    @else
                        @foreach ($profile->user->comments as $k)
                            
                            <div class="bg-light text-dark commentAutor">
                                <p>{{ $k->comment }}</p>
                                <hr>
                                <p class="small text-end">Blog: <a href="{{ route('blog.show', ['blog' => $k->id]) }}"
                                    class="link">{{ $b->title }}</a> {{ date('d.m.Y h:i:sa', strtotime($k->created_at)) }}</p>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endsection
