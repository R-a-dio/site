<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use SoftDeletes;
	use Authenticatable;
	use CanResetPassword;


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
		return $this->hasPerm('dev');
	}

	/**
	 * Check if a user is an admin
	 *
	 * @return bool
	 */
	public function isAdmin() {
		return $this->hasPerm('admin') || $this->hasPerm('dev');
	}

	/**
	 * Check if a user can post news
	 *
	 * @return bool
	 */
	public function canPostNews() {
		return $this->hasPerm('news');
	}

	/**
	 * Check if a user is a DJ
	 *
	 * @return bool
	 */
	public function isDJ() {
		return $this->hasPerm('dj') and $this->dj;
	}

	public function canViewDatabase() {
		return $this->hasPerm('database_view');
	}

	public function canEditDatabase() {
		return $this->hasPerm('database_edit');
	}

	public function canDeleteDatabase() {
		return $this->hasPerm('database_delete');
	}

	public function canViewPending() {
		return $this->hasPerm('pending_view');
	}

	public function canEditPending() {
		return $this->hasPerm('pending_edit');
	}

	/**
	 * Check if a user has basic permissions
	 *
	 * @return bool
	 */
	public function isActive() {
		return $this->hasPerm('active');
	}

///================ New permissions ===

	protected $userPermCache = false;

	/**
	 * Get a collection of strings with the user's permissions.
	 */
	public function getUserPermissions() {
		if ($this->userPermCache) return $this->userPermCache;
		$this->userPermCache =
			Permission::where('user_id', '=', $this->id)
				->get(['permission'])
				->map(function ($p) { return $p['permission']; })
				->toBase();
		return $this->userPermCache;
	}

	/**
	 * Get a collection of key-value pairs of all permissions,
	 * where the key is a permission and the value is a bool
	 * depending on whether the user has the permission or not.
	 */
	public function getPermissions() {
		$allPerms = PermissionKind::all()
			->map(function($pk) { return $pk['permission']; })
			->toBase();
		$userPerms = $this->getUserPermissions();
		$merged = Collection::make([]);
		foreach ($allPerms as $perm) {
			$merged[$perm] = $userPerms->contains($perm);
		}
		return $merged;
	}

	/**
	 * If the user has the permission, return true, otherwise
	 * return false.
	 */
	public function hasPerm($perm) {
		return $this->getUserPermissions()->contains($perm);
	}

	/**
	 * Update the user's permissions. The parameter must
	 * be a collection, similar to what getPermissions
	 * returns.
	 *
	 * Returns an old-style privilege number matching
	 * the new permissions.
	 */
	public function updatePermissions($newPerms) {
		$oldPerms = $this->getPermissions();
		$newPermsKeys = Collection::make($newPerms->keys());
		$priv = static::NONE;
		foreach ($oldPerms as $perm => $hadPerm) {
			if (!$newPermsKeys->contains($perm))
				continue;
			if ($perm === "dev" && $hadPerm !== $newPerms[$perm])
				continue;
			if (!$hadPerm && $newPerms[$perm]) {
				DB::table('permissions')
					->insert([
						'user_id' => $this->id,
						'permission' => $perm
						]);
			} else if ($hadPerm && !$newPerms[$perm]) {
				DB::table('permissions')
					->where('user_id', $this->id)
					->where('permission', $perm)
					->delete();
			}
		}
		if ($newPerms['dev'])
			$priv = static::DEV;
		else if ($newPerms['admin'])
			$priv = static::ADMIN;
		else if ($newPerms['news'])
			$priv = static::NEWS;
		else if ($newPerms['dj'])
			$priv = static::DJ;
		else if ($newPerms['active'])
			$priv = static::PENDING;
		if (!$newPerms['active'])
			$priv = static::NONE;
		$this->userPermCache = false;
		return $priv;
	}


/// ===================================

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

}
