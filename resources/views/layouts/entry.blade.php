<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/swiper/swiper.bundle.min.css') }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/swiper/swiper.bundle.min.js') }}"></script>
    <script>
        function cartCountdisplay(cartCount) {
            // Convert to number to ensure proper comparison
            cartCount = parseInt(cartCount) || 0;
            
            // Get all cart count elements
            const cartCountDom = document.getElementById("cart-count");
            const cartCountSidebarDom = document.getElementById("cart-count-sidebar");
            const guestCartCountDom = document.getElementById("guest-cart-count");
            const guestCartCountSidebarDom = document.getElementById("guest-cart-count-sidebar");
            
            // Update authenticated user cart count (top bar)
            if (cartCountDom) {
                if (cartCount > 0) {
                    cartCountDom.innerText = cartCount;
                    cartCountDom.classList.remove("hidden");
                } else {
                    cartCountDom.classList.add("hidden");
                }
            }
            
            // Update authenticated user cart count (sidebar)
            if (cartCountSidebarDom) {
                if (cartCount > 0) {
                    cartCountSidebarDom.innerText = cartCount;
                    cartCountSidebarDom.classList.remove("hidden");
                } else {
                    cartCountSidebarDom.classList.add("hidden");
                }
            }
            
            // Update guest cart count (top bar - if exists)
            if (guestCartCountDom) {
                if (cartCount > 0) {
                    guestCartCountDom.innerText = cartCount;
                    guestCartCountDom.classList.remove("hidden");
                } else {
                    guestCartCountDom.classList.add("hidden");
                }
            }
            
            // Update guest cart count (sidebar)
            if (guestCartCountSidebarDom) {
                if (cartCount > 0) {
                    guestCartCountSidebarDom.innerText = cartCount;
                    guestCartCountSidebarDom.classList.remove("hidden");
                } else {
                    guestCartCountSidebarDom.classList.add("hidden");
                }
            }
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileMenuOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        function loggedInDevicesCount(count) {
            let loggedInDevices = document.getElementById("loggedInDevices")

            if (loggedInDevices) {
                loggedInDevices.innerText = `{{ __('home.slotInfo') }}`.replace('{0}', count).replace('{2}', 2 - count)
            }
        }
    </script>

</head>

<body class="bg-slate-50">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Menu Overlay -->
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar Navigation -->
        <aside id="sidebar" 
            class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-white to-slate-50 border-r border-slate-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-xl">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <a href="/" class="flex items-center gap-3 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-primary-600 group-hover:text-primary-700 transition-colors">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
</svg>
                    <span class="text-xl font-bold tracking-wide text-primary-600 group-hover:text-primary-700 transition-colors">{{ __('home.online_exam') }}</span>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-primary-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    <span class="font-medium">Home</span>
                </a>

                @if (Auth::check())
                    <a href="/library" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                        <span class="font-medium">Library</span>
                    </a>

                    <a href="/cart-web" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-all group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="font-medium">Cart</span>
                        <span class="absolute right-4 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex justify-center items-center hidden" id="cart-count-sidebar"></span>
                    </a>
                @else
                    <a href="/cart-web" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-all group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="font-medium">Cart</span>
                        <span class="absolute right-4 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex justify-center items-center hidden" id="guest-cart-count-sidebar"></span>
                    </a>
                @endif

                <!-- Language Selector -->
                <div class="pt-4 border-t border-slate-200">
                    <div class="relative">
                        <button id="langToggleBtn" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">🌐</span>
                                <span class="font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                            </div>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="langDropdown" class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-lg shadow-lg hidden z-[111111] overflow-hidden">
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">English - 英語</a>
                            <a href="{{ route('lang.switch', 'jp') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Japanese - 日本語</a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer - User Section -->
            <div class="p-4 border-t border-slate-200">
                @if (Auth::check())
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-primary-50 transition-all group">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="w-10 h-10 rounded-full border-2 border-primary-200" alt="User avatar">
                            <div class="flex-1 text-left">
                                <p class="font-semibold text-slate-900 text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ Str::limit(auth()->user()->email, 20) }}</p>
                            </div>
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute bottom-full left-0 right-0 mb-2 bg-white border border-slate-200 rounded-lg shadow-xl z-50 overflow-hidden" style="display: none;">
                            <div class="p-4 border-b border-slate-100">
                                <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-left text-red-600 hover:bg-red-50 transition-colors font-medium">
                                    {{ __('home.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="block w-full px-4 py-2 text-center bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all shadow-md hover:shadow-lg">
                            {{ __('home.signin') }}
                        </a>
                                </div>
                @endif
                            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Top Bar -->
            <div class="lg:hidden flex items-center justify-between p-4 bg-white border-b border-slate-200 shadow-sm">
                <button onclick="toggleSidebar()" class="text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="/" class="text-lg font-bold text-primary-600">{{ __('home.online_exam') }}</a>
                <div class="w-10"></div>
                        </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

    </div>





    <!-- Toast Container -->
    <div id="infoToast" class="fixed bottom-5 right-5 z-[111111] hidden">
        <div
            class="bg-white border-l-4 border-primary-600 text-slate-800 px-4 py-3 shadow-xl rounded-lg flex items-start space-x-3 max-w-xs backdrop-blur-sm">
            <svg class="w-6 h-6 text-primary-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a7 7 0 107 7H9V2z" />
                <path d="M13 13H7v2h6v-2z" />
            </svg>
            <div>
                <p id="toastMessage" class="text-sm font-medium">This is your message</p>
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div id="authModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <!-- Modal Box -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 space-y-4 border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Sign in required</h3>
                    <p class="text-slate-600 text-sm mt-1">You need an account to purchase items.</p>
                </div>
                <button onclick="closeAuthModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-3 pt-2">
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all shadow-md hover:shadow-lg">
                    Sign In
                </a>
                <p class="text-slate-600 text-sm text-center">Contact your administrator for a user account.</p>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white p-6 rounded-2xl shadow-2xl text-center max-w-sm w-full border border-slate-200">
            <h2 class="text-lg font-bold mb-4 text-slate-900">Confirm Purchase</h2>
            <p class="text-slate-600">Are you sure you want to proceed to buy?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button onclick="confirmProceed()" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-2 rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all shadow-md hover:shadow-lg font-medium">
                    Yes
                </button>
                <button onclick="closeBuyModal()" class="bg-slate-100 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-200 transition-colors font-medium">
                    Cancel
                </button>
            </div>
        </div>
    </div>

</body>
<script>
    const langBtn = document.getElementById('langToggleBtn');
    const langDropdown = document.getElementById('langDropdown');

    if (langBtn && langDropdown) {
    langBtn.addEventListener('click', () => {
        langDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!langBtn.contains(e.target) && !langDropdown.contains(e.target)) {
            langDropdown.classList.add('hidden');
        }
    });
    }
</script>
<script>
    function showToast(message, duration = 3000) {
        const toast = document.getElementById('infoToast');
        const toastMessage = document.getElementById('toastMessage');

        toastMessage.textContent = message;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, duration);
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("form").forEach(function(form) {
            form.addEventListener("submit", function(e) {
                const submitBtn = form.querySelector("button[type='submit']");
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        ' <span class="ml-2">{{ __('loading') }}</span>';
                }
            });
        });
    });
