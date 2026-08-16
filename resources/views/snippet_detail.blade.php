<x-main-layout :page="$page">
    <div style="max-width: 860px; margin: 40px auto 80px;">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('snippets.index') }}" style="color: var(--accent); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                &larr; Back to Code Snippets
            </a>
        </div>

        <article style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 36px;">
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 16px;">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 12px; border-radius: 6px; background: var(--accent-soft); color: var(--accent);">
                    {{ $snippet->category ?: $snippet->language }}
                </span>
                <span style="font-size: 0.85rem; color: var(--muted);">Published {{ $snippet->created_at->format('M d, Y') }}</span>
            </div>

            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 16px; color: var(--fg); line-height: 1.3;">
                {{ $snippet->title }}
            </h1>

            @if ($snippet->description)
                <p style="color: var(--muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 28px;">
                    {{ $snippet->description }}
                </p>
            @endif

            <div style="position: relative; margin-top: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; background: #1e1e2e; padding: 10px 18px; border-radius: var(--radius) var(--radius) 0 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <span style="font-size: 0.75rem; font-family: monospace; color: #89b4fa; text-transform: uppercase; font-weight: 700;">
                        {{ $snippet->language ?: 'CODE' }}
                    </span>
                    <button type="button" onclick="copySnippetCode()" id="btnCopyCode" style="font-size: 0.75rem; background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        📋 Copy Code
                    </button>
                </div>
                <pre style="margin: 0; padding: 24px; background: #181825; color: #cdd6f4; border-radius: 0 0 var(--radius) var(--radius); overflow-x: auto; font-family: 'Fira Code', Consolas, Monaco, monospace; font-size: 0.9rem; line-height: 1.6;"><code id="snippetCode">{{ $snippet->code_content }}</code></pre>
            </div>
        </article>
    </div>

    <script>
        function copySnippetCode() {
            const codeText = document.getElementById('snippetCode').innerText;
            navigator.clipboard.writeText(codeText).then(() => {
                const btn = document.getElementById('btnCopyCode');
                btn.innerText = '✅ Copied!';
                setTimeout(() => {
                    btn.innerText = '📋 Copy Code';
                }, 2000);
            });
        }
    </script>
</x-main-layout>
