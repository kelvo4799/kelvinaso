@php
    $enableBlog = \App\Models\Settings::where('key', 'enable_blog')->value('value') ?? '1';
    $enableSnippets = \App\Models\Settings::where('key', 'enable_snippets')->value('value') ?? '1';
    $enableScheduler = \App\Models\Settings::where('key', 'enable_scheduler')->value('value') ?? '1';
@endphp

<a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
<a href="/projects" class="{{ request()->is('projects*') ? 'active' : '' }}">Projects</a>
<a href="/about" class="{{ request()->is('about*') ? 'active' : '' }}">About</a>

@if ($enableBlog === '1')
    <a href="/blog" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
@endif

@if ($enableSnippets === '1')
    <a href="/snippets" class="{{ request()->is('snippets*') || request()->is('snippet*') ? 'active' : '' }}">Snippets</a>
@endif

@if ($enableScheduler === '1')
    <a href="/book-call" class="{{ request()->is('book-call*') ? 'active' : '' }}">Book Call</a>
@endif

<a href="/contact" class="{{ request()->is('contact*') ? 'active' : '' }}">Contact</a>