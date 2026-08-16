<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - {{ $profile->first_name ?: $user->name }} {{ $profile->last_name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; margin: 0; padding: 40px; background: #fff; line-height: 1.5; font-size: 14px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 20px; margin-bottom: 30px; }
        .name { font-size: 28px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 1px; }
        .title { font-size: 16px; color: #6366f1; font-weight: 600; margin-top: 4px; }
        .contact { font-size: 12px; color: #64748b; margin-top: 8px; }
        .section-title { font-size: 16px; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-top: 28px; margin-bottom: 14px; color: #0f172a; }
        .exp-item { margin-bottom: 16px; }
        .exp-header { display: flex; justify-content: space-between; font-weight: 700; font-size: 15px; }
        .company { color: #475569; font-weight: 600; font-size: 13px; margin-top: 2px; }
        .chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .chip { background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background: #6366f1; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;">
            🖨️ Print / Save as PDF
        </button>
    </div>

    <div class="header">
        <div class="name">{{ $profile->first_name ?: $user->name }} {{ $profile->last_name }}</div>
        <div class="title">{{ $profile->bio_title ?: 'Senior Software Engineer & Architect' }}</div>
        <div class="contact">
            {{ $profile->direct_email ?: $user->email }} | {{ $profile->direct_phone ?: '+234 800 000 0000' }} | {{ $profile->location ?: 'Remote / Worldwide' }}
        </div>
    </div>

    @if ($profile->bio)
        <div class="section-title">Professional Summary</div>
        <p style="color: #334155; font-size: 13px; line-height: 1.6;">{{ $profile->bio }}</p>
    @endif

    @if ($experiences->count() > 0)
        <div class="section-title">Work Experience</div>
        @foreach ($experiences as $exp)
            <div class="exp-item">
                <div class="exp-header">
                    <span>{{ $exp->title }}</span>
                    <span>{{ $exp->start_year }} – {{ $exp->is_current ? 'Present' : ($exp->end_year ?: 'Present') }}</span>
                </div>
                <div class="company">{{ $exp->company }} | {{ $exp->location ?: 'Remote' }}</div>
                @if ($exp->description)
                    <p style="margin-top: 6px; color: #475569; font-size: 13px;">{{ $exp->description }}</p>
                @endif
            </div>
        @endforeach
    @endif

    @if ($stacks->count() > 0)
        <div class="section-title">Technical Skills & Technologies</div>
        <div class="chips">
            @foreach ($stacks as $stack)
                <span class="chip">{{ $stack->name }}</span>
            @endforeach
        </div>
    @endif

    @if ($projects->count() > 0)
        <div class="section-title">Featured Projects</div>
        @foreach ($projects as $proj)
            <div style="margin-bottom: 12px;">
                <div style="font-weight: 700; color: #0f172a;">{{ $proj->title }}</div>
                <div style="font-size: 13px; color: #475569;">{{ $proj->description }}</div>
            </div>
        @endforeach
    @endif

</body>
</html>
