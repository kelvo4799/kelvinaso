<x-admin-layout :page="$page" :profile="$profile">
    <div class="page-header">
        <div>
            <h1>Affiliate & Referral Partner Manager</h1>
            <div class="sub">Track client referrals, manage commission payouts, and update partner conversion statuses.</div>
        </div>
    </div>

    @if (session('success'))
        <div style="padding: 12px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.15); color: #10b981; margin-bottom: 24px; font-weight: 600; font-size: 0.85rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Metric Overview Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Total Referral Clicks</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--c-text); margin-top: 4px;">{{ number_format($totalReferrals) }}</div>
            <div style="font-size: 0.75rem; color: var(--accent); margin-top: 4px;">Link visits logged</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Converted Clients</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-top: 4px;">{{ number_format($totalConverted) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Conversions / Sales</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Pending Payouts</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #f59e0b; margin-top: 4px;">${{ number_format($totalCommissionPending, 2) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Awaiting payout approval</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 0.75rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase;">Total Paid Out</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #3b82f6; margin-top: 4px;">${{ number_format($totalCommissionPaid, 2) }}</div>
            <div style="font-size: 0.75rem; color: var(--c-text-muted); margin-top: 4px;">Total commissions sent</div>
        </div>
    </div>

    <!-- Referral Logs Table Card -->
    <div class="card">
        <div class="card-head">
            <h3>Affiliate Referral Logs & Payouts</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Affiliate / Referrer</th>
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Referred User / IP</th>
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Date</th>
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Status</th>
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Commission ($)</th>
                            <th style="padding: 12px 16px; color: var(--c-text-muted); font-weight: 600; font-size: 0.7rem; text-transform: uppercase; text-align: right;">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($referrals as $ref)
                            <tr style="border-bottom: 1px solid var(--c-border);">
                                <td style="padding: 14px 16px;">
                                    <div style="font-weight: 700; color: var(--c-text);">{{ $ref->referrer->name ?? 'Unknown' }}</div>
                                    <code style="font-size: 0.75rem; color: var(--accent);">{{ $ref->referrer->referral_code ?? '' }}</code>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="font-weight: 600;">{{ $ref->referredUser ? $ref->referredUser->name : 'Anonymous Visitor' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--c-text-muted); font-family: monospace;">IP: {{ $ref->visitor_ip }}</div>
                                </td>
                                <td style="padding: 14px 16px; color: var(--c-text-muted);">
                                    {{ $ref->created_at->format('M d, Y') }}
                                </td>
                                <td style="padding: 14px 16px;">
                                    @if ($ref->status === 'paid')
                                        <span style="padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Paid Out</span>
                                    @elseif ($ref->status === 'converted')
                                        <span style="padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(59, 130, 246, 0.15); color: #3b82f6;">Converted</span>
                                    @else
                                        <span style="padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">Pending</span>
                                    @endif
                                </td>
                                <td style="padding: 14px 16px; font-weight: 700;">
                                    ${{ number_format($ref->commission_amount, 2) }}
                                </td>
                                <td style="padding: 14px 16px; text-align: right;">
                                    <form action="{{ route('affiliates.update.admin', $ref->id) }}" method="POST" style="display: inline-flex; gap: 6px; align-items: center;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" style="padding: 4px 8px; font-size: 0.75rem; border-radius: 6px; background: var(--c-bg); border: 1px solid var(--c-border); color: var(--c-text);">
                                            <option value="pending" {{ $ref->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="converted" {{ $ref->status === 'converted' ? 'selected' : '' }}>Converted</option>
                                            <option value="paid" {{ $ref->status === 'paid' ? 'selected' : '' }}>Paid Out</option>
                                        </select>
                                        <input type="number" step="0.01" name="commission_amount" value="{{ $ref->commission_amount }}" style="width: 80px; padding: 4px 6px; font-size: 0.75rem; border-radius: 6px; background: var(--c-bg); border: 1px solid var(--c-border); color: var(--c-text);">
                                        <button type="submit" class="btn primary sm" style="padding: 4px 10px; font-size: 0.75rem;">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 24px; text-align: center; color: var(--c-text-muted);">
                                    No affiliate referral clicks or conversions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination-component :paginator="$referrals" />
        </div>
    </div>
</x-admin-layout>
