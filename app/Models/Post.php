<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithPagination;

class Post extends Model
{
    use HasFactory,WithPagination;
    protected $table = 'posts';
    protected $fillable = [
        'title', 'body','category','photo',
    ];
    public function scopeSearch($query,$item){
        $item = "%$item%";
        $query->where(function($query) use ($item){
            $query->where('title','like',$item)
                    ->orWhere('body','like',$item);
        });
    }

}
