@props(['title', 'form_action', 'method'])

<div {!! $attributes->merge(['class'=>'flex-grow bg-white overflow-hidden p-6 shadow-sm border-b border-gray-200 sm:rounded-lg']) !!}>
    
    @isset($title)
        <h2 class="mb-6">{{ $title }}</h2>
    @endisset
    
    {!! $slot !!}
    
</div>