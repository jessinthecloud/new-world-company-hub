{{-- modified from https://chrisdicarlo.ca/blog/-alpinejs-and-livewire-autocomplete/ --}}
  <div
  class="
    w-full rounded-md shadow-sm border border-gray-300
    focus:border-indigo-300 
    focus:ring 
    focus:ring-indigo-200 
    focus:ring-opacity-50
  " 
    x-data="{
      open: @entangle('showDropdown'),
      search: @entangle('search'),
      selected: @entangle('selected'),
      highlightedIndex: 0,
      highlightPrevious() {
        if (this.highlightedIndex > 0) {
          this.highlightedIndex = this.highlightedIndex - 1;
          this.scrollIntoView();
        }
      },
      highlightNext() {
        if (this.highlightedIndex < this.$refs.results.children.length - 1) {
          this.highlightedIndex = this.highlightedIndex + 1;
          this.scrollIntoView();
        }
      },
      scrollIntoView() {
        this.$refs.results.children[this.highlightedIndex].scrollIntoView({
          block: 'nearest',
          behavior: 'smooth'
        });
      },
      updateSelected(id, name, type, slug) {
        this.selected = id;
        this.search = name;
        this.open = false;
        this.highlightedIndex = 0;
        document.getElementById('base-model-id').value = id;
        document.getElementById('base-model-slug').value = slug;
        document.getElementById('itemType').value = type;
      },
  }">
  <div
    x-on:value-selected="updateSelected($event.detail.id, $event.detail.name, $event.detail.type, $event.detail.slug)">
        <input
          wire:model.debounce.300ms="search"
          x-on:keydown.arrow-down.stop.prevent="highlightNext()"
          x-on:keydown.arrow-up.stop.prevent="highlightPrevious()"
          x-on:keydown.enter.stop.prevent="$dispatch('value-selected', {
            id: $refs.results.children[highlightedIndex].getAttribute('data-result-id'),
            name: $refs.results.children[highlightedIndex].getAttribute('data-result-name'),
            type: $refs.results.children[highlightedIndex].getAttribute('data-result-type'),
            slug: $refs.results.children[highlightedIndex].getAttribute('data-result-slug')
          })"
          class="
            w-full h-full rounded-md py-2 px-3
            focus:border-indigo-300 
            focus:ring 
            focus:ring-indigo-200 
            focus:ring-opacity-50
          "
          >

    <div
      x-show="open"
      x-on:click.away="open = false">
        <ul x-ref="results">
          @forelse($results as $index => $result)
            <li
              wire:key="{{ $index }}"
              x-on:click.stop="$dispatch('value-selected', {
                id: {{ $result->id }},
                name: '{{ $result->name }}',
                type: '{{ $result->type }}',
                slug: '{{ $result->slug }}'
              })"
              :class="{
                'bg-indigo-400': {{ $index }} === highlightedIndex,
                'text-white': {{ $index }} === highlightedIndex
              }"
              data-result-id="{{ $result->id }}"
              data-result-name="{{ $result->name }}"
              data-result-type="{{ $result->type }}"
              data-result-slug="{{ $result->slug }}"
            >
                <span>
                  {{ $result->name }} ({{ $result->type }})
                </span>
            </li>
          @empty
            <li>No results found</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>