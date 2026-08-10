<x-admin-layout :profile="$profile">
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
            <div class="delta"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> +3 this month</div>
          </div>
        </div>
        <div class="stat">
          <div class="icon teal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 4 7v6c0 5 4 8 8 9 4-1 8-4 8-9V7z"/></svg>
          </div>
          <div>
            <div class="label">Skills listed</div>
            <div class="value">18</div>
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
            <div class="value">12.3k</div>
            <div class="delta down"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg> -4% vs last</div>
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
            <a href="projects.html" class="btn ghost sm">View all →</a>
          </div>
          <div class="table-wrap">
            <table class="table" id="projectsTable">
              <thead>
                <tr><th>Project</th><th>Tech</th><th>Updated</th><th></th></tr>
              </thead>
              <tbody>
                <tr>
                  <td><div class="flex gap-12" style="align-items:center"><div class="thumb">PA</div><div><div style="font-weight:600; color: #fff;">Portfolio v3</div><div class="muted" style="font-size:12px">Personal site rebuild</div></div></div></td>
                  <td><span class="tech-chip">React</span><span class="tech-chip">TS</span></td>
                  <td class="muted">2 days ago</td>
                  <td class="right"><button class="btn secondary sm" data-modal="projectModal">Edit</button></td>
                </tr>
                <tr>
                  <td><div class="flex gap-12" style="align-items:center"><div class="thumb" style="background:linear-gradient(135deg,#0d9488,#1e3a8a)">SH</div><div><div style="font-weight:600; color: #fff;">Shopify theme</div><div class="muted" style="font-size:12px">Custom storefront</div></div></div></td>
                  <td><span class="tech-chip">Liquid</span><span class="tech-chip">Tailwind</span></td>
                  <td class="muted">1 week ago</td>
                  <td class="right"><button class="btn secondary sm" data-modal="projectModal">Edit</button></td>
                </tr>
                <tr>
                  <td><div class="flex gap-12" style="align-items:center"><div class="thumb" style="background:linear-gradient(135deg,#d97706,#dc2626)">DA</div><div><div style="font-weight:600; color: #fff;">Dashboard analytics</div><div class="muted" style="font-size:12px">SaaS metrics tool</div></div></div></td>
                  <td><span class="tech-chip">Vue</span><span class="tech-chip">D3</span></td>
                  <td class="muted">2 weeks ago</td>
                  <td class="right"><button class="btn secondary sm" data-modal="projectModal">Edit</button></td>
                </tr>

                <tr>
                  <td><div class="flex gap-12" style="align-items:center"><div class="thumb" style="background:linear-gradient(135deg,#d97706,#dc2626)">DA</div><div><div style="font-weight:600; color: #fff;">Dashboard analytics</div><div class="muted" style="font-size:12px">SaaS metrics tool</div></div></div></td>
                  <td><span class="tech-chip">Vue</span><span class="tech-chip">D3</span></td>
                  <td class="muted">2 weeks ago</td>
                  <td class="right"><button class="btn secondary sm" data-modal="projectModal">Edit</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-head"><h3>Latest messages</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:14px">
            <div class="message-item flex gap-12" data-slideover="messages">
              <div class="avatar sm">JD</div>
              <div>
                <div style="font-weight:600; color: #fff;">Jane Doe</div>
                <div class="muted" style="font-size:12px">"Loved your latest case study, would you be open…"</div>
              </div>
            </div>
            <div class="message-item flex gap-12" data-slideover="messages">
              <div class="avatar sm" style="background:linear-gradient(135deg,#d97706,#dc2626)">MR</div>
              <div>
                <div style="font-weight:600; color: #fff;">Marc R.</div>
                <div class="muted" style="font-size:12px">"Hi! We have a contract role that might interest you…"</div>
              </div>
            </div>
            <div class="message-item flex gap-12" data-slideover="messages">
              <div class="avatar sm" style="background:linear-gradient(135deg,#0d9488,#16a34a)">SV</div>
              <div>
                <div style="font-weight:600; color: #fff;">Sara V.</div>
                <div class="muted" style="font-size:12px">"Quick question about your design system…"</div>
              </div>
            </div>
            <button class="btn secondary" data-slideover="messages" style="width:100%; margin-top: 10px;">View all messages</button>
          </div>
        </div>
      </div>
</x-admin-layout>