@props(['href', 'name', 'active' => false, 'icon' => 'circle', 'badge' => null])

<a href="{{ $href }}" 
   class="relative flex items-center px-4 py-3 transition-all duration-200 rounded-lg 
   {{ $active ? 'bg-blue-100 text-blue-700 font-semibold border-r-4 border-blue-600 shadow-sm' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
    
    {{-- Icon FontAwesome --}}
    <i class="fas fa-{{ $icon }} mr-3 text-base 
       {{ $active ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-500' }}"></i>

    <span class="font-medium">{{ $name }}</span>

    {{-- Badge Notification --}}
    @if($badge)
        <span class="px-2 py-1 ml-auto text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>
