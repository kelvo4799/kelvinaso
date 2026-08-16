<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Conversation Thread</h1>
            <div class="sub">Chat history with {{ $message->name }} (&lt;{{ $message->email }}&gt;)</div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <a href="{{ route('messages.admin') }}" class="btn secondary sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Messages
            </a>
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject ?: 'Contact Inquiry') }}" class="btn secondary sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                External Mail App
            </a>
        </div>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

        <!-- Main Column: Chat History & Reply Box -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Conversation Header & Thread History Card -->
            <div class="card">
                <div class="card-head" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.1rem;">Subject: {{ $message->subject ?: '(No Subject)' }}</h3>
                        <div class="muted" style="font-size: 0.8rem; margin-top: 2px;">Started {{ $message->created_at ? $message->created_at->format('M d, Y \a\t h:i A') : '' }}</div>
                    </div>
                    <div>
                        @if ($message->status === 'unread')
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; background: rgba(99, 102, 241, 0.15); color: #6366f1;">Unread</span>
                        @elseif ($message->status === 'replied')
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Replied</span>
                        @else
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">Read</span>
                        @endif
                    </div>
                </div>

                <div class="card-body" style="display: flex; flex-direction: column; gap: 24px;">

                    <!-- Timeline Item 1: Original Visitor Message -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0;">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1; background: var(--c-bg-subtle); border: 1px solid var(--c-border); border-radius: var(--radius-sm); padding: 18px; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid var(--c-border); padding-bottom: 8px;">
                                <div>
                                    <span style="font-weight: 700; color: var(--c-text); font-size: 0.95rem;">{{ $message->name }}</span>
                                    <span style="font-size: 0.8rem; color: var(--c-text-muted); margin-left: 6px;">&lt;{{ $message->email }}&gt;</span>
                                </div>
                                <span style="font-size: 0.75rem;" class="muted">{{ $message->created_at ? $message->created_at->format('M d, h:i A') : '' }}</span>
                            </div>
                            <div style="font-size: 0.95rem; line-height: 1.6; color: var(--c-text); white-space: pre-wrap;">{{ $message->message }}</div>
                        </div>
                    </div>

                    <!-- Subsequent Thread Replies -->
                    @if ($message->replies && $message->replies->count() > 0)
                        @foreach ($message->replies as $reply)
                            @if ($reply->sender_type === 'admin')
                                <!-- Admin Reply Bubble -->
                                <div style="display: flex; gap: 14px; align-items: flex-start; flex-direction: row-reverse;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($reply->sender_name ?: 'A', 0, 1)) }}
                                    </div>
                                    <div style="flex: 1; max-width: 88%; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: var(--radius-sm); padding: 18px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); padding-bottom: 8px;">
                                            <div>
                                                <span style="font-weight: 700; color: var(--c-text); font-size: 0.95rem;">{{ $reply->sender_name }} (Admin)</span>
                                                <span style="font-size: 0.75rem; background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 2px 8px; border-radius: 10px; margin-left: 8px; font-weight: 600;">Emailed & Saved</span>
                                            </div>
                                            <span style="font-size: 0.75rem;" class="muted">{{ $reply->created_at ? $reply->created_at->format('M d, h:i A') : '' }}</span>
                                        </div>
                                        <div style="font-size: 0.95rem; line-height: 1.6; color: var(--c-text); white-space: pre-wrap;">{{ $reply->message }}</div>
                                    </div>
                                </div>
                            @else
                                <!-- Visitor Reply Bubble -->
                                <div style="display: flex; gap: 14px; align-items: flex-start;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($reply->sender_name ?: $message->name, 0, 1)) }}
                                    </div>
                                    <div style="flex: 1; background: var(--c-bg-subtle); border: 1px solid var(--c-border); border-radius: var(--radius-sm); padding: 18px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid var(--c-border); padding-bottom: 8px;">
                                            <div>
                                                <span style="font-weight: 700; color: var(--c-text); font-size: 0.95rem;">{{ $reply->sender_name ?: $message->name }}</span>
                                                <span style="font-size: 0.8rem; color: var(--c-text-muted); margin-left: 6px;">&lt;{{ $reply->sender_email ?: $message->email }}&gt;</span>
                                            </div>
                                            <span style="font-size: 0.75rem;" class="muted">{{ $reply->created_at ? $reply->created_at->format('M d, h:i A') : '' }}</span>
                                        </div>
                                        <div style="font-size: 0.95rem; line-height: 1.6; color: var(--c-text); white-space: pre-wrap;">{{ $reply->message }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
            </div>

            <!-- Interactive Reply Input Box Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Send Reply</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('messages.reply.admin', $message->id) }}" method="POST">
                        @csrf

                        <div class="field">
                            <label for="reply_message">Reply Message to {{ $message->name }}</label>
                            <textarea class="textarea" id="reply_message" name="message" rows="5" placeholder="Type your reply here... This message will be emailed directly to {{ $message->email }} and saved in your chat history." required style="font-size: 0.95rem; line-height: 1.6;"></textarea>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px;">
                            <div class="muted" style="font-size: 0.825rem;">
                                Will send email to: <strong style="color: var(--c-text);">{{ $message->email }}</strong>
                            </div>
                            <button type="submit" class="btn primary-colored">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Send Reply & Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Sidebar: Visitor Info & Options -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Status Control Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Status Options</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('messages.status.admin', $message->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="field">
                            <label for="status">Mark Message Status</label>
                            <select class="input" id="status" name="status" onchange="this.form.submit()">
                                <option value="unread" {{ $message->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Visitor Details Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Visitor Metadata</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 14px; font-size: 0.85rem;">
                        <div>
                            <div class="muted" style="font-size: 0.75rem; font-weight: 600;">Contact Name</div>
                            <div style="color: var(--c-text); font-weight: 600; margin-top: 2px;">{{ $message->name }}</div>
                        </div>

                        <div>
                            <div class="muted" style="font-size: 0.75rem; font-weight: 600;">Email Address</div>
                            <div style="margin-top: 2px;">
                                <a href="mailto:{{ $message->email }}" style="color: var(--accent); text-decoration: none;">{{ $message->email }}</a>
                            </div>
                        </div>

                        <div>
                            <div class="muted" style="font-size: 0.75rem; font-weight: 600;">IP Address</div>
                            <div style="color: var(--c-text); font-weight: 500; margin-top: 2px;">{{ $message->ip_address ?: 'Not recorded' }}</div>
                        </div>

                        <div>
                            <div class="muted" style="font-size: 0.75rem; font-weight: 600;">User Agent / Browser</div>
                            <div style="color: var(--c-text-muted); font-size: 0.8rem; margin-top: 2px; word-break: break-all;">{{ $message->user_agent ?: 'Not recorded' }}</div>
                        </div>

                        @if ($message->replied_at)
                        <div>
                            <div class="muted" style="font-size: 0.75rem; font-weight: 600;">Last Replied Date</div>
                            <div style="color: #10b981; font-weight: 600; margin-top: 2px;">{{ $message->replied_at instanceof \DateTimeInterface ? $message->replied_at->format('M d, Y \a\t h:i A') : \Carbon\Carbon::parse($message->replied_at)->format('M d, Y \a\t h:i A') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 16px 24px;">
                    <form action="{{ route('messages.destroy.admin', $message->id) }}" method="POST" onsubmit="return confirm('Delete this conversation thread permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn secondary" style="width: 100%; justify-content: center; color: var(--c-danger);">Delete Thread</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</x-admin-layout>
