<x-admin-layout :page="$pages" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">


    <div class="page-header">
        <div>
            <h1>Content Pages</h1>
            <div class="sub">Manage the static pages on your portfolio.</div>
        </div>
        <a class="btn" href="page-edit.html">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>
            New page
        </a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>Path</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($pages as $page)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:var(--c-text);">{{ $page->title }}</div>
                            </td>
                            <td class="muted">/{{ $page->slug }}</td>
                            <td>
                                @if ($page->is_active)
                                    <span class="status-badge"
                                            style="color:#16a34a;background:#dcfce7;padding:2px 8px;border-radius:12px;font-size:12px;font-weight:500;">Published</span>
                                @else
                                    <span class="status-badge"
                                            style="color:#dc2626;background:#fee2e2;padding:2px 8px;border-radius:12px;font-size:12px;font-weight:500;">Draft</span>
                                @endif
                            </td>
                            <td class="muted">{{ $page->updated_at ? $page->updated_at->diffForHumans() : '-' }}</td>
                            <td class="right">
                                <a class="btn ghost sm" href="{{ route('pages.show', $page->slug) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



</x-admin-layout>
