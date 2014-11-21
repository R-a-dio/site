<?php namespace Amelia\Radio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    /**
     * Allow soft deletion to take place and add ->forceDelete
     */
    use SoftDeletes;

    /**
     * Table name~
     *
     * @var string
     */
    protected $table = "news";

    /**
     * Which items can be mass-assigned on the news post.
     *
     * @var array
     */
    protected $fillable = ["user_id", "title", "header", "text", "private"];

    /**
     * Get the User that owns this post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo("User", "user_id", "id");
    }

    /**
     * Get the last person to edit this post (by default the author)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo("User", "editor_id", "id");
    }

    /**
     * Get comments for the new post.
     * Could possibly use the CommentRepository for this.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany("Comment", "news_id", "id");
    }
}