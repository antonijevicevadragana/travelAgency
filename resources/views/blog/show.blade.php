@extends('layouts.show')
@section('content')
    <div class="row p-2">
        <div id="demo" class="carousel slide okvir" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @php
                    $slike = []; // prazan array za slike
                    $counter = 0;

                @endphp
                {{-- prolazimo kroz slike --}}
                @foreach ($images as $image)
                    @php
                        $slike[] = $image->path; // Dodajemo slike u $sliek
                    @endphp
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $counter }}"
                        class="{{ $counter === 0 ? 'active' : '' }}"></button>
                    @php
                        $counter++; //za svaku ubacenu sliku coutner se povecava za jedan
                    @endphp
                @endforeach
            </div>

            <!-- The slideshow -->
            <div class="carousel-inner">
                @php
                    $counter = 0; // reseruje se counter za slijder.
                    //ako je prva slika odnosno $counter === 0 to je aktivna tj. div dobija classu acitve u suprotnom ce biti classa change-item
                @endphp

                @foreach ($slike as $key => $slika)
                    <div class="carousel-item{{ $counter === 0 ? ' active' : '' }} change-item">
                        <img src="{{ asset('storage/' . $slika) }}" alt="" class="d-block images">

                    </div>
                    @php
                        $counter++;
                    @endphp
                @endforeach
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

    </div>

    {{-- ostali podaci --}}
    @if (auth()->check())
    <div class="col-12">
        <a type="button" class="btn btn-primary bg-blue float-end"
            href="{{ route('comment.create', ['blog' => $blog->id]) }}">
            {{ __('Komentarisi') }}
        </a>
    </div>
    @endif
    <h1 class="text-center">{{ $blog->titleTranslate }}</h1>
    <div>
        {{-- descritption je atribut u modelu --}}
        {!! nl2br(e($blog->description)) !!}
    </div>
    <hr>
    <div>
        @if ($blog->user->profile)
            <cite>{{__('Autor')}}: {{ $blog->user->profile->nickname }}</cite>
        @else
            <cite>{{__('Autor')}}: {{ $blog->user->name }}</cite>
        @endif
    </div>
    <div class="small text-end">{{__('Datum')}}: {{ date('d.m.Y h:i:sa', strtotime($blog->created_at)) }}</div>
    <hr>
    @if (!(auth()->check()))
    <div class="col-12">
        <p class="text-danger">{{__('Uloguj se da komentarises')}}</p>
    </div>
    @endif
    <h2>{{ __('Komentari') }}</h2>

    {{-- da nije $comment definisano u controleru pristupili bi $blog->$comments --}}
    @if (count($comment) === 0)
        <p>{{__('Nema komentara')}}</p>
    @else
     
        @foreach ($comment as $comm)
            @php
                $userProfileExists = $comm->user->profile !== null;
                $userIsAuthor = $comm->user_id === $blog->user_id;
                $userNickname = $userProfileExists ? $comm->user->profile->nickname : $comm->user->name ?? 'Anonymous';
            @endphp

            <div
                class="bg-{{ $userIsAuthor ? 'light' : 'info' }} text-dark comment{{ $userIsAuthor ? 'Autor' : 'Other' }}">
                    {{-- provera da li je ulogovan korisnik --}}
                @if (auth()->check())
                  {{-- ako je ulogovan autor nekog komentara isti moze da izmeni ili obrise --}}
                    @if (Auth::user()->id === $comm->user_id && $comm->comment !== 'Komentar je obrisan')
                        <div class="dropdown">
                            <button class="dropbtn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <div class="dropdown-content">
                                <form method="POST" action="{{ route('comment.destroy', $comm->id) }}">
                                    @method('delete')
                                    @csrf
                                    <a href="{{ route('comment.edit', $comm) }}" type="button"
                                        class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                            class="fa-solid fa-trash"></i>
                                    </button>

                                </form>
                            </div>
                        </div>
                    @endif
                @endif


                @if ($userProfileExists && $comm->comment !== 'Komentar je obrisan')
                    <p> {{ $userIsAuthor ? 'Autor' : $userNickname }} </p>
                    <p>{{ $comm->comment }}</p>
                    <hr>
                    <p>{{ $userProfileExists ? $comm->user->profile->hightlight : '' }}</p>
                @elseif(!$userProfileExists && $comm->comment !== 'Komentar je obrisan')
                    <p>{{ $userNickname }}</p>
                    <p>{{ $comm->comment }}</p>
                @elseif($comm->comment == 'Komentar je obrisan')
                    <p class="text-danger">{{ $comm->comment }}</p>
                @endif

                {{-- datum objave/izmene ili brisanja --}}
                @if ($comm->created_at == $comm->updated_at)
                    <p class="small text-end">{{ date('d.m.Y h:i:sa', strtotime($comm->created_at)) }}</p>
                @elseif($comm->comment === 'Komentar je obrisan')
                    <p class="small text-end text-danger">
                        {{ __('Obrisano') }}: {{ date('d.m.Y h:i:sa', strtotime($comm->updated_at)) }}</p>
                @else
                    <p class="small text-end ">
                        {{ __('Izmenjeno') }}: {{ date('d.m.Y h:i:sa', strtotime($comm->updated_at)) }}</p>
                @endif

            </div>
        @endforeach
    @endif
@endsection
