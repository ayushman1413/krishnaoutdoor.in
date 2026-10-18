<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Enums\MaritalStatus;
use App\Enums\Permission;
use App\Enums\Religion;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Institution;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Spatie\Permission\Models\Role;

interface AlumniInterface
{
    public function viewAlumniList(Request $request);
    public function viewAlumniCreate();
    public function viewAlumniUpdate($id);
    public function viewAlumniPreview($id);
    public function handleAlumniCreate(Request $request);
    public function handleAlumniUpdate(Request $request, $id);
    public function handleToggleAlumniStatus(Request $request);
    public function handleAlumniDelete($id);
    public function handleAlumniVerify($id);
}

class AlumniController extends Controller implements AlumniInterface
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
     * View Alumni List
     *
     * @return mixed
     */
    public function viewAlumniList(Request $request): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $alumnis = Alumni::query();

            if ($request->input('institution_id')) {
                $alumnis = $alumnis->where('institution_id', $request->input('institution_id'));
            }

            $alumnis = $alumnis->get();

            $institutions = Institution::where('status', true)->get();

            return view('admin.pages.alumni.alumni-list', [
                'alumnis' => $alumnis,
                'institutions' => $institutions
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
     * View Alumni Create
     *
     * @return mixed
     */
    public function viewAlumniCreate(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::ADD_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $institutions = Institution::all();

            return view('admin.pages.alumni.alumni-create', [
                'institutions' => $institutions
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
     * View Alumni Preview
     *
     * @return mixed
     */
    public function viewAlumniPreview($id): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $alumni = Alumni::find($id);

            if (!$alumni) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Alumni not found',
                    'description' => 'Alumni not found with specified ID'
                ]);
            }

            return view('admin.pages.alumni.alumni-preview', [
                'alumni' => $alumni
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
     * View Alumni Update
     *
     * @return mixed
     */
    public function viewAlumniUpdate($id): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $alumni = Alumni::find($id);

            if (!$alumni) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Alumni not found',
                    'description' => 'Alumni not found with specified ID'
                ]);
            }

            $institutions = Institution::all();

            return view('admin.pages.alumni.alumni-update', [
                'alumni' => $alumni,
                'institutions' => $institutions
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
     * Handle Alumni Create
     *
     * @return RedirectResponse
     */
    public function handleAlumniCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => ['required', 'string', 'email',  'min:1', 'max:250', 'unique:alumnis'],
                'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:alumnis'],
                'gender' => ['required', 'string', new Enum(Gender::class)],
                'date_of_birth' => ['required', 'date_format:Y-m-d'],
                'designation' => ['required', 'string', 'min:1', 'max:250'],
                'marital_status' => ['required', 'string', new Enum(MaritalStatus::class)],
                'joining_year' => ['required', 'numeric', 'digits:4'],
                'pass_out_year' => ['required', 'numeric', 'digits:4'],
                'religion' => ['required', 'string', new Enum(Religion::class)],
                'institution_id' => ['required', 'string', 'exists:institutions,id'],
                'present_home' => ['nullable', 'string', 'min:1', 'max:250'],
                'present_street' => ['nullable', 'string', 'min:1', 'max:250'],
                'present_city' => ['required', 'string', 'min:1', 'max:50'],
                'present_postal_code' => ['required', 'numeric', 'digits:6'],
                'present_state' => ['required', 'string', 'min:1', 'max:50'],
                'present_country' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_home' => ['nullable', 'string', 'min:1', 'max:250'],
                'permanent_street' => ['nullable', 'string', 'min:1', 'max:250'],
                'permanent_city' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_postal_code' => ['required', 'numeric', 'digits:6'],
                'permanent_state' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_country' => ['required', 'string', 'min:1', 'max:50'],
                'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $alumni = new Alumni();
            $alumni->name = $request->input('name');
            $alumni->email = $request->input('email');
            $alumni->phone = $request->input('phone');
            $alumni->gender = $request->input('gender');
            $alumni->date_of_birth = $request->input('date_of_birth');
            $alumni->designation = $request->input('designation');
            $alumni->marital_status = $request->input('marital_status');
            $alumni->joining_year = $request->input('joining_year');
            $alumni->pass_out_year = $request->input('pass_out_year');
            $alumni->religion = $request->input('religion');
            $alumni->institution_id = $request->input('institution_id');
            $alumni->generateAlumniProfile();
            $alumni->password = Hash::make($request->input('password'));

            $present_address = new Address();
            $present_address->home = $request->input('present_home');
            $present_address->street = $request->input('present_street');
            $present_address->city = $request->input('present_city');
            $present_address->postal_code = $request->input('present_postal_code');
            $present_address->state = $request->input('present_state');
            $present_address->country = $request->input('present_country');
            $present_address->save();

            $permanent_address = new Address();
            $permanent_address->home = $request->input('permanent_home');
            $permanent_address->street = $request->input('permanent_street');
            $permanent_address->city = $request->input('permanent_city');
            $permanent_address->postal_code = $request->input('permanent_postal_code');
            $permanent_address->state = $request->input('permanent_state');
            $permanent_address->country = $request->input('permanent_country');
            $permanent_address->save();

            if ($request->input('academic_history_course')) {
                $academic_history = [];
                foreach ($request->input('academic_history_course') as $key => $value) {
                    array_push($academic_history, [
                        'course' => $request->input('academic_history_course')[$key],
                        'institution' => $request->input('academic_history_institution')[$key],
                        'passing_year' => $request->input('academic_history_passing_year')[$key],
                        'result_type' => $request->input('academic_history_result_type')[$key],
                        'result_value' => $request->input('academic_history_result_value')[$key]
                    ]);
                }
                $alumni->academic_history = json_encode($academic_history);
            } else {
                $alumni->academic_history = null;
            }

            if ($request->input('employment_history_designation')) {
                $employment_history = [];
                foreach ($request->input('employment_history_designation') as $key => $value) {
                    array_push($employment_history, [
                        'designation' => $request->input('employment_history_designation')[$key],
                        'company' => $request->input('employment_history_company')[$key],
                        'from' => $request->input('employment_history_from')[$key],
                        'to' => $request->input('employment_history_to')[$key]
                    ]);
                }
                $alumni->employment_history = json_encode($employment_history);
            } else {
                $alumni->employment_history = null;
            }

            $alumni->is_verified = true;
            $alumni->present_address_id = $present_address->id;
            $alumni->permanent_address_id = $permanent_address->id;
            $alumni->save();

            return redirect()->route('admin.view.alumni.list')->with('message', [
                'status' => 'success',
                'title' => 'Alumni created',
                'description' => 'The alumni is successfully created.'
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
     * Handle Alumni Update
     *
     * @return RedirectResponse
     */
    public function handleAlumniUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $alumni = Alumni::find($id);

            if (!$alumni) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Alumni not found',
                    'description' => 'Alumni not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => ['required', 'string', 'email',  'min:1', 'max:250', Rule::unique('alumnis')->ignore($id)],
                'phone' => ['required', 'numeric', 'digits_between:10,12', Rule::unique('alumnis')->ignore($id)],
                'gender' => ['required', 'string', new Enum(Gender::class)],
                'date_of_birth' => ['required', 'date_format:Y-m-d'],
                'designation' => ['required', 'string', 'min:1', 'max:250'],
                'marital_status' => ['required', 'string', new Enum(MaritalStatus::class)],
                'joining_year' => ['required', 'numeric', 'digits:4'],
                'pass_out_year' => ['required', 'numeric', 'digits:4'],
                'religion' => ['required', 'string', new Enum(Religion::class)],
                'institution_id' => ['required', 'string', 'exists:institutions,id'],
                'present_home' => ['nullable', 'string', 'min:1', 'max:250'],
                'present_street' => ['nullable', 'string', 'min:1', 'max:250'],
                'present_city' => ['required', 'string', 'min:1', 'max:50'],
                'present_postal_code' => ['required', 'numeric', 'digits:6'],
                'present_state' => ['required', 'string', 'min:1', 'max:50'],
                'present_country' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_home' => ['nullable', 'string', 'min:1', 'max:250'],
                'permanent_street' => ['nullable', 'string', 'min:1', 'max:250'],
                'permanent_city' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_postal_code' => ['required', 'numeric', 'digits:6'],
                'permanent_state' => ['required', 'string', 'min:1', 'max:50'],
                'permanent_country' => ['required', 'string', 'min:1', 'max:50'],
                'password' => ['nullable', 'string', 'min:6', 'max:20', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $alumni->name = $request->input('name');
            $alumni->email = $request->input('email');
            $alumni->phone = $request->input('phone');
            $alumni->gender = $request->input('gender');
            $alumni->date_of_birth = $request->input('date_of_birth');
            $alumni->designation = $request->input('designation');
            $alumni->marital_status = $request->input('marital_status');
            $alumni->joining_year = $request->input('joining_year');
            $alumni->pass_out_year = $request->input('pass_out_year');
            $alumni->religion = $request->input('religion');
            $alumni->institution_id = $request->input('institution_id');

            if (!is_null($alumni->present_address_id)) {
                $present_address = Address::find($alumni->present_address_id);
                $present_address->home = $request->input('present_home');
                $present_address->street = $request->input('present_street');
                $present_address->city = $request->input('present_city');
                $present_address->postal_code = $request->input('present_postal_code');
                $present_address->state = $request->input('present_state');
                $present_address->country = $request->input('present_country');
                $present_address->update();
            }

            if (!is_null($alumni->permanent_address_id)) {
                $permanent_address = Address::find($alumni->permanent_address_id);
                $permanent_address->home = $request->input('permanent_home');
                $permanent_address->street = $request->input('permanent_street');
                $permanent_address->city = $request->input('permanent_city');
                $permanent_address->postal_code = $request->input('permanent_postal_code');
                $permanent_address->state = $request->input('permanent_state');
                $permanent_address->country = $request->input('permanent_country');
                $permanent_address->update();
            }

            if ($request->input('academic_history_course')) {
                $academic_history = [];
                foreach ($request->input('academic_history_course') as $key => $value) {
                    array_push($academic_history, [
                        'course' => $request->input('academic_history_course')[$key],
                        'institution' => $request->input('academic_history_institution')[$key],
                        'passing_year' => $request->input('academic_history_passing_year')[$key],
                        'result_type' => $request->input('academic_history_result_type')[$key],
                        'result_value' => $request->input('academic_history_result_value')[$key]
                    ]);
                }
                $alumni->academic_history = json_encode($academic_history);
            } else {
                $alumni->academic_history = null;
            }

            if ($request->input('employment_history_designation')) {
                $employment_history = [];
                foreach ($request->input('employment_history_designation') as $key => $value) {
                    array_push($employment_history, [
                        'designation' => $request->input('employment_history_designation')[$key],
                        'company' => $request->input('employment_history_company')[$key],
                        'from' => $request->input('employment_history_from')[$key],
                        'to' => $request->input('employment_history_to')[$key]
                    ]);
                }
                $alumni->employment_history = json_encode($employment_history);
            } else {
                $alumni->employment_history = null;
            }

            if ($request->input('password')) {
                $alumni->password = Hash::make($request->input('password'));
            }

            $alumni->update();

            return redirect()->route('admin.view.alumni.list')->with('message', [
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
     * Handle Toggle Alumni Access Status
     *
     * @return Response
     */
    public function handleToggleAlumniStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'alumni_id' => ['required', 'numeric', 'exists:alumnis,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $alumni = Alumni::find($request->input('alumni_id'));
            $alumni->status = !$alumni->status;
            $alumni->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $alumni
            ], 200);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "An error occcured",
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Handl Alumni Access Delete
     *
     * @return RedirectResponse
     */
    public function handleAlumniDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $alumni = Alumni::find($id);

            if (!$alumni) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Alumni not found',
                    'description' => 'Alumni not found with specified ID'
                ]);
            }

            $alumni->delete();

            return redirect()->route('admin.view.alumni.list')->with('message', [
                'status' => 'success',
                'title' => 'Alumni deleted',
                'description' => 'The alumni is successfully deleted.'
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
     * Handle Alumni Verify
     *
     * @return RedirectResponse
     */
    public function handleAlumniVerify($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_ALUMNI->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $alumni = Alumni::find($id);

            if (!$alumni) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Alumni not found',
                    'description' => 'Alumni not found with specified ID'
                ]);
            }

            $alumni->is_verified = !$alumni->is_verified;
            $alumni->save();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' =>  $alumni->is_verified ? "Verified" : "Unverified",
                'description' => "The alumni is successfully " . ($alumni->is_verified ? "verified" : "unverified")
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
