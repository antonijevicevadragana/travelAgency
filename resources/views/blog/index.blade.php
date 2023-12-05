@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-12">
            @if ($user)
                <a type="button" class="btn btn-primary float-end" href="{{ route('blog.create', ['User' => $user->id]) }}">
                    {{ __('Kreiraj blog') }}
                </a>
            @endif

        </div>
    </div>

    <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">
        @foreach ($blog as $blog)
        @php
         
            $create = $blog->created_at;
            $ceateFormatted = date('d.m.Y h:i:sa', strtotime($create));
        @endphp
            <div class="col content ">
                <div class="row mb-2">
                    <a href="{{ route('blog.show', $blog) }}" type="button" class="btn  btn-md bg-blue"><i
                        class="fa fa-eye" aria-hidden="true"></i>
                    {{ __('Prikaz') }}</a>

                </div>

                <h3 class="text-center">{{ $blog->titleTranslate }}</h3>
                <hr>
               
               
                <div>{!! nl2br(e(substr($blog->description, 0, 150))) !!}...</div>
                <hr>
                <p class="float-end small">{{ $ceateFormatted }}</p>
            </div>
        @endforeach
    @endsection
