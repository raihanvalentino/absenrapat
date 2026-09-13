<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link rel="icon" type="image/png" href="/Logo1.png">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
        <link href="/resources/css/style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="{{ asset('DataTables-1.13.8/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('DataTables-1.13.8/js/jquery.dataTables.js') }}" type="text/javascript" language="javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <!-- Script untuk mencegah tombol back -->
        <script type="text/javascript">
            (function(global) {
                if(typeof (global) === "undefined") {
                    throw new Error("window is undefined");
                }
                
                var _hash = "!";
                var noBackPlease = function() {
                    global.location.href += "#";
                    
                    // Membuat fungsi yang akan dipanggil saat hash berubah
                    global.setTimeout(function() {
                        global.location.href += "!";
                    }, 50);
                };
                
                global.onhashchange = function() {
                    if (global.location.hash !== _hash) {
                        global.location.hash = _hash;
                    }
                };
                
                global.onload = function() {
                    noBackPlease();
                    
                    // Menonaktifkan tombol back
                    document.body.onkeydown = function(e) {
                        var elm = e.target.nodeName.toLowerCase();
                        if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                            e.preventDefault();
                        }
                        // Menonaktifkan Alt + Left arrow
                        e.stopPropagation();
                    };
                };
            })(window);
        </script>
    </head>
    <body>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="#" class="flex items-center ms-2 md:me-24 group">
                        {{-- Logo --}}
                        <img src="{{ asset('Logo3.png') }}" class="h-10 me-3 rounded shadow-sm" alt="Kementrans Logo" />
                        
                        {{-- Teks Aesthetic --}}
                        <div class="flex flex-col">
                            <span class="text-[10px] font-light text-white uppercase tracking-[0.2em] opacity-90">
                                Kementerian
                            </span>
                            <span class="text-sm font-bold text-white uppercase tracking-widest leading-none">
                                Transmigrasi
                            </span>
                        </div>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                    <!-- Nama User -->
                    <span class="me-2 text-gray-700 dark:text-gray-300 font-medium">{{ Auth::user()->username }}</span>

                    <!-- Tombol Dropdown -->
                    <button type="button" class="flex items-center text-sm px-3 py-2 bg-transparent rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" 
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        
                        <!-- Ikon User -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-8 h-8 text-gray-700 dark:text-gray-300">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ Auth::user()->username }}
                            </p>
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    </body>
</html>