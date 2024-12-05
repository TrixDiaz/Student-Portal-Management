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
                    <div class="p-4 bg-white rounded-lg shadow">
                        <p class="text-gray-700">{{ $roomSection->subject->name }}</p>
                        <p class="text-sm text-gray-500">Code: {{ $roomSection->subject->code }}</p>
                        <p class="text-sm text-gray-500">Semester: {{ ucfirst($roomSection->semester) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>