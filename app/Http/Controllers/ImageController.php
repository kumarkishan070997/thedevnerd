<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Image\Image;


class ImageController extends Controller
{
    public function show(){
        return view('images.show');
    }
    public function blurImage(Request $request){
        // Validate the incoming request to ensure an image is provided
        $request->validate(['image' => 'required|image']);

        // Get the uploaded image
        $image = $request->file('image');

        // Load the image using Intervention
        $originalImage = Image::load($image)->useImageDriver('gd')->save();

        // Create a blurred version of the image
        $blurredImage = $originalImage->blur(15); // Adjust the blur level as needed

        // Save the images to temporary paths (optional)
        $originalPath = storage_path('app/public/original.jpg');
        $blurredPath = storage_path('app/public/blurred.jpg');
        $originalImage->save($originalPath);
        $blurredImage->save($blurredPath);

        // Return the view with both images
        return view('images.show', [
            'originalImage' => $originalPath,
            'blurredImage' => $blurredPath,
        ]);
    }
}
