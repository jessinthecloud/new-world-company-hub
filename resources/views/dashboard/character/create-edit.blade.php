<x-dashboard.section
    :title="'Character'"
>
    <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ $form_action ?? '' }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
    >
        <x-forms.field :name="'name'">
            <x-forms.label for="name" :required="true">Name:</x-forms.label>
            <x-forms.input id="name" type="text" name="name" class="" :required="true" value="{{ old('name') ?? '' }}"/>
        </x-forms.field>

        <x-forms.field :name="'level'">
            <x-forms.label for="level" :required="true">Level:</x-forms.label>
            <x-forms.input id="level" type="text" name="level" size="10" :required="true" value="{{ old('level') ?? '' }}" />
        </x-forms.field>

        <x-forms.field :name="'rank'">
            <x-forms.label for="rank" :required="true">Rank:</x-forms.label>
            <x-forms.select name="rank" id="rank"
                            :values="$ranks"
                            :required="true"
            ></x-forms.select>
        </x-forms.field>

        {{-- 
        <x-forms.field :name="'skill'">
            <x-forms.label for="skill">Skill:</x-forms.label>
            <x-forms.select name="skill" id="skill"
                :values="$skills"
            ></x-forms.select>
        </x-forms.field>
        --}}
    </x-forms.form>
</x-dashboard.section>