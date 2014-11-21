<?php namespace Amelia\Radio\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    /**
     * Table name for status
     *
     * @var string
     */
    protected $table = "curstatus";

    /**
     * If we should use timestamps (created_at, etc.)
     *
     * @var bool
     */
    protected $timestamps = false;
}