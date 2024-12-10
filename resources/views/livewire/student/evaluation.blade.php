<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Teacher Evaluation</h2>
            <p class="mb-4">Subject: {{ $roomSection->subject->name }}</p>
            <p class="mb-4">Code: {{ $roomSection->subject->code }}</p>
            <p class="mb-4">Semester: {{ ucfirst($roomSection->semester) }}</p>
            <p class="mb-4">Section: {{ $roomSection->section->name }}</p>
            <p class="mb-4">Room: {{ $roomSection->room->name }}</p>
            <p class="mb-4">Instructor: {{ $roomSection->teacher->name }}</p>
            @if(count($evaluationResponses) > 0)
            {{-- Show completed evaluation responses --}}
            @foreach($phases as $phase)
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">{{ $phase->name }}</h3>

                @foreach($phase->questions->sortBy('order') as $question)
                <div class="mb-6">
                    <p class="mb-2">{{ $question->question }}</p>
                    <div class="flex space-x-4">
                        <p class="font-semibold">Your Rating: {{ $evaluationResponses[$question->id] ?? 'N/A' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
            @else
            {{-- Show evaluation form --}}
            <form wire:submit.prevent="submitEvaluation">
                @foreach($phases as $phase)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">{{ $phase->name }}</h3>

                    @foreach($phase->questions->sortBy('order') as $question)
                    <div class="mb-6">
                        <p class="mb-2">{{ $question->question }}</p>
                        <div class="flex space-x-4">
                            @foreach(range(1, 5) as $rating)
                            <label class="flex items-center">
                                <input type="radio"
                                    wire:model="evaluationResponses.{{ $question->id }}"
                                    value="{{ $rating }}"
                                    class="form-radio">
                                <span class="ml-2">{{ $rating }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('evaluationResponses.' . $question->id)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @endforeach
                </div>
                @endforeach

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Submit Evaluation
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>