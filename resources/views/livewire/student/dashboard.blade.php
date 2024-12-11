<div>
    <div>
        <livewire:student.tab />

        <!-- Filtering Controls -->
        <div class="my-4 flex gap-4">

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
                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                <select wire:model.live="selectedSemester" id="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">All Semesters</option>
                    @foreach($semesters as $semester)
                    <option value="{{ $semester }}">{{ ucfirst($semester) }} Semester</option>
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
            <div wire:key="{{ $roomSection->room_section_id }}"
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
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        @php
                        $evaluationStatus = $this->checkEvaluationStatus($roomSection->room_section_id);
                        $grade = $evaluationStatus['grade'];
                        $evaluationResponse = $evaluationStatus['evaluationResponse'];
                        @endphp

                        <div class="flex space-x-2">
                            @if(!$evaluationResponse && $roomSection->room_section_id)
                            <button
                                wire:click="redirectToEvaluation({{ $roomSection->room_section_id }})"
                                class="flex-1 bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition-colors duration-300">
                                Answer Evaluation
                            </button>
                            @else
                            @if($grade)
                            <div @click="$dispatch('open-modal-' + {{ $roomSection->room_section_id }})" class="flex-1 flex justify-between items-center cursor-pointer">
                                <span class="font-medium text-gray-700">Grade: {{ $grade->grade }}</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $grade->status === 'Passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $grade->status }}
                                </span>
                            </div>

                            <!-- View details -->
                            <div>
                                <button @click="$dispatch('open-modal-' + {{ $roomSection->room_section_id }})" class="flex-1 flex p-1 shadow-sm bg-green-500 text-white rounded-md px-2 justify-between items-center cursor-pointer w-auto">
                                    <span class="font-medium text-white text-sm">View Details</span>
                                </button>
                            </div>

                            @if($grade && $grade->student_id === auth()->id())
                            <div x-data="{ 
                            show: false,
                            init() {
                                this.$watch('show', value => {
                                    if (value) {
                                        this.$nextTick(() => {
                                            const gradeData = @js($grade);
                                            if (gradeData && gradeData.student_id === {{ auth()->id() }}) {
                                                const quizData = gradeData.quiz_scores;
                                                this.initQuizChart(quizData);
                                                this.initGradeChart(
                                                    {{ $grade->prelim_grade ?? 0 }}, 
                                                    {{ $grade->midterm_grade ?? 0 }}, 
                                                    {{ $grade->final_grade ?? 0 }}
                                                );
                                            }
                                        })
                                    }
                                })
                            },
                            initQuizChart(quizData) {
                                // Extract quiz scores from the correct structure
                                const quizzes = quizData.quizzes || [];
                                const scores = quizzes.map(quiz => ({
                                    score: parseFloat(quiz.quiz_score) || 0,
                                    over: parseFloat(quiz.quiz_over) || 0,
                                    percentage: parseFloat(quiz.percentage) || 0,
                                    name: quiz.quiz_name
                                }));

                                const quizOptions = {
                                    series: [{
                                        name: 'Score',
                                        data: quizzes.map(q => parseFloat(q.quiz_score)),
                                    }, {
                                        name: 'Perfect Score',
                                        data: quizzes.map(q => parseFloat(q.quiz_over)),
                                    }, {
                                        name: 'Percentage',
                                        data: quizzes.map(q => parseFloat(q.percentage)),
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 200,
                                        stacked: false,
                                    },
                                    title: {
                                        text: 'Quiz Performance',
                                        align: 'center'
                                    },
                                    xaxis: {
                                        categories: quizzes.map(q => q.quiz_name),
                                    },
                                    yaxis: [
                                        {
                                            title: {
                                                text: 'Score'
                                            },
                                        },
                                        {
                                            opposite: true,
                                            title: {
                                                text: 'Percentage (%)'
                                            }
                                        }
                                    ],
                                    plotOptions: {
                                        bar: {
                                            borderRadius: 5,
                                            dataLabels: {
                                                position: 'top',
                                            }
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true,
                                        formatter: function (val, opts) {
                                            // Format based on series name
                                            if (opts.seriesIndex === 2) { // Percentage series
                                                return val.toFixed(2) + '%';
                                            }
                                            return val.toFixed(2);
                                        },
                                        offsetY: -20,
                                        style: {
                                            fontSize: '12px',
                                            colors: ['#304758']
                                        }
                                    },
                                    colors: ['#FFA500', '#FFD700', '#4CAF50'],
                                    tooltip: {
                                        shared: true,
                                        intersect: false,
                                        y: [{
                                            formatter: function (val) {
                                                return val.toFixed(2);
                                            }
                                        }, {
                                            formatter: function (val) {
                                                return val.toFixed(2);
                                            }
                                        }, {
                                            formatter: function (val) {
                                                return val.toFixed(2) + '%';
                                            }
                                        }]
                                    }
                                };

                                // Add total/average information
                                const totalSection = {
                                    series: [{
                                        name: 'Totals',
                                        data: [
                                            parseFloat(quizData.quiz_total) || 0,
                                            parseFloat(quizData.quiz_over_total) || 0,
                                            parseFloat(quizData.total_percentage) || 0
                                        ]
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Quiz Summary',
                                        align: 'center'
                                    },
                                    xaxis: {
                                        categories: ['Total Score', 'Perfect Score', 'Overall Percentage'],
                                    },
                                    plotOptions: {
                                        bar: {
                                            borderRadius: 5,
                                            dataLabels: {
                                                position: 'top',
                                            }
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true,
                                        formatter: function (val, opts) {
                                            if (opts.dataPointIndex === 2) { // Percentage
                                                return val.toFixed(2) + '%';
                                            }
                                            return val.toFixed(2);
                                        },
                                        offsetY: -20,
                                        style: {
                                            fontSize: '12px',
                                            colors: ['#304758']
                                        }
                                    },
                                    colors: ['#2196F3']
                                };

                                // Render both charts
                                const quizChart = new ApexCharts(document.querySelector('#quiz-chart-' + {{ $roomSection->room_section_id }}), quizOptions);
                                quizChart.render();

                                const totalChart = new ApexCharts(document.querySelector('#quiz-total-chart-' + {{ $roomSection->room_section_id }}), totalSection);
                                totalChart.render();
                            },
                            initGradeChart(prelim, midterm, final) {
                                const gradeOptions = {
                                    series: [{
                                        name: 'Term Grades',
                                        data: [prelim, midterm, final]
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Term Grades',
                                        align: 'center'
                                    },
                                    xaxis: {
                                        categories: ['Prelim', 'Midterm', 'Final'],
                                    },
                                    plotOptions: {
                                        bar: {
                                            borderRadius: 5,
                                            dataLabels: {
                                                position: 'top',
                                            }
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true,
                                        formatter: function (val) {
                                            return val.toFixed(2);
                                        },
                                        offsetY: -20,
                                        style: {
                                            fontSize: '12px',
                                            colors: ['#304758']
                                        }
                                    },
                                    colors: ['#4CAF50']
                                };

                                const gradeChart = new ApexCharts(document.querySelector('#grade-chart-' + {{ $roomSection->room_section_id }}), gradeOptions);
                                gradeChart.render();
                            }
                        }"
                                @open-modal-{{ $roomSection->room_section_id }}.window="show = true"
                                @keydown.escape.window="show = false">
                                <!-- Modal Backdrop -->
                                <div x-show="show" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

                                <!-- Modal Content -->
                                <div x-show="show"
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95">

                                    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                                        <div class="p-4 border-b border-gray-200">
                                            <div class="flex justify-between items-center">
                                                <h3 class="text-xl font-bold text-gray-900">
                                                    Grade Details - {{ $roomSection->subject->name }}
                                                </h3>
                                                <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="p-6 space-y-6">
                                            <!-- Quiz Performance Charts -->
                                            <div class="space-y-6">
                                                <div id="quiz-chart-{{ $roomSection->room_section_id }}"></div>
                                                <div id="quiz-total-chart-{{ $roomSection->room_section_id }}"></div>
                                            </div>

                                            <!-- Term Grades Chart -->
                                            <div>
                                                <div id="grade-chart-{{ $roomSection->room_section_id }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <div class="flex-1 text-center text-gray-500 italic">
                                Grade not released yet
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</div>