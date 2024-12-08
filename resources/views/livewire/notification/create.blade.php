<div>
    <div>
        <div class="py-12">
            <!-- Breadcrump -->
            <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                Notifications
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
                    <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Notifications</h1>
                    <a wire:navigate href="{{ route('admin.notifications.create') }}">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
            @endif

            <form wire:submit="sendNotification">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notification Title</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea wire:model="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Send Notification
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>