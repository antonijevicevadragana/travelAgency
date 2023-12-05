@extends('layouts.app')
@section('content')
    <form action="{{ route('user.index') }}">
        @include('partials._search')
    </form>

    <div class="blur text-center">
        <h2 class="text-light">Korisnici</h2>
        <div class="table-responsive">
            <table class="table table-bordered mb-0 indextable">
                <thead>
                    <tr>

                        <th>{{ __('e-mail') }}</th>
                        <th>{{ __('ime') }}</th>
                        <th>{{ __('uloga') }}</th>
                        <th>{{__('Profil')}}</th>
                        <th>{{__('Promena/Brisanje')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <td><h4>{{ $user->email}}</h4>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    {{-- {{$role->type}} --}}
                                    @if ($role->type === 1)
                                        {{'Admin'}}
                                    @else 
                                    {{'Korisnik'}}
                                    @endif
                                @endforeach
                            </td>
                          
                            
                            <td>
                                @if ($user && $user->profile && $user->profile->exists())
                                <a href="{{ route('profile.show',['profile' => $user->profile->id]) }}" type="button"
                                class="btn bg-blue btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                {{ __('Prikaz') }}</a>
                            @else
                                {{ 'Nema profila' }}
                            @endif
                            
                            </td>
                            <td>
                                <a href="{{ route('user.edit',$user)}}" type="button"
                                    class="btn bg-blue btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                    {{ __('Izmena uloge') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{$data->links()}} 
@endsection