</script>
<script>
    const CART_KEY = 'cart_items';

    // Add to cart function
    function addGuestItemToCart(item) {
        item = {
            ...item,
            qty: 1
        }
        let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];

        const existing = cart.find(i => i.id === item.id);
        if (existing) {
            if (typeof showToast === 'function') {
            showToast("Already added in cart");
            }
            //  existing.qty += item.qty;
        } else {
            cart.push(item);
        }

        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        
        // Update cart count display only
        if (typeof cartCountdisplay === 'function') {
            cartCountdisplay(cart.length);
        }

    }

    // Render cart items
    function renderGuestCart() {
        const container = document.getElementById('cart-items');
        if (!container) {
            console.error('Cart items container not found');
            return;
        }
        
        const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];

        container.innerHTML = ''; // Clear previous

        let total = 0;
        cart.forEach((item, index) => {

            const itemDiv = document.createElement('div');
            itemDiv.className = 'flex flex-col items-center gap-4';

            itemDiv.innerHTML = `
  <div class="flex flex-col w-full gap-3 relative border border-primary-200 shadow-sm rounded-lg p-3 bg-white hover:shadow-md transition-all">

    <!-- Book Image -->
    <a href="/detail/${item?.id}/view" class="block w-full aspect-[2/3] overflow-hidden rounded-lg bg-slate-100">
      <img 
        loading="lazy"
        src="/${item.images || 'placeholder.jpg'}"
        alt="Product Image"
        class="w-full h-full object-cover"
        onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 200 300\\'%3E%3Crect fill=\\'%23e2e8f0\\' width=\\'200\\' height=\\'300\\'/%3E%3Ctext x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dy=\\'.3em\\' fill=\\'%2394a3b8\\' font-family=\\'Arial\\' font-size=\\'14\\'%3EBook%3C/text%3E%3C/svg%3E';"
      />
    </a>

    <!-- Info -->
    <div class="flex flex-col gap-2">

      <!-- Price -->
      <p class="text-primary-700 font-bold text-base">${ new Intl.NumberFormat("ne-NP", { style: "currency", currency: "NPR" }).format(
   (item.price * item.qty).toFixed(0)
  )}</p>

      <!-- Quantity Controls -->
      <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <button onclick="updateQty(${index}, -1)" 
                  class="p-1.5 border border-slate-300 rounded-lg hover:bg-primary-50 hover:border-primary-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
          </svg>
        </button>
          <span class="text-primary-700 text-sm w-8 text-center font-semibold">${item.qty}</span>
        <button onclick="updateQty(${index}, 1)" 
                  class="p-1.5 border border-slate-300 rounded-lg hover:bg-primary-50 hover:border-primary-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </button>
    </div>

    <!-- Delete Button -->
    <button onclick="removeFromCart(${index})"
                class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 
              19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 
              5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 
              .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 
              1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 
              51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 
              2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
      </svg>
    </button>
      </div>
    </div>
  </div>
`;

            container.appendChild(itemDiv);
            total += item.price * item.qty;
        });

        // Update total at bottom
        const totalElement = document.getElementById('cart-total');
        if (totalElement) {
            totalElement.innerText = `Rs.${total.toFixed(0)}`;
        }

        // Update cart count display using centralized function
        if (typeof cartCountdisplay === 'function') {
            cartCountdisplay(cart.length);
        }
        
        // Show/hide subtotal section
        const subTotalSection = document.getElementById("subTotalSection");
        if (subTotalSection) {
            if (cart.length > 0) {
                subTotalSection.classList.remove("hidden");
        } else {
                subTotalSection.classList.add("hidden");
            }
            }
            container.innerHTML = `
    <div class="flex flex-col items-center justify-center text-center py-10 text-slate-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z"/>
      </svg>
      <p class="font-semibold text-lg text-slate-700">{{ __('home.yourCartIsEmpty') }}</p>
      <p class="text-sm mt-1 text-slate-500">{{ __('home.emptyCartInfo') }}</p>
    </div>
  `;
        }

    }

    let payloadOfCart = [];
    async function renderCartFromApi() {
        const container = document.getElementById('cart-items');
        if (!container) {
            console.error('Cart items container not found');
            return;
        }
        
        container.innerHTML = `
  <div class="flex flex-col items-center justify-center py-10 text-primary-500 animate-pulse">
    <svg class="w-12 h-12 mb-4 text-primary-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    <p class="font-semibold text-lg text-slate-700">Loading your cart...</p>
  </div>
`;

        try {
            const response = await fetch('/cart'); // Replace with your actual API URL if needed
            if (!response.ok) throw new Error('Failed to fetch cart data.');

            const data = await response.json();
            const cart = data.cartList || [];
            let total = 0;

            if (cart.length === 0) {
                container.innerHTML = `
        <div class="flex flex-col items-center justify-center text-center py-10 text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11L17 13M9 21a1 1 0 100-2 1 1 0 000 2z"/>
          </svg>
          <p class="font-semibold text-lg text-slate-700">{{ __('home.yourCartIsEmpty') }}</p>
          <p class="text-sm mt-1 text-slate-500">{{ __('home.emptyCartInfo') }}</p>
        </div>
      `;
                // Update cart count display using centralized function
                if (typeof cartCountdisplay === 'function') {
                    cartCountdisplay(0);
                }
                
                // Hide subtotal section
                const subTotalSection = document.getElementById("subTotalSection");
                if (subTotalSection) {
                    subTotalSection.classList.add("hidden");
                }
                
                // Reset total
                const totalElement = document.getElementById('cart-total');
                if (totalElement) {
                    totalElement.innerText = 'Rs.0';
                }
                return;
            }


            container.innerHTML = "";
            payloadOfCart = [];
            cart.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex flex-col items-center gap-4';

                itemDiv.innerHTML = `
  <div class="flex flex-col w-full gap-3 relative border border-primary-200 shadow-sm rounded-lg p-3 bg-white hover:shadow-md transition-all">
    
    <!-- Book Image -->
    <a href="/detail/${item?.book?.id}/view" class="block w-full aspect-[2/3] overflow-hidden rounded-lg bg-slate-100">
      <img 
        loading="lazy"
        src="/${item.book?.images || 'placeholder.jpg'}"
        alt="Product Image"
        class="w-full h-full object-cover"
        onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 200 300\\'%3E%3Crect fill=\\'%23e2e8f0\\' width=\\'200\\' height=\\'300\\'/%3E%3Ctext x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dy=\\'.3em\\' fill=\\'%2394a3b8\\' font-family=\\'Arial\\' font-size=\\'14\\'%3EBook%3C/text%3E%3C/svg%3E';"
      />
    </a>

    <!-- Info -->
    <div class="flex flex-col gap-2">
      
      <!-- Price -->
      <p class="text-primary-700 font-bold text-base">${new Intl.NumberFormat("ne-NP", { style: "currency", currency: "NPR" }).format(
  (item.book?.price * item.quantity).toFixed(0)
  )}</p>

      <!-- Quantity Controls -->
      <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <button onclick="updateQuantity(${item.book.id}, ${item.quantity} - 1)" 
                  class="p-1.5 border border-slate-300 rounded-lg hover:bg-primary-50 hover:border-primary-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
          </svg>
        </button>
          <span class="text-primary-700 text-sm w-8 text-center font-semibold">${item.quantity}</span>
        <button onclick="updateQuantity(${item.book.id}, ${item.quantity} + 1)" 
                  class="p-1.5 border border-slate-300 rounded-lg hover:bg-primary-50 hover:border-primary-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </button>
    </div>

    <!-- Delete Button -->
    <button onclick="if(confirm('Are you sure you want to remove this item?')) deleteCart(${item.book.id})"
                class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 
              19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 
              5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 
              .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 
              1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 
              51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 
              2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
      </svg>
    </button>
      </div>
    </div>
  </div>
`;


                container.appendChild(itemDiv);
                total += item.book?.price * item.quantity;

                payloadOfCart.push({
                    book_id: item.book.id,
                    quantity: item.quantity,
                    price: parseFloat(item.book.price * item.quantity),
                    per_price: parseFloat(item.book.price)
                });
            });

            const totalElement = document.getElementById('cart-total');
            if (totalElement) {
                totalElement.innerText = `Rs.${total.toFixed(0)}`;
            }
            
            // Update cart count display using centralized function
            if (typeof cartCountdisplay === 'function') {
                cartCountdisplay(cart.length);
            }
            
            // Show subtotal section
            const subTotalSection = document.getElementById("subTotalSection");
            if (subTotalSection) {
                subTotalSection.classList.remove("hidden");
            }

        } catch (error) {
            console.error('Error rendering cart:', error);
            container.innerHTML = `
      <div class="text-red-500 text-center py-10">
        Failed to load cart. Please try again later.
      </div>
    `;
        }
    }

    function removeFromCart(index) {
        let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
        cart.splice(index, 1); // Remove item by index
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        
        // Update cart count display
        if (typeof cartCountdisplay === 'function') {
            cartCountdisplay(cart.length);
        }
        
        // Re-render cart after removal
        if (typeof renderGuestCart === 'function') {
            renderGuestCart();
        }
    }

    function updateQty(index, change) {
        let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
        if (!cart[index]) return;

        cart[index].qty += change;

        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }

        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        
        // Update cart count display only
        if (typeof cartCountdisplay === 'function') {
            cartCountdisplay(cart.length);
        }
    }
