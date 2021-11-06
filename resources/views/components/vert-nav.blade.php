@props(['menuItems'])

<aside class="max-w-1/4 w-full bg-blue-200 overflow-hidden p-6 border-b border-gray-200 shadow-sm sm:rounded-lg">
    <nav class="vert-nav">
        <x-layouts.menu :menu-items="$menuItems"/>
    </nav>
</aside>