<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ChatVisitor;

/** Admin > Chats: what visitors asked Krishna AI, what it remembered, and which chats became leads. */
class ChatLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Admin::find(auth()->user()->id);
        if (!$admin->can(Permission::VIEW_ENQUIRY->value)) {
            return redirect()->back()->with('message', ['status' => 'warning', 'title' => 'Unauthorized Access', 'description' => 'You do not have access to this url']);
        }

        $visitors = ChatVisitor::has('messages')->withCount('messages')->orderByDesc('last_seen_at')->limit(100)->get();

        return view('admin.pages.chat.chat-list', ['visitors' => $visitors]);
    }

    public function show(string $id)
    {
        $admin = Admin::find(auth()->user()->id);
        if (!$admin->can(Permission::VIEW_ENQUIRY->value)) {
            return redirect()->back();
        }

        $visitor = ChatVisitor::with('messages')->findOrFail($id);

        return view('admin.pages.chat.chat-show', ['visitor' => $visitor]);
    }
}
