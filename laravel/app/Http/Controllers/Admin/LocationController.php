<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaType;
use App\Enums\Permission;
use App\Enums\City;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Location;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

interface LocationInterface
{
    public function viewLocationList();
    public function viewLocationCreate();
    public function viewLocationUpdate($id);
    public function handleLocationCreate(Request $request);
    public function handleLocationUpdate(Request $request, $id);
    public function handleToggleLocationStatus(Request $request);
    public function handleToggleLocationAvailability(Request $request);
    public function handleLocationDelete($id);
}

class LocationController extends Controller implements LocationInterface
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
     * View Location List
     *
     * @return mixed
     */
    public function viewLocationList(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_LOCATION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $locations = Location::orderBy('created_at', 'desc')->get();

            return view('admin.pages.location.location-list', [
                'locations' => $locations
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
     * View Location Create
     *
     * @return mixed
     */
    public function viewLocationCreate(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::ADD_LOCATION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $media_type = MediaType::class;
            $cities     = City::class;

            return view('admin.pages.location.location-create', [
                'media_type' => $media_type,
                'cities'     => $cities,
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
     * View Location Update
     *
     * @return mixed
     */
    public function viewLocationUpdate($id): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_LOCATION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $location = Location::find($id);

            if (!$location) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Location not found',
                    'description' => 'Location not found with specified ID'
                ]);
            }

            $media_type = MediaType::class;
            $cities     = City::class;

            return view('admin.pages.location.location-update', [
                'location'   => $location,
                'media_type' => $media_type,
                'cities'     => $cities,
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
     * Handle Create Location
     *
     * @return RedirectResponse
     */
    public function handleLocationCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'name'         => ['required', 'string', 'min:1', 'max:250'],
                'media_type'   => ['required', 'string', Rule::enum(MediaType::class)],
                'city'         => ['required', 'string', Rule::in(array_column(City::cases(), 'value'))],
                'area'         => ['nullable', 'string', 'min:1', 'max:250'],
                'size'         => ['nullable', 'string', 'max:100'],
                'image'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'image_alt'    => ['nullable', 'string', 'max:255'],
                'is_available' => ['nullable', 'boolean'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $location = new Location();
            $location->name = $request->input('name');
            $location->media_type = $request->input('media_type');
            $location->city = $request->input('city');
            $location->area = $request->input('area');
            $location->size = $request->input('size');
            $location->is_available = $request->boolean('is_available', true);
            $location->image_alt = $request->input('image_alt');
            if ($request->hasFile('image')) {
                $imageOriginal = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                $imageSlug = Str::slug($imageOriginal) ?: 'location-' . time();
                $location->image = ImageOptimizer::store($request->file('image'), 'locations', $imageSlug);
            }
            $location->save();

            return redirect()->route('admin.view.location.list')->with('message', [
                'status' => 'success',
                'title' => 'Location created',
                'description' => 'The location is successfully created.'
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
     * Handle Update Location
     *
     * @return RedirectResponse
     */
    public function handleLocationUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $location = Location::find($id);

            if (!$location) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Location not found',
                    'description' => 'Location not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name'         => ['required', 'string', 'min:1', 'max:250'],
                'media_type'   => ['required', 'string', Rule::enum(MediaType::class)],
                'city'         => ['required', 'string', Rule::in(array_column(City::cases(), 'value'))],
                'area'         => ['nullable', 'string', 'min:1', 'max:250'],
                'size'         => ['nullable', 'string', 'max:100'],
                'image'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'image_alt'    => ['nullable', 'string', 'max:255'],
                'is_available' => ['nullable', 'boolean'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $location->name = $request->input('name');
            $location->media_type = $request->input('media_type');
            $location->city = $request->input('city');
            $location->area = $request->input('area');
            $location->size = $request->input('size');
            $location->is_available = $request->boolean('is_available', true);
            $location->image_alt = $request->input('image_alt');
            if ($request->hasFile('image')) {
                if ($location->image)
                    Storage::delete($location->image);
                $imageOriginal = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                $imageSlug = Str::slug($imageOriginal) ?: 'location-' . time();
                $location->image = ImageOptimizer::store($request->file('image'), 'locations', $imageSlug);
            }
            $location->update();

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
     * Handle Toggle Location Status
     *
     * @return Response
     */
    public function handleToggleLocationStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'location_id' => ['required', 'string', 'exists:locations,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], Response::HTTP_OK);
            }

            $location = Location::find($request->input('location_id'));
            $location->status = !$location->status;
            $location->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $location
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
     * Handle Toggle Location Availability
     *
     * @return Response
     */
    public function handleToggleLocationAvailability(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'location_id' => ['required', 'string', 'exists:locations,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], Response::HTTP_OK);
            }

            $location = Location::find($request->input('location_id'));
            $location->is_available = !$location->is_available;
            $location->update();

            return response([
                'status' => true,
                'message' => "Availability successfully updated",
                'data' => $location
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
     * Handle Delete Location
     *
     * @return RedirectResponse
     */
    public function handleLocationDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_LOCATION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $location = Location::find($id);

            if (!$location) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Location not found',
                    'description' => 'Location not found with specified ID'
                ]);
            }

            $location->delete();

            return redirect()->route('admin.view.location.list')->with('message', [
                'status' => 'success',
                'title' => 'Location deleted',
                'description' => 'The location is successfully deleted.'
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
