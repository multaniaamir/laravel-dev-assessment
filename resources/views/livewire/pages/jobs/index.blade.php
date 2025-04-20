<div class="container mx-auto p-6">
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Job Vacancies</h1>
        <a href="{{ route('admin.jobs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Job
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Title</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Company Logo</th>
                    <th class="py-2 px-4 border-b">Company</th>
                    <th class="py-2 px-4 border-b">Experience</th>
                    <th class="py-2 px-4 border-b">Salary</th>
                    <th class="py-2 px-4 border-b">Location</th>
                    <th class="py-2 px-4 border-b">Skills</th>
                    <th class="py-2 px-4 border-b">Job Type</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $job)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $job->title }}</td>
                        <td class="py-2 px-4 border-b">{{ Str::limit($job->description, 50, '...') }}</td>
                        <td class="py-2 px-4 border-b">
                            @if ($job->company_logo && file_exists(public_path('storage/' . $job->company_logo)))
                                <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company }}" class="h-10 w-10 object-contain">
                            @else
                                <span class="text-gray-500">No Logo</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">{{ $job->company }}</td>
                        <td class="py-2 px-4 border-b">{{ $job->experience }} years</td>
                        <td class="py-2 px-4 border-b">₹{{ number_format($job->salary, 2) }}</td>
                        <td class="py-2 px-4 border-b">{{ $job->location }}</td>
                        <td class="py-2 px-4 border-b">
                            @foreach ($job->skills as $skill)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">{{ $skill->name }}</span>
                            @endforeach
                        </td>
                        <td class="py-2 px-4 border-b">{{ $job->job_type }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <button wire:click="delete({{ $job->id }})" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-4 px-4 text-center text-gray-500">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>