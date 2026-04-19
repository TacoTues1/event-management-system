@extends('home.admin')

@section('title', 'Dashboard')

@section('content')

<div class="container mx-auto mt-8 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Events</h1>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Add Event</a>
    </div>

    <div class="overflow-x-auto bg-white shadow ">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ Str::limit($event->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->event_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->start_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->end_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->location }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $event->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Default Laravel Pagination --}}
    <div class="mt-4 flex justify-center">
        {{ $events->links() }}
    </div>

</div>

@endsection
