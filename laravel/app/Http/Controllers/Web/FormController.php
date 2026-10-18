<?php

namespace App\Http\Controllers\Web;

use App\Enums\Requirement;
use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Enquiry;
use App\Notifications\Web\CampaignEnquiry;
use App\Notifications\Web\CareerEnquiry;
use App\Notifications\Web\ContactEnquiry;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * =========================================================
     * HANDLE CONTACT FORM SUBMIT
     * =========================================================
     */
    public function handleContactFormSubmit(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => ['required', 'string', 'email', 'min:1', 'max:250'],
                'phone' => ['required', 'numeric', 'digits_between:10,12'],
                'subject' => ['nullable', 'string', 'max:250'],
                'message' => ['required', 'string', 'min:1', 'max:1000'],
            ]);

            if ($validation->fails()) {

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validation->errors()
                    ], 422);
                }

                return redirect()
                    ->back()
                    ->withErrors($validation)
                    ->withInput();
            }

            $enquiry = new Enquiry();

            $enquiry->name = $request->input('name');
            $enquiry->phone = $request->input('phone');
            $enquiry->company = $request->input('email');
            $enquiry->requirement =
                $request->input('subject') ?: $request->input('message');

            $enquiry->save();

            // Email notification
            // Notification::route('mail', env('RECEIVER_MAIL'))
            //     ->notify(new ContactEnquiry($request->all()));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Enquiry submitted successfully',
                    'track_event' => 'form_submit'
                ]);
            }

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Message Submitted',
                'description' =>
                    'Your message has been successfully submitted, we will get in touch with you soon'
            ])->with('track_event', 'form_submit');

        } catch (Exception $exception) {

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 500);
            }

            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occurred',
                'description' => $exception->getMessage()
            ]);
        }
    }


    /**
     * =========================================================
     * HANDLE ENQUIRY NOW POPUP FORM SUBMIT
     * =========================================================
     *
     * Popup fields:
     * Name
     * Company Name
     * Mobile Number
     * Services
     */
    public function handlePopupEnquirySubmit(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [

                'name' => [
                    'required',
                    'string',
                    'min:1',
                    'max:250'
                ],

                'company_name' => [
                    'nullable',
                    'string',
                    'max:250'
                ],

                'mobile' => [
                    'required',
                    'digits:10'
                ],

                'service' => [
                    'required',
                    'string',
                    'max:250'
                ],

            ]);

            /*
             * Validation failed
             */
            if ($validation->fails()) {

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validation->errors()
                    ], 422);
                }

                return redirect()
                    ->back()
                    ->withErrors($validation)
                    ->withInput();
            }


            /*
             * Save enquiry
             */
            $enquiry = new Enquiry();

            $enquiry->name = $request->input('name');

            $enquiry->phone = $request->input('mobile');

            $enquiry->company = $request->input('company_name');

            $enquiry->requirement = $request->input('service');

            $enquiry->save();


            /*
             * Optional email notification
             *
             * Uncomment this only if your ContactEnquiry
             * notification is already configured correctly.
             */
            /*
            try {

                Notification::route(
                    'mail',
                    env('RECEIVER_MAIL')
                )->notify(
                    new ContactEnquiry([
                        'name' => $enquiry->name,
                        'phone' => $enquiry->phone,
                        'company' => $enquiry->company,
                        'requirement' => $enquiry->requirement,
                    ])
                );

            } catch (Exception $mailException) {

                \Illuminate\Support\Facades\Log::error(
                    'Popup enquiry email failed: ' .
                    $mailException->getMessage()
                );
            }
            */


            /*
             * AJAX request
             */
            if ($request->wantsJson()) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Enquiry submitted successfully',
                    'redirect' => route('view.thankyou'),
                    'track_event' => 'form_submit'
                ]);
            }


            /*
             * NORMAL FORM SUBMIT
             * Redirect directly to Thank You page
             */
            return redirect()->route('view.thankyou')->with('track_event', 'form_submit');

        } catch (Exception $exception) {

            /*
             * AJAX error
             */
            if ($request->wantsJson()) {

                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 500);
            }


            /*
             * Normal form error
             */
            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'error',
                    'title' => 'An error occurred',
                    'description' => $exception->getMessage()
                ]);
        }
    }


    /**
     * =========================================================
     * HANDLE CAREER FORM SUBMIT
     * =========================================================
     */
    public function handleCareerFormSubmit(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [

                'name' => [
                    'required',
                    'string',
                    'min:1',
                    'max:250'
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'min:1',
                    'max:250'
                ],

                'phone' => [
                    'required',
                    'numeric',
                    'digits_between:10,12'
                ],

                'role' => [
                    'required',
                    'string',
                    'min:1',
                    'max:250'
                ],

                'resume' => [
                    'required',
                    'file'
                ],

            ]);


            if ($validation->fails()) {

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validation->errors()
                    ], 422);
                }

                return redirect()
                    ->back()
                    ->withErrors($validation)
                    ->withInput();
            }


            $resumePath = null;


            if ($request->hasFile('resume')) {

                $nameSlug = Str::slug(
                    $request->input('name')
                );

                $roleSlug = Str::slug(
                    $request->input('role')
                );

                $resumeExt =
                    $request->file('resume')
                        ->getClientOriginalExtension();

                $resumePath =
                    $request->file('resume')
                        ->storeAs(
                            'resumes',
                            $nameSlug .
                            '-' .
                            $roleSlug .
                            '.' .
                            $resumeExt
                        );
            }


            if (Schema::hasTable('careers')) {

                $career = new Career();

                $career->name =
                    $request->input('name');

                $career->email =
                    $request->input('email');

                $career->phone =
                    $request->input('phone');

                $career->role =
                    $request->input('role');

                $career->resume =
                    $resumePath;

                $career->save();
            }


            // Email notification
            // Notification::route('mail', env('RECEIVER_MAIL'))
            //     ->notify(new CareerEnquiry($request->all()));


            if ($request->wantsJson()) {

                return response()->json([
                    'status' => 'success',
                    'message' =>
                        'Application submitted successfully',
                    'track_event' => 'form_submit'
                ]);
            }


            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Message Submitted',
                'description' =>
                    'Your message has been successfully submitted, we will get in touch with you soon'
            ])->with('track_event', 'form_submit');

        } catch (Exception $exception) {

            if ($request->wantsJson()) {

                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 500);
            }

            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occurred',
                'description' =>
                    $exception->getMessage()
            ]);
        }
    }


    /**
     * =========================================================
     * HANDLE PLAN YOUR CAMPAIGN POPUP FORM SUBMIT
     * =========================================================
     */
    public function handlePlanCampaignFormSubmit(
        Request $request
    ): RedirectResponse {

        try {

            $validation = Validator::make($request->all(), [

                'name' => [
                    'required',
                    'string',
                    'min:1',
                    'max:250'
                ],

                'phone' => [
                    'required',
                    'string',
                    'min:1',
                    'max:20'
                ],

                'company' => [
                    'required',
                    'string',
                    'min:1',
                    'max:250'
                ],

                'requirement' => [
                    'required',
                    'string'
                ],

            ]);


            if ($validation->fails()) {

                return redirect()
                    ->back()
                    ->withErrors(
                        $validation,
                        'planCampaign'
                    )
                    ->withInput()
                    ->with(
                        'open_plan_campaign_popup',
                        true
                    );
            }


            $enquiry = new Enquiry();

            $enquiry->name =
                $request->input('name');

            $enquiry->phone =
                $request->input('phone');

            $enquiry->company =
                $request->input('company');

            $enquiry->requirement =
                $request->input('requirement');

            $enquiry->save();


            $requirement_label =
                Requirement::tryFrom(
                    $request->input('requirement')
                )?->label()
                ??
                $request->input('requirement');


            /*
             * Campaign email notification
             */
            try {

                Notification::route(
                    'mail',
                    env('RECEIVER_MAIL')
                )->notify(
                    new CampaignEnquiry([
                        'name' =>
                            $enquiry->name,

                        'phone' =>
                            $enquiry->phone,

                        'company' =>
                            $enquiry->company,

                        'requirement' =>
                            $requirement_label,
                    ])
                );

            } catch (Exception $e) {

                \Illuminate\Support\Facades\Log::error(
                    'Failed to send campaign enquiry email: ' .
                    $e->getMessage()
                );
            }


            return redirect()->back()->with('message', [

                'status' => 'success',

                'title' => 'Thank You!',

                'description' =>
                    'Your campaign request is successfully submitted, we will get in touch with you soon.'

            ])->with('track_event', 'form_submit');

        } catch (Exception $exception) {

            return redirect()->back()->with('message', [

                'status' => 'error',

                'title' => 'An error occurred',

                'description' =>
                    $exception->getMessage()

            ]);
        }
    }
}