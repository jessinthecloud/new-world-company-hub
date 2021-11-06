@props(['title'=>'Submission Error'])

@if ($errors->any())
    <div {!! $attributes->merge(['class' => 'alert alert-danger my-6 shadow-md']) !!}>
        <h3>{{ $title }}</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
