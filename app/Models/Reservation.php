<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'hotel_id',
        'user_id',
        'confirmationCode',
        'dateReservation',
        'name',
        'surname',
        'name',
        'phoneNumber',
        'passingerNumbers',
        'reservationPrice',
        'destination_id'

    ];



    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
