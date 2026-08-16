<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>Tech Stacks & Skill Matrix</h1>
            <div class="sub">Manage languages, frameworks, databases, and developer tooling badges displayed on your portfolio.</div>
        </div>
        <div>
            <a href="{{ route('stacks.create.admin') }}" class="btn primary-colored">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Skill / Stack
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
            <h3>Skills & Technologies List</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Skill / Technology</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Category / Type</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Proficiency Level</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Status</th>
                            <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stacks as $stack)
                            <tr style="border-bottom: 1px solid var(--c-border);">
                                <td style="padding: 16px 20px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: {{ $stack->color ?: 'var(--accent)' }}; display: inline-block;"></span>
                                        <span style="font-weight: 700; color: var(--c-text);">{{ $stack->name }}</span>
                                    </div>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <code style="font-size: 0.8rem; padding: 2px 8px; border-radius: 4px; background: var(--c-bg-subtle); color: var(--c-text); text-transform: uppercase;">{{ $stack->type }}</code>
                                </td>
                                <td style="padding: 16px 20px; color: var(--c-text-muted); font-weight: 500;">
                                    {{ ucfirst($stack->level ?: 'Intermediate') }}
                                </td>
                                <td style="padding: 16px 20px;">
                                    @if ($stack->is_active)
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Active</span>
                                    @else
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">Hidden</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('stacks.edit.admin', $stack->id) }}" class="btn secondary sm" style="font-size: 0.75rem; padding: 4px 10px;">
                                            Edit
                                        </a>
                                        <form action="{{ route('stacks.destroy.admin', $stack->id) }}" method="POST" onsubmit="return confirm('Delete this skill badge?')">
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
                                    No skills added yet. Click "+ Add Skill / Stack" to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination-component :paginator="$stacks" />
        </div>
    </div>

</x-admin-layout>
