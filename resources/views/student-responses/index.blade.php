<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Filters Section --}}
                    <div class="mb-6">
                        <form method="GET" class="flex gap-4">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                <select name="department" id="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="teacher" class="block text-sm font-medium text-gray-700">Teacher</label>
                                <select name="teacher" id="teacher" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Teachers</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    @foreach($evaluations as $evaluation)
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ $evaluation->title }}</h2>

                        <div class="overflow-x-auto bg-white rounded-lg shadow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Responses</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($evaluation->teacherResponses as $teacherId => $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data['teacher']->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data['department']->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data['total_responses'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data['completed_responses'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('student-responses.show', ['evaluation' => $evaluation, 'teacher_id' => $data['teacher']->id]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                View Summary
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>