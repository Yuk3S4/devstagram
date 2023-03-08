<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    // Variables registradas automáticamente se pasan a la vista
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if ( $this->post->checkLike(auth()->user() )) {
            auth()->user()->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }
    
    public function render()
    {
        return view('livewire.like-post');
    }

}