</script>

<script>
    function addToCart(button, book, quantity = 1) {
        const isLoggedIn = @json(Auth::check());
        const isEmailVerified = isLoggedIn ? @json(Auth::check() && Auth::user()->hasVerifiedEmail()) : false;
        console.log(button)
        if (isLoggedIn) {
            if (isEmailVerified) {

                const textSpan = button.querySelector('.button-text');
                const loadingSpan = button.querySelector('.loading');
                button.setAttribute("disabled", true)
                textSpan.classList.add('hidden');
                loadingSpan.classList.remove('hidden');


                fetch('/cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            book_id: book?.id,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count display only
                            if (typeof cartCountdisplay === 'function' && data.cartCount !== undefined) {
                                cartCountdisplay(data.cartCount);
                            }
                            // Show success message
                            if (typeof showToast === 'function') {
                                showToast(data.message || 'Item added to cart successfully');
                            }
                        } else {
                            if (typeof showToast === 'function') {
                                showToast(data.message || 'Failed to add item to cart');
                            }
                        }

                        if (textSpan) textSpan.classList.remove('hidden');
                        if (loadingSpan) loadingSpan.classList.add('hidden');
                        if (button) button.removeAttribute("disabled");

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (textSpan) textSpan.classList.remove('hidden');
                        if (loadingSpan) loadingSpan.classList.add('hidden');
                        if (button) button.removeAttribute("disabled");
                    });
            } else {
                showToast("Please verify your email before adding items to the cart.");
            }
        } else {
            // Guest user - show login message
            if (typeof showToast === 'function') {
                showToast('Please login to add to cart', 4000);
            } else {
                alert('Please login to add to cart');
            }
            // Redirect to login page after showing message
            setTimeout(() => {
                window.location.href = '/login-register';
            }, 1500);
        }

    }

    function updateQuantity(bookId, quantity = 0) {
        if (quantity == 0) return;
        fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: bookId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success !== false) {
                    // Update cart count if provided
                    if (data.cartCount !== undefined && typeof cartCountdisplay === 'function') {
                        cartCountdisplay(data.cartCount);
                    }
                    // Show success message
                    if (typeof showToast === 'function') {
                        showToast('Cart updated successfully');
                    }
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
            });
    }

    function deleteCart(bookId) {
        fetch('/cart/delete-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: bookId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success !== false) {
                    // Update cart count if provided
                    if (data.cartCount !== undefined && typeof cartCountdisplay === 'function') {
                        cartCountdisplay(data.cartCount);
                    }
                    // Show success message
                    if (typeof showToast === 'function') {
                        showToast('Cart updated successfully');
                    }
                }
            })
            .catch(error => {
                console.error('Error deleting cart item:', error);
            });
    }
