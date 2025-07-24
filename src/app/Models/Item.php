<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
            'user_id',
            'name',
            'description',
            'image_path',
            'condition',
            'price',
            'category_id',
    ];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Mylist::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function mylists()
    {
        return $this->hasMany(Mylist::class);
    }
}
