<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::query()
            ->search($request->query('search'))
            ->aura($request->query('aura'))
            ->paginate(10)
            ->withQueryString();

        return MediaResource::collection($media);
    }

    public function show(Media $media)
    {
        return new MediaResource($media->load('users'));
    }

    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))->response()->setStatusCode(201);
    }

    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return new MediaResource($media);
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}
