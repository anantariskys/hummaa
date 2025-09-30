<footer class="bg-main-bg text-white">
    <div class="container mx-auto px-6 py-16">

        <div class="grid gap-10 md:grid-cols-4">
            <div class="space-y-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-putih.png') }}" alt="Logo" class="h-20 w-auto">
                </a>
                <div>
                    <p class="text-lg font-bold">Malang</p>
                    <p class="text-sm text-gray-300">Fakultas Ilmu Komputer Universitas Brawijaya, Malang, Indonesia</p>
                </div>
            </div>

            <div>
                <p class="text-lg font-bold mb-4">Company</p>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <p class="text-lg font-bold mb-4">Other</p>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Privacy & Policy</a></li>
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Terms & Condition</a></li>
                </ul>
            </div>

            <div>
                <p class="text-lg font-bold mb-4">Social Media</p>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Instagram</a></li>
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Youtube</a></li>
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Telegram</a></li>
                    <li><a href="#" class="hover:opacity-80 transition-opacity">Facebook</a></li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-12">
            <p>Ikuti kami di</p>
            <div class="flex justify-center items-center space-x-4 mt-4">
                <a href="https://instagram.com" class="p-2 border-2 border-white rounded-full hover:bg-white/20 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" fill="currentColor"
                              d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0
                              012.153 1.153 4.902 4.902 0 011.153 2.153c.247.636.416 1.363.465 2.427.048 1.024.06
                              1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0
                              01-1.153 2.153 4.902 4.902 0 01-2.153 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902
                              4.902 0 01-2.153-1.153A4.902 4.902 0 013.06 19.48c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902
                              4.902 0 011.153-2.153A4.902 4.902 0 015.48 3.06c.636-.247 1.363-.416 2.427-.465C8.93 2.013 9.284 2 11.715 2h.6zM12 6.848c-2.837 0-5.152 2.315-5.152 5.152s2.315 5.152 5.152
                              5.152 5.152-2.315 5.152-5.152S14.837 6.848 12 6.848zM12 15.354c-1.848 0-3.354-1.506-3.354-3.354s1.506-3.354
                              3.354-3.354 3.354 1.506 3.354 3.354-1.506 3.354-3.354 3.354zM16.949 8.194a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z"
                              clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="https://youtube.com" class="p-2 border-2 border-white rounded-full hover:bg-white/20 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356
                        2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62
                        4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816V8l8 4-8 4z" /></svg>
                </a>

                <a href="https://telegram.com" class="p-2 border-2 border-white rounded-full hover:bg-white/20 transition-colors">
                    <svg class="h-5 w-5" viewBox="18 65 105 85" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M76.33 132.14L62.5 143.73L58.59 144.26L49.84
                        114.11L19.06 104L113.82 67.8799L118.29 67.9799L103.36 149.19L76.33 132.14ZM100.03 83.1399L56.61
                        109.17L61.61 130.5L62.98 130.19L68.2 113.73L102.9 83.4799L100.03 83.1399Z" fill="currentColor"/>
                    </svg>
                </a>

                <a href="https://facebook.com" class="p-2 border-2 border-white rounded-full hover:bg-white/20 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" fill="currentColor"
                              d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438
                              9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195
                              2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343
                              21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="mt-12 border-t border-white/20 pt-8 text-center">
            <p class="text-sm text-gray-300">
                &copy; 2025 PPKIn | Made with <span class="text-red-500">&hearts;</span> PKL FILKOM UB
            </p>
        </div>

    </div>
</footer>
