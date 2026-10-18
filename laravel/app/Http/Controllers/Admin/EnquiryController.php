<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Enquiry;
use Exception;
use Illuminate\Http\RedirectResponse;

interface EnquiryInterface
{
    public function viewEnquiryList();
    public function handleEnquiryDelete($id);
}

class EnquiryController extends Controller implements EnquiryInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * View Enquiry List
     *
     * @return mixed
     */
    public function viewEnquiryList(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_ENQUIRY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $enquiries = Enquiry::orderBy('created_at', 'desc')->get();

            return view('admin.pages.enquiry.enquiry-list', [
                'enquiries' => $enquiries
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Delete Enquiry
     *
     * @return RedirectResponse
     */
    public function handleEnquiryDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_ENQUIRY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $enquiry = Enquiry::find($id);

            if (!$enquiry) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Enquiry not found',
                    'description' => 'Enquiry not found with specified ID'
                ]);
            }

            $enquiry->delete();

            return redirect()->route('admin.view.enquiry.list')->with('message', [
                'status' => 'success',
                'title' => 'Enquiry deleted',
                'description' => 'The enquiry is successfully deleted.'
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
