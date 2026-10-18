<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Seo404Log;
use Exception;

class Seo404LogController extends Controller
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

    public function viewLogList(): mixed
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            $logs = Seo404Log::where('resolved', false)
                ->orderBy('hit_count', 'desc')
                ->orderBy('last_seen_at', 'desc')
                ->get();

            return view('admin.pages.seo.log-404-list', ['logs' => $logs]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleLogDelete($id)
    {
        try {
            if ($r = $this->deny(Permission::MANAGE_REDIRECTS->value)) return $r;

            Seo404Log::find($id)?->delete();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Log dismissed',
                'description' => 'The 404 log entry has been successfully dismissed.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }
}
