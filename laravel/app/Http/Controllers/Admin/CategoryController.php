<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Enums\ProjectCategory;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\CategoryMedia;
use App\Models\SeoRedirect;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

interface CategoryInterface
{
    public function viewCategoryList();
    public function viewCategoryCreate();
    public function viewCategoryUpdate($id);
    public function handleCategoryCreate(Request $request);
    public function handleCategoryUpdate(Request $request, $id);
    public function handleToggleCategoryStatus(Request $request);
    public function handleCategoryDelete($id);
    public function handleCategoryMediaUpdate(Request $request, $id);
}

class CategoryController extends Controller implements CategoryInterface
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
     * View Category List
     *
     * @return mixed
     */
    public function viewCategoryList(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::VIEW_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $categories = Category::where('category_id', null)->get();

            return view('admin.pages.category.category-list', [
                'categories' => $categories
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
     * View Category Create
     *
     * @return mixed
     */
    public function viewCategoryCreate(): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::ADD_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $project_category = ProjectCategory::class;

            $categories = Category::all();

            return view('admin.pages.category.category-create', [
                'categories' => $categories,
                'project_category' => $project_category
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
     * View Category Update
     *
     * @return mixed
     */
    public function viewCategoryUpdate($id): mixed
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $category = Category::find($id);

            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not found',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            $category_media = CategoryMedia::where('category_id', $category->id)->get();

            $categories = Category::all();

            $project_category = ProjectCategory::class;

            return view('admin.pages.category.category-update', [
                'category' => $category,
                'categories' => $categories,
                'category_media' => $category_media,
                'project_category' => $project_category
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
     * Handle Create Category
     *
     * @return RedirectResponse
     */
    public function handleCategoryCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'category_id' => ['nullable', 'string', 'exists:categories,id'],
                'name' => ['required', 'string', 'min:1', 'max:250', 'unique:categories'],
                'slug' => ['nullable', 'string', 'min:1', 'max:500', 'unique:categories'],
                'summary' => ['nullable', 'string', 'min:1', 'max:500'],
                'description' => ['nullable', 'string', 'min:1', 'max:1000'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,gif'],
                'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,gif'],
                'priority' => ['nullable', 'numeric']
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $category = new Category();
            $category->category_id = $request->input('category_id');
            $category->name = $request->input('name');
            $category->summary = $request->input('summary');
            $category->description = $request->input('description');
            if ($request->hasFile('thumbnail_image')) {
                $thumbOriginal = pathinfo($request->file('thumbnail_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $thumbSlug = Str::slug($thumbOriginal);
                $category->thumbnail_image = ImageOptimizer::store($request->file('thumbnail_image'), 'categories', $thumbSlug);
            }
            if ($request->hasFile('cover_image')) {
                $coverOriginal = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $coverSlug = Str::slug($coverOriginal);
                $category->cover_image = ImageOptimizer::store($request->file('cover_image'), 'categories', $coverSlug);
            }
            $category->priority = $request->input('priority');

            if ($request->input('slug'))
                $category->slug = $request->input('slug');
            else
                $category->slug = Str::slug($request->input('name')) ?: Str::random(64);

            $category->save();

            if ($request->category_media) {
                foreach ($request->category_media as $key => $file) {
                    if ($request->hasFile('category_media')) {
                        $category_media = new CategoryMedia();
                        $category_media->category_id = $category->id;
                        $category_media->type = $file->getClientMimeType();
                        $mediaOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $mediaSlug = Str::slug($mediaOriginal);
                        $category_media->path = ImageOptimizer::store($file, 'category-media', $mediaSlug . '-' . ($key + 1));
                        $category_media->project_category = $request->input('project_category');
                        $category_media->save();
                    }
                }
            }

            return redirect()->route('admin.view.category.list')->with('message', [
                'status' => 'success',
                'title' => 'Category created',
                'description' => 'The category is successfully created.'
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
     * Handle Update Category
     *
     * @return RedirectResponse
     */
    public function handleCategoryUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $category = Category::find($id);

            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not found',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'category_id' => ['nullable', 'string', 'exists:categories,id'],
                'name' => [
                    'required', 'string', 'min:1', 'max:250',
                    Rule::unique('categories')->ignore($category->name, 'name')
                ],
                'slug' => [
                    'required', 'string', 'min:1', 'max:500',
                    Rule::unique('categories')->ignore($category->slug, 'slug')
                ],
                'summary' => ['nullable', 'string', 'min:1', 'max:500'],
                'description' => ['nullable', 'string', 'min:1', 'max:1000'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,gif'],
                'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,gif'],
                'priority' => ['nullable', 'numeric']
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $oldSlug = $category->slug;

            $category->category_id = $request->input('category_id');
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->summary = $request->input('summary');
            $category->description = $request->input('description');
            if ($request->hasFile('thumbnail_image')) {
                if ($category->thumbnail_image)
                    Storage::delete($category->thumbnail_image);
                $thumbOriginal = pathinfo($request->file('thumbnail_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $thumbSlug = Str::slug($thumbOriginal);
                $category->thumbnail_image = ImageOptimizer::store($request->file('thumbnail_image'), 'categories', $thumbSlug);
            }
            if ($request->hasFile('cover_image')) {
                if ($category->cover_image)
                    Storage::delete($category->cover_image);
                $coverOriginal = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
                $coverSlug = Str::slug($coverOriginal);
                $category->cover_image = ImageOptimizer::store($request->file('cover_image'), 'categories', $coverSlug);
            }
            $category->priority = $request->input('priority');
            $category->update();

            if ($oldSlug !== $category->slug) {
                SeoRedirect::create([
                    'old_url' => '/' . $oldSlug,
                    'new_url' => '/' . $category->slug,
                    'type' => '301',
                    'status' => true,
                ]);
            }

            if ($request->category_media) {
                $existingMediaCount = $category->media()->count();
                foreach ($request->category_media as $key => $file) {
                    if ($request->hasFile('category_media')) {
                        $category_media = new CategoryMedia();
                        $category_media->category_id = $category->id;
                        $category_media->type = $file->getClientMimeType();
                        $mediaOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $mediaSlug = Str::slug($mediaOriginal);
                        $category_media->path = ImageOptimizer::store($file, 'category-media', $mediaSlug . '-' . ($existingMediaCount + $key + 1));
                        $category_media->project_category = $request->input('project_category');
                        $category_media->alt_text = $category->name . ' - ' . $mediaOriginal;
                        $category_media->title_text = $category->name;
                        $category_media->save();
                    }
                }
            }

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
     * Handle Toggle Category Status
     *
     * @return Response
     */
    public function handleToggleCategoryStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'category_id' => ['required', 'string', 'exists:categories,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], Response::HTTP_OK);
            }

            $category = Category::find($request->input('category_id'));
            $category->status = !$category->status;
            $category->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $category
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
     * Handle Delete Category
     *
     * @return RedirectResponse
     */
    public function handleCategoryDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $category = Category::find($id);

            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not found',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            $category->delete();

            return redirect()->route('admin.view.category.list')->with('message', [
                'status' => 'success',
                'title' => 'Category deleted',
                'description' => 'The category is successfully deleted.'
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
     * Handle Category Media Delete
     *
     * @return RedirectResponse
     */
    public function handleCategoryMediaDelete($id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::DELETE_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $category_media = CategoryMedia::find($id);
            Storage::delete($category_media->path);
            $category_media->delete();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Image Deleted',
                'description' => 'The image is successfully deleted'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    public function handleCategoryMediaUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $admin = Admin::find(auth()->user()->id);
            if (!$admin->can(Permission::EDIT_CATEGORY->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $category_media = CategoryMedia::find($id);
            if (!$category_media) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Image not found',
                    'description' => 'Image not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'alt_text' => ['nullable', 'string', 'max:255'],
                'title_text' => ['nullable', 'string', 'max:255'],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $category_media->alt_text = $request->input('alt_text');
            $category_media->title_text = $request->input('title_text');
            $category_media->update();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The image details are successfully saved.'
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
