<?php

namespace App\Http\Livewire;

use App\Models\Chat as ModelsChat;
use App\Models\Contact;
use App\Models\Message;
use App\Notifications\NewMessage;
use App\Notifications\ReadMessage;
use App\Notifications\TypingMessage;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Chat extends Component
{
    public $search;
    public $contactChat,$chat,$chat_id;
    public $messagetext;
    public $users;

    public function mount(){
        $this->users=collect();
    }
    //listeners---oyentes
    public function getListeners(){
        $user_id=auth()->user()->id;
        //$this->emit('hola');
        return [
            "echo-notification:App.Models.User.{$user_id},notification"=>'render',
            "echo-presence:chat.1,here"=>'chatHere',
            "echo-presence:chat.1,joining"=>'chatJoining',
            "echo-presence:chat.1,leaving"=>'chatLeaving',
        ];
        
    }
    //propiedda computada
    public function getContactsProperty(){
        return Contact::where('user_id',auth()->user()->id)
                ->when($this->search,function($query){
                    $query->where(function($query){
                        $query->where('name','LIKE','%'.$this->search.'%')
                            ->orWhereHas('user',function($query){
                                $query->where('email','LIKE','%'.$this->search.'%');
                        });
                    });
                })->get() ?? [];
    }
    public function getMessagesProperty(){
        return $this->chat ? Message::where('chat_id',$this->chat->id)->get() : [];
        //return $this->chat ? $this->chat->messages()->get() : [];
    }
    public function getChatsProperty(){
        return auth()->user()->chats()->get()->sortByDesc('last_message_at');
    }
    public function getUsersNotifyProperty(){
        return $this->chat ? $this->chat->users->where('id','!=',auth()->user()->id) :collect();
    }
    public function getUserIdProperty(){
        return auth()->user()->id;
    }
    public function getActiveProperty(){
        if($this->users_notify->first()){
            return $this->users->contains($this->users_notify->first()->id);
        }
        //return $this->users->contains($this->users_notify->first()->id);
    }
    //ciclo de vida
    public function updatedMessagetext($value){
        if($value && $this->chat){
            Notification::send($this->users_notify,new TypingMessage($this->chat->id));
        }
    }
    //metodos
    public function open_chat_contact(Contact $contact){
        $chat=auth()->user()->chats()
            ->whereHas('users',function($query) use ($contact){
                $query->where('user_id',$contact->contact_id);
            })->has('users',2)
            ->first();
        if($chat && !$chat->is_group){
            
            $this->chat=$chat;
            $this->chat_id=$chat->id;
            $this->reset('messagetext','contactChat','search');
        }else{
            $this->contactChat=$contact;
            $this->reset('messagetext','chat','search');
        }
    }
    public function open_chat(ModelsChat $chat){
        $this->chat=$chat;
        $this->chat_id=$chat->id;
        /* $chat->messages()->where('user_id','!=',auth()->user()->id)->where('is_read',false)->update([
            'is_read'=>true
        ]);
        Notification::send($this->users_notify,new ReadMessage()); */
        $this->reset('messagetext','contactChat');
    }
    public function sendMessage(){
        $this->validate([
            'messagetext'=>'required'
        ]);
        if(!$this->chat){
            $this->chat=ModelsChat::create();
            $this->chat_id=$this->chat->id;
            $this->chat->users()->sync([
                auth()->user()->id,
                $this->contactChat->contact_id
            ]);
            
        }
        $this->chat->messages()->create([
            'body'=>$this->messagetext,
            'user_id'=>auth()->user()->id
        ]);
        
        Notification::send($this->users_notify,new NewMessage());

        $this->reset('messagetext','contactChat');
    }
    public function chatHere($users){//recupera usuarios conectados
        $this->users=collect($users)->pluck('id');
    }
    public function chatJoining($user){//cuando se conecta un nuevo usuario
        $this->users->push($user['id']);
    }
    public function chatLeaving($user){//cuando se desconecta un usuario
        $this->users=$this->users->filter(function($id) use($user){
            return $id != $user['id'];
        });
    }
    public function render()
    {
        if($this->chat){
            if($this->chat->unread_messages>0){
                Notification::send($this->users_notify,new ReadMessage());
            }
            $this->chat->messages()->where('user_id','!=',auth()->user()->id)->where('is_read',false)->update([
                'is_read'=>true
            ]);
            //Notification::send($this->users_notify,new ReadMessage());
            $this->emit('scrollintoview');
        }
        return view('livewire.chat')->layout('layouts.chat');
    }
}
