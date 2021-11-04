{{--
@props(['name', 'id' => '', 'values' => []])

<select name="{{ $name }}" id="{{ $id }}">
    <option value=""></option>
    @foreach($values as $text => $value)
        <option value="{{ $value }}">{{ $text }}</option>
    @endforeach
</select>--}}

@props(['values' => []])

<select {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    <option value=""></option>
    @foreach($values as $value)
        <option value="{{ $value['value'] }}">{{ $value['text'] }}</option>
    @endforeach
</select>
