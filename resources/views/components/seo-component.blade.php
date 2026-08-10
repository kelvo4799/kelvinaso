
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $page->title ?? '' }} | {{ $settings->site_name ?? '' }}</title>


    <meta name="description" content="{{ $page->content['meta_description'] ?? '' }}">

    <meta name="keywords" content="{{ $page->content['meta_keywords'] ?? '' }}">

    <meta name="author" content="{{ $page->content['author'] ?? '' }}">

    <meta name="robots" content="{{ $page->content['robots'] ?? '' }}">

    <meta name="generator" content="Laravel">

    <meta name="application-name" content="{{ $page->content['site_name'] ?? '' }}">

    <meta name="apple-mobile-web-app-title" content="{{ $page->content['site_name'] ?? '' }}">

    <meta name="theme-color" content="#0F172A">

    <link rel="canonical" href="{{ $page->content['url'] ?? '' }}">

    <!-- Open Graph -->

    <meta property="og:type" content="{{ $page->content['type'] ?? '' }}">

    <meta property="og:site_name" content="{{ $page->content['site_name'] ?? '' }}">

    <meta property="og:title" content="{{ $page->content['title'] ?? '' }}">

    <meta property="og:description" content="{{ $page->content['meta_description'] ?? '' }}">

    <meta property="og:url" content="{{ $page->content['url'] ?? '' }}">

    <meta property="og:image" content="{{ $page->content['image'] ?? '' }}">

    <meta property="og:image:secure_url" content="{{ $page->content['image'] ?? '' }}">

    <meta property="og:image:width" content="1200">

    <meta property="og:image:height" content="630">

    <meta property="og:image:type" content="image/jpeg">

    <meta property="og:locale" content="{{ $page->content['locale'] ?? '' }}">

    <!-- Twitter -->

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="{{ $page->content['title'] ?? '' }}">

    <meta name="twitter:description" content="{{ $page->content['meta_description'] ?? '' }}">

    <meta name="twitter:image" content="{{ $page->content['image'] ?? '' }}">

    <meta name="twitter:site" content="@">

    <meta name="twitter:creator" content="@">

    <!-- Icons -->

    <link rel="icon" href="">

    <link rel="icon" type="image/png" sizes="32x32" href="">

    <link rel="icon" type="image/png" sizes="16x16" href="">

    <link rel="apple-touch-icon" sizes="180x180" href="">

    <link rel="manifest" href="">
