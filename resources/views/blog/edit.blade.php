@extends('layouts.app')
@section('content')
<div class="row  p-2">
    <div class="col content">
        <h3 class="text-center">{{__( 'Edit blog') }}</h3>
        <hr>

            <form method="POST" action="{{ route('blog.update', $blog) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row p-2">
                    <label for="coverImage" class="col-lg-1 col-form-label">{{ __('Slike za blog') }}</label>
                    <div class="col-lg-5">
                        <div class="input-group col-lg-4 input-box">
                            <input type="file" class="form-control @error('coverImage.*') is-invalid @enderror" id="coverImage"
                                name="coverImage[]" value="{{ old('coverImage') }}" multiple>
                            @error('coverImage.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        
                        @foreach ($images as $image)
                            <img src="{{ asset('storage/' . $image->path) }}" style="width: 100px;" alt="">
                        @endforeach
                    </div>
                    <div class="col-lg-3 input-box">
                        <input class="form-check-input" type="checkbox" value="1" id="keep_old_images"
                            name="keep_old_images">
                        <label for="keep_old_images">{{__('Zadrzi stare slike')}}</label>
                       
                        <p>{{__('ako ste čekirali Zadrži stare slike, možete dodati nove slike bez brisanja prethodnih')}}</p>
                    </div>
                </div>

                {{-- ostalo --}}
                <div class="row p-2">
                    <label for="title" class="col-lg-1 col-form-label ">{{ __('Naslov') }}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ $blog->title }}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row p-2">
                    <label for="titleEng" class="col-lg-1 col-form-label ">{{ __('Naslov') }}-{{__('Eng')}}</label>
                    <div class="col-lg-5 input-box">
                        <input type="text" class="form-control @error('titleEng') is-invalid @enderror" id="titleEng"
                            name="titleEng" value="{{ $blog->titleEng }}">
                        @error('titleEng')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                
                <div class="row p-2">
                    <label for="descriptionSrb"
                        class="col-lg-1 col-form-label ">{{ __('Opis putovanja-Srpski') }}</label>
                    <div class="col-lg-11 input-box">
                        <textarea name="descriptionSrb" id="descriptionSrb" cols="15"
                            rows="5"class="form-control @error('descriptionSrb') is-invalid @enderror" id="descriptionSrb"
                            name="descriptionSrb" style="background-color: transparent; color:white;">{{ $blog->descriptionSrb }}</textarea>

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
                    <div class="col-lg-11 input-box">
                        <textarea name="descriptionEng" id="descriptionEng" cols="15" rows="5"
                            class="form-control @error('descriptionEng') is-invalid @enderror" name="descriptionEng" style="background-color: transparent; color:white;">{{ $blog->descriptionEng }}</textarea>

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
                        </button><a href="{{ back()->getTargetUrl() }}"
                            class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
                </div>

            </form>
        </div>
    </div>
@endsection









