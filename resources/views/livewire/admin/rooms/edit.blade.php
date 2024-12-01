<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.rooms') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Rooms
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-icons.chevron-right-icon class="w-5 h-5 text-gray-400 mx-1" />
                            <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Create</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Title -->
            <div class="flex flex-row justify-between items-center">
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Rooms</h1>
            </div>

            <!-- Form -->
            <div>
                <form wire:submit.prevent="updateRoom" method="POST" class="mx-auto">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2 isolate bg-white  rounded-md sm:p-4">
                        <!-- Name -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="name">Name</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="name" name="name" id="name" autocomplete="name" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                                @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Building -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="building_id">Building</x-label>
                            <div class="mt-2.5">
                                <select wire:model="building_id" name="building_id" id="building_id" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6">
                                    <option value="{{ $room->building_id }}">{{ $room->building->name }}</option>
                                    @foreach ($buildings as $building)
                                    @if ($building->id !== $room->building_id)
                                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-row space-x-4 mt-4">
                        <x-button type="submit">Save</x-button>
                        <x-secondary-button type="button">
                            <a href="{{ route('admin.rooms') }}" wire:navigate>Cancel</a>
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>