<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['title', 'type', 'genres', 'score', 'units', 'creator'];

    protected $casts = [
        'genres' => 'array',
        'score'  => 'float',
        'units'  => 'integer',
    ];

    protected function action(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->type, ['anime', 'drama']) ? 'Tonton' : 'Baca',
        );
    }

    protected function unitLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->type) {
                'anime', 'drama' => 'episode',
                'manga'          => 'chapter',
                default          => 'volume',
            },
        );
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $keyword ? $query->where('title', 'like', "%{$keyword}%") : $query;
    }

    public function scopeAura($query, ?string $aura)
    {
        $byGenre = fn (array $genres) => $query->where(function ($q) use ($genres) {
            foreach ($genres as $genre) {
                $q->orWhereJsonContains('genres', $genre);
            }
        });

        return match ($aura) {
            'energy'     => $byGenre(['Action', 'Adventure', 'Sports']),
            'melancholy' => $byGenre(['Drama', 'Romance']),
            'binge'      => $query->where('units', '>=', 24),
            default      => $query,
        };
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
