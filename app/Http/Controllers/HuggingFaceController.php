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

    public function objectDetection()
    {
        $objectDetected = false;
        return view('huggingface.object-detection', compact('objectDetected'));
    }

    public function objectDetectionMatching(Request $request)
    {
        $url = "https://api-inference.huggingface.co/models/facebook/detr-resnet-50";
        $image = $request->file('image');

        if (!$image) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        $imagePath = $image->store('uploads', 'public');
        $imageUrl = asset('storage/' . $imagePath);

        // Convert image to base64
        $imageData = file_get_contents($image->getRealPath());

        // Send request to Hugging Face API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_TOKEN'),
            'Content-Type' => 'application/json',
        ])->withBody($imageData, 'application/octet-stream')->post($url);

        // Convert response to array
        $result = $response->json();

        return response()->json([
            'result' => $result,
            'objectDetected' => !empty($result),
            'imageUrl' => $imageUrl
        ]);
    }

    public function textClassification(){
        return view('huggingface.text-classification');
    }
    public function textClassificationProcess(Request $request){
        $url = "https://api-inference.huggingface.co/models/distilbert/distilbert-base-uncased-finetuned-sst-2-english";
        $data = ["inputs" => $request->text];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post($url,$data);
        $result = $response->json();
        return response()->json([
            'result' => $result
        ]);
    }
}
