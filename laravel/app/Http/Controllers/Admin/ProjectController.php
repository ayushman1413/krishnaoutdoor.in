<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ImageOptimizer;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

interface ProjectInterface
{
    public function viewProjectList();
    public function viewProjectCreate();
    public function viewProjectUpdate($id);
    public function handleProjectCreate(Request $request);
    public function handleProjectUpdate(Request $request, $id);
    public function handleToggleProjectStatus(Request $request);
    public function handleProjectDelete($id);
}


class ProjectController extends Controller
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
     * View Project List
     *
     * @return mixed
     */
    public function viewProjectList(): mixed
    {
        try {
            $projects = Project::all();

            return view('admin.pages.project.project-list', [
                'projects' => $projects
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
     * View Project Create
     *
     * @return mixed
     */
    public function viewProjectCreate(): mixed
    {
        try {
            return view('admin.pages.project.project-create');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View AccessoriesCondition Update
     *
     * @return mixed
     */
    public function viewProjectUpdate($id): mixed
    {
        try {
            $project = Project::find($id);

            if (!$project) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Project not found',
                    'description' => 'Project not found with specified ID'
                ]);
            }

            return view('admin.pages.project.project-update', [
                'project' => $project
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
     * Handle Project Create
     *
     * @return mixed
     */
    public function handleProjectCreate(Request $request): RedirectResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'summary' => ['nullable', 'string', 'min:1', 'max:500'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'thumbnail_image_alt' => ['nullable', 'string', 'max:255'],
                'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'cover_image_alt' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $project = new Project();
            $project->name = $request->input('name');
            $project->summary = $request->input('summary');
            $project->thumbnail_image_alt = $request->input('thumbnail_image_alt');
            $project->cover_image_alt = $request->input('cover_image_alt');
            if ($request->hasFile('thumbnail_image')) {
                $thumbOriginal = pathinfo($request->file('thumbnail_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $thumbSlug = Str::slug($thumbOriginal);
                $project->thumbnail_image = ImageOptimizer::store($request->file('thumbnail_image'), 'project', $thumbSlug);
            }
            if ($request->hasFile('cover_image')) {
                $coverOriginal = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $coverSlug = Str::slug($coverOriginal);
                $project->cover_image = ImageOptimizer::store($request->file('cover_image'), 'project', $coverSlug);
            }
            $project->save();

            return redirect()->route('admin.view.project.list')->with('message', [
                'status' => 'success',
                'title' => 'Project created',
                'description' => 'The project is successfully created.'
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
     * Handle Project Update
     *
     * @return mixed
     */
    public function handleProjectUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $project = Project::find($id);

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'summary' => ['nullable', 'string', 'min:1', 'max:500'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'thumbnail_image_alt' => ['nullable', 'string', 'max:255'],
                'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'cover_image_alt' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $project->name = $request->input('name');
            $project->summary = $request->input('summary');
            $project->thumbnail_image_alt = $request->input('thumbnail_image_alt');
            $project->cover_image_alt = $request->input('cover_image_alt');
            if ($request->hasFile('thumbnail_image')) {
                if (!is_null($project->thumbnail_image)) Storage::delete($project->thumbnail_image);
                $thumbOriginal = pathinfo($request->file('thumbnail_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $thumbSlug = Str::slug($thumbOriginal);
                $project->thumbnail_image = ImageOptimizer::store($request->file('thumbnail_image'), 'project', $thumbSlug);
            }
            if ($request->hasFile('cover_image')) {
                if (!is_null($project->cover_image)) Storage::delete($project->cover_image);
                $coverOriginal = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $coverSlug = Str::slug($coverOriginal);
                $project->cover_image = ImageOptimizer::store($request->file('cover_image'), 'project', $coverSlug);
            }
            $project->update();

            return redirect()->route('admin.view.project.list')->with('message', [
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
     * Handle Toggle Project Status
     *
     * @return mixed
     */
    public function handleToggleProjectStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'project_id' => ['required', 'numeric', 'exists:project,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $project = Project::find($request->input('project_id'));
            $project->status = !$project->status;
            $project->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $project
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
     * Handl Project Delete
     *
     * @return mixed
     */
    public function handleProjectDelete($id): RedirectResponse
    {
        try {
            $project = Project::find($id);

            if (!$project) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Project not found',
                    'description' => 'Project not found with specified ID'
                ]);
            }

            $project->delete();

            return redirect()->route('admin.view.project.list')->with('message', [
                'status' => 'success',
                'title' => 'Project deleted',
                'description' => 'The project is successfully deleted.'
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
