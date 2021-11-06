<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    @isset( $meta_content )
        <meta name="description" content="{{ $meta_content }}"> 
    @endisset
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Laravel cross site request forgery protection --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Additional meta tags, FB, twitter, etc--}}
    @stack('meta')

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- additional <head> content (optional) --}}
    {!! $headslot ?? '' !!}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- override tailwind with browser defaults --}}
    <link rel="stylesheet" href="{{ asset('css/webkit-defaults.css') }}">
    {{-- styles that should apply to every page --}}
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    @isset($styles)
        {{-- Add passed in styles to @stack('styles') --}}
        <x-utils.push-styles-stack :styles="$styles ?? []"/>
    @endisset
    
    @stack('styles')

    @isset($scripts)
        {{-- Add passed in scripts to @stack('scripts') --}}
        <x-utils.push-scripts-stack :scripts="$scripts ?? []"/>
    @endisset

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    {{-- Scripts that should be loaded first --}}
    @stack('head_scripts')
    
</head>
<body {{ $attributes->only('class')->merge(['class'=>'font-sans antialiased']) }} >
    
    <div class="min-h-screen bg-gray-100">
        {{-- additional header content (optional) --}}
        {!! $slot ?? '' !!}