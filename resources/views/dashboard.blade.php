<x-admin-layout>
    <div
        x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 1000)">
        <!-- Pulse loading animation -->

        <div x-show="loading" class="shadow rounded-md p-8 h-full w-full mx-auto my-8">
            <p class="text-2xl font-bold animate-pulse">Loading...</p>
        </div>
        <!-- Livewire component -->
        <div x-show="!loading">
            <div class="py-12">
                <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
                    <!-- Welcome Content -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h1 class="uppercase text-2xl font-bold text-yellow-700 text-center">Your Gateway to success welcome back. goldenian</h1>
                    </div>

                    <!-- Users Count Content -->
                    <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Accounts</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                                <x-application-logo class="w-20 h-20" />
                                <h1 class="font-bold text-gray-700 text-start">Total Students <span class="text-gray-700 text-sm my-2">231</span> </h1>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                                <x-application-logo class="w-20 h-20" />
                                <h1 class="font-bold text-gray-700 text-start">Total Professors <span class="text-gray-700 text-sm my-2">50</span></h1>
                            </div>
                        </div>
                    </div>

                    <!-- Users Count Content -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                                <x-application-logo class="w-20 h-20" />
                                <h1 class="font-bold text-gray-700 text-start">Total staff <span class="text-gray-700 text-sm my-2">231</span> </h1>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                                <x-application-logo class="w-20 h-20" />
                                <h1 class="font-bold text-gray-700 text-start">Total Department <span class="text-gray-700 text-sm my-2">50</span></h1>
                            </div>
                        </div>
                    </div>

                    <!-- Mission and Vision -->
                    <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Mission and Vision</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-lime-900 overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-start rounded-lg p-4">
                                <p class="text-white text-start text-xl font-bold">Mission</p>
                                <h1 class="font-bold text-white text-center">Golden Gate Colleges, as a private non-sectarian institution.</h1>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-start rounded-lg p-4">
                                <p class="text-gray-700 text-start text-xl font-bold">Vision</p>
                                <h1 class="font-bold text-gray-700 text-center">A center of educational excellence, whose graduates are global.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>