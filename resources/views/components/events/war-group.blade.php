@props(['title'])

<ul 
    {{ $attributes->merge([
        'class' => 'war-group drop-target bg-gray-200 border border-gray-300 p-2'
    ]) }}
    x-on:drop="adding = false"
    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
        const target = event.target.closest('ul');
        const element = document.getElementById(id);
        target.appendChild(element);
        element.classList.add('bg-gray-300');
        element.classList.add('border');
        element.classList.add('rounded');
        element.classList.remove('flex');
        element.classList.add('flex-col');
      
        // remove classes from children
        for(let el of element.getElementsByTagName('div')){
            el.className = '';
        }
        
        if(element.getElementsByTagName('svg').length > 0){
            element.classList.add('border-green-500');
            element.removeChild(element.getElementsByTagName('svg')[0]);
        }
    "
    x-on:dragover.prevent="adding = true"
    x-on:dragleave.prevent="adding = false"
>
    <h3 class="mb-2">{{ $title }}</h3>
</ul>