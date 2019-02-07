<?php namespace App\Classes;

use Illuminate\Contracts\Hashing\Hasher;

class RadioHasher implements Hasher {

	protected $hasher;
	protected $rounds = 12;

	/**
	 * Hash the given value.
	 *
	 * @param  string  $value
	 * @return array   $options
	 * @return string
	 */
	public function make($value, array $options = [])
	{
		$cost = isset($options["cost"]) ? $options["cost"] : $this->rounds;

		$hash = password_hash($value, PASSWORD_BCRYPT, ["cost" => $cost]);

		// see static::check()
		return str_replace("$2y$", "$2a$", $hash);
	}

	/**
	 * Check the given plain value against a hash.
	 *
	 * @param  string  $value
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool
	 */
	public function check($value, $hashedValue, array $options = [])
	{
		// To clarify here: the 2y implementation of bcrypt is specific to
		// the crypt_blowfish implementation of bcrypt (that PHP uses).
		// the act of naming this bugfix "2y" was a stupid idea as it is not
		// an updated version of the algorithm at all.
		// 2a and 2y are literally identical; crypt_blowfish just had bugs in 2a
		$hashedValue = str_replace("$2a$", "$2y$", $hashedValue);
		return password_verify($value, $hashedValue);

	}

	/**
	 * Check if the given hash has been hashed using the given options.
	 *
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		$cost = isset($options["rounds"]) ? $options["rounds"] : $this->rounds;

		$hashedValue = str_replace("$2a$", "$2y$", $hashedValue);

		return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, ["cost" => $cost]);
	}
}
