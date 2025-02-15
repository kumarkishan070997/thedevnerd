<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HuggingFaceController extends Controller
{
    public function index()
    {
        return view('huggingface.image-classifier');
    }

    public function classifyImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $image = $request->file('image');
    $imagePath = $image->store('uploads', 'public'); // Save image in public storage
    $imageUrl = asset('storage/' . $imagePath); // Get the accessible URL

    $imageData = file_get_contents($image->getRealPath());

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_TOKEN'),
            'Content-Type'  => 'application/octet-stream',
        ])->withBody($imageData, 'application/octet-stream')
          ->post('https://api-inference.huggingface.co/models/google/vit-base-patch16-224');

    } catch (\Exception $e) {
        return back()->with('error', 'API request failed: ' . $e->getMessage());
    }

    $result = json_decode($response->body(), true);

    return view('huggingface.image-classifier', [
        'result' => $result,
        'imageUrl' => $imageUrl // Send image URL to view
    ]);
}

}
