<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Activity Logs</h2>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-4 border border-gray-300">ID</th>
                        <th class="py-3 px-4 border border-gray-300">Description</th>
                        <th class="py-3 px-4 border border-gray-300">Subject</th>
                        <th class="py-3 px-4 border border-gray-300">Causer</th>
                        <th class="py-3 px-4 border border-gray-300">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="py-3 px-4 border border-gray-300 text-center">{{ $log->id }}</td>
                            <td class="py-3 px-4 border border-gray-300">{{ $log->description }}</td>
                            <td class="py-3 px-4 border border-gray-300">
                                {{ $log->subject_type }} (ID: {{ $log->subject_id }})
                            </td>
                            <td class="py-3 px-4 border border-gray-300">
                                {{ optional($log->causer)->name ?? 'System' }}
                            </td>
                            <td class="py-3 px-4 border border-gray-300">
                                {{ $log->created_at->format('d M Y, H:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">No logs available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $logs->links() }}
        </div>
    </div>

</body>
</html>
