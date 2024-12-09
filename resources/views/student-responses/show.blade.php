<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Header Section --}}
                <header class="mb-6">
                    <h2 class="text-2xl font-bold">
                        Responses for {{ $evaluationResponse->user->name }}
                    </h2>
                    <div class="mt-2 text-gray-600">
                        <span class="mr-4">Section: {{ $evaluationResponse->roomSection->name }}</span>
                        <span class="inline-flex items-center">
                            Status:
                            <span class="ml-1 px-2 py-1 text-sm rounded-full {{ $evaluationResponse->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $evaluationResponse->is_completed ? 'Completed' : 'Pending' }}
                            </span>
                        </span>
                    </div>
                </header>

                {{-- Responses Section --}}
                <div class="space-y-8">
                    @foreach($responsesByPhase as $phase)
                    <section class="border-t pt-6">
                        <h3 class="text-xl font-semibold mb-4">Category: {{ $phase->title }}</h3>
                        <div class="space-y-6">
                            <p>Questions:</p>
                            @foreach($phase->questions as $question)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium text-gray-800">{{ $question->question }}</p>
                                @foreach($question->responses as $response)
                                <p class="mt-2 text-gray-600">
                                    <span class="font-medium">Answer:</span>
                                    {{ $response->answer }}
                                </p>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>