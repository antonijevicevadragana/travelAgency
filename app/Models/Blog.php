<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'descriptionSrb',
        'descriptionEng',
        'titleEng'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_id'); //blog_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli comments
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'blog_id'); //blog_id je kolona preko koje su u vezi, tj koja je strani kljuc u tabeli images
    }

// proverava jezik i na osnovu izabranog vrsi pikaz kolone
    protected function description(): Attribute
    {
        $locale = App::currentLocale();

        return Attribute::make(
            get: fn () => ($locale == 'sr' ? $this->descriptionSrb : $this->descriptionEng),
        );
    }

    protected function titleTranslate(): Attribute
    {
        $locale = App::currentLocale();

        return Attribute::make(
            get: fn () => ($locale == 'sr' ? $this->title : $this->titleEng),
        );
    }
}
