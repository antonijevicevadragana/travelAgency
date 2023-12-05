<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
//     protected function create(array $data)
// {
//     // Provera da li je korisnik već registrovan
//     $existingUser = User::where('email', $data['email'])->first();

//     if ($existingUser) {
//         // Ako korisnik već postoji, stvori korisnika bez dodjele uloge
//         $user = $existingUser;
//     } else {
//         // Ako korisnik ne postoji, stvori novog korisnika
//         $user = User::create([
//             'name' => $data['name'],
//             'email' => $data['email'],
//             'password' => Hash::make($data['password']),
//         ]);
//     }

//     // Dodajte korisniku ulogu nakon uspešne registracije
//     $user->assignRole();

//     return $user;
// }


//izmenjena fja crate da samo prvi kreirani korisnik ima ulogu 1, a svaki sledcei ulogu 2.
//prvi registorovan ce biti admin a svaki sledeci ce biti moci samo deo sajta da vide.
public function create(array $data)
{
    // Prvo proverite koliko korisnika već postoji
    $userCount = User::count();

    if ($userCount === 0) {
        // Ako nema registrovanih korisnika, dodelite ulogu "1"
        $roleType = 1;
    } else {
        // Ako postoji barem jedan registrovani korisnik, dodelite ulogu "2"
        $roleType = 2;
    }

    // Kreirajte korisnika
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    // Dodajte korisniku ulogu nakon uspešne registracije
    Role::create([
        'user_id' => $user->id,
        'type' => $roleType,
    ]);

    return $user;
}

    

   
}
