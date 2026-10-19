@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.chat.list') }}">Chats</a></li>
        </ul>
        <h1 class="panel-title">Chatbot Conversations</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Krishna AI chats</h1>
                <p class="panel-card-description">Most recent 100 visitors. Leads left in the chat also appear under Enquiries.</p>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Last seen</th><th>Visitor</th><th>Mobile</th><th>Interest</th><th>Messages</th><th>Lead</th><th>Action</th>
                    </thead>
                    <tbody>
                        @forelse ($visitors as $v)
                            @php $p = $v->profile ?? []; @endphp
                            <tr>
                                <td>{{ $v->last_seen_at?->format('d M Y, h:i A') ?? '-' }}</td>
                                <td>{{ $v->name ?: 'Anonymous' }}@if ($v->company)<br><small>{{ $v->company }}</small>@endif</td>
                                <td>{{ $v->phone ?: '-' }}</td>
                                <td style="white-space: normal; max-width: 260px;">
                                    {{ collect([!empty($p['media']) ? implode(', ', array_map(fn ($k) => config("chatbot.media.$k.label", $k), $p['media'])) : null, $p['city'] ?? null, $p['goal'] ?? null, $p['budget'] ?? null])->filter()->implode(' · ') ?: '-' }}
                                </td>
                                <td>{{ $v->messages_count }}</td>
                                <td>{{ $v->lead_saved ? 'Yes' : '-' }}</td>
                                <td><a href="{{ route('admin.view.chat.show', ['id' => $v->id]) }}" class="btn-primary-sm flex w-fit">View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No chats yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>document.getElementById('chat-tab')?.classList.add('active');</script>
@endsection
