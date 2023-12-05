<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'hotel_id',
        'price',
        'firstMin',
        'lasteMin',
        'firstOnly',
        'lastOnly'
        
    ];

   

     public function hotel(): BelongsTo {
        return $this->belongsTo(Hotel::class);
     }
}
