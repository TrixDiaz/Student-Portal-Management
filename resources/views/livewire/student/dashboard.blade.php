<div>
    <div>
        <livewire:student.tab />

        <!-- Filtering Controls -->
        <div class="mb-4 flex gap-4">
            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                <select wire:model.live="selectedSemester" id="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">All Semesters</option>
                    @foreach($semesters as $semester)
                    <option value="{{ $semester }}">{{ ucfirst($semester) }} Semester</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                <select wire:model.live="selectedYearLevel" id="year_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">All Year Levels</option>
                    @foreach($yearLevels as $yearLevel)
                    <option value="{{ $yearLevel }}">{{ $yearLevel }} Year</option>
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

        <!-- Total Subjects Counter -->
        <div class="my-4">
            <p class="text-2xl font-bold text-yellow-700">
                Total Subjects: {{ $totalSubjects }}
                <span class="text-lg font-normal text-gray-600">
                    ({{ $selectedSemester ? ucfirst($selectedSemester) . ' Semester' : 'All Semesters' }},
                    {{ $selectedYearLevel ? ucfirst($selectedYearLevel) . ' Year' : 'All Years' }},
                    {{ $selectedYear }})
                </span>
            </p>
        </div>

        <!-- Subject Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subjects as $room)
            @foreach($room->roomSections as $roomSection)
            <div wire:key="{{ $roomSection->id }}"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <!-- Card Header -->
                <div class="bg-yellow-50 p-4 border-b border-yellow-100">
                    <h3 class="text-xl font-bold text-yellow-800">{{ $roomSection->subject->name }}</h3>
                    <p class="text-yellow-600 font-medium">{{ $roomSection->subject->code }}</p>
                </div>

                <!-- Card Body -->
                <div class="p-4 space-y-3">
                    <!-- Year Level and Semester Info (New) -->
                    <div class="flex items-center space-x-2">
                        <x-icons.academic-cap-icon class="h-5 w-5 text-gray-500" />
                        <span class="text-gray-700">{{ $roomSection->year_level }} Year | {{ ucfirst($roomSection->semester) }} Semester</span>
                    </div>

                    <!-- Section Info -->
                    <div class="flex items-center space-x-2">
                        <x-icons.user-group-icon class="h-5 w-5 text-gray-500" />
                        <span class="text-gray-700">Section: {{ $roomSection->section->name }}</span>
                    </div>

                    <!-- Room Info -->
                    <div class="flex items-center space-x-2">
                        <x-icons.building-office-icon class="h-5 w-5 text-gray-500" />
                        <span class="text-gray-700">Room: {{ $roomSection->room->name }}</span>
                    </div>

                    <!-- Schedule Info -->
                    <div class="flex items-center space-x-2">
                        <x-icons.calendar-icon class="h-5 w-5 text-gray-500" />
                        <div class="text-gray-700">
                            <div>{{ $roomSection->start_date->format('g:i A') }} - {{ $roomSection->end_date->format('g:i A') }}</div>
                            <div class="text-sm text-gray-500">{{ $roomSection->start_date->format('M d, Y') }}</div>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    <div class="flex items-center space-x-2">
                        <x-icons.academic-cap-icon class="h-5 w-5 text-gray-500" />
                        <span class="text-gray-700">Instructor: {{ $roomSection->teacher->name }}</span>
                    </div>

                    <!-- Grade and Status -->
                    @php
                    $grade = App\Models\StudentGrade::where('room_section_id', $roomSection->id)
                    ->where('student_id', auth()->id())
                    ->first();

                    $evaluationResponse = App\Models\EvaluationResponse::where('room_section_id', $roomSection->id)
                    ->where('user_id', auth()->id())
                    ->first();
                    @endphp

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        @if($grade && (!$evaluationResponse || !$evaluationResponse->is_completed))
                        <button wire:click="redirectToEvaluation({{ $roomSection->id }})"
                            class="w-full bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition-colors duration-300">
                            Answer Evaluation
                        </button>
                        @elseif($evaluationResponse && $evaluationResponse->is_completed && $grade)
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Grade: {{ $grade->grade }}</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $grade->status === 'Passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $grade->status }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</div>