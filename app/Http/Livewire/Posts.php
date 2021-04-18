<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $title, $body, $image, $postId = null, $newImage;
    public $showModalForm = false;
    public function showCreatePostsModal(){

        $this->showModalForm=true;
    
    }
    public function updateShowModalForm(){
        $this->reset();
    } 

    public function storePost(){
        $this->validate([
            'title'=>'required',
            'body'=>'required',
            'image'=>'required|image',
        ]);
        
        $image_name = $this->image->getClientOriginalName();
        $this->image->storeAs('public/photos/', $image_name);
        $post = new Post();
        $post -> user_id=auth()->user()->id;
        $post->title=$this->title;
        $post->slug=Str::slug($this->title);
        $post->body=$this->body;
        $post->image=$image_name;
        $post->save();
        $this->reset();
        session()->flash('flash.banner', 'Success Create New Post');

    }

    public function showEditPostModal($id){
        $this->reset();
        $this->showModalForm=true;
        $this->postId = $id;
        $this->loadEditForm();
    } 

    public function loadEditForm(){
        $post = Post::findOrFail($this->postId); 
        $this->title = $post->title;
        $this->body = $post->body;
        $this->newImage = $post->image;
    }   
    public function updatePost(){
        $this->validate([
            'title'=>'required',
            'body'=>'required',
            'image'=>'nullable',
        ]);

        if($this->image){
            Storage::delete('public/photos/' , $this->newImage);
              $this->newImage = $this->image->getClientOriginalName();
              $this->image->storeAs('public/photos/',$this->newImage);
        }
        Post::find($this->postId)->update([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->newImage
        ]);
        $this->reset();
        session()->flash('flash.banner', 'Success Update Post');
    } 
    public function deletePost($id){
        $post = Post::findOrFail($id); 
        Storage::delete('public/photos/' , $post->image);
        $post->delete();
        session()->flash('flash.banner', 'Success Delete Post');
    }   
    public function render()
    {
        return view('livewire.posts',[
            'posts'=>Post::orderBy('created_at','DESC')->paginate(2)
        ]);

    }

}
