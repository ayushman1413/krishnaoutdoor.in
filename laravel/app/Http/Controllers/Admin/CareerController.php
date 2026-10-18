<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;

interface CareerInterface
{
    public function viewCareerList();
    public function handleCareerDelete($id);
}

class CareerController extends Controller implements CareerInterface
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
     * View Career Application List
     *
     * @return mixed
     */
    public function viewCareerList(): mixed
    {
        try {
            if (!Schema::hasTable('careers')) {
                $careers = collect();
            } else {
                $careers = Career::orderBy('created_at', 'desc')->get();
            }

            return view('admin.pages.career.career-list', [
                'careers' => $careers
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
     * Handle Delete Career Application
     *
     * @return RedirectResponse
     */
    public function handleCareerDelete($id): RedirectResponse
    {
        try {
            if (!Schema::hasTable('careers')) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Table missing',
                    'description' => 'Careers table is not created in the database yet.'
                ]);
            }

            $career = Career::find($id);

            if (!$career) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Application not found',
                    'description' => 'Candidate application not found with specified ID'
                ]);
            }

            $career->delete();

            return redirect()->route('admin.view.career.list')->with('message', [
                'status' => 'success',
                'title' => 'Application deleted',
                'description' => 'The candidate application has been successfully deleted.'
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
