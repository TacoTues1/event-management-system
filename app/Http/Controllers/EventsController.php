<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    public function EventDisplay()
    {
        try {
            if (Event::count() == 0) {
                Event::create([
                    'title' => 'Sample Barangay Event',
                    'description' => 'This is a sample event.',
                    'event_date' => now()->toDateString(),
                    'start_time' => now()->format('H:i:s'),
                    'end_time' => now()->addHours(2)->format('H:i:s'),
                    'location' => 'Barangay Hall',
                ]);
            }

            $events = Event::orderBy('event_date', 'desc')->paginate(5);
            return view('portals.events', compact('events'));
        } catch (\Exception $e) {
            Log::error('Failed to load events display: ' . $e->getMessage());
            return back()->with('error', 'Unable to load events. Please try again later.');
        }
    }
}
