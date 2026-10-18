<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Testimonial;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

interface TestimonialInterface
{
    public function viewTestimonialList();
    public function viewTestimonialCreate();
    public function viewTestimonialUpdate($id);
    public function handleTestimonialCreate(Request $request);
    public function handleTestimonialUpdate(Request $request, $id);
    public function handleToggleTestimonialStatus(Request $request);
    public function handleTestimonialDelete($id);
}

class TestimonialController extends Controller implements TestimonialInterface
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
     * View Testimonial List
     *
     * @return mixed
     */
    public function viewTestimonialList(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_TESTIMONIAL->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $testimonials = Testimonial::orderBy('created_at', 'desc')->get();

            return view('admin.pages.testimonial.testimonial-list', [
                'testimonials' => $testimonials
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
     * View Testimonial Create
     *
     * @return mixed
     */
    public function viewTestimonialCreate(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::ADD_TESTIMONIAL->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            return view('admin.pages.testimonial.testimonial-create');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Testimonial Update
     *
     * @return mixed
     */
    public function viewTestimonialUpdate($id): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_TESTIMONIAL->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $testimonial = Testimonial::find($id);

            if (!$testimonial) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Testimonial not found',
                    'description' => 'Testimonial not found with specified ID'
                ]);
            }

            return view('admin.pages.testimonial.testimonial-update', [
                'testimonial' => $testimonial
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
     * Handle Create Testimonial
     *
     * @return RedirectResponse
     */
    public function handleTestimonialCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'client_name' => ['required', 'string', 'min:1', 'max:250'],
                'company_name' => ['nullable', 'string', 'min:1', 'max:250'],
                'feedback' => ['required', 'string', 'min:1', 'max:1000'],
                'company_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'company_logo_alt' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $testimonial = new Testimonial();
            $testimonial->client_name = $request->input('client_name');
            $testimonial->company_name = $request->input('company_name');
            $testimonial->feedback = $request->input('feedback');
            $testimonial->company_logo_alt = $request->input('company_logo_alt');
            if ($request->hasFile('company_logo')) {
                $logoOriginal = pathinfo($request->file('company_logo')->getClientOriginalName(), PATHINFO_FILENAME);
                $logoSlug = Str::slug($logoOriginal);
                $testimonial->company_logo = ImageOptimizer::store($request->file('company_logo'), 'testimonials', $logoSlug);
            }
            $testimonial->save();

            return redirect()->route('admin.view.testimonial.list')->with('message', [
                'status' => 'success',
                'title' => 'Testimonial created',
                'description' => 'The testimonial is successfully created.'
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
     * Handle Update Testimonial
     *
     * @return RedirectResponse
     */
    public function handleTestimonialUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $testimonial = Testimonial::find($id);

            if (!$testimonial) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Testimonial not found',
                    'description' => 'Testimonial not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'client_name' => ['required', 'string', 'min:1', 'max:250'],
                'company_name' => ['nullable', 'string', 'min:1', 'max:250'],
                'feedback' => ['required', 'string', 'min:1', 'max:1000'],
                'company_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'company_logo_alt' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $testimonial->client_name = $request->input('client_name');
            $testimonial->company_name = $request->input('company_name');
            $testimonial->feedback = $request->input('feedback');
            $testimonial->company_logo_alt = $request->input('company_logo_alt');
            if ($request->hasFile('company_logo')) {
                if ($testimonial->company_logo)
                    Storage::delete($testimonial->company_logo);
                $logoOriginal = pathinfo($request->file('company_logo')->getClientOriginalName(), PATHINFO_FILENAME);
                $logoSlug = Str::slug($logoOriginal);
                $testimonial->company_logo = ImageOptimizer::store($request->file('company_logo'), 'testimonials', $logoSlug);
            }
            $testimonial->update();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
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
     * Handle Toggle Testimonial Status
     *
     * @return Response
     */
    public function handleToggleTestimonialStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'testimonial_id' => ['required', 'string', 'exists:testimonials,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], Response::HTTP_OK);
            }

            $testimonial = Testimonial::find($request->input('testimonial_id'));
            $testimonial->status = !$testimonial->status;
            $testimonial->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $testimonial
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "An error occcured",
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle Delete Testimonial
     *
     * @return RedirectResponse
     */
    public function handleTestimonialDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_TESTIMONIAL->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $testimonial = Testimonial::find($id);

            if (!$testimonial) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Testimonial not found',
                    'description' => 'Testimonial not found with specified ID'
                ]);
            }

            if ($testimonial->company_logo)
                Storage::delete($testimonial->company_logo);

            $testimonial->delete();

            return redirect()->route('admin.view.testimonial.list')->with('message', [
                'status' => 'success',
                'title' => 'Testimonial deleted',
                'description' => 'The testimonial is successfully deleted.'
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
