<div>
    <div class="container mx-auto py-4">
        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Skills</h1>
        </div>
        {{-- TODO: Add table here and a form to create a new skill --}}
        <div class="p-4">
            <form wire:submit.prevent="save" class="space-y-2 mb-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Add new skill</h1>
                </div>
                <input type="text" wire:model="name" class="input" placeholder="Enter Skill Name" />
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    {{ $editId ? 'Update' : 'Add' }} Skill
                </button>
            </form>
        
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr ><th scope="col" class="px-6 py-3">Skill</th><th scope="col" class="px-6 py-4 text-right">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($skills as $skill)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td>{{ $skill->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="edit({{ $skill->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-red-700 rounded">Edit</button>
                            <button wire:click="delete({{ $skill->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
