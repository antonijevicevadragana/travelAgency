<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'nickname',
        'name',
        'surname',
        'hightlight',
        'dateofBirth',
        'gender',
        'avatar',
        
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
     }
     
// veza sa rezervacijama preko usera
public function reservations()
{
    return $this->user->reservations; 
}
//veza sa blogovima preko usera
public function blogs()
{
    return $this->user->blogs; 
}

//veza sa komentarima preko usera
public function comments()
{
    return $this->user->comments; 
}
}

