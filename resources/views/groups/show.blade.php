<x-app-layout>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-12 py-12">
        <div class="mb-6">
            <p class="font-semibold text-lg text-center"><span>GRUPO: </span>{{ $chat->name }}</p>
        </div>
        @livewire('add-contacts', ['chat' => $chat])
    </div>
    @push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            Livewire.on('contact-delete',function(){
                toastr.success('contacto eliminado del grupo correctamente');

            });
            Livewire.on('contact-add',function(){
                toastr.success('contacto agregado al grupo correctamente');
                
            });
        </script>
    @endpush
</x-app-layout>