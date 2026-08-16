<x-main-layout :page="$page">
    <div style="max-width: 900px; margin: 40px auto 80px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 12px;">Schedule a Discovery Call</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Select a convenient time slot for a 15-minute consultation, contract project inquiry, or technical interview.
            </p>
        </div>

        <div style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; min-height: 650px;">
            <iframe src="{{ $calendlyUrl }}" style="width: 100%; height: 650px; border: none; border-radius: var(--radius);" title="Schedule a Meeting"></iframe>
        </div>
    </div>
</x-main-layout>
