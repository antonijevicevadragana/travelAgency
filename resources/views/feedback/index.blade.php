@extends('layouts.app')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 g-4 mx-auto p-2">
        @foreach ($data as $feedback)
            <div class="col content ">
                <form method="POST" action="{{ route('feedback.destroy', $feedback) }}">
                    @method('delete')
                    @csrf
                    {{-- admin moze da izbrise recenziju --}}
                    <button type="submit" class="btn btn-danger btn-sm delete-button"><i class="fa-solid fa-trash"></i>
                        {{ __('Izbriši') }}</button>
                </form>



                @php
                    if ($feedback->destination->star == 1) {
                        $s = '★☆☆☆☆';
                    } elseif ($feedback->destination->star == 2) {
                        $s = '★★☆☆☆';
                    } elseif ($feedback->destination->star == 3) {
                        $s = '★★★☆☆';
                    } elseif ($feedback->destination->star == 4) {
                        $s = '★★★★☆';
                    } else {
                        $s = '★★★★★';
                    }
                @endphp
                <p class="d-flex justify-content-end"> {{__('Ocena')}}: {{ $s }}</p>
                <hr>
                <p>{{ $feedback->destination->state }} - {{ $feedback->destination->city }}
                    ({{ date('d.m.Y', strtotime($feedback->destination->startDate)) }}
                    -{{ date('d.m.Y', strtotime($feedback->destination->endDate)) }})
                    {{ $feedback->destination->transportation }}</p>
                <p>{{ $feedback->feedback }}</p>
                <hr>
                <p class="float-end small">{{ date('d.m.Y h:i:sa', strtotime($feedback->created_at)) }}</p>
            </div>
        @endforeach

    </div>
@endsection
