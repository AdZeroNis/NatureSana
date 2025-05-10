<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $fillable = ['content', 'user_id', 'article_id', 'parent_id'];
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ArticleComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ArticleComment::class, 'parent_id');
    }
}
