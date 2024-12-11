<div>
    <div class="py-12">
        <!-- Breadcrump -->
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Users
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
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Users</h1>
            </div>

            <!-- Form -->
            <div>
                <form wire:submit.prevent="storeUser" method="POST" class="mx-auto">
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
                        <!-- Email -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="email">Email</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                                @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="date_of_birth">Date of Birth</x-label>
                            <div class="mt-2.5">
                                <x-input type="date" wire:model="date_of_birth" name="date_of_birth" id="date_of_birth" autocomplete="date_of_birth" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="phone_number">Phone Number</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="phone_number" name="phone_number" id="phone_number" autocomplete="phone_number" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="address">Address</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="address" name="address" id="address" autocomplete="address" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>


                        <!-- City -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="city">City</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="city" name="city" id="city" autocomplete="city" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>

                        <!-- State  -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="state">State</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="state" name="state" id="state" autocomplete="state" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="zip_code">Zip Code</x-label>
                            <div class="mt-2.5">
                                <x-input type="text" wire:model="zip_code" name="zip_code" id="zip_code" autocomplete="zip_code" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            </div>
                        </div>

                        <!-- Roles -->
                        <div>
                            <x-label class="text-sm/6 text-gray-900 " for="roles">Roles</x-label>
                            <div class="mt-2.5">
                                <select wire:model="selectedRoles" name="roles" id="roles" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row space-x-4 mt-4">
                        <x-button type="submit">Submit</x-button>
                        <x-secondary-button type="button">
                            <a href="{{ route('admin.users') }}" wire:navigate>Cancel</a>
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>