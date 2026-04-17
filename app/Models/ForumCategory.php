<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $table = 'forum_categories';

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'forum_category_id');
    }
}
