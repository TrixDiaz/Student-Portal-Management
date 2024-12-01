<div>
    <div class="mx-auto max-w-6xl my-8">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.roles') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 ">
                        Roles
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-icons.arrow-right-icon />
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Edit</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-row justify-between items-center">
            <h1 class="text-3xl font-bold my-4">Edit Role</h1>
        </div>

        <!-- Form -->
        <div>
            <form wire:submit.prevent="updateRole" method="POST" class="mx-auto">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2 isolate bg-white rounded-md sm:p-4">
                    <div>
                        <x-label class="text-sm/6 text-gray-900" for="name">Name</x-label>
                        <div class="mt-2.5">
                            <x-input type="text" wire:model="name" name="name" id="name" autocomplete="name" class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6" />
                            @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <x-label class="text-sm/6 text-gray-900" for="guard_name">Guard Name</x-label>
                        <div class="mt-2.5">
                            <x-input type="text" wire:model="guard_name" name="guard_name" id="guard_name" autocomplete="guard_name" disabled
                                class="block w-full rounded-md shadow-gray-400 shadow-md border-0 px-3.5 py-2 text-gray-900 sm:text-sm/6 cursor-not-allowed" />
                            @error('guard_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Permission -->
                    <div class="col-span-2">
                        <x-label class="text-sm/6 text-gray-900" for="permissions">Permissions</x-label>
                        @foreach ($permissions as $permission)
                        <div class="flex flex-row justify-between items-center mt-2.5 border-b border-gray-200 pb-2 space-y-4">
                            <div class="flex-shrink-0 w-1/3">
                                <div><span class="capitalize">{{ $permission['name'] }}</span></div>
                            </div>
                            <div class="flex flex-row space-x-4 flex-grow justify-start">
                                @foreach ($permission['group'] as $valueGroup)
                                <div class="flex flex-row items-center space-x-1">
                                    <x-input class="w-4 h-4 border-gray-500" type="checkbox" wire:model="selectedPermissions" :value="$valueGroup['id']" />
                                    <x-label class="text-sm/6 text-gray-900 capitalize" for="permissions">{{ $valueGroup['name'] }}</x-label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-row space-x-4 mt-10">
                    <x-button type="submit">Save</x-button>
                    <x-secondary-button type="button">
                        <a href="{{ route('admin.roles') }}" wire:navigate>Cancel</a>
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>
</div>