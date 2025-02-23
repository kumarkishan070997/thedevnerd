<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Object Detection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full text-center">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Upload an Image for Object Detection</h1>

        <!-- Image Upload Form -->
        <form id="imageUploadForm" class="mb-4">
            <div class="flex flex-col items-center">
                <!-- Image Preview -->
                <img id="imagePreview" class="hidden object-contain rounded-lg shadow mb-4" />

                <input type="file" name="image" id="imageInput" required class="border p-2 rounded-lg mb-2">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">
                    Process Image
                </button>
            </div>
        </form>

        <!-- Loading Indicator -->
        <div id="loading" class="hidden text-blue-500 font-semibold">Processing...</div>

        <!-- Show Processed Image and Results -->
        <h2 id="resultTitle" class="hidden text-lg font-bold mt-4">Detected Objects</h2>
        
        <div class="relative flex justify-center mt-4">
            <canvas id="canvas" class="hidden border border-gray-300 rounded-lg shadow-md"></canvas>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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

        $(document).ready(function () {
            $('#imageUploadForm').on('submit', function (event) {
                event.preventDefault(); // Prevent form submission

                let formData = new FormData();
                let fileInput = document.getElementById('imageInput').files[0];

                if (!fileInput) {
                    alert("Please select an image.");
                    return;
                }

                formData.append('image', fileInput);
                
                $('#loading').removeClass('hidden'); // Show loading indicator

                $.ajax({
                    url: "{{ route('object-detection-matching') }}", // Laravel route
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#loading').addClass('hidden'); // Hide loading indicator

                        if (response.objectDetected) {
                            $('#resultTitle').removeClass('hidden');
                            drawBoundingBoxes(response.imageUrl, response.result);
                        } else {
                            alert("No objects detected.");
                        }
                    },
                    error: function (xhr) {
                        $('#loading').addClass('hidden'); // Hide loading indicator
                        console.error("Error:", xhr.responseText);
                        alert("Something went wrong! Check the console for details.");
                    }
                });
            });

            function drawBoundingBoxes(imageUrl, detections) {
                const img = new Image();
                img.src = imageUrl;

                img.onload = function () {
                    const canvas = document.getElementById('canvas');
                    const ctx = canvas.getContext('2d');

                    // Resize canvas dynamically
                    const maxWidth = 1000; // Max width for UI
                    const scaleFactor = img.width > maxWidth ? maxWidth / img.width : 1;

                    canvas.width = img.width * scaleFactor;
                    canvas.height = img.height * scaleFactor;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    ctx.strokeStyle = 'red';
                    ctx.lineWidth = 2;
                    ctx.font = "14px Arial";
                    ctx.fillStyle = "red";

                    if (Array.isArray(detections)) {
                        detections.forEach(det => {
                            if (det.box) {
                                const box = det.box;
                                const label = det.label || "Unknown";
                                const score = det.score ? (det.score * 100).toFixed(2) + "%" : "N/A"; // Convert to percentage

                                // Scale bounding boxes
                                const xmin = box.xmin * scaleFactor;
                                const ymin = box.ymin * scaleFactor;
                                const xmax = box.xmax * scaleFactor;
                                const ymax = box.ymax * scaleFactor;

                                ctx.strokeRect(xmin, ymin, xmax - xmin, ymax - ymin);
                                ctx.fillText(`${label} (${score})`, xmin, ymin - 5);
                            }
                        });
                        canvas.classList.remove('hidden');
                    } else {
                        console.error("Detections is not an array:", detections);
                    }
                };
            }
        });
    </script>
</body>
</html>
