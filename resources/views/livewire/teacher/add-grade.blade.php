<div>
    <div x-data="{ show: @entangle('showModal') }"
        x-show="show"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Add Grade</h3>

                    <div class="mt-4">
                        <label for="grade" class="block text-sm font-medium text-gray-700">Grade (1-5)</label>
                        <input type="number"
                            wire:model="grade"
                            step="0.01"
                            min="1"
                            max="5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('grade') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4 flex space-x-3">
                        <button @click="show = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button wire:click="saveGrade" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Save Grade
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>