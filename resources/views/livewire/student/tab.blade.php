<div>
    <style>
        @media print {
            @page {
                size: 3.375in 2.125in landscape;
                margin: 0;
            }

            body * {
                visibility: hidden;
            }

            #id-card,
            #id-card * {
                visibility: visible;
            }

            #id-card {
                position: fixed;
                top: 0;
                left: 0;
                width: 3.375in;
                height: 2.125in;
                margin: 0;
                padding: 0;
                background: white;
                border-radius: 0.5rem;
                border: 2px solid rgb(47, 84, 15);
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            /* Header section */
            #id-card .bg-lime-900 {
                background-color: rgb(47, 84, 15) !important;
                padding: 0.3rem !important;
                height: auto !important;
                flex: 0 0 auto;
            }

            /* Logo */
            #id-card .w-16 {
                width: 1.5rem !important;
                height: 1.5rem !important;
                margin: 0 auto !important;
            }

            /* School name */
            #id-card .text-xl {
                font-size: 0.9rem !important;
                margin-top: 0.1rem !important;
                font-weight: bold !important;
            }

            /* Profile photo */
            #id-card .w-32 {
                width: 2.5rem !important;
                height: 2.5rem !important;
                border: 2px solid rgb(47, 84, 15) !important;
                margin: 0.2rem auto !important;
            }

            /* Student info section */
            #id-card .space-y-4 {
                padding: 0.3rem !important;
                text-align: center !important;
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 0.2rem !important;
            }

            /* Student name */
            #id-card .text-lime-900 {
                color: rgb(47, 84, 15) !important;
                font-size: 0.9rem !important;
                margin-bottom: 0.2rem !important;
                font-weight: bold !important;
            }

            /* Other text */
            #id-card .text-gray-600 {
                color: rgb(75, 85, 99) !important;
                font-size: 0.7rem !important;
                margin: 0 !important;
                line-height: 1.2 !important;
            }

            /* Remove any spacing utilities that might interfere */
            #id-card .space-y-2,
            #id-card .mt-4,
            #id-card .mt-2 {
                margin: 0 !important;
            }

            /* Adjust the student info container */
            #id-card .text-center.space-y-2 {
                display: flex;
                flex-direction: column;
                gap: 0.1rem !important;
            }

            /* Hide modal elements */
            .modal-container,
            .print\:hidden {
                display: none !important;
            }
        }
    </style>
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
        <div @click="$dispatch('open-modal', { id: {{ Auth::user()->id }} })" class="flex flex-col justify-center items-center cursor-pointer">
            <x-icons.identification class="w-20 h-20" />
            <x-label class="text-white text-lg font-bold">View Identification Card</x-label>
        </div>

        <!-- Modal ID Card -->
        <div x-data="{ 
            showModal: false, 
            userId: null,
            printId() {
                setTimeout(() => {
                    window.print();
                }, 100);
            }
        }"
            @open-modal.window="showModal = true; userId = $event.detail.id"
            x-show="showModal"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-xl font-semibold">Student ID Card</h3>
                        <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- ID Card Content -->
                    <div class="p-6">
                        <div id="id-card" class="w-full bg-white border-2 border-lime-900 rounded-lg overflow-hidden">
                            <!-- School Header -->
                            <div class="bg-lime-900 p-4 text-center">
                                <x-application-logo class="w-16 h-16 w-auto mx-auto" />
                                <h2 class="text-white text-xl font-bold mt-2">{{ config('app.name') }}</h2>
                            </div>

                            <!-- Student Info -->
                            <div class="p-4 space-y-4">
                                <div class="flex justify-center">
                                    <img class="w-32 h-32 rounded-full border-4 border-lime-900 object-cover"
                                        src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}">
                                </div>

                                <div class="text-center space-y-2">
                                    <h3 class="text-xl font-bold text-lime-900">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-600 font-semibold">Student ID: {{ Auth::user()->id }}</p>
                                    <p class="text-gray-600">3rd Year - BSIT Section ABC</p>
                                    <p class="text-gray-600">Second Semester AY 2024-2025</p>
                                </div>

                                <!-- Barcode/QR (Optional) -->
                                <div class="flex justify-center mt-4">
                                    <!-- Add barcode/QR code here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-2 p-4 border-t">
                        <button @click="printId()" class="bg-lime-900 text-white px-4 py-2 rounded-md hover:bg-lime-800 print:hidden">
                            Print ID Card
                        </button>
                        <button @click="showModal = false" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 print:hidden">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>