<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Naruto', 'anime', ['Action', 'Adventure'], 8.0, 220, 'Pierrot'],
            ['Violet Evergarden', 'anime', ['Drama', 'Fantasy'], 8.5, 13, 'Kyoto Animation'],
            ['Crash Landing on You', 'drama', ['Romance', 'Comedy'], 8.7, 16, 'Korea Selatan'],
            ['One Piece', 'manga', ['Action', 'Adventure'], 9.2, 1100, 'Eiichiro Oda'],
            ['Nana', 'manga', ['Drama', 'Romance'], 8.4, 84, 'Ai Yazawa'],
            ['Spice and Wolf', 'light_novel', ['Adventure', 'Romance'], 8.3, 25, 'Isuna Hasekura'],
        ];

        foreach ($data as [$title, $type, $genres, $score, $units, $creator]) {
            Media::create(compact('title', 'type', 'genres', 'score', 'units', 'creator'));
        }
    }
}
