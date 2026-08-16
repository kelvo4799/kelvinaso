<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>Work Experience & Career History</h1>
            <div class="sub">Manage your professional employment timeline, positions, companies, and key achievements.</div>
        </div>
        <div>
            <a href="{{ route('experiences.create.admin') }}" class="btn primary-colored">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Experience
            </a>
        </div>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="card">
        <div class="card-head">
            <h3>Career Timeline Entries</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Job Role / Title</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Company & Location</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Duration / Period</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Status</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($experiences as $exp)
                            <tr style="border-bottom: 1px solid var(--c-border);">
                                <td style="padding: 16px 20px;">
                                    <div style="font-weight: 700; color: var(--c-text);">{{ $exp->title }}</div>
                                    <div style="font-size: 0.75rem; color: var(--c-text-muted);">{{ $exp->employment_type ?: 'Full-time' }}</div>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <div style="color: var(--c-text); font-weight: 600;">{{ $exp->company }}</div>
                                    <div style="font-size: 0.75rem; color: var(--c-text-muted);">{{ $exp->location ?: 'Remote' }}</div>
                                </td>
                                <td style="padding: 16px 20px; color: var(--c-text); font-weight: 500;">
                                    {{ $exp->start_year }} - {{ $exp->is_current ? 'Present' : ($exp->end_year ?: 'Present') }}
                                </td>
                                <td style="padding: 16px 20px;">
                                    @if ($exp->is_active)
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Active</span>
                                    @else
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">Hidden</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('experiences.edit.admin', $exp->id) }}" class="btn secondary sm" style="font-size: 0.75rem; padding: 4px 10px;">
                                            Edit
                                        </a>
                                        <form action="{{ route('experiences.destroy.admin', $exp->id) }}" method="POST" onsubmit="return confirm('Delete this experience entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn ghost sm" style="font-size: 0.75rem; color: var(--c-danger); padding: 4px 10px;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 32px; text-align: center; color: var(--c-text-muted);">
                                    No experience entries added yet. Click "+ Add Experience" to build your timeline.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination-component :paginator="$experiences" />
        </div>
    </div>

</x-admin-layout>
