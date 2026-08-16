<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>Chat Transcript & Lead #{{ $conversation->id }}</h1>
            <div class="sub">Recorded {{ $conversation->created_at->format('M d, Y \a\t h:i A') }} • IP: {{ $conversation->ip_address ?: 'Unknown' }}</div>
        </div>
        <div>
            <a href="{{ route('ai-leads.admin') }}" class="btn secondary">
                &larr; Back to AI Leads
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

        <!-- Left: Full Transcript -->
        <div class="card">
            <div class="card-head">
                <h3>Full Conversation Thread</h3>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 16px; max-height: 600px; overflow-y: auto; background: var(--c-bg-subtle); padding: 20px; border-radius: var(--radius-sm);">
                @foreach ($conversation->messages as $msg)
                    <div style="align-self: {{ $msg->sender === 'user' ? 'flex-end' : 'flex-start' }}; max-width: 80%;">
                        <div style="font-size: 0.7rem; color: var(--c-text-muted); margin-bottom: 4px; text-align: {{ $msg->sender === 'user' ? 'right' : 'left' }};">
                            {{ $msg->sender === 'user' ? 'Visitor' : 'AI Assistant' }} • {{ $msg->created_at->format('h:i A') }}
                        </div>
                        <div style="padding: 12px 16px; border-radius: 12px; font-size: 0.9rem; line-height: 1.5; {{ $msg->sender === 'user' ? 'background: var(--accent); color: #fff;' : 'background: var(--c-card); border: 1px solid var(--c-border); color: var(--c-text);' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Extracted Lead Info & Actions -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <div class="card-head">
                    <h3>Visitor & Lead Metadata</h3>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Lead Score</span>
                        <div style="margin-top: 4px;">
                            @if ($conversation->lead_score === 'HOT')
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 0.85rem; font-weight: 700; background: rgba(239, 68, 68, 0.15); color: #ef4444;">🔥 HOT LEAD</span>
                            @elseif ($conversation->lead_score === 'WARM')
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 0.85rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">⚡ WARM PROSPECT</span>
                            @else
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">VISITOR</span>
                            @endif
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Client Name</span>
                        <div style="font-weight: 700; color: var(--c-text); margin-top: 2px;">{{ $conversation->client_name ?: 'Not provided yet' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Contact Email / Phone</span>
                        <div style="font-weight: 600; color: var(--accent); margin-top: 2px;">{{ $conversation->client_email ?: $conversation->client_phone ?: 'None captured' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">IP Address</span>
                        <div style="font-family: monospace; font-size: 0.85rem; color: var(--c-text); margin-top: 2px;">{{ $conversation->ip_address ?: 'Unknown' }}</div>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">User Agent</span>
                        <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 2px; line-height: 1.4; word-break: break-all;">{{ $conversation->user_agent ?: 'Unknown' }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
