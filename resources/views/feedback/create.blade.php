@extends('layouts.app')
@section('content')
    <div class="row  p-2">
        <div class="col content">
            <h3 class="text-center">{{__('Kreiranje feedback-a')  }}</h3>
            <hr>

            <form method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
                @csrf
                <p>{{__('Feedback se moze ostaviti samo za realizvona putovanja')}}.</p>
                <p>{{__('Iz padajuceg menija izaberite neko od Vasih realizovanih putovanja za koje zelite da ostavite recenziju')}}</p>
                <label for="destination_id">{{ __('Izbor destinacije') }}:</label>
                    <select class="form-select text-white @error('destination_id') is-invalid @enderror" aria-label="Default select example" name="destination_id">
                        <option value="">--</option>
                        @foreach ($reservation as $d)
                        {{-- moze da se ostavi feedback samo za putovanja koja su vec realizovana --}}
                        @if (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($d->destination->startDate))
                            <option value="{{ $d->destination_id }}">
                               {{ $d->destination->city }} {{ $d->destination->transportation }}
                                {{date('d.m.Y', strtotime($d->destination->startDate ))}}
                            </option>
                            @endif
                        @endforeach
                        
                    </select>
                    @error('destination_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                <label for="feedback" class="col-lg-1 col-form-label ">{{ __('Recenzija') }}</label>
                <div class="col-lg-11">
                    <textarea name="feedback" id="feedback" cols="15"
                        rows="5"class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback"
                        style="background-color: transparent; color:white;">{{ old('feedback') }}</textarea>

                    @error('feedback')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- ocena  --}}
                <div class="p-2 row">
                    <p>{{ __('1-najlosija ocena, 5-najbolja ocena') }}</p>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                       
                        <p class="col-sm-2 col-form-label">{{__( 'Ocena') }}</p>
                        <div class="p-2">
                            <input type="radio" class="btn-check" name="star" id="1" value="1"
                                @if (old('star') === '1') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="1" style="padding: 5px 25px;">{{ '★' }}</label>
                
                            <input type="radio" class="btn-check" name="star" id="2" value="2"
                                @if (old('star') === '2') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="2" style="padding: 5px 25px;">{{ __('★★') }}</label>

                            
                            <input type="radio" class="btn-check" name="star" id="3" value="3"
                                @if (old('star') === '3') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="3" style="padding: 5px 25px;">{{ __('★★★') }}</label>

                            <input type="radio" class="btn-check" name="star" id="4" value="4"
                            @if (old('star') === '4') checked @endif>
                        <label class="btn btn-outline-primary bg-label" for="4" style="padding: 5px 25px;">{{ __('★★★★') }}</label>

                        <input type="radio" class="btn-check" name="star" id="5" value="5"
                                @if (old('star') === 'cityBreak') checked @endif>
                            <label class="btn btn-outline-primary bg-label" for="5" style="padding: 5px 25px;">{{ __('★★★★★') }}</label>
                        </div>
                    </div>
                </div>


        

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-md bg-blue">
                {{ __('Sacuvaj') }}
            </button><a href="{{ back()->getTargetUrl() }}" class="btn btn-md bg-grey">{{ __('Odustani') }}</a>
        </div>

        </form>
    </div>
    </div>
@endsection
