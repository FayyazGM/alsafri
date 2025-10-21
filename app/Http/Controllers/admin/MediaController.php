<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExhibitorMedia;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $exhibitor = Auth::guard('admin')->user();
        
        // Get all media for this exhibitor
        $media = ExhibitorMedia::where('exhibitor_id', $exhibitor->id)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.media.index', compact('media', 'exhibitor'));
    }

    public function create()
    {
        $exhibitor = Auth::guard('admin')->user();
        
        // Get events linked to this exhibitor
        $events = $exhibitor->events()->where('events.is_active', true)->get();

        return view('admin.media.create', compact('events', 'exhibitor'));
    }

    public function store(Request $request)
    {
        $exhibitor = Auth::guard('admin')->user();

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'media_type' => 'required|in:video,brochure,file',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        // Verify that the event is linked to this exhibitor
        $event = $exhibitor->events()->where('events.id', $request->event_id)->first();
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'You are not linked to this event.'
            ], 403);
        }

        // Validate file type based on media type
        $file = $request->file('file');
        $mimeType = $file->getMimeType();
        $allowedMimes = $this->getAllowedMimes($request->media_type);

        if (!in_array($mimeType, $allowedMimes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file type for ' . $request->media_type . '. Allowed types: ' . implode(', ', $this->getAllowedExtensions($request->media_type))
            ], 422);
        }

        // Store the file
        $filePath = $file->store('exhibitor-media/' . $request->media_type, 'public');

        // Create media record
        $media = ExhibitorMedia::create([
            'exhibitor_id' => $exhibitor->id,
            'event_id' => $request->event_id,
            'title' => $request->title,
            'media_type' => $request->media_type,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $mimeType,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Media uploaded successfully.',
            'data' => $media
        ]);
    }

    public function show($id)
    {
        $exhibitor = Auth::guard('admin')->user();
        
        $media = ExhibitorMedia::where('exhibitor_id', $exhibitor->id)
            ->with('event')
            ->findOrFail($id);

        return view('admin.media.show', compact('media'));
    }

    public function edit($id)
    {
        $exhibitor = Auth::guard('admin')->user();
        
        $media = ExhibitorMedia::where('exhibitor_id', $exhibitor->id)->findOrFail($id);
        $events = $exhibitor->events()->where('events.is_active', true)->get();

        return view('admin.media.edit', compact('media', 'events'));
    }

    public function update(Request $request, $id)
    {
        $exhibitor = Auth::guard('admin')->user();
        
        $media = ExhibitorMedia::where('exhibitor_id', $exhibitor->id)->findOrFail($id);

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'media_type' => 'required|in:video,brochure,file',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Verify that the event is linked to this exhibitor
        $event = $exhibitor->events()->where('events.id', $request->event_id)->first();
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'You are not linked to this event.'
            ], 403);
        }

        $data = [
            'event_id' => $request->event_id,
            'media_type' => $request->media_type,
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Handle file upload if provided
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mimeType = $file->getMimeType();
            $allowedMimes = $this->getAllowedMimes($request->media_type);

            if (!in_array($mimeType, $allowedMimes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file type for ' . $request->media_type . '. Allowed types: ' . implode(', ', $this->getAllowedExtensions($request->media_type))
                ], 422);
            }

            // Delete old file
            if ($media->file_path && Storage::exists('public/' . $media->file_path)) {
                Storage::delete('public/' . $media->file_path);
            }

            // Store new file
            $filePath = $file->store('exhibitor-media/' . $request->media_type, 'public');
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $mimeType;
        }

        $media->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Media updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $exhibitor = Auth::guard('admin')->user();
        
        $media = ExhibitorMedia::where('exhibitor_id', $exhibitor->id)->findOrFail($id);

        // Delete file from storage
        if ($media->file_path && Storage::exists('public/' . $media->file_path)) {
            Storage::delete('public/' . $media->file_path);
        }

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully.'
        ]);
    }

    private function getAllowedMimes($mediaType)
    {
        switch ($mediaType) {
            case 'video':
                return [
                    'video/mp4',
                    'video/avi',
                    'video/mov',
                    'video/wmv',
                    'video/flv',
                    'video/webm',
                    'video/mkv'
                ];
            case 'brochure':
                return [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp'
                ];
            case 'file':
                return [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'text/plain',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp'
                ];
            default:
                return [];
        }
    }

    private function getAllowedExtensions($mediaType)
    {
        switch ($mediaType) {
            case 'video':
                return ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
            case 'brochure':
                return ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
            case 'file':
                return ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
            default:
                return [];
        }
    }
}
