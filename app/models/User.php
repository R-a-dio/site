<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * Should deleted_at be used
	 *
	 * @var bool
	 */
	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('pass');

	protected $fillable = ["user", "pass", "privileges", "email"];

	const NONE = 0;
	const PENDING = 1;
	const DJ = 2;
	const NEWS = 3;
	const ADMIN = 4;
	const DEV = 5;

	public function isDev() {
		return $this->privilege(static::DEV);
	}

	public function isAdmin() {
		return $this->privilege(static::ADMIN);
	}

	public function canPostNews() {
		return $this->privilege(static::NEWS);
	}

	public function isDJ() {
		return $this->privilege(static::DJ) and $this->djid;
	}

	public function canDoPending() {
		return $this->privilege(static::PENDING);
	}

	protected function privilege($priv) {
		// check it, etc
		return $this->privileges >= $priv;
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->pass;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	public function getDjAttribute()
	{
		$dj = Dj::find($this->djid);
		return $dj;
	}

	public function groups() {
		return $this->belongsToMany("Group", "user_privileges", "user_id", "privilege_id")->withTimestamps();
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

}
