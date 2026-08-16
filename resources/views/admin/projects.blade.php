<x-admin-layout :page="$pages" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Projects</h1>
            <div class="sub">Manage your portfolio items and case studies.</div>
        </div>
        <button class="btn primary-colored" data-modal="projectModal">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>
            New project
        </button>
    </div>

    <div class="card">
        <div class="card-head">
            <div class="tabs" style="border:none;margin:0;padding:0;background:transparent;">
                <span class="tab">All ({{ $pageCount['countAll'] }})</span>
                <span class="tab">Active ({{ $pageCount['countActive'] }})</span>
                <span class="tab">Inactive ({{ $pageCount['countInactive'] }})</span>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Category</th>
                        <th>Tech</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <div class="flex gap-12" style="align-items:center">
                                    <div class="thumb">{{ $project->initials }}</div>
                                    <div>
                                        <div style="font-weight:600">{{ $project->title }}</div>
                                        <div class="muted" style="font-size:12px">{{ $project->short_description ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ ucfirst($project->project_type) }}</td>
                            <td>
                                @php
                                    $stacks = is_array($project->tech_stack) ? $project->tech_stack : (array_filter(array_map('trim', explode(',', $project->tech_stack ?? ''))));
                                @endphp
                                @foreach (array_slice($stacks, 0, 3) as $stack)
                                    <span class="tech-chip">{{ $stack }}</span>
                                @endforeach
                            </td>
                            <td><span class="status-badge {{ $project->is_active ? 'success' : 'danger'}}">{{ $project->is_active ? 'Active' : 'Inactive'}}</span>
                            </td>
                            <td class="muted">{{ $project->updated_at ? $project->updated_at->diffForHumans() : '-' }}</td>
                            <td class="right">
                                <a class="btn ghost sm" href="{{ route('projects.show.admin', $project->slug) }}">Edit</a>
                                <form action="{{ route('projects.destroy.admin', $project->slug) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $project->title }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn ghost sm text-red" style="color:var(--c-danger);">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        <x-pagination-component :paginator="$projects" />
    </div>


</x-admin-layout>

