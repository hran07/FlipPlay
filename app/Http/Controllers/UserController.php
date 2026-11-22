<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function collection(User $user)
    {
        return new UserResource($user->load('media'));
    }

    public function addToCollection(Request $request, User $user)
    {
        $data = $request->validate([
            'media_id' => ['required', 'integer', 'exists:media,id'],
        ]);

        if ($user->media()->where('media_id', $data['media_id'])->exists()) {
            return response()->json(['message' => 'Media sudah ada di koleksi'], 409);
        }

        $user->media()->attach($data['media_id']);

        return response()->json(['message' => 'Media berhasil ditambahkan ke koleksi'], 201);
    }

    public function removeFromCollection(User $user, Media $media)
    {
        if (! $user->media()->where('media_id', $media->id)->exists()) {
            return response()->json(['message' => 'Media tidak ada di koleksi'], 404);
        }

        $user->media()->detach($media->id);

        return response()->json(['message' => 'Media dihapus dari koleksi']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => 'password',
        ]);

        return (new UserResource($user))->response()->setStatusCode(201);
    }
}
