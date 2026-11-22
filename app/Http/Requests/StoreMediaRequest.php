<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // pengganti parseGenres() di App.php Modul 3
    protected function prepareForValidation(): void
    {
        if (is_array($this->genres)) {
            $this->merge([
                'genres' => collect($this->genres)
                    ->map(fn ($g) => ucwords(strtolower(trim($g))))
                    ->filter()
                    ->values()
                    ->all(),
            ]);
        }
    }

    public function rules(): array
    {
        // POST: semua wajib. PATCH: hanya field yang dikirim yang diperiksa.
        $wajib = $this->isMethod('PATCH') ? 'sometimes' : 'required';

        return [
            'title'    => [$wajib, 'string', 'max:255',
                           Rule::unique('media', 'title')->ignore($this->route('media'))],
            'type'     => [$wajib, Rule::in(['anime', 'drama', 'manga', 'light_novel'])],
            'genres'   => ['sometimes', 'array'],
            'genres.*' => ['string', 'max:50'],
            'score'    => [$wajib, 'numeric', 'between:0,10'],
            'units'    => [$wajib, 'integer', 'min:1'],
            'creator'  => [$wajib, 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi',
            'title.unique'   => 'Judul media sudah ada',
            'type.in'        => 'Jenis harus: anime, drama, manga, atau light_novel',
            'score.between'  => 'Skor harus antara 0 dan 10',
            'units.min'      => 'Jumlah unit minimal 1',
        ];
    }
}
