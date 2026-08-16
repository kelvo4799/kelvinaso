<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Inbox & Messages</h1>
            <div class="sub">View and manage contact form submissions from website visitors.</div>
        </div>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Metric Stat Cards -->
    <div class="metrics-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Total Messages</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--c-text);">{{ $stats['countAll'] }}</div>
        </div>
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Unread</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #6366f1;">{{ $stats['countUnread'] }}</div>
        </div>
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Read</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--c-text-muted);">{{ $stats['countRead'] }}</div>
        </div>
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Replied</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #10b981;">{{ $stats['countReplied'] }}</div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card" style="margin-bottom: 24px; padding: 16px 20px;">
        <form method="GET" action="{{ route('messages.admin') }}" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; justify-content: space-between;">
            
            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <a href="{{ route('messages.admin', array_filter(['search' => request('search')])) }}" class="btn sm {{ !request('status') ? 'primary-colored' : 'secondary' }}">
                    All ({{ $stats['countAll'] }})
                </a>
                <a href="{{ route('messages.admin', array_filter(['status' => 'unread', 'search' => request('search')])) }}" class="btn sm {{ request('status') === 'unread' ? 'primary-colored' : 'secondary' }}">
                    Unread ({{ $stats['countUnread'] }})
                </a>
                <a href="{{ route('messages.admin', array_filter(['status' => 'read', 'search' => request('search')])) }}" class="btn sm {{ request('status') === 'read' ? 'primary-colored' : 'secondary' }}">
                    Read ({{ $stats['countRead'] }})
                </a>
                <a href="{{ route('messages.admin', array_filter(['status' => 'replied', 'search' => request('search')])) }}" class="btn sm {{ request('status') === 'replied' ? 'primary-colored' : 'secondary' }}">
                    Replied ({{ $stats['countReplied'] }})
                </a>
            </div>

            <div style="display: flex; gap: 8px; flex: 1; max-width: 360px;">
                <input class="input" type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, subject..." style="height: 36px; font-size: 0.85rem;" />
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}" />
                @endif
                <button type="submit" class="btn secondary sm" style="height: 36px;">Search</button>
                @if (request('search'))
                    <a href="{{ route('messages.admin', array_filter(['status' => request('status')])) }}" class="btn secondary sm" style="height: 36px;" title="Clear search">Clear</a>
                @endif
            </div>

        </form>
    </div>

    <!-- Messages Table Card -->
    <div class="card">
        <form id="bulkForm" action="{{ route('messages.bulk.admin') }}" method="POST">
            @csrf

            <div style="padding: 16px 24px; border-bottom: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center; background: var(--c-bg-subtle);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; user-select: none;">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" style="cursor: pointer;" />
                        Select All
                    </label>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="submit" name="action" value="read" class="btn secondary sm">Mark Read</button>
                    <button type="submit" name="action" value="unread" class="btn secondary sm">Mark Unread</button>
                    <button type="submit" name="action" value="delete" class="btn secondary sm" style="color: var(--c-danger);" onclick="return confirm('Are you sure you want to delete selected messages?')">Delete Selected</button>
                </div>
            </div>

            @if ($messages->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--c-border); text-align: left;">
                                <th style="padding: 14px 20px; width: 40px;"></th>
                                <th style="padding: 14px 20px;">Sender</th>
                                <th style="padding: 14px 20px;">Subject & Preview</th>
                                <th style="padding: 14px 20px;">Status</th>
                                <th style="padding: 14px 20px;">Received</th>
                                <th style="padding: 14px 20px; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $msg)
                                <tr style="border-bottom: 1px solid var(--c-border); {{ $msg->status === 'unread' ? 'background: rgba(99, 102, 241, 0.04); font-weight: 600;' : '' }}">
                                    <td style="padding: 14px 20px;">
                                        <input type="checkbox" name="ids[]" value="{{ $msg->id }}" class="msg-checkbox" style="cursor: pointer;" />
                                    </td>
                                    <td style="padding: 14px 20px; white-space: nowrap;">
                                        <div style="font-size: 0.9rem; color: var(--c-text);">{{ $msg->name }}</div>
                                        <div class="muted" style="font-size: 0.8rem; font-weight: normal;">
                                            <a href="mailto:{{ $msg->email }}" style="color: var(--c-text-muted); text-decoration: none;">{{ $msg->email }}</a>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 20px; max-width: 320px;">
                                        <a href="{{ route('messages.show.admin', $msg->id) }}" style="text-decoration: none; color: var(--c-text); display: block;">
                                            <div style="font-size: 0.9rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; {{ $msg->status === 'unread' ? 'font-weight: 700; color: var(--c-text);' : '' }}">
                                                {{ $msg->subject ?: '(No Subject)' }}
                                            </div>
                                            <div class="muted" style="font-size: 0.8rem; font-weight: normal; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                {{ Str::limit($msg->message, 60) }}
                                            </div>
                                        </a>
                                    </td>
                                    <td style="padding: 14px 20px; white-space: nowrap;">
                                        @if ($msg->status === 'unread')
                                            <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(99, 102, 241, 0.15); color: #6366f1;">Unread</span>
                                        @elseif ($msg->status === 'replied')
                                            <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Replied</span>
                                        @else
                                            <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">Read</span>
                                        @endif
                                    </td>
                                    <td style="padding: 14px 20px; white-space: nowrap; font-size: 0.825rem;" class="muted">
                                        {{ $msg->created_at ? $msg->created_at->diffForHumans() : '' }}
                                    </td>
                                    <td style="padding: 14px 20px; text-align: right; white-space: nowrap;">
                                        <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                            <a href="{{ route('messages.show.admin', $msg->id) }}" class="btn secondary sm" title="View Message">
                                                View
                                            </a>
                                            <form action="{{ route('messages.destroy.admin', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn danger sm" title="Delete message" style="height: 32px; width: 32px;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding: 18px 24px; border-top: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center;">
                    {{ $messages->links() }}
                </div>
            @else
                <div style="padding: 60px 20px; text-align: center; color: var(--c-text-muted);">
                    <div style="margin-bottom: 12px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div style="font-size: 1.1rem; font-weight: 600; color: var(--c-text);">No messages found</div>
                    <div style="font-size: 0.875rem; margin-top: 4px;">There are no contact form submissions matching your criteria.</div>
                </div>
            @endif

        </form>
    </div>

    <script>
        function toggleSelectAll(master) {
            const checkboxes = document.querySelectorAll('.msg-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
        }
    </script>

</x-admin-layout>
