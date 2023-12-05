@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{__('Kreiranje bloga')  }}</h3>
            <hr>

            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="user_id" value="{{ $userId }}"> --}}
                {{-- pozadinska slika --}}
                <div class="row p-2">

                    <label for="coverImage" class="col-lg-1 col-form-label">{{ __('Slike za blog') }}</label>
                    <div class="col-lg-5 input-box">
                        <div class="input-group col-lg-4">
                            <input type="file" class="form-control @error('coverImage.*') is-invalid @enderror"
                                id="coverImage" name="coverImage[]" value="{{ old('coverImage') }}" multiple>
                            @error('coverImage.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
               
                <div class="row p-2">
                    <label for="title" class="col-lg-1 col-form-label ">{{ __('Naslov') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


                <div class="row p-2">
                    <label for="titleEng" class="col-lg-1 col-form-label ">{{ __('Naslov') }} - {{__('Eng')}}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('titleEng') is-invalid @enderror" id="titleEng"
                            name="titleEng" value="{{ old('titleEng') }}">
                        @error('titleEng')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descriptionSrb" class="col-lg-1 col-form-label ">{{ __('Opis putovanja-Srpski') }}</label>
                    <div class="col-lg-11">
                        <textarea name="descriptionSrb" id="descriptionSrb" cols="15"
                            rows="5"class="form-control @error('descriptionSrb') is-invalid @enderror" id="descriptionSrb"
                            name="descriptionSrb" style="background-color: transparent; color:white;">{{ old('descriptionSrb') }} </textarea>

                        @error('descriptionSrb')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="descriptionEng"
                        class="col-lg-1 col-form-label ">{{ __('Opis putovanja-Engleski') }}</label>
                    <div class="col-lg-11">
                        <textarea name="descriptionEng" id="descriptionEng" cols="15" rows="5"
                            class="form-control @error('descriptionEng') is-invalid @enderror" name="descriptionEng" style="background-color: transparent; color:white;">{{ old('descriptionEng') }}</textarea>

                        @error('descriptionEng')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-md bg-blue">
                            {{ __('Sacuvaj') }}
                        </button><a href="{{ route('blog.index') }}"
                            class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
