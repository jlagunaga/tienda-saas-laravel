<div class="flex items-center gap-2" {{ $attributes }}>
    <div class="flex items-center justify-center p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200">
        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>
    <span class="text-xl font-black tracking-tight text-gray-900 bg-clip-text">Stores<span class="text-indigo-600"> {{ env('APP_NAME') }}</span></span>
</div>
