<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '');
        
        $query = ContactMessage::orderBy('created_at', 'desc');
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter . '%')
                  ->orWhere('email', 'like', '%' . $filter . '%')
                  ->orWhere('subject', 'like', '%' . $filter . '%')
                  ->orWhere('message', 'like', '%' . $filter . '%');
            });
        }
        
        $messages = $query->paginate(10);
        
        return view('admin.contact-messages', compact('messages', 'filter'));
    }
}
