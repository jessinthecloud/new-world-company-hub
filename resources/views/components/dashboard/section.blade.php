@props(['title'])
<div class="bg-white overflow-hidden p-6 shadow-sm border-b border-gray-200 sm:rounded-lg">
    <h1>{{ $title }}</h1>
    
    {!! $slot !!}
    
</div>