<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


   //relacija sa rezervacijama, blog, komentarima

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

//veza 1:1 sa profilima (to su profili usera)
    public function profile(): HasOne {
        return $this->hasOne(Profile::class);
     }


    //relacija sa rolama
    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }
     

//     public function assignRole()
// {
//     // Proveravamo da li korisnik već ima ulogu
//     $existingRole = $this->roles->first();

//     if (!$existingRole) {
//         // Ako korisnik nema ulogu i ako tabela roles za ovog korisnika ne sadrži nijedan zapis,
//         // dodajemo "type=1"
//         Role::create([
//             'user_id' => $this->id,
//             'type' => 1,
//         ]);
//     } else {
//         // Ako korisnik već ima ulogu ili ako tabela roles za ovog korisnika sadrži bar jedan zapis,
//         // ažuriramo "type=2"
//         $existingRole->update(['type' => 2]);
//     }
}


    

