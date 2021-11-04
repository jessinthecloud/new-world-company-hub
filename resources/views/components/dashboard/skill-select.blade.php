@props(['skills'])

<x-label for="skill">Skill:</x-label>
<x-select name="skill" id="skill"
    :values="$skills"
></x-select>