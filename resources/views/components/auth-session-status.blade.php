@props(['status'=>null])

@isset ($status['message'])
    <div {{ $attributes->merge(['class' => 'font-medium text-sm alert alert-'.$status['type']]) }}>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">{{ $status['message'] }}</div>
    </div>
@endisset
