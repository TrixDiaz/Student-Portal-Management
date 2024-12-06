<div>
    <livewire:student.tab />

    <div class="my-2">
        <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Subjects</h1>
    </div>

    <div class="mb-4 flex gap-4">
        <div>
            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
            <select wire:model.live="selectedSemester" id="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                <option value="">All Semesters</option>
                @foreach($semesters as $semester)
                <option value="{{ $semester }}">{{ $semester }} Semester</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
            <select wire:model.live="selectedYear" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                @foreach($availableYears as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <p>Total Subjects for
            {{ $selectedSemester ? ucfirst($selectedSemester) . ' Semester' : 'All Semesters' }},
            {{ $selectedYear }}: {{ $totalSubjects }}
        </p>

        <div class="mt-6">
            @foreach($subjects as $room)
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ $room->name }}</h3>
                <div class="mt-2 space-y-2">
                    @foreach($room->roomSections as $roomSection)
                    <div wire:key="{{ $roomSection->id }}" class="p-4 bg-white rounded-lg shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-700">{{ $roomSection->subject->name }}</p>
                                <p class="text-sm text-gray-500">Code: {{ $roomSection->subject->code }}</p>
                                <p class="text-sm text-gray-500">Semester: {{ ucfirst($roomSection->semester) }}</p>
                            </div>
                            <x-secondary-button @click="$dispatch('open-grade-modal', { id: {{ $roomSection->id }} })">
                                View Grade
                            </x-secondary-button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>


        <!-- Show Grade Modal -->
        <div x-data="{ showGradeModal: false, gradeId: null }"
            @open-grade-modal.window="showGradeModal = true; gradeId = $event.detail.id"
            x-show="showGradeModal"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showGradeModal = false"></div>

                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Grade</h3>
                        <p class="mt-2 text-sm text-gray-500">Your Grade for this subject is: 82</p>
                        <p class="mt-2 text-sm text-green-500">Passed</p>

                        <div class="mt-4 flex space-x-3">
                            <button @click="showGradeModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Cancel
                            </button>
                            <button @click="$wire.sendEvaluation(gradeId); showGradeModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Send Evaluation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>