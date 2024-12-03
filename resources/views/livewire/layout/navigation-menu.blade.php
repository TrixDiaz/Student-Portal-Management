<nav x-data="{ open: false, notificationOpen: false }"
    @notification-drawer-close.window="notificationOpen = false"
    class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Global Search -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <form class="max-w-md mx-auto">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <x-icons.magnifying-glass-icon class="text-gray-500" />
                            </div>
                            <x-input type="text" id="search" class="block w-full ps-10 text-sm" placeholder="Search..." required />
                        </div>
                    </form>
                </div>

                <div class="hidden sm:flex items-center justify-center ml-4"
                    x-data="{ time: new Date().toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour12: false }) }"
                    x-init="setInterval(() => time = new Date().toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour12: false }), 1000)">
                    <p class="text-center text-gray-500">
                        {{ now()->format('l, F j, Y') }} <span x-text="time"></span>
                    </p>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Bell for Large Screens -->
                <div class="relative">
                    <button @click="notificationOpen = ! notificationOpen" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <span class="animate-pulse absolute top-2 right-2 h-2 w-2 bg-red-500 rounded-full"></span>
                        <x-icons.bell-alert-icon class="size-6" />
                    </button>

                    <!-- Notification Drawer for Large Screens -->
                    <div x-show="notificationOpen"
                        x-transition:enter="transform transition ease-in-out duration-500"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        @click.away="notificationOpen = false"
                        class="fixed inset-y-0 right-0 w-96 bg-white shadow-lg p-6 overflow-y-auto z-50">

                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold">Notifications
                                <span class="animate-pulse h-auto w-auto px-2 py-1 text-xs bg-red-500 rounded-full">{{ $unreadNotificationsCount }}</span>
                            </h2>

                            <button @click="notificationOpen = false" class="text-gray-500 hover:text-gray-700">
                                <x-icons.mark-icon class="size-6" />
                            </button>
                        </div>
                        <div class="flex flex-row gap-2 mb-6">
                            <button wire:click="markAllAsRead" class="text-gray-500 hover:text-gray-700 text-sm">
                                Mark all as read
                            </button>
                            <button wire:click="clearAllNotifications" class="text-gray-500 hover:text-gray-700 text-sm">
                                Clear all
                            </button>
                        </div>

                        <!-- Notification Items -->
                        <div wire:poll.5s class="space-y-4">
                            @forelse ($notifications as $notification)
                            <div wire:click="readNotification('{{ $notification->id }}')" class="p-4 z-0 bg-gray-50 hover:bg-gray-200 rounded-lg flex flex-col justify-between space-y-2 cursor-pointer">
                                <div class="font-semibold flex flex-row justify-between gap-2">
                                    <p>{{ $notification->data['message'] }}</p>
                                    <x-icons.mark-icon
                                        wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                        class="size-4 mt-1 z-10 cursor-pointer" />
                                </div>
                                <div class="flex flex-row gap-2">
                                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->read_at === null)
                                    <span class="h-4 w-4 px-2 py-1 text-xs bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">No notifications</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    {{ Auth::user()->currentTeam->name }}

                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Team Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Team') }}
                                </div>

                                <!-- Team Settings -->
                                <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-dropdown-link>
                                @endcan

                                <!-- Team Switcher -->
                                @if (Auth::user()->allTeams()->count() > 1)
                                <div class="border-t border-gray-200"></div>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                                @endforeach
                                @endif
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}

                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger and Notification Bell -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Notification Bell Icon -->
                <button @click="notificationOpen = ! notificationOpen" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <span class="absolute top-2 right-2 h-2 w-2 bg-red-500 rounded-full"></span>
                    <x-icons.bell-alert-icon class="size-6" />
                </button>

                <!-- Notification Drawer -->
                <div x-show="notificationOpen"
                    x-transition:enter="transform transition ease-in-out duration-500"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    @click.away="notificationOpen = false"
                    class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-lg p-6 overflow-y-auto z-50">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold">Notifications</h2>
                        <button @click="notificationOpen = false" class="text-gray-500 hover:text-gray-700">
                            <x-icons.mark-icon class="size-6" />
                        </button>
                    </div>

                    <!-- Notification Items -->
                    <div wire:poll.5s class="space-y-4">
                        @forelse ($notifications as $notification)
                        <div wire:click="readNotification('{{ $notification->id }}')" class="p-4 z-0 bg-gray-50 hover:bg-gray-200 rounded-lg flex flex-col justify-between space-y-2 cursor-pointer">
                            <div class="font-semibold flex flex-row justify-between gap-2">
                                <p>{{ $notification->data['message'] }}</p>
                                <x-icons.mark-icon
                                    wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                    class="size-4 mt-1 z-10 cursor-pointer" />
                            </div>
                            <div class="flex flex-row gap-2">
                                <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->read_at === null)
                                <span class="h-4 w-4 px-2 py-1 text-xs bg-blue-500 rounded-full"></span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">No notifications</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link> -->
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 me-3">
                    <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                        @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                    {{ __('Create New Team') }}
                </x-responsive-nav-link>
                @endcan

                <!-- Team Switcher -->
                @if (Auth::user()->allTeams()->count() > 1)
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <x-switchable-team :team="$team" component="responsive-nav-link" />
                @endforeach
                @endif
                @endif
            </div>
        </div>
    </div>
</nav>