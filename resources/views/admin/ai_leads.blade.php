<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>24/7 AI Sales Leads & Chat Logs</h1>
            <div class="sub">Review automated project inquiries, lead qualification scores, visitor IPs, and full conversation transcripts.</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3>Captured Visitor Conversations</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Lead / Client Info</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Lead Score</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">IP & Device</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Messages</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($conversations as $conv)
                            <tr style="border-bottom: 1px solid var(--c-border);">
                                <td style="padding: 16px 20px;">
                                    <div style="font-weight: 700; color: var(--c-text);">{{ $conv->client_name ?: 'Anonymous Visitor' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--accent);">{{ $conv->client_email ?: $conv->client_phone ?: 'No direct contact yet' }}</div>
                                </td>
                                <td style="padding: 16px 20px;">
                                    @if ($conv->lead_score === 'HOT')
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; background: rgba(239, 68, 68, 0.15); color: #ef4444;">🔥 HOT LEAD</span>
                                    @elseif ($conv->lead_score === 'WARM')
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">⚡ WARM PROSPECT</span>
                                    @else
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">VISITOR</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 20px;">
                                    <div style="font-family: monospace; font-size: 0.8rem; color: var(--c-text);">{{ $conv->ip_address ?: '127.0.0.1' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--c-text-muted);">{{ $conv->updated_at->diffForHumans() }}</div>
                                </td>
                                <td style="padding: 16px 20px; color: var(--c-text); font-weight: 600;">
                                    {{ $conv->messages->count() }} messages
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <a href="{{ route('ai-leads.show.admin', $conv->id) }}" class="btn secondary sm" style="font-size: 0.75rem; padding: 4px 10px;">
                                        View Transcript
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 32px; text-align: center; color: var(--c-text-muted);">
                                    No AI chat conversations recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination-component :paginator="$conversations" />
        </div>
    </div>

</x-admin-layout>
