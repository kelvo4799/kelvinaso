<x-admin-layout :page="$page" :profile="$profile">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="page-header">
        <div>
            <h1>Website Analytics & Traffic Metrics</h1>
            <div class="sub">Real-time tracking of pageviews, unique visitors, traffic sources, and conversion metrics.</div>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('analytics.admin', ['range' => '7']) }}" class="btn {{ $range === '7' ? 'primary-colored' : 'secondary' }}" style="font-size: 0.8rem; padding: 6px 12px;">7 Days</a>
            <a href="{{ route('analytics.admin', ['range' => '30']) }}" class="btn {{ $range === '30' ? 'primary-colored' : 'secondary' }}" style="font-size: 0.8rem; padding: 6px 12px;">30 Days</a>
            <a href="{{ route('analytics.admin', ['range' => '90']) }}" class="btn {{ $range === '90' ? 'primary-colored' : 'secondary' }}" style="font-size: 0.8rem; padding: 6px 12px;">90 Days</a>
            <a href="{{ route('analytics.admin', ['range' => 'all']) }}" class="btn {{ $range === 'all' ? 'primary-colored' : 'secondary' }}" style="font-size: 0.8rem; padding: 6px 12px;">All Time</a>
        </div>
    </div>

    <!-- Overview Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Total Page Views</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--c-text); margin-top: 4px;">{{ number_format($totalViews) }}</div>
            <div style="font-size: 0.75rem; color: var(--accent); margin-top: 4px;">Recorded requests</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Unique Visitors</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-top: 4px;">{{ number_format($uniqueVisitors) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Unique browser sessions</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Contact Messages</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #3b82f6; margin-top: 4px;">{{ number_format($totalContacts) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Direct inquiries</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Qualified AI Leads</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #f59e0b; margin-top: 4px;">{{ number_format($totalAiLeads) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Project inquiries via AI</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 28px;">
        
        <!-- Daily Traffic Chart -->
        <div class="card">
            <div class="card-head">
                <h3>Daily Traffic & Unique Visitors</h3>
            </div>
            <div class="card-body">
                <canvas id="trafficChart" height="220"></canvas>
            </div>
        </div>

        <!-- Top Visited Pages Chart -->
        <div class="card">
            <div class="card-head">
                <h3>Top Visited Pages</h3>
            </div>
            <div class="card-body">
                <canvas id="pagesChart" height="220"></canvas>
            </div>
        </div>

    </div>

    <!-- Bottom Row: Referrers & Live Feed -->
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">

        <!-- Top Referrers Card -->
        <div class="card">
            <div class="card-head">
                <h3>Traffic Referrers</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse ($topReferrers as $ref)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-radius: var(--radius-sm); background: var(--c-bg-subtle);">
                            <span style="font-size: 0.85rem; font-weight: 600; color: var(--c-text); word-break: break-all;">{{ Str::limit($ref->referer, 35) }}</span>
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 10px; background: rgba(99, 102, 241, 0.15); color: var(--accent);">{{ $ref->count }}</span>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--c-text-muted); font-size: 0.85rem; padding: 20px;">
                            Direct traffic / No external referrers logged.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Live Visitor Activity Feed -->
        <div class="card">
            <div class="card-head">
                <h3>Recent Live Activity Feed</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                                <th style="padding: 10px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">URL Path</th>
                                <th style="padding: 10px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">IP Address</th>
                                <th style="padding: 10px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentViews as $v)
                                <tr style="border-bottom: 1px solid var(--c-border);">
                                    <td style="padding: 12px 16px;">
                                        <code style="font-size: 0.8rem; color: var(--accent); font-weight: 600;">{{ $v->path }}</code>
                                    </td>
                                    <td style="padding: 12px 16px; font-family: monospace; color: var(--c-text-muted);">
                                        {{ $v->ip_address ?: '127.0.0.1' }}
                                    </td>
                                    <td style="padding: 12px 16px; color: var(--c-text-muted);">
                                        {{ $v->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding: 20px; text-align: center; color: var(--c-text-muted);">
                                        No recent page views logged.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <x-pagination-component :paginator="$recentViews" />
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Traffic Line Chart
            const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
            new Chart(ctxTraffic, {
                type: 'line',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [
                        {
                            label: 'Page Views',
                            data: @json($dailyViewsData),
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Unique Visitors',
                            data: @json($dailyVisitorsData),
                            borderColor: '#10b981',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [4, 4],
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Top Pages Bar Chart
            const ctxPages = document.getElementById('pagesChart').getContext('2d');
            const pageLabels = @json($topPages->pluck('path'));
            const pageData = @json($topPages->pluck('count'));

            new Chart(ctxPages, {
                type: 'bar',
                data: {
                    labels: pageLabels,
                    datasets: [{
                        label: 'Views',
                        data: pageData,
                        backgroundColor: '#38bdf8',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                        y: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
