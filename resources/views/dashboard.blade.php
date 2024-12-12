<!-- Admin and other Content -->
@if (auth()->user()->hasRole(['admin', 'teacher', 'dean']))
<x-admin-layout>
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8 ">

                <!-- Welcome Content -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1 class="uppercase text-2xl font-bold text-yellow-700 text-center">Your Gateway to success welcome back. {{ config('app.name') }}</h1>
                </div>

                @if(auth()->user()->hasRole('admin'))
                <!-- Users Count Content -->
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start my-8">Accounts</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                            <x-application-logo class="w-20 h-20" />
                            <h1 class="font-bold text-gray-700 text-start">Total Students <span class="text-gray-700 text-sm my-2">
                                    @php
                                    $totalStudents = App\Models\User::whereHas('roles', function($query) {
                                    $query->where('name', 'student');
                                    })->count();
                                    @endphp
                                    {{ $totalStudents }}
                                </span> </h1>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                            <x-application-logo class="w-20 h-20" />
                            <h1 class="font-bold text-gray-700 text-start">Total Professors <span class="text-gray-700 text-sm my-2">
                                    @php
                                    $totalTeachers = App\Models\User::whereHas('roles', function($query) {
                                    $query->where('name', 'teacher');
                                    })->count();
                                    @endphp
                                    {{ $totalTeachers }}
                                </span></h1>
                        </div>
                    </div>
                </div>



                <!-- Users Count Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 my-8 gap-4">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                            <x-application-logo class="w-20 h-20" />
                            <h1 class="font-bold text-gray-700 text-start">Total staff <span class="text-gray-700 text-sm my-2">
                                    @php
                                    $totalStaff = App\Models\User::whereHas('roles', function($query) {
                                    $query->where('name', 'teacher')->where('name', 'dean');
                                    })->count();
                                    @endphp
                                    {{ $totalStaff }}
                                </span> </h1>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                            <x-application-logo class="w-20 h-20" />
                            <h1 class="font-bold text-gray-700 text-start">Total Department <span class="text-gray-700 text-sm my-2">
                                    @php
                                    $totalDepartment = App\Models\Department::count();
                                    @endphp
                                    {{ $totalDepartment }}
                                </span></h1>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Mission and Vision -->
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start my-8">Mission and Vision</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-lime-900 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-start rounded-lg p-4">
                            <p class="text-white text-start text-xl font-bold">Mission</p>
                            <h1 class="font-bold text-white text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, praesentium? Aperiam ab neque quibusdam ex?</h1>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-start rounded-lg p-4">
                            <p class="text-gray-700 text-start text-xl font-bold">Vision</p>
                            <h1 class="font-bold text-gray-700 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, praesentium? Aperiam ab neque quibusdam ex?</h1>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->hasRole('teacher'))
                <!-- Teacher Dashboard Student Count -->
                <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start my-8">Student Count</h1>
                @php
                $totalStudents = 0;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($roomSections as $roomSection)
                    @php
                    $subject = $roomSection->subject;
                    $studentCount = $roomSection->students->count();
                    $totalStudents += $studentCount;
                    @endphp
                    <a href="{{ route('teacher.room', ['subject_id' => $subject->id]) }}">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <div class="flex flex-col justify-center items-center border-2 border-gray-200 rounded-lg p-4">
                                <x-application-logo class="w-20 h-20" />
                                <h1 class="font-bold text-gray-700">Section: {{ $roomSection->section->name }}</h1>
                                <p class="text-gray-700 text-sm">Subject: {{ $subject->name }}</p>
                                <p class="text-gray-700 text-sm my-2">Total Students: {{ $studentCount }}</p>
                                <p class="text-gray-700 text-sm">Room: {{ $roomSection->room->name }}</p>
                                <p class="text-gray-700 text-sm">Teacher: {{ $roomSection->teacher->name }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $roomSections->links() }}
                </div>

                <!-- Total Students Card -->
                <div class="mt-4">
                    <div class="bg-yellow-700 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex flex-col justify-center items-center border-2 border-yellow-600 rounded-lg p-4">
                            <h1 class="font-bold text-white text-xl">Total Students Across All Subjects</h1>
                            <p class="text-white text-2xl font-bold my-2">{{ $totalStudents }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
@else
<x-app-layout>
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
                <livewire:student.dashboard />
            </div>
        </div>
    </div>
</x-app-layout>
@endif