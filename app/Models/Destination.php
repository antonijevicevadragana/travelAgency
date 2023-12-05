<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'state',
        'city',
        'coverImage',
        'startDate',
        'endDate',
        'startCity',
        'number',
        'transportation',
        'descriptionSrb',
        'descriptionEng',
        'type',
        'priceTrip',
        'cityEng',
        'stateEng'

    ];

    public function hotels(): HasMany {
        return $this->hasMany(Hotel::class, 'destination_id');//destination_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli hotels
     }

     //atribut koji ispisuje date informacije
     protected function DestinationInfo(): Attribute
     {
         return Attribute::make(
             get: fn () => ($this->state . " " . $this->city . " (" . $this->transportation . ") " . $this->startDate .":" . $this->endDate),
         );
     }

     public function reservations()
    {
        return $this->hasMany(Reservation::class, 'destination_id');
    }


    public function scopeFilter($query, array $filters)
    {

        if ($filters['search'] ?? false) {
            $query->where('state', 'like', '%' . request('search') . '%')
                ->orWhere('city', 'like', '%' . request('search') . '%')
                ->orWhere('transportation', 'like', '%' . request('search') . '%')
                ->orWhere('startDate', 'like', '%' . request('search') . '%');
        }
    }
     

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }


    protected function description(): Attribute
    {
        $locale = App::currentLocale();

        return Attribute::make(
            get: fn () => ($locale == 'sr' ? $this->descriptionSrb : $this->descriptionEng),
        );
    }

    protected function cityTranslate(): Attribute
    {
        $locale = App::currentLocale();

        return Attribute::make(
            get: fn () => ($locale == 'sr' ? $this->city : $this->cityEng),
        );
    }

    protected function stateTranslate(): Attribute
    {
        $locale = App::currentLocale();

        return Attribute::make(
            get: fn () => ($locale == 'sr' ? $this->state : $this->stateEng),
        );
    }
}
