<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text To Image</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-700">Text to Image Generator</h1>
        
        <form id="textSubmitForm" class="mb-6">
            <input type="text" id="textInput" placeholder="Enter text here..." class="border p-3 rounded-lg w-full mb-4 text-lg">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold text-lg">
                Generate Image
            </button>
        </form>
        
        <div id="loading" class="hidden text-blue-500 font-semibold text-lg">Processing...</div>
        
        <div id="result" class="mt-6 hidden">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Generated Image:</h2>
            <div class="flex justify-center">
                <img id="generatedImage" class="rounded-lg shadow-md w-full h-auto max-h-[500px] object-contain" src="" alt="Generated Image">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#textSubmitForm").submit(function(event) {
                event.preventDefault();
                
                var textData = $("#textInput").val();
                if (!textData) {
                    alert("Please enter some text.");
                    return;
                }
                
                $("#loading").removeClass("hidden");
                $("#result").addClass("hidden");
                
                $.ajax({
                    url: "{{ route('text-to-image-classification') }}", 
                    type: "POST",
                    data: JSON.stringify({ text: textData }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json",
                    xhrFields: {
                        responseType: 'blob' // Expecting a binary image response
                    },
                    success: function(blob) {
                        const imageUrl = URL.createObjectURL(blob);
                        $("#generatedImage").attr("src", imageUrl);
                        $("#result").removeClass("hidden");
                    },
                    error: function() {
                        alert("Error generating image.");
                    },
                    complete: function() {
                        $("#loading").addClass("hidden");
                    }
                });
            });
        });
    </script>
</body>
</html>
