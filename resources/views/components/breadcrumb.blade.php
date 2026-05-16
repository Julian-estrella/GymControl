@props(['links' => []])

<nav class="flex mb-4" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
    <li class="inline-flex items-center">
      <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 inline-flex items-center">
        <i class="fa-solid fa-house mr-2"></i>
        Dashboard
      </a>
    </li>
    @foreach($links as $label => $url)
        @if($url)
        <li>
          <div class="flex items-center">
            <i class="fa-solid fa-chevron-right text-gray-400 mx-2 text-xs"></i>
            <a href="{{ $url }}" class="hover:text-indigo-600">{{ $label }}</a>
          </div>
        </li>
        @else
        <li aria-current="page">
          <div class="flex items-center">
            <i class="fa-solid fa-chevron-right text-gray-400 mx-2 text-xs"></i>
            <span class="text-gray-800 font-semibold">{{ $label }}</span>
          </div>
        </li>
        @endif
    @endforeach
  </ol>
</nav>
