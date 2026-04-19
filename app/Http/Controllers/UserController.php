<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DocumentRequest;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        // Get recent document requests for the user
        $recentRequests = DocumentRequest::where('resident_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get upcoming cash assistance events matching user's exact assistance program
        $upcomingEvents = \App\Models\Event::where('event_date', '>', now()->toDateString())
            ->whereNotNull('event_type')
            ->where('event_type', $user->is_indigent)
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();
            
        return view('home.user', compact('user', 'recentRequests', 'upcomingEvents'));
    }

    public function myRequests()
    {
        $user = Auth::user();
        $requests = DocumentRequest::where('resident_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.requests', compact('requests'));
    }

    public function viewRequestStatus($id)
    {
        try {
            $request = DocumentRequest::where('request_id', $id)
                ->where('resident_id', Auth::user()->user_id)
                ->firstOrFail();

            return response()->json([
                'id' => $request->request_id,
                'document_type' => explode(' - ', $request->purpose)[0] ?? 'Document Request',
                'purpose' => explode(' - ', $request->purpose, 2)[1] ?? $request->purpose,
                'status' => $request->status,
                'request_date' => $request->created_at->format('M d, Y'),
                'updated_at' => $request->updated_at->format('M d, Y h:i A'),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Request not found or access denied.'], 404);
        } catch (\Exception $e) {
            Log::error('Failed to fetch request status for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Unable to retrieve request status.'], 500);
        }
    }

    public function requestDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'purpose' => 'required|string|max:500',
        ]);

        try {
            DocumentRequest::create([
                'resident_id' => Auth::user()->user_id,
                'purpose' => $request->document_type . ' - ' . $request->purpose,
                'request_date' => now()->format('Y-m-d'),
                'status' => 'pending',
            ]);
            return redirect()->route('user.dashboard')->with('success', 'Document request submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to submit document request: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit your request. Please try again.');
        }
    }

    public function requestIndigency()
    {
        return view('user.documents.indigency');
    }

    public function requestAgricultural()
    {
        return view('user.documents.agricultural');
    }

    public function requestBarangay()
    {
        return view('user.documents.barangay');
    }

    public function requestBusiness()
    {
        return view('user.documents.business');
    }

    public function requestGoodMoral()
    {
        return view('user.documents.good-moral');
    }

    public function events()
    {
        $user = Auth::user();
        $events = \App\Models\Event::where('event_date', '>', now()->toDateString())
            ->whereNotNull('event_type')
            ->where('event_type', $user->is_indigent)
            ->orderBy('event_date', 'asc')
            ->get();
            
        return view('user.events', compact('events'));
    }
}