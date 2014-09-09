<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use SlackTrait;
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
	protected $hidden = ["pass"];

	protected $fillable = ["user", "pass", "privileges", "email"];

	const NONE = 0;
	const PENDING = 1;
	const DJ = 2;
	const NEWS = 3;
	const ADMIN = 4;
	const DEV = 5;

	/**
	 * Check if a user is a dev
	 *
	 * @return bool
	 */
	public function isDev() {
		return $this->privilege(static::DEV);
	}

	/**
	 * Check if a user is an admin
	 *
	 * @return bool
	 */
	public function isAdmin() {
		return $this->privilege(static::ADMIN);
	}

	/**
	 * Check if a user can post news
	 *
	 * @return bool
	 */
	public function canPostNews() {
		return $this->privilege(static::NEWS);
	}

	/**
	 * Check if a user is a DJ
	 *
	 * @return bool
	 */
	public function isDJ() {
		return $this->privilege(static::DJ) and $this->dj;
	}

	/**
	 * Check if a user is able to touch the pending list
	 *
	 * @return bool
	 */
	public function canDoPending() {
		return $this->privilege(static::PENDING);
	}

	/**
	 * Check a user's privilege.
	 *
	 * @param $priv int
	 * @return bool
	 */
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
	
	/**
	 * Get the DJ Model for a user using $user->dj
	 *
	 * @return Dj|null
	 */
	public function getDjAttribute()
	{
		$dj = Dj::find($this->djid);
		return $dj;
	}

	/**
	 * Get a user's username using $user->username
	 *
	 * @return string
	 */
	public function getUsernameAttribute() {
		return $this->user;
	}

	/**
	 * Get the token used for sessions that dont expire
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token used for sessions that dont expire
	 *
	 * @param string
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the name of the database column used for sessions that dont expire.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	public function save(array $options = array()) {
		if ($this->exists) {
			$this->slack("user.edit");
		} else {
			$this->slack("user.add");
		}
		parent::save($options);
	}

	public function delete() {
		$this->slack("user.delete");
		parent::delete();
	}

}
