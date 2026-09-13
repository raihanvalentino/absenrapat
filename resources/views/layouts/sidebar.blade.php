<nav id="logo-sidebar" class="fixed pt-12 top-5 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 shadow-lg border-r border-gray" aria-label="Sidebar">
    <div class="h-full px-3 py-3 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2 font-medium h-10 me-3 sm:h-10 ps-2.5 mb-5">
            
            {{-- MENU UMUM (ADMIN SUPER & ADMIN BIASA) --}}
            @if(in_array(auth()->user()->role, ['admin', 'adminbiasa']))
            
            {{-- 1. DASHBOARD --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200' : '' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            {{-- 2. RAPAT --}}
            <li>
                <a href="{{ route('rapat') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('rapat') ? 'bg-gray-200' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Rapat</span>           
                </a>
            </li>

            {{-- 3. DATA PESERTA --}}
            <!-- <li>
                <a href="{{ route('dataPeserta') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dataPeserta') ? 'bg-gray-200' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                      </svg>                      
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Peserta</span>           
                </a>
            </li> -->

            @endif

            {{-- MENU KHUSUS SUPER ADMIN --}}
            @if(auth()->user()->role == 'admin')
                <div class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase">Super Admin</p>
                    
                    {{-- KELOLA USER (LINK SUDAH DIPERBAIKI) --}}
                    <li>
                        <a href="{{ route('admin.kelolaUser') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.kelolaUser') ? 'bg-gray-200' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                               <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                               <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                               <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .532-.284l6.118-6.116a2.85 2.85 0 0 0-4.03-4.03l-6.117 6.117a.96.96 0 0 0-.285.532l-.679 3.4a.961.961 0 0 0 .872 1.079ZM10.5 8.125a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Z"/>
                            </svg>
                            <span class="ms-3">Kelola User</span>
                        </a>
                    </li>
                </div>
            @endif

            {{-- TOMBOL LOGOUT --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-100 dark:hover:bg-red-900 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                        </svg>
                        <span class="ms-3 text-gray-700 group-hover:text-red-600">Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.querySelector('[data-collapse-toggle="dropdown-example"]');
        const dropdownMenu = document.getElementById('dropdown-example');
        
        if(toggleButton && dropdownMenu) {
            toggleButton.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });
        }
    });
</script>