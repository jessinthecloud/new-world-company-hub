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
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
<x-layouts.html-footer>
    {{-- additional footer content --}}
    {!! $footer_slot ?? '' !!}

    {{-- also has footer_styles, and scripts @stacks --}}
</x-layouts.html-footer>

