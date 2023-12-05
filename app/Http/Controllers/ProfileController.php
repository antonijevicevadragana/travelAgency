<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Profile;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $profiles = Profile::with('reservations')->get();

    return view('profile.index', compact('profiles'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          //validacija podataka
          $form = $request->validate([
           
            'avatar' => '|image|between:1,2048',
            'nickname' => 'required|regex:/^[\pL\s\-\(\)]+$/u',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'surname' => 'required|regex:/^[\pL\s\-]+$/u', //omogućava unos slova (pomoću \pL), razmaka (pomoću \s), i znaka "-" (poznatog i kao "minus") u prezimenu. 
            'hightlight'=>'nullable',
            'dateofBirth' => 'required',
            'gender'=>'required'
        ]);

        $user = Auth::user();
        $form['user_id'] = $user->id;

       // dd($form);
        //kreiranje
        
        $profile=Profile::create($form);

           //proveravamo da li forma ima sliku i da li je slika validno otpremljena
           if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            //generisemo naziv slike id filma i ekstenzija fajla
            $imgName = $profile->id . '.' . $request->file('avatar')->extension();
            //smestamo fajl u folder public/film_images
            Storage::disk('public')
                ->putFileAs('Profilne_Slike', $request->file('avatar'), $imgName);

            //u bazi belezimo putanju od public foldera
            $profile->image = 'film_images/' . $imgName;
            $profile->save();
        }
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno kriran profil!');
        return redirect()->route('destination.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //u profilu ukljucene rezervacije, blogovi i komentari preko veze sa userom. Veza je u modelu
        $profileWithReservations = $profile->load('user.reservations','user.blogs', 'user.comments');

        return view('profile.show', ['profile' => $profileWithReservations]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
        return view('profile.edit',['profile'=>$profile]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
        $form = $request->validate([
           
            'avatar' => '|image|between:1,2048',
            'nickname' => 'required|regex:/^[\pL\s\-\(\)]+$/u',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'surname' => 'required|regex:/^[\pL\s\-]+$/u', //omogućava unos slova (pomoću \pL), razmaka (pomoću \s), i znaka "-" (poznatog i kao "minus") u prezimenu. 
            'hightlight'=>'nullable',
            'dateofBirth' => 'required',
            'gender'=>'required'
        ]);

        $user = Auth::user();
        $form['user_id'] = $user->id;
        // dd($form);

        $profile->update($form);


        //proveravamo da li forma ima sliku i da li je slika validno otpremljena
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
         //generisemo naziv slike id filma i ekstenzija fajla
         $imgName = $profile->id . '.' . $request->file('avatar')->extension();
         //smestamo fajl u folder public/film_images
         Storage::disk('public')
             ->putFileAs('Profilne_Slike', $request->file('avatar'), $imgName);

         //u bazi belezimo putanju od public foldera
         $profile->image = 'film_images/' . $imgName;
         $profile->save();
     }
     session()->flash('alertType', 'success');
     session()->flash('alertMsg', 'Uspesno izmenjen profil!');
     return redirect()->route('destination.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function myProfile() {
        //prikazati stranicu ako ulogovani user ima profil
        $user = Auth::user();
        $userId=$user->id;
        $profil = Profile::where('user_id',  $userId)->get();
        $reservation=Reservation::where('user_id',  $userId)->get();
        $blog=Blog::where('user_id',  $userId)->get();
        return view('profile.myprofile', ['profil'=>$profil, 'userId'=>$userId, 'reservation'=>$reservation, 'blog'=>$blog]);

    }
}
