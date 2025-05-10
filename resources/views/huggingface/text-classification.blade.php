<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Classification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Text Classification</h1>
        
        <form id="textSubmitForm" class="mb-4">
            <input type="text" id="textInput" placeholder="Enter text here..." class="border p-2 rounded-lg w-full mb-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
                Submit Text
            </button>
        </form>
        
        <div id="loading" class="hidden text-blue-500 font-semibold">Processing...</div>
        
        <div id="result" class="mt-4 hidden">
            <h2 class="text-xl font-semibold text-gray-700">Result:</h2>
            <div id="classificationResults"></div>
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
                    url: "{{ route('text-classification') }}", 
                    type: "POST",
                    data: JSON.stringify({ text: textData }),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    contentType: "application/json",
                    success: function(response) {
                        if (response.result.length > 0 && response.result[0].length > 0) {
                            let resultsHtml = "";
                            response.result[0].forEach(result => {
                                let label = result.label;
                                let score = (result.score * 100).toFixed(2);
                                let colorClass = label === "POSITIVE" ? "bg-green-500" : "bg-red-500";
                                resultsHtml += `
                                    <div class="mt-2">
                                        <p class="font-semibold text-gray-700">${label} - ${score}% Confidence</p>
                                        <div class="w-full bg-gray-200 rounded-full h-4 mt-1 relative">
                                            <div class="${colorClass} h-4 rounded-full" style="width: ${score}%;"></div>
                                        </div>
                                    </div>
                                `;
                            });
                            $("#classificationResults").html(resultsHtml);
                            $("#result").removeClass("hidden");
                        }
                    },
                    error: function() {
                        alert("Error submitting text.");
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