</script>
<script>
    function openAuthModal() {
        document.getElementById('authModal').classList.remove('hidden');
    }

    function closeAuthModal() {
        document.getElementById('authModal').classList.add('hidden');
    }
</script>
<script>
    function proceedToBuy() {
        const isLoggedIn = @json(Auth::check());
        const isEmailVerified = isLoggedIn ? @json(Auth::check() && Auth::user()->hasVerifiedEmail()) : false;

        if (isLoggedIn) {
            window.location.href = "/cart-web";
        } else {
            window.location.href = "/login-register";
        }
    }
    
    // Initialize cart count on page load
    document.addEventListener("DOMContentLoaded", function() {
        const isLoggedIn = @json(Auth::check());
        
        // Initialize cart count display based on login status
        if (isLoggedIn) {
            // Fetch cart count from API
            fetch('/cart')
                .then(response => response.json())
                .then(data => {
                    const cartCount = data.cartList?.length || 0;
                    if (typeof cartCountdisplay === 'function') {
                        cartCountdisplay(cartCount);
                    }
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                });
        } else {
            // Get cart count from localStorage
            const cart = JSON.parse(localStorage.getItem('cart_items')) || [];
            if (typeof cartCountdisplay === 'function') {
                cartCountdisplay(cart.length);
            }
        }
    });

    function confirmToBuy() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeBuyModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }


    function confirmProceed() {
        closeBuyModal();
        document.getElementById("proceedToBuy").setAttribute("disabled", true);
        document.getElementById("proceedToBuy").innerText = "{{ __('home.loading') }}"
        fetch('/purchases', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')


                },
                body: JSON.stringify({
                    books: payloadOfCart
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                window.location.href = `/purchases?purchase_id=${data?.purchase_id}`;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById("proceedToBuy").removeAttribute("disabled");
                document.getElementById("proceedToBuy").innerText = "Proceed to Buy"
            });
    }
</script>


</html>
