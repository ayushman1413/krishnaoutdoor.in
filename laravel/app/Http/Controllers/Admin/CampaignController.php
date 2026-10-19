<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Campaign;
use App\Services\ImageOptimizer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function __construct()
    {
        // listJson public hai (projects.html ke liye)
        $this->middleware('auth:admin')->except('listJson');
    }

    private function deny(string $permission)
    {
        $admin = Admin::find(auth()->user()->id);
        if (!$admin->can($permission)) {
            return redirect()->back()->with('message', [
                'status' => 'warning',
                'title' => 'Unauthorized Access',
                'description' => 'You do not have access to this url'
            ]);
        }
        return null;
    }

    private function fail(Exception $e)
    {
        return redirect()->back()->with('message', [
            'status' => 'error',
            'title' => 'An error occcured',
            'description' => $e->getMessage()
        ]);
    }

    private function notFound()
    {
        return redirect()->back()->with('message', [
            'status' => 'warning',
            'title' => 'Campaign not found',
            'description' => 'Campaign not found with specified ID'
        ]);
    }

    private function rules(bool $isCreate): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'tagline' => ['nullable', 'string', 'max:250'],
            'media_type' => ['required', 'in:outdoor,transit,integrated,social'],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => [$isCreate ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['file', 'mimes:jpg,jpeg,png,webp'],
            'gallery_alt' => ['nullable', 'array'],
            'gallery_alt.*' => ['nullable', 'string', 'max:255'],
            'remove_gallery' => ['nullable', 'array'],
        ];
    }

    /**
     * File name for an uploaded campaign image: the slugified campaign title
     * (plus a suffix for gallery photos), never a random string. A name that
     * another file already uses gets a numeric suffix so nothing is overwritten.
     */
    private function imageName(Campaign $campaign, string $suffix = ''): string
    {
        $base = (Str::slug($campaign->name) ?: 'campaign') . $suffix;
        $name = $base;
        for ($i = 2; Storage::exists('campaigns/' . $name . '.webp'); $i++) {
            $name = $base . '-' . $i;
        }

        return $name;
    }

    private function fill(Campaign $campaign, Request $request): void
    {
        $campaign->name = $request->input('name');
        $campaign->tagline = $request->input('tagline');
        $campaign->media_type = $request->input('media_type');
        $campaign->city = $request->input('city');
        $campaign->description = $request->input('description');
        $campaign->image_alt = $request->input('image_alt');
        if ($request->hasFile('image')) {
            if ($campaign->image)
                Storage::delete($campaign->image);
            $campaign->image = ImageOptimizer::store($request->file('image'), 'campaigns', $this->imageName($campaign));
        }

        // Gallery for the case-study page: drop ticked photos, then add uploads.
        $gallery = $campaign->gallery ?? [];
        foreach ((array) $request->input('remove_gallery', []) as $index) {
            if (isset($gallery[$index])) {
                Storage::delete($gallery[$index]['path']);
                unset($gallery[$index]);
            }
        }
        $gallery = array_values($gallery);
        foreach ($request->file('gallery', []) as $key => $file) {
            $path = ImageOptimizer::store($file, 'campaigns', $this->imageName($campaign, '-photo-' . (count($gallery) + 1)));
            $gallery[] = ['path' => $path, 'alt' => trim((string) $request->input("gallery_alt.$key")) ?: null];
        }
        $campaign->gallery = $gallery ?: null;
    }

    public function viewCampaignList(): mixed
    {
        try {
            if ($r = $this->deny(Permission::VIEW_CAMPAIGN->value)) return $r;
            return view('admin.pages.campaign.campaign-list', [
                'campaigns' => Campaign::orderBy('created_at', 'desc')->get()
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewCampaignCreate(): mixed
    {
        try {
            if ($r = $this->deny(Permission::ADD_CAMPAIGN->value)) return $r;
            return view('admin.pages.campaign.campaign-create');
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewCampaignUpdate($id): mixed
    {
        try {
            if ($r = $this->deny(Permission::EDIT_CAMPAIGN->value)) return $r;
            $campaign = Campaign::find($id);
            if (!$campaign) return $this->notFound();
            return view('admin.pages.campaign.campaign-update', ['campaign' => $campaign]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleCampaignCreate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->rules(true));
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $campaign = new Campaign();
            $this->fill($campaign, $request);
            $campaign->save();

            return redirect()->route('admin.view.campaign.list')->with('message', [
                'status' => 'success',
                'title' => 'Campaign created',
                'description' => 'The campaign is successfully created.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleCampaignUpdate(Request $request, $id)
    {
        try {
            $campaign = Campaign::find($id);
            if (!$campaign) return $this->notFound();

            $validation = Validator::make($request->all(), $this->rules(false));
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $this->fill($campaign, $request);
            $campaign->update();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleToggleCampaignStatus(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'campaign_id' => ['required', 'string', 'exists:campaigns,id']
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validation->errors()->first()
                ], 200);
            }

            $campaign = Campaign::find($request->input('campaign_id'));
            $campaign->status = !$campaign->status;
            $campaign->update();

            return response()->json([
                'status' => true,
                'message' => 'Status successfully updated'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occcured',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function handleCampaignDelete($id)
    {
        try {
            if ($r = $this->deny(Permission::DELETE_CAMPAIGN->value)) return $r;
            $campaign = Campaign::find($id);
            if (!$campaign) return $this->notFound();

            if ($campaign->image)
                Storage::delete($campaign->image);
            $campaign->delete();

            return redirect()->route('admin.view.campaign.list')->with('message', [
                'status' => 'success',
                'title' => 'Campaign deleted',
                'description' => 'The campaign is successfully deleted.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    /**
     * Public JSON for projects.html
     */
    public function listJson()
    {
        $campaigns = Campaign::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'tagline' => $c->tagline,
                'media_type' => $c->media_type,
                'city' => $c->city,
                'description' => $c->description,
                'image' => $c->image ? asset('storage/' . $c->image) : null,
            ]);

        return response()->json(['status' => true, 'data' => $campaigns]);
    }
}