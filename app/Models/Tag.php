<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newsPosts()
    {
        return $this->morphedByMany(NewsPost::class, 'taggable');
    }
}
