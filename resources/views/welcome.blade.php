@extends('layouts.logreg')
@section('content')
    <div class="content">
        <div class="row justify-content-center welcome">
            <h2 class="text-center"><q><i>{{__('Svet je knjiga, a oni koji ne putuju pročitaju samo jednu stranicu')}}</i></q>{{__('(Sveti Avgustin)')}} </h2>
            <div class="text-center ">
                <i class=" animate__animated  animate__flip"></i>
                {{-- ovo i je za animaciju samo --}}
                <a href="{{ route('destination.summer') }}"><i class="fa-solid fa-umbrella-beach "></i> <br> {{__('Letovanje')}}</a>
                <a href="{{ route('destination.winter') }}"><i class="fa-regular fa-snowflake "></i> <br> {{__('Zimovanje')}}</a>
                <a href="{{ route('destination.citybreak') }}"><i class="fa-solid fa-city"></i> <br> City break</a>
                <a href="{{ route('destination.index') }}"><i class="fa-solid fa-pen-to-square"></i> <br> {{__('Aktuelno')}}</a>
                <a href="{{ route('destination.trip') }}"><i class="fa-solid fa-landmark"></i> <br>{{__('Izleti')}}</a>
            
            </div>

            <div class="text-center ">
                <br>
                {{-- <a href="aboutUs" ><i class="fa-solid fa-pen"></i> <br>Feedback</a> --}}
                <h2 class="text-center"> <i>{{__('Zavirite u svet putovanja sa Dve Laste. Pravimo uspomene zajedno')}}</i></h2>
            </div>
        </div>
    </div>
@endsection
