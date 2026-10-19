@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.chat.list') }}">Chats</a></li>
        </ul>
        <h1 class="panel-title">{{ $visitor->name ?: 'Anonymous visitor' }}</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header"><div><h1 class="panel-card-title">What the bot remembers</h1></div></div>
        <div class="panel-card-body">
            <pre style="white-space: pre-wrap">{{ json_encode($visitor->profile, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            <p>Mobile: {{ $visitor->phone ?: '-' }} · Visits: {{ $visitor->visits }} · Lead saved: {{ $visitor->lead_saved ? 'yes' : 'no' }}</p>
        </div>
    </figure>
    <figure class="panel-card">
        <div class="panel-card-header"><div><h1 class="panel-card-title">Transcript</h1></div></div>
        <div class="panel-card-body">
            @foreach ($visitor->messages as $m)
                <p style="margin:0 0 10px"><b>{{ $m->role === 'user' ? 'Visitor' : 'Krishna AI' }}</b> <small>{{ $m->created_at?->format('d M, h:i A') }}</small><br>{!! nl2br(e($m->body)) !!}</p>
            @endforeach
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>document.getElementById('chat-tab')?.classList.add('active');</script>
@endsection
