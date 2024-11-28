<div>
    <!-- User Profile -->
    <div class="flex flex-row justify-between items-center space-x-2 bg-lime-900 overflow-hidden shadow-xl sm:rounded-lg p-4">
        <div class="flex justify-center items-center flex-row space-x-2">
            <div>
                <img class="size-20 rounded-full object-cover" src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </div>
            <div>
                <h1 class="text-white text-lg font-bold">{{ Auth::user()->name }}</h1>
                <p class="text-white text-sm font-semibold">3rd year, BSIT</p>
                <p class="text-white text-sm">{{ Auth::user()->email }}</p>
                <p class="text-white text-sm">Second Semester AY 2024-2025</p>
                <p class="text-lime-400 text-sm">ENROLLED</p>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <x-application-logo class="w-20 h-20" />
        </div>
    </div>
</div>