<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        img {
            max-width: 100%;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }
        .image-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Upload Image</h1>
    <form id="imageUploadForm" enctype="multipart/form-data">
        <input type="file" name="image" id="image" required>
        <button type="submit">Upload</button>
    </form>

    <div class="image-container">
        <h2>Original Image</h2>
        <img id="originalImage" src="" alt="Original Image" style="display:none;">

        <h2>Blurred Image</h2>
        <img id="blurredImage" src="" alt="Blurred Image" style="display:none;">
    </div>

    <script>
        $(document).ready(function() {
            $('#imageUploadForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this);

                $.ajax({
                    url: '/api/blur-image', // Adjust the URL to your API endpoint
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Show the images
                        $('#originalImage').attr('src', response.originalImage).show();
                        $('#blurredImage').attr('src', response.blurredImage).show();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
