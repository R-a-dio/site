<?php namespace Amelia\Radio\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    /**
     * Table name for comments
     *
     * @var string
     */
    protected $table = "comments";

    /**
     * Which items in the array can be mass-assigned
     *
     * @var array
     */
    protected $fillable = ["comment"];

    /**
     * The User who posted this, if logged in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo("User", "user_id", "id");
    }
}