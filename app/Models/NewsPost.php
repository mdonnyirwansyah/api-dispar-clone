<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newsCategory()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function newsTags()
    {
        return $this->belongsToMany(NewsTag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
