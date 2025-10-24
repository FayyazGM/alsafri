<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSubscription;
use Illuminate\Http\Request;

class EmailSubscriptionsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '');
        
        $query = EmailSubscription::orderBy('created_at', 'desc');
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('email', 'like', '%' . $filter . '%')
                  ->orWhere('ip_address', 'like', '%' . $filter . '%');
            });
        }
        
        $subscriptions = $query->paginate(10);
        
        return view('admin.email-subscriptions', compact('subscriptions', 'filter'));
    }
}
