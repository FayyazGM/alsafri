<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\EventsController;
use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\admin\EmailController;
use App\Http\Controllers\admin\WhatsAppController;
use App\Http\Controllers\public\PagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\QrCodeController;
use App\Http\Controllers\admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class , 'home'])->name('home');
Route::get('/event-detail/{slug}', [PagesController::class , 'event_detail'])->name('event-detail');
Route::get('/exhibitor-detail/{id}', [PagesController::class , 'exhibitor_detail'])->name('exhibitor-detail');
Route::post('/event-registration', [PagesController::class , 'event_registration'])->name('event-registration');
Route::get('/events', [PagesController::class , 'events'])->name('events');
Route::get('/previous-events', [PagesController::class , 'previous_events'])->name('previous-events');
Route::get('/city-events/{cityId}', [PagesController::class , 'city_events'])->name('city-events');
Route::get('/gallery', [PagesController::class , 'gallery'])->name('gallery');
Route::get('/faq', [PagesController::class , 'faq'])->name('faq');
// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class , 'login'])->name('admin-login');
    Route::post('/', [AuthController::class , 'login_request'])->name('login-request');
    Route::get('/logout', [AuthController::class , 'logout'])->name('admin-logout');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPassword'])->name('admin.forgot-password.send');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('admin.password.reset');
    Route::post('/resetting-password', [AuthController::class, 'updatePassword'])->name('admin.password.update');
     // Protected Routes
    Route::middleware('auth:admin')->group(function () {
         // Admin Dashboard - only accessible by admin users
        Route::get('/dashboard', [DashboardController::class , 'dashboard'])->name('admin-dashboard')->middleware('admin.only');
        
        // Exhibitor Dashboard - only for exhibitors
        Route::get('/exhibitor/dashboard', [DashboardController::class , 'exhibitorDashboard'])->name('exhibitor.dashboard')->middleware('exhibitor');
        
        // Profile Routes - accessible by both admin and exhibitor
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        
        // Media Management Routes - only for exhibitors
        Route::middleware('exhibitor')->group(function () {
            // Media Management
            Route::get('/media', [App\Http\Controllers\admin\MediaController::class, 'index'])->name('admin.media.index');
            Route::get('/media/create', [App\Http\Controllers\admin\MediaController::class, 'create'])->name('admin.media.create');
            Route::post('/media', [App\Http\Controllers\admin\MediaController::class, 'store'])->name('admin.media.store');
            Route::get('/media/{id}', [App\Http\Controllers\admin\MediaController::class, 'show'])->name('admin.media.show');
            Route::get('/media/{id}/edit', [App\Http\Controllers\admin\MediaController::class, 'edit'])->name('admin.media.edit');
            Route::put('/media/{id}', [App\Http\Controllers\admin\MediaController::class, 'update'])->name('admin.media.update');
            Route::delete('/media/{id}', [App\Http\Controllers\admin\MediaController::class, 'destroy'])->name('admin.media.destroy');
            
            // Staff Management
            Route::get('/staff', [App\Http\Controllers\admin\StaffController::class, 'index'])->name('admin.staff.index');
            Route::get('/staff/create', [App\Http\Controllers\admin\StaffController::class, 'create'])->name('admin.staff.create');
            Route::post('/staff', [App\Http\Controllers\admin\StaffController::class, 'store'])->name('admin.staff.store');
            Route::get('/staff/{staff}', [App\Http\Controllers\admin\StaffController::class, 'show'])->name('admin.staff.show');
            Route::get('/staff/{staff}/edit', [App\Http\Controllers\admin\StaffController::class, 'edit'])->name('admin.staff.edit');
            Route::put('/staff/{staff}', [App\Http\Controllers\admin\StaffController::class, 'update'])->name('admin.staff.update');
            Route::delete('/staff/{staff}', [App\Http\Controllers\admin\StaffController::class, 'destroy'])->name('admin.staff.destroy');
            
            // Appointment Management
            Route::get('/appointments', [App\Http\Controllers\admin\AppointmentController::class, 'index'])->name('admin.appointments.index');
            Route::get('/appointments/create', [App\Http\Controllers\admin\AppointmentController::class, 'create'])->name('admin.appointments.create');
            Route::post('/appointments', [App\Http\Controllers\admin\AppointmentController::class, 'store'])->name('admin.appointments.store');
            Route::get('/appointments/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'show'])->name('admin.appointments.show');
            Route::get('/appointments/{appointment}/edit', [App\Http\Controllers\admin\AppointmentController::class, 'edit'])->name('admin.appointments.edit');
            Route::put('/appointments/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'update'])->name('admin.appointments.update');
            Route::delete('/appointments/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
            Route::patch('/appointments/{appointment}/status', [App\Http\Controllers\admin\AppointmentController::class, 'updateStatus'])->name('admin.appointments.update-status');
            
            // Exhibitor Reports
            Route::get('/exhibitor-reports', [App\Http\Controllers\admin\ExhibitorReportsController::class, 'index'])->name('admin.exhibitor-reports.index');
            Route::get('/exhibitor-reports/student-registrations', [App\Http\Controllers\admin\ExhibitorReportsController::class, 'studentRegistrations'])->name('admin.exhibitor-reports.student-registrations');
            Route::get('/exhibitor-reports/student-visits', [App\Http\Controllers\admin\ExhibitorReportsController::class, 'studentVisits'])->name('admin.exhibitor-reports.student-visits');
            Route::get('/exhibitor-reports/leads', [App\Http\Controllers\admin\ExhibitorReportsController::class, 'leads'])->name('admin.exhibitor-reports.leads');
            Route::get('/exhibitor-reports/export', [App\Http\Controllers\admin\ExhibitorReportsController::class, 'export'])->name('admin.exhibitor-reports.export');
        });
        
        // Admin-only routes - exclude exhibitors
        Route::middleware('admin.only')->group(function () {
            // UserManagement
            Route::get('/users', [UsersController::class, 'view'])->name('manage-users');
            Route::post('/add-new-user', [UsersController::class, 'add'])->name('add-new-user');
            Route::post('/update-user', [UsersController::class, 'update'])->name('update-user');
            
            // Event Management
            Route::get('/events', [EventsController::class, 'view'])->name('events-view');
            Route::post('/events/add', [EventsController::class, 'add'])->name('add-new-event');
            Route::post('/events/update', [EventsController::class, 'update'])->name('update-event');
            Route::get('/registration-form/{id}', [EventsController::class, 'registration_form'])->name('registration-form-view');
            Route::post('/add-registration-field', [EventsController::class, 'add_registration_field'])->name('add-registration-field');
            Route::post('/edit-registration-field', [EventsController::class, 'edit_registration_field'])->name('edit-registration-field');
            Route::post('/update-registration-field-order', [EventsController::class, 'update_registration_field_order'])->name('update-registration-field-order');
            Route::post('/delete-registration-field', [EventsController::class, 'delete_registration_field'])->name('delete-registration-field');
            Route::get('/event-attendees/{id}', [EventsController::class, 'eventAttendees'])->name('event-attendees');
            Route::get('/event-attendees/{id}/all-ids', [EventsController::class, 'getAllAttendeeIds'])->name('event-attendees-all-ids');
            Route::get('/import-attendees', [EventsController::class, 'importAttendeesForm'])->name('import-attendees-form');
            Route::post('/import-attendees', [EventsController::class, 'importAttendees'])->name('import-attendees');
            Route::get('/download-attendees-template', [EventsController::class, 'downloadAttendeesTemplate'])->name('download-attendees-template');
            Route::post('/mark-attendee-visited/{id}', [EventsController::class, 'markAttendeeVisited'])->name('mark-attendee-visited');
            Route::post('/mark-attendee-not-visited/{id}', [EventsController::class, 'markAttendeeNotVisited'])->name('mark-attendee-not-visited');
            Route::post('/approve-attendee', [EventsController::class, 'approveAttendee'])->name('approve-attendee');
            Route::post('/bulk-approve-attendees', [EventsController::class, 'bulkApproveAttendees'])->name('bulk-approve-attendees');
            Route::post('/bulk-reject-attendees', [EventsController::class, 'bulkRejectAttendees'])->name('bulk-reject-attendees');
            Route::post('/update-attendee-remarks', [EventsController::class, 'updateAttendeeRemarks'])->name('update-attendee-remarks');
            Route::post('/update-attendee', [EventsController::class, 'updateAttendee'])->name('update-attendee');
            
            // Event Exhibitor Routes
            Route::get('/events/{id}/exhibitors', [EventsController::class, 'getEventExhibitors'])->name('admin.events.exhibitors');
            Route::post('/events/link-exhibitors', [EventsController::class, 'linkExhibitors'])->name('admin.events.link-exhibitors');
            Route::post('/events/unlink-exhibitor', [EventsController::class, 'unlinkExhibitor'])->name('admin.events.unlink-exhibitor');
            
            // Event Gallery Routes
            Route::get('/event-gallery/{id}', [EventsController::class, 'eventGallery'])->name('event-gallery');
            Route::post('/add-gallery-image', [EventsController::class, 'addGalleryImage'])->name('add-gallery-image');
            Route::post('/delete-gallery-image/{id}', [EventsController::class, 'deleteGalleryImage'])->name('delete-gallery-image');
            Route::post('/bulk-delete-gallery-images', [EventsController::class, 'bulkDeleteGalleryImages'])->name('bulk-delete-gallery-images');
            Route::get('/scan-qrcode', [QrCodeController::class, 'scan'])->name('scan-qrcode');
            
            // Reports Routes
            Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports.index');
            Route::get('/reports/event/{eventId}', [ReportsController::class, 'getEventReport'])->name('admin.reports.event');
            Route::get('/reports/export/{eventId}', [ReportsController::class, 'exportEventReport'])->name('admin.reports.export');
            Route::get('/reports/export-present/{eventId}', [ReportsController::class, 'exportPresentAttendees'])->name('admin.reports.export-present');
            Route::get('/reports/export-absent/{eventId}', [ReportsController::class, 'exportAbsentAttendees'])->name('admin.reports.export-absent');
            Route::get('/reports/attendees', [ReportsController::class, 'attendeesReport'])->name('admin.reports.attendees');
            Route::get('/reports/attendees/generate', [ReportsController::class, 'generateAttendeesReport'])->name('admin.reports.attendees.generate');
            
            // Email Routes
            Route::get('/email-attendees', [EmailController::class, 'index'])->name('admin.email-attendees');
            Route::post('/email-attendees/preview', [EmailController::class, 'preview'])->name('admin.email-attendees-preview');
            Route::post('/email-attendees/send', [EmailController::class, 'send'])->name('admin.email-attendees-send');
            
            // WhatsApp Routes
            Route::get('/whatsapp-attendees', [WhatsAppController::class, 'index'])->name('admin.whatsapp-attendees');
            Route::post('/whatsapp-attendees/preview', [WhatsAppController::class, 'preview'])->name('admin.whatsapp-attendees-preview');
            Route::post('/whatsapp-attendees/send', [WhatsAppController::class, 'send'])->name('admin.whatsapp-attendees-send');
        });
    });

    
});
Route::get('/qr/{qr_code}' , [QrCodeController::class , 'qrcode_scanning'])->name('qrcode_code_scanning');
Route::get('/admin/events/{id}/edit-data', [App\Http\Controllers\admin\EventsController::class, 'editData'])->name('admin.events.edit-data');
Route::delete('/admin/events/slider-image/{id}/delete', [App\Http\Controllers\admin\EventsController::class, 'deleteSliderImage'])->name('admin.events.slider-image.delete');
Route::get('/events/{slug}', [App\Http\Controllers\admin\EventsController::class, 'publicEventDetail'])->name('public.event.detail');
Route::post('/admin/reject-attendee/{id}', [App\Http\Controllers\admin\EventsController::class, 'rejectAttendee']);
// Route::middleware('auth:admin')->group(function () {
    
// });
