<x-admin-layout :profile="$profile">
    <script>
        const pageViewData = @json($pageViewsByMonth);
    </script>

    <div class="page-header">
        <div>
          <h1>Welcome back, {{ ucfirst($profile->first_name) }} 👋</h1>
          <div class="sub">Here's what's happening with your portfolio today.</div>
        </div>
        <div style="display: flex; gap: 12px;">
          <button class="btn secondary" data-modal="mailModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
            Compose Mail
          </button>
          <button class="btn primary-colored" data-modal="projectModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            New project
          </button>
        </div>
      </div>

      <!-- Stats -->
      <div class="stats animate-slide-up stagger-1">
        <div class="stat">
          <div class="icon indigo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>
          </div>
          <div>
            <div class="label">Total projects</div>
            <div class="value">{{ $projectsCount }}</div>
            <div class="delta">Active Projects</div>
          </div>
        </div>
        <div class="stat">
          <div class="icon teal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 4 7v6c0 5 4 8 8 9 4-1 8-4 8-9V7z"/></svg>
          </div>
          <div>
            <div class="label">Blog posts</div>
            <div class="value">0</div>
            <div class="delta"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> +2 recently</div>
          </div>
        </div>
        <div class="stat">
          <div class="icon amber animate-pulse">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <div>
            <div class="label">Messages</div>
            <div class="value">{{ $msgsCount }}</div>
            <div class="delta"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> {{ $unreadMsgsCount }} unread</div>
          </div>
        </div>
        <div class="stat">
          <div class="icon rose">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
          </div>
          <div>
            <div class="label">Page views (30d)</div>
            <div class="value">{{ $pageViewsCount }}</div>
            @if ($percentageChange >= 0)
            <div class="delta up"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> {{ number_format($percentageChange, 2) }}% vs last</div>
            @else
            <div class="delta down"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg> {{ number_format($percentageChange, 2) }}% vs last</div>
            @endif
          </div>
        </div>
      </div>

      <!-- Chart Area -->
      
      <div class="chart-container animate-slide-up stagger-2">
        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 20px;">Audience Overview</h3>
        <canvas id="audienceChart"></canvas>
      </div>

      <!-- Two-column area -->
      <div class="grid-cols-2 animate-slide-up stagger-3">
        <div class="card">
          <div class="card-head">
            <h3>Recent projects</h3>
            <a href="{{ route('projects.admin') }}" class="btn ghost sm">View all →</a>
          </div>
          <div class="table-wrap">
            <table class="table" id="projectsTable">
              <thead>
                <tr><th>Project</th><th>Tech</th><th>Updated</th><th></th></tr>
              </thead>
              <tbody>
                @if ($recentProjects->isNotEmpty())
                  @foreach ($recentProjects as $project)
                  <tr>
                    <td><div class="flex gap-12" style="align-items:center"><div class="thumb">{{ $project->initials }}</div><div><div style="font-weight:600; color: #fff;">{{ $project->title }}</div><div class="muted" style="font-size:12px">{{ $project->description }}</div></div></div></td>
                    <td>
                      @php
                        $stacks = is_array($project->tech_stack) ? $project->tech_stack : (array_filter(array_map('trim', explode(',', $project->tech_stack ?? ''))));
                      @endphp
                      @if(!empty($stacks))
                        <span class="tech-chip">{{ $stacks[0] }}</span>
                      @endif
                    </td>
                    <td class="muted" style="font-size:12px">{{ $project->updated_at ? $project->updated_at->diffForHumans() : '-' }}</td>
                    <td class="right"><a href="{{ route('projects.show.admin', $project->slug) }}" class="btn secondary sm">Edit</a></td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="4" class="muted" style="font-size: 14px; text-align: center; padding: 20px;">No recent projects.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-head"><h3>Latest messages</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:14px">
            @if ($contacts->isNotEmpty())
            @foreach ($contacts as $contact)
            <div class="message-item flex gap-12" data-slideover="messages">
              <div class="avatar sm">{{ strtoupper(substr($contact->name ?? 'U', 0, 2)) }}</div>
              <div>
                <div style="font-weight:600; color: #fff;">{{ $contact->name }}</div>
                <div class="muted" style="font-size:12px">"{{ Str::limit($contact->message ?? '', 50) }}"</div>
              </div>
            </div>
            @endforeach
        

            <button class="btn secondary" data-slideover="messages" style="width:100%; margin-top: 10px;">View all messages</button>
            @else
            <div class="muted" style="font-size: 14px; text-align: center; padding: 20px;">No messages yet.</div>
            @endif

          </div>
        </div>
      </div>
</x-admin-layout>