<div class="bg-white shadow-lg rounded p-6">
    {{-- {{ $cth }} --}}
    @if ($contacts->count())
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Nombre
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Email
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $contact->name }}
                            </th>
                            <td class="py-4 px-6">
                                {{ $contact->user->email }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-end space-x-4">
                                    @if ($chat->users->where('id',$contact->contact_id)->count())
                                        <i class="fas fa-check  text-emerald-700"></i>
                                        <button type="button" class="font-medium text-blue-600 dark:text-blue-500"
                                            wire:click="remove({{ $contact }})">
                                            <i class="fas fa-trash-alt text-lg text-red-600"></i>
                                        </button>
                                    @else
                                        <button type="button" class="font-medium text-blue-600 dark:text-blue-500"
                                            wire:click="add({{ $contact }})">
                                            <i class="fas fa-plus text-lg text-blue-600"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-12">
            <a href="{{ route('groups.index') }}"
                class="font-medium text-blue-600 dark:text-blue-500">
                Cancelar
            </a>
        </div>
    @else
        <x-alert-one type="info">
            Usted no tiene contactos
        </x-alert-one>
    @endif
</div>
