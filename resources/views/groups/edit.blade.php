<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-12 py-12">
        <div class="bg-white shadow-lg rounded p-6">
            <form action="{{ route('groups.update',$chat) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-8">
                    <label for="name" class="text-sm mb-1 text-gray-700 dark:text-gray-200">Nombre del chat de grupo</label>
                    <input type="text" name="name" value="{{ $chat->name }}"
                        placeholder="ingrese nombre del chat de grupo"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                
                <div class="mb-4">
                    <div class="grid grid-cols-2">
                        <div class="post-image">
                            @if ($chat->image_url)
                                <img id="img_group" class="w-56 h-56  object-cover object-center rounded-full" src="{{ $chat->image }}" alt="">
                            @else
                                <img id="img_group" class="w-56 h-56  object-cover object-center rounded-full" src="https://cdn.pixabay.com/photo/2016/04/22/04/57/graduation-1345143__340.png" alt="">
                            @endif
                            
                        </div>
                        <div class="">
                            <label for="image" class="text-sm text-gray-700 dark:text-gray-200">Imagen del chat de grupo</label>
                            <label class="block mt-4">
                                <span class="sr-only">Choose File</span>
                                <input type="file" id="image" name="image" accept='image/*' class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-emerald-700 rounded-md hover:bg-emerald-800 focus:outline-none focus:bg-emerald-800 uppercase">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('css')
    @endpush
    @push('js')
        <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script>
            document.getElementById("image").addEventListener('change', cambiarImagen);
            function cambiarImagen(event){
                var file = event.target.files[0];

                var reader = new FileReader();
                reader.onload = (event) => {
                    document.getElementById("img_group").setAttribute('src', event.target.result);
                };

                reader.readAsDataURL(file);
            }
            //inicializr custom file
            $(function () {
                bsCustomFileInput.init();
            });
        </script>
    @endpush
</x-app-layout>