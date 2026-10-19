<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChatVisitor;
use App\Services\Chat\ChatEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct(private ChatEngine $engine)
    {
    }

    /** Opening the widget: restores the recent conversation or greets (recognising returning visitors). */
    public function history(Request $request): JsonResponse
    {
        $visitor = $this->visitor($request);
        $path = $this->path($request);

        $newSession = !$visitor->last_seen_at || $visitor->last_seen_at->lt(now()->subMinutes(30));
        if ($newSession && $visitor->wasRecentlyCreated === false && $visitor->messages()->exists()) {
            $visitor->increment('visits');
            $visitor->refresh();
        }

        $recent = $visitor->messages()->where('created_at', '>=', now()->subMinutes(30))->latest('id')->limit(20)->get()->reverse()->values();

        $payload = ['visitor' => $visitor->id, 'messages' => $recent->map(fn ($m) => ['role' => $m->role, 'text' => $m->body])->all(), 'welcome' => null];
        if ($recent->isEmpty()) {
            $payload['welcome'] = $this->engine->welcome($visitor, $path);
            $visitor->update(['last_seen_at' => now()]);
        }

        return response()->json($payload)->header('Cache-Control', 'no-store');
    }

    public function message(Request $request): JsonResponse
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:600']]);
        $visitor = $this->visitor($request);

        $result = $this->engine->handle($visitor, $data['message'], $this->path($request), (string) $request->input('title'));

        return response()->json($result + ['visitor' => $visitor->id])->header('Cache-Control', 'no-store');
    }

    public function forget(Request $request): JsonResponse
    {
        $this->engine->forget($this->visitor($request));

        return response()->json(['ok' => true]);
    }

    private function path(Request $request): ?string
    {
        $path = '/' . ltrim((string) parse_url((string) $request->input('path'), PHP_URL_PATH), '/');

        return strlen($path) <= 120 ? rtrim($path, '/') ?: '/' : null;
    }

    private function visitor(Request $request): ChatVisitor
    {
        $id = (string) $request->input('visitor');
        if (!Str::isUuid($id)) {
            $id = (string) Str::uuid();
        }

        $visitor = ChatVisitor::find($id);
        if (!$visitor) {
            $visitor = new ChatVisitor(['profile' => [], 'state' => [], 'visits' => 1]);
            $visitor->id = $id;
            $visitor->save();
            $visitor->wasRecentlyCreated = true;
        }

        return $visitor;
    }
}
