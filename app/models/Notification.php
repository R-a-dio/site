<?php

class Notification extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'radio_notifications';

	/**
	 * Should deleted_at be used
	 *
	 * @var bool
	 */
	protected $softDeletes = true;

	// allow mass-assignment
	protected $fillable = ["notification", "privileges"];


	public static function generate($notification, $level) {
		return static::create([
			"privileges" => $level,
			"notification" => $notification,
		]);
	}

	public static function dev($notification) {
		return static::generate($notification, User::DEV);
	}
	public static function pending($notification) {
		return static::generate($notification, User::PENDING);
	}
	public static function admin($notification) {
		return static::generate($notification, User::ADMIN);
	}
	public static function news($notification) {
		return static::generate($notification, User::NEWS);
	}
	public static function dj($notification) {
		return static::generate($notification, User::DJ);
	}


	public function toArray() {
		$array = parent::toArray();

		$array["notification"] = Markdown::render($array["notification"]);

		return $array;
	}
}
