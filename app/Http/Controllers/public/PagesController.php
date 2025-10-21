<?php

namespace App\Http\Controllers\public;

use App\Helpers\WhatsappHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventGallery;
use App\Models\ExhibitorMedia;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{

    public function home()
    {
        return view('public.index');
    }
}