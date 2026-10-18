<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SeoRedirect;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class SeoRedirectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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
            'title' => 'Redirect not found',
            'description' => 'Redirect not found with specified ID'
        ]);
    }

    private function rules(): array
    {
        return [
            'old_url' => ['required', 'string', 'max:500'],
            'new_url' => ['required', 'string', 'max:500'],
            'type' => ['required', 'in:301,302'],
        ];
    }

    private function fill(SeoRedirect $redirect, Request $request): void
    {
        $redirect->old_url = $request->input('old_url');
        $redirect->new_url = $request->input('new_url');
        $redirect->type = $request->input('type');
        $redirect->status = $request->has('status') ? $request->boolean('status') : true;
    }

    private function toBool($value): bool
    {
        $value = strtolower(trim((string) $value));
        return in_array($value, ['1', 'true', 'on', 'yes'], true);
    }

    public function viewRedirectList(): mixed
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            return view('admin.pages.seo.redirect-list', [
                'redirects' => SeoRedirect::orderBy('created_at', 'desc')->get()
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewRedirectCreate(): mixed
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            return view('admin.pages.seo.redirect-create');
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewRedirectUpdate($id): mixed
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $redirect = SeoRedirect::find($id);
            if (!$redirect) return $this->notFound();

            return view('admin.pages.seo.redirect-update', ['redirect' => $redirect]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleRedirectCreate(Request $request)
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $redirect = new SeoRedirect();
            $this->fill($redirect, $request);
            $redirect->save();

            return redirect()->route('admin.view.redirect.list')->with('message', [
                'status' => 'success',
                'title' => 'Redirect created',
                'description' => 'The redirect is successfully created.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleRedirectUpdate(Request $request, $id)
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $redirect = SeoRedirect::find($id);
            if (!$redirect) return $this->notFound();

            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $this->fill($redirect, $request);
            $redirect->update();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleToggleRedirectStatus(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'redirect_id' => ['required', 'string', 'exists:seo_redirects,id']
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validation->errors()->first()
                ], 200);
            }

            $redirect = SeoRedirect::find($request->input('redirect_id'));
            $redirect->status = !$redirect->status;
            $redirect->update();

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

    public function handleRedirectDelete($id)
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $redirect = SeoRedirect::find($id);
            if (!$redirect) return $this->notFound();

            $redirect->delete();

            return redirect()->route('admin.view.redirect.list')->with('message', [
                'status' => 'success',
                'title' => 'Redirect deleted',
                'description' => 'The redirect is successfully deleted.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleImportCsv(Request $request)
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $validation = Validator::make($request->all(), [
                'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $csv = Reader::createFromPath($request->file('csv_file')->getRealPath());
            $csv->setHeaderOffset(0);

            $imported = 0;
            $skipped = 0;

            foreach ($csv->getRecords() as $record) {
                $oldUrl = trim($record['old_url'] ?? '');
                $newUrl = trim($record['new_url'] ?? '');

                if (empty($oldUrl) || empty($newUrl)) {
                    $skipped++;
                    continue;
                }

                $type = trim($record['type'] ?? '301');
                if (!in_array($type, ['301', '302'])) {
                    $type = '301';
                }

                $status = isset($record['status']) ? $this->toBool($record['status']) : true;

                SeoRedirect::create([
                    'old_url' => $oldUrl,
                    'new_url' => $newUrl,
                    'type' => $type,
                    'status' => $status,
                ]);
                $imported++;
            }

            return redirect()->route('admin.view.redirect.list')->with('message', [
                'status' => 'success',
                'title' => 'Import complete',
                'description' => "{$imported} redirects imported, {$skipped} rows skipped."
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }
}
