@php
    $displayUrl = $imageUrl ?? null;
@endphp

@if (!empty($displayUrl))
    <div
        class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800 shadow-sm mt-4">
        <div class="relative">
            <img src="{{ $displayUrl }}" alt="Preview" class="w-full h-auto object-cover" style="max-height: 400px;"
                onerror="this.onerror=null; this.src='https://placehold.co/600x400/1e232e/FFF?text=Image+Not+Found';" />

            @if (!empty($imageCredit))
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                    <p class="text-white text-sm">
                        Photo by
                        @if (!empty($imageCreditUrl))
                            <a href="{{ $imageCreditUrl }}" target="_blank" class="font-semibold hover:underline">
                                {{ $imageCredit }}
                            </a>
                        @else
                            <span class="font-semibold">{{ $imageCredit }}</span>
                        @endif
                        on Unsplash
                    </p>
                </div>
            @endif
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            @if (isset($isUnsplash) && $isUnsplash)
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Image from Unsplash
                    </span>
                </p>
            @elseif(isset($isUpload) && $isUpload)
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        Uploaded Image
                    </span>
                </p>
            @endif
        </div>
    </div>
@endif
