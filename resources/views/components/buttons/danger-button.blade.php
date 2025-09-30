<button {{ $attributes->merge(['type' => 'submit',
'class' => 'inline-flex items-center justify-center px-6 py-2 bg-red-600 border border-transparent
rounded-md font-semibold text-sm text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-800
focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
