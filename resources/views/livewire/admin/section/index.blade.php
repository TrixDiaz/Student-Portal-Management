<div>
    <div class="py-12">
        <!-- Breadcrump -->
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.sections') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Sections
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-icons.chevron-right-icon class="w-5 h-5 text-gray-400 mx-1" />
                            <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">List</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Title -->
            <div class="flex flex-row justify-between items-center">
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Sections</h1>
                <a wire:navigate href="{{ route('admin.sections.create') }}">
                    <x-secondary-button class="bg-lime-900 text-white flex flex-row items-center justify-between mx-1">
                        <x-icons.plus-icon class="w-5 h-5 mr-1" />
                        <span>Add Section</span>
                    </x-secondary-button>
                </a>
            </div>

            <!-- Table -->
            <div class="bg-slate-100 shadow-md shadow-lime-500 sm:rounded-lg overflow-hidden">
                <!-- Add Filter Tags -->
                @if($archiveStatus !== 'Active')
                <div class="flex items-center gap-2 p-4 bg-gray-50 border-b">
                    <span class="text-sm text-gray-600 font-semibold">Active filters:</span>
                    @if($archiveStatus !== 'Active')
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                        <span>Status: {{ $archiveStatus }}</span>
                        <button wire:click="$set('archiveStatus', 'Active')" class="ml-1 text-gray-500 hover:text-gray-700">
                            <x-icons.mark-icon class="w-3 h-3" />
                        </button>
                    </span>
                    @endif
                </div>
                @endif

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-icons.magnifying-glass-icon class="w-5 h-5 text-gray-500" />
                                </div>
                                <input wire:model.live.debounce.500ms="search" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2" placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <div x-data="{ open: false, archiveStatus: 'Active', role: 'All' }" class="relative">
                                <x-secondary-button @click="open = !open" class="flex flex-row space-x-0.5">
                                    <x-icons.funnel-icon class="w-5 h-5 mr-2 text-gray-400" />
                                    <span>Filter</span>
                                    <x-icons.chevron-right-icon
                                        class="w-5 h-5 ml-2 text-gray-400 transition-transform duration-200"
                                        ::class="open ? 'rotate-90' : ''" />
                                </x-secondary-button>

                                <div x-show="open"
                                    @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute mt-2 w-64 p-3 z-[100] bg-white rounded-lg shadow-lg mr-4"
                                    :class="[
                                        window.innerWidth >= 768 
                                            ? 'right-0' 
                                            : 'left-0 right-0 mx-auto'
                                    ]"
                                    style="min-width: max-content; position: fixed; transform: translateY(5%);">

                                    <!-- Archive Status Filter -->
                                    <div class="mb-4">
                                        <h6 class="mb-2 text-sm font-medium text-gray-900 whitespace-normal">Archive Status</h6>
                                        <select wire:model.live="archiveStatus"
                                            @change="open = false"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                                            <option value="Active">Active</option>
                                            <option value="Archived">Archived</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Name</th>
                                <th scope="col" class="px-4 py-3">Room</th>
                                <th scope="col" class="px-4 py-3">Building</th>
                                <th scope="col" class="px-4 py-3">Start Date</th>
                                <th scope="col" class="px-4 py-3">End Date</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sections as $section)
                            <tr wire:key="{{ $section->id }}" class="border-b">
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $section->name }}</th>
                                <td class="px-4 py-3">{{ optional($section->roomSection)->room?->name ?? 'No Room Assigned' }}</td>
                                <td class="px-4 py-3">{{ optional($section->roomSection)->room?->building?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if(optional($section->roomSection)->start_date)
                                    <div>{{ optional($section->roomSection)->start_date?->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ optional($section->roomSection)->start_date?->format('h:i A') }}</div>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if(optional($section->roomSection)->end_date)
                                    <div>{{ optional($section->roomSection)->end_date?->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ optional($section->roomSection)->end_date?->format('h:i A') }}</div>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute z-10 w-44 right-10 bg-white rounded divide-y divide-gray-100 shadow">
                                            @if($section->deleted_at === null)

                                            <ul class="py-1 text-sm text-gray-700">
                                                <li>
                                                    <a wire:navigate href="{{ route('admin.sections.edit', $section->id) }}" class="block py-2 px-4 hover:bg-gray-100">Edit</a>
                                                </li>
                                            </ul>
                                            <div class="py-1">
                                                <button @click="$dispatch('open-modal', { id: {{ $section->id }} })" class="block w-full text-left py-2 px-4 text-sm text-red-700 hover:bg-gray-100">Delete</button>
                                            </div>
                                            @endif
                                            @if($section->deleted_at !== null)
                                            <div class="py-1">
                                                <button @click="$dispatch('restore-section', { id: {{ $section->id }} })" class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Restore</button>
                                            </div>
                                            <div class="py-1">
                                                <button @click="$dispatch('force-delete-section', { id: {{ $section->id }} })" class="block w-full text-left py-2 px-4 text-sm text-red-700 hover:bg-gray-100">Permanently Delete</button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center">No sections found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <section class="p-2">
                    {{ $sections->links() }}
                </section>
            </div>
            <!-- End Table -->
        </div>
    </div>

    <!-- Modal Delete -->
    <div x-data="{ showModal: false, sectionId: null }"
        @open-modal.window="showModal = true; sectionId = $event.detail.id"
        x-show="showModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Deletion</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to delete this section? This action cannot be undone.</p>

                    <div class="mt-4 flex space-x-3">
                        <button @click="showModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancel
                        </button>
                        <button @click="$wire.deleteSection(sectionId); showModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Restore -->
    <div x-data="{ showRestoreModal: false, sectionId: null }"
        @restore-section.window="showRestoreModal = true; sectionId = $event.detail.id"
        x-show="showRestoreModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showRestoreModal = false"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Restoration</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to restore this section?</p>

                    <div class="mt-4 flex space-x-3">
                        <button @click="showRestoreModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancel
                        </button>
                        <button @click="$wire.restoreSection(sectionId); showRestoreModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Restore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Force Delete -->
    <div x-data="{ showForceDeleteModal: false, sectionId: null }"
        @force-delete-section.window="showForceDeleteModal = true; sectionId = $event.detail.id"
        x-show="showForceDeleteModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showForceDeleteModal = false"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Permanent Deletion</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to permanently delete this section? This action cannot be undone.</p>

                    <div class="mt-4 flex space-x-3">
                        <button @click="showForceDeleteModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancel
                        </button>
                        <button @click="$wire.forceDeleteSection(sectionId); showForceDeleteModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Permanently
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>