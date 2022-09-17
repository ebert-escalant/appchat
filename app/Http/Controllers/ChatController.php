<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $groups=auth()->user()->chats()->where('is_group',1)->get();
        return view('groups.index',compact('groups'));
    }
    public function create()
    {
        return view('groups.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $chat=new Chat();
        $chat->name=$request->name;
        $chat->is_group=true;
        if ($request->file('image')) {
            $path=Storage::disk('public')->put('chats', $request->file('image'));
            $chat->image_url=$path;
        }
        $chat->save();
        $chat->users()->attach(auth()->user()->id);
        session()->flash('flash.banner','chat de grupo creado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($chat)
    {
        $chat= Chat::find($chat);
        return view('groups.show',compact('chat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit($chat)
    {
        $chat= Chat::find($chat);
        return view('groups.edit',compact('chat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chat)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $chat=Chat::find($chat);
        $chat->name=$request->name;
        if ($request->file('image')) {
            $path=Storage::disk('public')->put('chats', $request->file('image'));
            if($chat->image_url){
                Storage::disk('public')->delete($chat->image_url);
            }
            $chat->image_url=$path;
        }
        $chat->save();
        session()->flash('flash.banner','chat de grupo actualizado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat)
    {
        $chat=Chat::find($chat);
        foreach($chat->users as $user){
            $user->chats()->detach($chat->id);
        }
        if($chat->image_url){
            Storage::disk('public')->delete($chat->image_url);
        }
        $chat->delete();
        session()->flash('flash.banner','chat de grupo eliminado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('groups.index');
    }
}
