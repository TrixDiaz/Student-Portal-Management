<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-gray-800 text-white border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest ']) }}>
    {{ $slot }}
</button>