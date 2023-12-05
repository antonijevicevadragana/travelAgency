@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{ __('Izmeni')}} {{__('Komentar')}}</h3>
            <hr>

            <form method="POST" action="{{ route('comment.update', $comment) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="blog_id" value="{{ $comment->blog_id }}">
                <div class="row p-2">

                    <label for="comment" class="col-lg-1 col-form-label ">{{ __('Komentar') }}</label>
                    <div class="col-lg-11">
                        <textarea name="comment" id="comment" cols="15"
                            rows="5"class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment"
                            style="background-color: transparent; color:white;">{{ $comment->comment }}</textarea>

                        @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-md bg-blue">
                            {{ __('Sacuvaj') }}
                        </button><a href="{{ back()->getTargetUrl() }}"
                            class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
