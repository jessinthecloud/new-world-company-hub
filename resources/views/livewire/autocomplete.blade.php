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
      updateSelected(itemId, itemName, itemType, itemSlug, inputName) {
        this.selected = itemId;
        this.search = itemName;
        this.open = false;
        this.highlightedIndex = 0;
        
        document.getElementById(inputName+'-base-model-id').value = itemId;
        document.getElementById(inputName+'-base-model-slug').value = itemSlug;
        document.getElementById(inputName+'-itemType').value = itemType;
      },
  }">
  <div
    x-on:value-selected="updateSelected(
        $event.detail.itemId, 
        $event.detail.itemName, 
        $event.detail.itemType, 
        $event.detail.itemSlug,
        $event.detail.inputName
    )">
        <input
          wire:model.debounce.300ms="search"
          x-on:keydown.arrow-down.stop.prevent="highlightNext()"
          x-on:keydown.arrow-up.stop.prevent="highlightPrevious()"
          x-on:keydown.enter.stop.prevent="$dispatch('value-selected', {
            itemId: $refs.results.children[highlightedIndex].getAttribute('data-result-itemId'),
            itemName: $refs.results.children[highlightedIndex].getAttribute('data-result-itemName'),
            itemType: $refs.results.children[highlightedIndex].getAttribute('data-result-itemType'),
            itemSlug: $refs.results.children[highlightedIndex].getAttribute('data-result-itemSlug'),
            inputName: $refs.results.children[highlightedIndex].getAttribute('data-result-inputName'),
          })"
          class="
            w-full h-full rounded-md py-2 px-3
            focus:border-indigo-300 
            focus:ring 
            focus:ring-indigo-200 
            focus:ring-opacity-50
          "
          name="{{ $equipSlotName }}"
          >

    <div
      x-show="open"
      x-on:click.away="open = false">
        <ul x-ref="results">
          @forelse($results as $index => $result)
            <li
              wire:key="{{ $index }}"
              x-on:click.stop="$dispatch('value-selected', {
                itemId: {{ $result->id }},
                {{-- item names with single quotes is creating JS errors
                no idea why {{ }} is not already escaping quotes
                htmlspecialchars() does not work here --}}
                itemName: '{{ addslashes($result->name) }}',
                itemType: '{{ $result->type }}',
                itemSlug: '{{ $result->slug }}',
                inputName: '{{ $equipSlotName }}'
              })"
              :class="{
                'bg-indigo-400': {{ $index }} === highlightedIndex,
                'text-white': {{ $index }} === highlightedIndex
              }"
              data-result-itemId="{{ $result->id }}"
              data-result-itemName="{{ $result->name }}"
              data-result-itemType="{{ $result->type }}"
              data-result-itemSlug="{{ $result->slug }}"
              data-result-inputName="{{ $equipSlotName }}"
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