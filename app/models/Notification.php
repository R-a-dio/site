<?php

class Notification extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

	/**
	 * Should deleted_at be used
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	// allow mass-assignment
	protected $fillable = ["notification", "privileges"];


	public static function generate($notification, $level, User $user = null) {

		if ($user) {
			$notification = $user->user . " (" . $user->id . ") " . $notification;
		}
		
		return static::create([
			"privileges" => $level,
			"notification" => $notification,
		]);
	}

	public static function dev($notification, User $user = null) {
		return static::generate($notification, User::DEV, $user);
	}
	public static function pending($notification, User $user = null) {
		return static::generate($notification, User::PENDING, $user);
	}
	public static function admin($notification, User $user = null) {
		return static::generate($notification, User::ADMIN, $user);
	}
	public static function news($notification, User $user = null) {
		return static::generate($notification, User::NEWS, $user);
	}
	public static function dj($notification, User $user = null) {
		return static::generate($notification, User::DJ, $user);
	}

	public static function fetch(User $user) {
		return static::where("privileges", "<=", $user->privileges)->orderBy("created_at", "desc")->get();
	}

	public static function count(User $user) {
		return static::where("privileges", "<=", $user->privileges)
			->orderBy("created_at", "desc")
			->select(DB::raw("count(*) as count"))
			->first()["count"];
	}

	public static function grab(User $user) {
		return static::where("privileges", "<=", $user->privileges)->orderBy("created_at", "desc");
	}

	public function toArray() {
		$array = parent::toArray();

		$array["notification"] = Markdown::render($array["notification"]);

		return $array;
	}
}
