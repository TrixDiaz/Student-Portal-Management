<div>
    <div class="py-12">
        <!-- ... existing breadcrumb code ... -->

        <!-- Form -->
        <div>
            <form wire:submit.prevent="updateEvaluation" method="POST" class="mx-auto space-y-8">
                <!-- Evaluation Details -->
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2 isolate bg-white rounded-md sm:p-4">
                    <div class="sm:col-span-2">
                        <x-label for="title">Evaluation Title</x-label>
                        <div class="mt-2.5">
                            <x-input type="text" wire:model="title" name="title" id="title" class="block w-full" placeholder="Enter evaluation title" />
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="description">Evaluation Description</x-label>
                        <div class="mt-2.5">
                            <textarea wire:model="description" name="description" id="description" rows="3" class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Phases -->
                @foreach($phases as $phaseIndex => $phase)
                <div class="bg-white rounded-md p-4 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Phase {{ $phaseIndex + 1 }}</h3>
                        @if($phaseIndex > 0)
                        <button type="button" wire:click="removePhase({{ $phaseIndex }})" class="text-red-600 hover:text-red-800">
                            <x-icons.trash-icon class="w-5 h-5" />
                        </button>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <x-label for="phases.{{ $phaseIndex }}.title">Phase Title</x-label>
                            <x-input type="text" wire:model="phases.{{ $phaseIndex }}.title" class="block w-full mt-1" />
                            @error("phases.{$phaseIndex}.title") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Questions for this phase -->
                        @foreach($phase['questions'] as $questionIndex => $question)
                        <div class="ml-4 p-4 border border-gray-200 rounded-md">
                            <div class="flex justify-between items-center">
                                <h4 class="text-md font-medium">Question {{ $questionIndex + 1 }}</h4>
                                <button type="button" wire:click="removeQuestion({{ $phaseIndex }}, {{ $questionIndex }})" class="text-red-600 hover:text-red-800">
                                    <x-icons.trash-icon class="w-4 h-4" />
                                </button>
                            </div>
                            <div class="mt-2">
                                <x-label for="phases.{{ $phaseIndex }}.questions.{{ $questionIndex }}.question_text">Question Text</x-label>
                                <x-input type="text" wire:model="phases.{{ $phaseIndex }}.questions.{{ $questionIndex }}.question_text" class="block w-full mt-1" />
                                @error("phases.{$phaseIndex}.questions.{$questionIndex}.question_text")
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endforeach

                        <button type="button" wire:click="addQuestion({{ $phaseIndex }})" class="text-indigo-600 hover:text-indigo-800">
                            + Add Question
                        </button>
                    </div>
                </div>
                @endforeach

                <div class="flex justify-center">
                    <button type="button" wire:click="addPhase" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                        + Add Phase
                    </button>
                </div>

                <div class="flex justify-end space-x-4 mt-4">
                    <x-secondary-button type="button">
                        <a href="{{ route('admin.evaluations') }}" wire:navigate>Cancel</a>
                    </x-secondary-button>
                    <x-button type="submit">Update Evaluation</x-button>
                </div>
            </form>
        </div>
    </div>
</div>