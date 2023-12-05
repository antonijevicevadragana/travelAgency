@extends('layouts.app')
@section('content')

        <div class="card">
            <div class="card-header">{{ __('Profili') }}</div>
            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Ime') }} & {{__('Prezime')}}</th>
                            <th scope="col">{{ __('Nadimak') }}</th>
                            <th scope="col">{{ __('Datum rodjenja') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($profile as $p)
                            <tr>
                                <td>{{ $p->name}} {{$p->surname}}</td>
                                <td>{{ $p->nickname}}</td>
                                <td>{{ $p->dateofBirth }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="">
                                            @method('delete')
                                            @csrf
                                           
                                            <a href="{{ route('profile.show', $p) }}" type="button" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i> {{ __('Show') }}</a>
                                            <a href="{{ route('profile.edit', $p) }}" type="button" class="btn btn-info btn-sm"><i
                                                    class="fa-solid fa-pencil"></i>
                                                {{ __('Edit') }}</a>
                                            <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                    class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
   @endsection