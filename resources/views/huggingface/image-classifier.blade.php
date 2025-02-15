<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Classifier</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg text-center">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Upload an Image for Classification</h1>
        
        <!-- Image Upload Form -->
        <form action="{{ route('classify.image') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="flex flex-col items-center">
                <!-- Image Preview -->
                <img id="imagePreview" class="hidden w-48 h-48 object-cover rounded-lg shadow mb-4" />

                <input type="file" name="image" id="imageInput" required class="border p-2 rounded-lg w-full mb-2">
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">
                    Classify Image
                </button>
            </div>
        </form>

        <!-- Show Uploaded Image -->
        @if(isset($imageUrl))
            <h2 class="text-xl font-semibold mt-4 text-gray-700">Uploaded Image:</h2>
            <img src="{{ $imageUrl }}" alt="Uploaded Image" class="w-48 h-48 object-cover rounded-lg shadow mt-2">
        @endif

        <!-- Display Classification Results -->
        @if(isset($result) && is_array($result))
            <h2 class="text-xl font-semibold mt-4 text-gray-700">Classification Result:</h2>
            <div class="bg-gray-200 p-4 rounded-lg mt-2 shadow">
                <ul class="text-left space-y-2">
                    @foreach($result as $item)
                        <li class="flex justify-between bg-white p-2 rounded shadow">
                            <span class="font-semibold">{{ $item['label'] }}</span>
                            <span class="text-blue-600">{{ number_format($item['score'] * 100, 2) }}%</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        // Image preview before upload
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
