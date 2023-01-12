<?php

namespace App\Http\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Notifications\Test;
use Illuminate\Notifications\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Posts extends Component
{
    use WithPagination,WithFileUploads;
    public $posts, $title, $body,$category, $post_id,$user;
    public $orderBy = 'title';
    public $sortBy = 'asc';
    public $search;
    public $photo;
    public $byCategory= null;
    public $perPage = null;
    public $updateMode = false;
    public function render()
    {
       $posts = $this->posts = Post::when($this->byCategory,function($query){
            $query->where('category',$this->byCategory);
        })->search(trim($this->search))->orderBy($this->orderBy,$this->sortBy)->get();
        $messages = Message::with('user')->get();

        return view('livewire.posts', compact('posts','messages'));
    }
    private function resetInputFields()
    { // using to reset fields and make them empty.
        $this->title = '';
        $this->body = '';
    }
    public function store()
    {
            $user = User::first();
            $items = $this->validate([
                'body' => 'required',
                'title' => 'required',
                'category' => 'required',
                'photo' => 'required|image|max:1024', // 1MB Max
            ]);
            $path =  $this->photo->store('photos','public');
            $items['photo'] = $path;
            Post::create($items);
            session()->flash('message', 'Post Created Successfully.');
            $this->resetInputFields();
            $user->notify(new Test($user));

    }
    public function show()
    {
        dd('show');
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->category = $post->category;
        $this->photo = $post->photo;

        $this->updateMode = true;
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function fetchMessages()
    {
        $messages = Message::with('user')->get();
        return $messages;
    }
    public function sendMessage(Request $request)
    {
      $user = Auth::user();
    
      $message = $user->messages()->create([
        'message' => $request->input('message')
      ]);
    
      broadcast(new MessageSent($user, $message))->toOthers();
    
    //   return ['status' => 'Message Sent!'];
    }
    public function markasread($not)
    {
        if($not['id']){
            auth()->user()->unreadNotifications->where('id',$not['id'])->markAsRead();
        }
        // $this->user->unreadNotifications->where('id',$not->id)->markAsRead();
    }
    public function update()
    {
        $validate = $this->validate([
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'photo' => 'required',
        ]);

        $post = Post::find($this->post_id);
        $post->update([
            'title' => $this->title,
            'body' => $this->body,
            'category' => $this->category,
            'photo' => $this->photo,
        ]);
        $path = $this->photo->store('photos','public');
        $post->photo = $path;
        $post->save();


        $this->updateMode = false;

        session()->flash('message', 'Post Updated Successfully.');
        $this->resetInputFields();
    }
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
