<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between mb-8">
            <a class="bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm py-2 px-4 border-b-4 border-teal-700 hover:border-teal-800 rounded uppercase inline-flex items-center"
                href="{{ route('chat') }}">
                <i class="fa fa-arrow-left text-white mr-2 text-lg"></i>
                Volver al chat
            </a>
            <a class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm py-2 px-4 border-b-4 border-blue-700 hover:border-blue-800 rounded uppercase inline-flex items-center"
                href="{{ route('groups.create') }}">
                <i class="fa fa-plus text-white mr-2 text-lg"></i>
                Nuevo Chat de Grupo
            </a>
        </div>
        @if ($groups->count())
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6" width="15%">
                            </th>
                            <th scope="col" class="py-3 px-6" width="70%">
                                Nombre de grupo
                            </th>
                            <th scope="col" class="py-3 px-6" width="15%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                
                                <td class="py-4 px-6">
                                    @if ($group->image_url)
                                    <img src="{{ Storage::url($group->image_url) }}" alt="{{ $group->name }}" class="w-16 h-16 object-cover object-center rounded-full">
                                    @else
                                    <img
                                    src="https://cdn.pixabay.com/photo/2016/04/22/04/57/graduation-1345143__340.png"
                                    class="h-16 w-16 object-cover object-center rounded-full"
                                    alt="sin foto"
                                    />
                                    @endif
                                </td>
                                <th scope="row"
                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $group->name }}
                                </th>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end space-x-4">
                                        <a href="{{ route('groups.show',$group) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 ">
                                            <i class="fas fa-eye text-lg text-sky-600"></i>
                                        </a>
                                        <a href="{{ route('groups.edit',$group) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500">
                                            <i class="fas fa-edit text-lg text-emerald-600"></i>
                                        </a>
                                        
                                        <form action="{{ route('groups.destroy',$group) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="font-medium text-blue-600 dark:text-blue-500">
                                                <i class="fas fa-trash-alt text-lg text-red-600"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-alert-one type="info">
                Usted no tiene chats de grupo
            </x-alert-one>
        @endif
    </div>
</x-app-layout>
