<?php namespace Amelia\Radio\Repositories\Users;

interface UserRepository {

    /**
     * Get a collection of all users who are visible staff
     *
     * @return \Illuminate\Support\Collection
     */
    public function staff();

    /**
     * Get a user by their username.
     *
     * @param string $name
     * @return \Amelia\Radio\Models\User
     */
    public function getByName($name);

    /**
     * Get a user by ID
     *
     * @param int $id
     * @return \Amelia\Radio\Models\User
     */
    public function getById($id);

    /**
     * Delete a user by ID.
     *
     * @param $id
     * @return void
     */
    public function delete($id);


    public function insert(User $user);
}