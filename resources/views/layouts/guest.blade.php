<x-layouts.html-head
        :meta-content="$meta_content ?? ''"
        :title="$title ?? ''"
        :styles="$styles ?? null"
        :scripts="$scripts ?? null"
        {{-- additional <head> content --}}
        :headslot="$headslot ?? ''"

        {{-- also has meta, styles, and head_scripts @stacks --}}
>
    {{-- additional header content --}}
    {!! $header_slot ?? '' !!}
</x-layouts.html-head>
    
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @empty($header)
                <x-header-title :title="$title ?? 'Welcome'"/>
            @else
                {{ $header ?? '' }}
            @endempty
        </div>
    </header>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
    
<x-layouts.html-footer>
    {{-- additional footer content --}}
    {!! $footer_slot ?? '' !!}

    {{-- also has footer_styles, and scripts @stacks --}}
</x-layouts.html-footer>

