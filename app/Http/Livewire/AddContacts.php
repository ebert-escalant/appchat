<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\Contact;
use Livewire\Component;

class AddContacts extends Component
{
    public $chat;
    /* public $cth=[]; */
    protected $listeners=['renderizar'=>'render'];
    public function mount($chat){
        $this->chat=$chat;
    }
    public function render()
    {
        $contacts=auth()->user()->contacts()->paginate();
        return view('livewire.add-contacts',compact('contacts'));
    }
    public function remove(Contact $contact){
        $this->chat->users()->detach($contact->contact_id);
        $this->emit('renderizar');
        $this->emit('contact-delete');
    }
    
    public function add(Contact $contact){
        $this->chat->users()->attach($contact->contact_id);
        $this->emit('renderizar');
        $this->emit('contact-add');
    }
}
