<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {

        $images = Image::latest()->paginate(9);

        return view('index', compact('images'));

    }

    public function uploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedImages = [];

        foreach ($request->file('images') as $imageFile) {
            $imagePath = $imageFile->store('images', 'public');

            $image = Image::create([
                'hash' => uniqid(),
                'url' => $imagePath,
            ]);

            $uploadedImages[] = $image;
        }

        return $uploadedImages;
    }

    public function show($imageHash)
    {
        $image = Image::where('hash', $imageHash)->firstOrFail();

        return view('show', compact('image'));
    }

    public function like(Request $request, $imageHash)
    {
        $image = Image::where('hash', $imageHash)->firstOrFail();

        $image->increment('likes');
        $likesCount = $image->likes;

        return response()->json(['likesCount' => $likesCount, 'message' => 'Liked successfully.']);
    }

    public function dislike(Request $request, $imageHash)
    {
        $image = Image::where('hash', $imageHash)->firstOrFail();

        $image->decrement('likes');
        $likesCount = $image->likes;

        return response()->json(['likesCount' => $likesCount, 'message' => 'Disliked successfully.']);
    }
}
