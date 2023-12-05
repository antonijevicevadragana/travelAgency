<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'destination_id',
        'name',
        'location',
        'descript',
        'number',
        'link',
        'img',
        'descriptEng'

    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'hotel_id'); //hotel_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli prices
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'hotel_id');
    }

    public function images(): HasMany {
        return $this->hasMany(Image::class, 'hotel_id');//blog_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli images
     }

     protected function descriptTranslate(): Attribute
     {
         $locale = App::currentLocale();
 
         return Attribute::make(
             get: fn () => ($locale == 'sr' ? $this->descript : $this->descriptEng),
         );
     }
}
