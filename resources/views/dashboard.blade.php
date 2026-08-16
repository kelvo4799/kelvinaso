<x-main-layout :page="$page ?? null" :settings="$settings ?? ['site_name' => 'Portfolio']">
    <div style="max-w-7xl; margin: 0 auto; padding: 40px 20px;">
        
        <!-- Welcome Banner Card -->
        <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 16px; padding: 28px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: linear-gradient(135deg, var(--accent, #6366f1), #a855f7); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; color: #fff;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-size: 1.6rem; font-weight: 700; margin: 0; color: var(--text-color, #fff);">Welcome back, {{ $user->name }}!</h1>
                    <p style="margin: 4px 0 0 0; color: var(--muted-color, #94a3b8); font-size: 0.9rem;">
                        Client & Member Dashboard · <span style="color: #10b981; font-weight: 600;">{{ $user->email }}</span>
                    </p>
                </div>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('book-call') }}" class="btn" style="padding: 10px 18px; font-size: 0.85rem; border-radius: 10px; background: var(--accent, #6366f1); color: #fff; text-decoration: none; font-weight: 600;">
                    Book Discovery Call
                </a>
                <a href="{{ route('contact') }}" class="btn" style="padding: 10px 18px; font-size: 0.85rem; border-radius: 10px; background: rgba(255,255,255,0.08); color: var(--text-color, #fff); text-decoration: none; font-weight: 600;">
                    Send New Inquiry
                </a>
                <a href="{{ route('profile.edit') }}" class="btn" style="padding: 10px 18px; font-size: 0.85rem; border-radius: 10px; background: rgba(255,255,255,0.05); color: var(--muted-color, #94a3b8); text-decoration: none;">
                    Account Settings
                </a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 36px;">
            <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 14px; padding: 20px;">
                <div style="font-size: 0.75rem; font-weight: 700; color: var(--muted-color, #94a3b8); text-transform: uppercase; letter-spacing: 0.5px;">Messages Sent</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-color, #fff); margin-top: 4px;">{{ $userMessages->count() }}</div>
                <div style="font-size: 0.75rem; color: #3b82f6; margin-top: 4px;">Direct portal inquiries</div>
            </div>

            <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 14px; padding: 20px;">
                <div style="font-size: 0.75rem; font-weight: 700; color: var(--muted-color, #94a3b8); text-transform: uppercase; letter-spacing: 0.5px;">AI Assistant Chats</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-top: 4px;">{{ $userChats->count() }}</div>
                <div style="font-size: 0.75rem; color: #10b981; margin-top: 4px;">Sales assistant interactions</div>
            </div>

            <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 14px; padding: 20px;">
                <div style="font-size: 0.75rem; font-weight: 700; color: var(--muted-color, #94a3b8); text-transform: uppercase; letter-spacing: 0.5px;">Member Status</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent, #6366f1); margin-top: 4px;">Active</div>
                <div style="font-size: 0.75rem; color: var(--muted-color, #94a3b8); margin-top: 4px;">Member since {{ $user->created_at->format('M Y') }}</div>
            </div>
        </div>

        <!-- Section 1: My Contact Messages -->
        <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 16px; padding: 24px; margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0; color: var(--text-color, #fff);">My Contact Messages</h3>
                    <p style="margin: 4px 0 0 0; color: var(--muted-color, #94a3b8); font-size: 0.85rem;">History of inquiries submitted through the contact form.</p>
                </div>
                <a href="{{ route('contact') }}" style="font-size: 0.85rem; color: var(--accent, #6366f1); text-decoration: none; font-weight: 600;">+ New Message</a>
            </div>

            @if ($userMessages->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: var(--muted-color, #94a3b8);">
                                <th style="padding: 10px 12px;">Subject / Message</th>
                                <th style="padding: 10px 12px;">Date</th>
                                <th style="padding: 10px 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userMessages as $msg)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 14px 12px; color: var(--text-color, #fff);">
                                        <div style="font-weight: 600; margin-bottom: 2px;">{{ $msg->subject ?: 'General Project Inquiry' }}</div>
                                        <div style="color: var(--muted-color, #94a3b8); font-size: 0.8rem;">{{ Str::limit($msg->message, 90) }}</div>
                                    </td>
                                    <td style="padding: 14px 12px; color: var(--muted-color, #94a3b8);">
                                        {{ $msg->created_at->format('M d, Y · h:i A') }}
                                    </td>
                                    <td style="padding: 14px 12px;">
                                        @if ($msg->status === 'unread')
                                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(59, 130, 246, 0.15); color: #3b82f6;">Received</span>
                                        @else
                                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Reviewed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 30px; color: var(--muted-color, #94a3b8); font-size: 0.9rem;">
                    You haven't submitted any direct messages yet. Need help with a project? <a href="{{ route('contact') }}" style="color: var(--accent, #6366f1);">Send an inquiry</a>.
                </div>
            @endif
        </div>

        <!-- Section 2: Affiliate & Referral Program Portal -->
        <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 16px; padding: 24px; margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0; color: var(--text-color, #fff);">Affiliate & Referral Partner Portal</h3>
                    <p style="margin: 4px 0 0 0; color: var(--muted-color, #94a3b8); font-size: 0.85rem;">Share your unique link to refer clients and earn commissions on completed software projects.</p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #10b981;">
                        Total Earnings: ${{ number_format($totalEarnings, 2) }}
                    </span>
                </div>
            </div>

            <!-- Unique Referral Link Box -->
            <div style="background: rgba(255,255,255,0.03); border: 1px dashed var(--accent, #6366f1); border-radius: 12px; padding: 18px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <div style="flex: 1; min-width: 260px;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: var(--muted-color, #94a3b8); text-transform: uppercase;">Your Personal Referral Link</div>
                    <input type="text" id="refLinkInput" readonly value="{{ $referralLink }}" style="width: 100%; margin-top: 6px; background: transparent; border: none; color: var(--accent, #6366f1); font-weight: 700; font-size: 0.95rem; font-family: monospace; outline: none;">
                </div>
                <button onclick="copyRefLink()" id="copyRefBtn" class="btn" style="padding: 10px 20px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; background: var(--accent, #6366f1); color: #fff; border: none; cursor: pointer;">
                    📋 Copy Referral Link
                </button>
            </div>

            <!-- Referral Stats Row -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: rgba(255,255,255,0.02); padding: 14px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 0.7rem; color: var(--muted-color, #94a3b8); font-weight: 700; text-transform: uppercase;">Link Clicks</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--text-color, #fff); margin-top: 2px;">{{ $totalClicks }}</div>
                </div>
                <div style="background: rgba(255,255,255,0.02); padding: 14px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 0.7rem; color: var(--muted-color, #94a3b8); font-weight: 700; text-transform: uppercase;">Converted Clients</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #10b981; margin-top: 2px;">{{ $convertedLeads }}</div>
                </div>
                <div style="background: rgba(255,255,255,0.02); padding: 14px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 0.7rem; color: var(--muted-color, #94a3b8); font-weight: 700; text-transform: uppercase;">Commission Earned</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #3b82f6; margin-top: 2px;">${{ number_format($totalEarnings, 2) }}</div>
                </div>
            </div>

            <!-- Referral Activity History -->
            @if ($referrals->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: var(--muted-color, #94a3b8);">
                                <th style="padding: 10px 12px;">Referral Event</th>
                                <th style="padding: 10px 12px;">Date</th>
                                <th style="padding: 10px 12px;">Status</th>
                                <th style="padding: 10px 12px;">Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referrals as $ref)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 600; color: var(--text-color, #fff);">
                                            {{ $ref->referredUser ? $ref->referredUser->name : 'Visitor Click' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--muted-color, #94a3b8);">{{ $ref->notes ?: 'Referral tracking' }}</div>
                                    </td>
                                    <td style="padding: 12px; color: var(--muted-color, #94a3b8);">
                                        {{ $ref->created_at->diffForHumans() }}
                                    </td>
                                    <td style="padding: 12px;">
                                        @if ($ref->status === 'paid')
                                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Paid Out</span>
                                        @elseif ($ref->status === 'converted')
                                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(59, 130, 246, 0.15); color: #3b82f6;">Converted</span>
                                        @else
                                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">Pending Visit</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px; font-weight: 700; color: var(--text-color, #fff);">
                                        ${{ number_format($ref->commission_amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Section 3: AI Sales Assistant Activity -->
        <div style="background: var(--card-bg, #12131a); border: 1px solid var(--border-color, rgba(255,255,255,0.08)); border-radius: 16px; padding: 24px;">
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0; color: var(--text-color, #fff);">AI Assistant Conversations</h3>
                <p style="margin: 4px 0 0 0; color: var(--muted-color, #94a3b8); font-size: 0.85rem;">Your interactions with Kelvin's 24/7 AI Sales Assistant.</p>
            </div>

            @if ($userChats->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach ($userChats as $chat)
                        <div style="padding: 14px 18px; border-radius: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-color, #fff);">
                                    {{ $chat->project_summary ?: 'General Conversation Thread' }}
                                </div>
                                <div style="font-size: 0.78rem; color: var(--muted-color, #94a3b8); margin-top: 2px;">
                                    Session #{{ substr($chat->session_id, 0, 8) }} · {{ $chat->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div>
                                @if ($chat->lead_score === 'HOT')
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(239, 68, 68, 0.15); color: #ef4444;">🔥 Priority Lead</span>
                                @elseif ($chat->lead_score === 'WARM')
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">⚡ Project Prospect</span>
                                @else
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(99, 102, 241, 0.15); color: var(--accent, #6366f1);">Visitor Inquiry</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 30px; color: var(--muted-color, #94a3b8); font-size: 0.9rem;">
                    No AI chatbot conversations recorded for this account. Click the AI Assistant widget at the bottom right to get started!
                </div>
            @endif
        </div>

    </div>

    <script>
        function copyRefLink() {
            const input = document.getElementById('refLinkInput');
            input.select();
            navigator.clipboard.writeText(input.value);
            const btn = document.getElementById('copyRefBtn');
            btn.innerText = '✅ Copied!';
            setTimeout(() => { btn.innerText = '📋 Copy Referral Link'; }, 2500);
        }
    </script>
</x-main-layout>
