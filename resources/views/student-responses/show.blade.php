<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <header class="mb-6">
                    <h2 class="text-2xl font-bold">
                        {{ $evaluation->title }}
                    </h2>
                    <div class="mt-2 text-gray-600">
                        <span class="mr-4">Teacher: {{ $teacher->name }}</span>
                        <span class="mr-4">Total Responses: {{ $responses->count() }}</span>
                    </div>
                </header>

                <div class="space-y-8">
                    @foreach($phases as $phase)
                    <section class="border-t pt-6">
                        <h3 class="text-xl font-semibold mb-4">{{ $phase->title }}</h3>
                        <div class="space-y-6">
                            @foreach($phase->questions as $question)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium text-gray-800 mb-4">{{ $question->question }}</p>

                                @php
                                $ratings = array_replace([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0], $question->aggregatedResponses);
                                @endphp

                                <div class="h-64">
                                    <div id="chart{{ $question->id }}"></div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var options = {
                                            series: [{
                                                name: 'Number of Ratings',
                                                data: Object.values(@json($ratings))
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 256
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 4,
                                                    dataLabels: {
                                                        position: 'top',
                                                    },
                                                }
                                            },
                                            xaxis: {
                                                categories: ['1', '2', '3', '4', '5'],
                                                title: {
                                                    text: 'Rating'
                                                }
                                            },
                                            yaxis: {
                                                title: {
                                                    text: 'Number of Responses'
                                                },
                                                min: 0,
                                                forceNiceScale: true,
                                                labels: {
                                                    formatter: function(val) {
                                                        return Math.floor(val);
                                                    }
                                                }
                                            }
                                        };

                                        var chart = new ApexCharts(document.querySelector("#chart{{ $question->id }}"), options);
                                        chart.render();
                                    });
                                </script>
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