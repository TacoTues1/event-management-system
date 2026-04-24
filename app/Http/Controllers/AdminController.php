<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\AdminLog;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    use LogsAdminActivity;
    /**
     * Display admin dashboard with system overview
     */
    public function dashboard()
    {
        // Get current date for filtering
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();
        
        // Total counts
        $totalUsers = User::where('role', '!=', 'admin')->where('is_archived', false)->count();
        $totalRequests = DocumentRequest::count();
        $totalEvents = Event::count();
        $totalAdmins = User::where('role', 'admin')->where('is_archived', false)->count();
        
        // Request statistics
        $pendingRequests = DocumentRequest::where('status', 'pending')->count();
        $approvedRequests = DocumentRequest::where('status', 'approved')->count();
        $rejectedRequests = DocumentRequest::where('status', 'rejected')->count();
        
        // Monthly statistics
        $monthlyRequests = DocumentRequest::where('created_at', '>=', $thisMonth)->count();
        $monthlyUsers = User::where('role', '!=', 'admin')
                           ->where('is_archived', false)
                           ->where('created_at', '>=', $thisMonth)
                           ->count();
        
        // Document type breakdown
        $documentTypes = DocumentRequest::selectRaw('SUBSTRING_INDEX(purpose, " - ", 1) as doc_type, COUNT(*) as count')
                                      ->groupBy('doc_type')
                                      ->orderBy('count', 'desc')
                                      ->get();
        
        // Recent activities - handle both User and Resident models
        $recentRequests = DocumentRequest::with('resident')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
        
        $recentUsers = User::where('role', '!=', 'admin')
                          ->where('is_archived', false)
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();
        
        // Purok distribution
        $purokDistribution = User::where('role', '!=', 'admin')
                                ->where('is_archived', false)
                                ->whereNotNull('purok')
                                ->selectRaw('purok, COUNT(*) as count')
                                ->groupBy('purok')
                                ->orderBy('count', 'desc')
                                ->get();
        
        // Status distribution for chart
        $statusData = [
            'pending' => $pendingRequests,
            'approved' => $approvedRequests,
            'rejected' => $rejectedRequests
        ];
        
        // Residents with cash assistance
        $residentsWithAssistance = User::where('role', '!=', 'admin')
                                ->where('is_archived', false)
                                ->where('is_indigent', '!=', 'N/A')
                                ->whereNotNull('is_indigent')
                                ->select('name', 'purok', 'is_indigent')
                                ->orderBy('name')
                                ->get();

        // Assistance members per purok (for purok detail modal)
        $assistanceByPurok = User::where('role', '!=', 'admin')
                                ->where('is_archived', false)
                                ->whereNotNull('purok')
                                ->whereNotNull('is_indigent')
                                ->where('is_indigent', '!=', 'N/A')
                                ->selectRaw('purok, is_indigent, COUNT(*) as count')
                                ->groupBy('purok', 'is_indigent')
                                ->get()
                                ->groupBy('purok');
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalRequests', 'totalEvents', 'totalAdmins',
            'pendingRequests', 'approvedRequests', 'rejectedRequests',
            'monthlyRequests', 'monthlyUsers', 'documentTypes',
            'recentRequests', 'recentUsers', 'purokDistribution', 'statusData',
            'residentsWithAssistance', 'assistanceByPurok'
        ));
    }

    /**
     * Display residents list
     */
    public function residentsList(Request $request)
    {
        $query = User::where('role', 'resident')->where('is_archived', false);

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $residents = $query->orderBy('name')->get();

        return view('portals.residents-list', compact('residents'));
    }

    public function updateResident(Request $request, $id)
    {
        $resident = User::where('role', 'resident')->where('user_id', $id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $resident->user_id . ',user_id',
            'contact_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'age' => 'nullable|integer|min:0|max:150',
            'civil_status' => 'required|string|max:20',
            'id_type' => 'required|string|max:100',
            'resident_id_file' => 'nullable|file|extensions:jpg,jpeg,png,webp,avif,heic,heif,pdf|mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/avif,image/heic,image/heif,image/heic-sequence,image/heif-sequence,application/pdf,application/octet-stream|max:10240',
            'purok' => 'required|string|max:100',
            'building_no' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'cash_assistance_programs' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'date_issued' => 'nullable|date',
        ]);

        try {
            DB::transaction(function () use ($request, $resident, $validated) {
                $updateData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'contact_number' => $validated['contact_number'],
                    'age' => $validated['age'] ?? $resident->age,
                    'civil_status' => $validated['civil_status'],
                    'id_type' => $validated['id_type'],
                    'purok' => $validated['purok'],
                    'building_no' => $validated['building_no'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'full_address' => trim($validated['building_no'] . ', ' . $validated['purok'] . ', ' . $validated['barangay'] . ', ' . $validated['city']),
                    'latitude' => $validated['latitude'] ?? null,
                    'longitude' => $validated['longitude'] ?? null,
                    'is_indigent' => $validated['cash_assistance_programs'],
                    'purpose' => $validated['purpose'] ?? ($resident->purpose ?: 'Resident Registration'),
                    'date_issued' => $validated['date_issued'] ?? ($resident->date_issued ?: now()->format('Y-m-d')),
                ];

                if (!empty($validated['password'])) {
                    $updateData['password'] = Hash::make($validated['password']);
                }

                if ($request->hasFile('resident_id_file')) {
                    $newFilePath = $request->file('resident_id_file')->store('resident-ids', 'public');

                    if (!empty($resident->resident_id_file)) {
                        Storage::disk('public')->delete($resident->resident_id_file);
                    }

                    $updateData['resident_id_file'] = $newFilePath;
                }

                $resident->update($updateData);

                $this->logActivity('UPDATE_RESIDENT', "Updated resident details: {$resident->name} (ID: {$resident->user_id})");
            });

            return redirect()->route('dashboard-residents.residents')->with('success', 'Resident details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update resident ID ' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to update resident details. Please try again.')->withInput();
        }
    }

    public function archiveUser($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        try {
            DB::transaction(function () use ($user) {
                $userName = $user->name;
                $userRole = $user->role;
                
                $user->update(['is_archived' => true]);

                $this->logActivity('ARCHIVE_USER', "Archived {$userRole}: {$userName} (ID: {$user->user_id})");
            });

            return redirect()->back()->with('success', 'User archived successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to archive user ID ' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to archive user. Please try again.');
        }
    }

    public function restoreUser($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        try {
            DB::transaction(function () use ($user) {
                $userName = $user->name;
                $userRole = $user->role;
                
                $user->update(['is_archived' => false]);

                $this->logActivity('RESTORE_USER', "Restored {$userRole}: {$userName} (ID: {$user->user_id})");
            });

            return redirect()->back()->with('success', 'User restored successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to restore user ID ' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to restore user. Please try again.');
        }
    }

    public function adminsList(Request $request)
    {
        $query = User::where('role', 'admin')->where('is_archived', false);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $admins = $query->orderBy('name')->get();

        return view('admin.admins-list', compact('admins'));
    }

    public function archiveList(Request $request)
    {
        $query = User::where('is_archived', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $archivedUsers = $query->orderBy('updated_at', 'desc')->get();

        return view('admin.archive-list', compact('archivedUsers'));
    }

    public function deleteResident($id)
    {
        // Keeping this for compatibility if needed, but routing will likely change to archiveUser
        return $this->archiveUser($id);
    }

    public function viewResidentIdFile($id)
    {
        $resident = User::where('role', 'resident')->where('user_id', $id)->firstOrFail();

        if (empty($resident->resident_id_file)) {
            abort(404, 'No ID file uploaded for this resident.');
        }

        $rawPath = str_replace('\\', '/', trim($resident->resident_id_file));
        $urlPath = parse_url($rawPath, PHP_URL_PATH) ?: $rawPath;
        $filePath = ltrim($urlPath, '/');
        $normalizedPath = preg_replace('/^(storage|public)\//i', '', $filePath);
        $fileName = basename($normalizedPath);

        $candidates = array_values(array_filter(array_unique([
            $normalizedPath,
            $filePath,
            preg_replace('/^storage\//i', '', $filePath),
            preg_replace('/^public\//i', '', $filePath),
            $fileName ? 'resident-ids/' . $fileName : null,
        ])));

        $resolvedPath = null;
        foreach ($candidates as $candidate) {
            if (!empty($candidate) && Storage::disk('public')->exists($candidate)) {
                $resolvedPath = $candidate;
                break;
            }
        }

        if (!$resolvedPath) {
            abort(404, 'ID file not found.');
        }

        $fileContent = Storage::disk('public')->get($resolvedPath);
        $extension = strtolower(pathinfo($resolvedPath, PATHINFO_EXTENSION));
        $mimeMap = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'avif' => 'image/avif',
            'heic' => 'image/heic',
            'heif' => 'image/heif',
            'pdf' => 'application/pdf',
        ];
        $detectedMimeType = null;
        if (class_exists('finfo')) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $detectedMimeType = $finfo->buffer($fileContent) ?: null;
        }

        $mimeType = $detectedMimeType ?: ($mimeMap[$extension] ?? 'application/octet-stream');
        $filename = basename($resolvedPath);

        return response($fileContent, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function indigency()
    {
        $residents = Resident::orderBy('full_name')->get();

        return view('portals.dashboard', compact('residents'));
    }

    public function documentRequests()
    {
        $requests = DocumentRequest::with('resident')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portals.document-requests', compact('requests'));
    }

    public function showDocumentRequest($id)
    {
        $request = DocumentRequest::with('resident')->findOrFail($id);
        
        // Extract document type from purpose (format: "Document Type - Purpose")
        $purposeParts = explode(' - ', $request->purpose, 2);
        $documentType = $purposeParts[0] ?? 'Document Request';
        $actualPurpose = $purposeParts[1] ?? $request->purpose;
        
        return response()->json([
            'resident_name' => $request->resident->name,
            'document_type' => $documentType,
            'purpose' => $actualPurpose,
            'status' => $request->status,
            'requested_at' => $request->created_at->format('M d, Y h:i A')
        ]);
    }

    public function approveRequest($id)
    {
        try {
            $request = DocumentRequest::findOrFail($id);
            DB::transaction(function () use ($request, $id) {
                $request->update(['status' => 'approved']);
                $this->logActivity('APPROVE_REQUEST', "Approved document request ID: {$id} for user: {$request->resident->name}");
            });
            return redirect()->back()->with('success', 'Document request approved successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to approve request ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve the request. Please try again.');
        }
    }

    public function rejectRequest($id)
    {
        try {
            $request = DocumentRequest::findOrFail($id);
            DB::transaction(function () use ($request, $id) {
                $request->update(['status' => 'rejected']);
                $this->logActivity('REJECT_REQUEST', "Rejected document request ID: {$id} for user: {$request->resident->name}");
            });
            return redirect()->back()->with('success', 'Document request rejected.');
        } catch (\Exception $e) {
            Log::error('Failed to reject request ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reject the request. Please try again.');
        }
    }

    public function viewDocument($id)
    {
        $request = DocumentRequest::with('resident')->findOrFail($id);
        
        // Extract document type from purpose
        $purposeParts = explode(' - ', $request->purpose, 2);
        $documentType = $purposeParts[0] ?? 'Document Request';
        $actualPurpose = $purposeParts[1] ?? $request->purpose;
        
        // Determine which document view to show based on document type
        $viewMap = [
            'Certificate of Indigency' => 'admin.documents.indigency',
            'Agricultural Certification' => 'admin.documents.agricultural',
            'Barangay Certification' => 'admin.documents.barangay',
            'Business Certification' => 'admin.documents.business',
            'Certificate of Good Moral' => 'admin.documents.good-moral',
        ];
        
        $view = $viewMap[$documentType] ?? 'admin.documents.generic';
        
        return view($view, compact('request', 'documentType', 'actualPurpose'));
    }

    public function adminLogs()
    {
        $logs = AdminLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.logs', compact('logs'));
    }

    public function createAdminForm()
    {
        return view('admin.create-admin');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $admin = DB::transaction(function () use ($request) {
                return User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'role' => 'admin',
                    'civil_status' => 'Single',
                    'purok' => 'Admin Office',
                    'barangay' => 'Bagacay',
                    'city' => 'Dumaguete City',
                    'is_indigent' => 'N/A',
                    'purpose' => 'Admin Account',
                    'date_issued' => now()->format('Y-m-d'),
                ]);
            });

            $this->logActivity('CREATE_ADMIN', "Created new admin account: {$admin->name} ({$admin->email})");
            return redirect()->route('admin.create-admin')->with('success', 'Admin account created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create admin account: ' . $e->getMessage());
            return back()->with('error', 'Failed to create admin account. Please try again.');
        }
    }

    public function residentsWithGeoTag()
    {
        $residents = User::where('role', '!=', 'admin')->where('is_archived', false)->paginate(10);
        $allResidents = User::where('role', '!=', 'admin')
            ->where('is_archived', false)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['name', 'purok', 'full_address', 'latitude', 'longitude', 'is_indigent', 'age', 'civil_status']);

        $allResidentsForModal = User::where('role', '!=', 'admin')
            ->where('is_archived', false)
            ->get(['name', 'purok', 'full_address', 'is_indigent', 'age', 'civil_status']);

        $programCounts = User::where('role', '!=', 'admin')
            ->where('is_archived', false)
            ->whereNotNull('is_indigent')
            ->where('is_indigent', '!=', 'N/A')
            ->selectRaw('is_indigent, COUNT(*) as count')
            ->groupBy('is_indigent')
            ->pluck('count', 'is_indigent');

        $purokCounts = User::where('role', '!=', 'admin')
            ->where('is_archived', false)
            ->whereNotNull('purok')
            ->selectRaw('purok, COUNT(*) as count')
            ->groupBy('purok')
            ->pluck('count', 'purok')
            ->mapWithKeys(fn($count, $purok) => [
                preg_replace('/^purok\s+/i', '', trim($purok)) => $count
            ]);

        $purokProgramCounts = User::where('role', '!=', 'admin')
            ->where('is_archived', false)
            ->whereNotNull('purok')
            ->whereNotNull('is_indigent')
            ->where('is_indigent', '!=', 'N/A')
            ->selectRaw('purok, is_indigent, COUNT(*) as count')
            ->groupBy('purok', 'is_indigent')
            ->get()
            ->groupBy(fn($r) => preg_replace('/^purok\s+/i', '', trim($r->purok)))
            ->map(fn($rows) => $rows->pluck('count', 'is_indigent'));
            
        return view('admin.residents-map', compact('residents', 'allResidents', 'programCounts', 'purokCounts', 'purokProgramCounts', 'allResidentsForModal'));
    }

    public function storeResident(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'id_type' => 'required|string|max:100',
            'resident_id_file' => 'required|file|extensions:jpg,jpeg,png,webp,avif,heic,heif,pdf|mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/avif,image/heic,image/heif,image/heic-sequence,image/heif-sequence,application/pdf,application/octet-stream|max:10240',
            'birthdate' => 'required|date|before:today',
            'civil_status' => 'required|string|max:20',
            'purok' => 'required|string|max:100',
            'building_no' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'cash_assistance_programs' => 'required|string|max:255',
        ]);

        try {
            $age = Carbon::parse($request->birthdate)->age;
            $fullName = trim($request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name . ' ' . ($request->suffix ?? ''));
            $fullAddress = trim($request->building_no . ', ' . $request->purok . ', Bagacay, Dumaguete City');
            $residentIdFilePath = $request->file('resident_id_file')->store('resident-ids', 'public');

            DB::transaction(function () use ($request, $age, $fullName, $fullAddress, $residentIdFilePath) {
                $user = User::create([
                    'name' => $fullName,
                    'email' => $request->email,
                    'contact_number' => $request->contact_number,
                    'password' => $request->password,
                    'role' => 'resident',
                    'age' => $age,
                    'civil_status' => $request->civil_status,
                    'id_type' => $request->id_type,
                    'resident_id_file' => $residentIdFilePath,
                    'purok' => $request->purok,
                    'building_no' => $request->building_no,
                    'barangay' => 'Bagacay',
                    'city' => 'Dumaguete City',
                    'full_address' => $fullAddress,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'is_indigent' => $request->cash_assistance_programs,
                    'purpose' => 'Resident Registration',
                    'date_issued' => now()->format('Y-m-d'),
                ]);
                $this->logActivity('ADD_RESIDENT', "Added new resident: {$fullName}");
            });

            return redirect()->route('add-user.portal')->with('success', 'Resident registered successfully!');
        } catch (\Exception $e) {
            if (isset($residentIdFilePath)) {
                Storage::disk('public')->delete($residentIdFilePath);
            }
            Log::error('Failed to register resident: ' . $e->getMessage());
            return back()->with('error', 'Failed to register resident. Please try again.')->withInput();
        }
    }

    public function events()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return view('admin.events', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_type' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'latitude.required' => 'Please click on the map to set the event location.',
            'longitude.required' => 'Please click on the map to set the event location.',
            'event_date.after_or_equal' => 'Event date must be today or in the future.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $event = Event::create($request->only([
                    'title', 'event_type', 'event_date', 'start_time',
                    'end_time', 'location', 'latitude', 'longitude', 'description',
                ]));
                $this->logActivity('CREATE_EVENT', "Created cash assistance event: {$event->title}");
            });
            return redirect()->route('admin.events')->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create event: ' . $e->getMessage());
            return back()->with('error', 'Failed to create event. Please try again.')->withInput();
        }
    }

    public function showEvent($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function deleteEvent($id)
    {
        try {
            $event = Event::findOrFail($id);
            $title = $event->title;
            DB::transaction(function () use ($event, $title) {
                $event->delete();
                $this->logActivity('DELETE_EVENT', "Deleted event: {$title}");
            });
            return redirect()->route('admin.events')->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete event ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('admin.events')->with('error', 'Failed to delete event. Please try again.');
        }
    }

    
}
