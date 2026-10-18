<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Enquiry;
use App\Models\Location;
use App\Models\Testimonial;
use Exception;

interface DashboardInterface
{
    public function viewDashboard();
}

class DashboardController extends Controller implements DashboardInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('logout');
    }

    /**
     * View Dashboard
     *
     * @return mixed
     */
    public function viewDashboard(): mixed
    {
        try {

            $total_admin = Admin::where('status', true)->count();
            $total_locations = Location::count();
            $total_testimonials = Testimonial::count();
            $total_enquiries = Enquiry::count();
            $recent_enquiries = Enquiry::orderBy('created_at', 'desc')->take(5)->get();

            return view('admin.pages.dashboard.dashboard',[
                'total_admin' => $total_admin,
                'total_locations' => $total_locations,
                'total_testimonials' => $total_testimonials,
                'total_enquiries' => $total_enquiries,
                'recent_enquiries' => $recent_enquiries,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }
}
