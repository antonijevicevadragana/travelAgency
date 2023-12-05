<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = [
        'id',
        'destination_id',
        'user_id',
        'feedback',
        'star'
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    //veza sa profilima preko usera
public function profile()
{
    return $this->user->profile; 
}

// veza sa rezervacijama preko usera
public function reservations()
{
    return $this->user->reservations; 
}

}
