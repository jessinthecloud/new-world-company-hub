@props(['ranks'])

<x-label for="rank">Rank:</x-label>
<x-select name="rank" id="rank"
    :values="$ranks"
></x-select>