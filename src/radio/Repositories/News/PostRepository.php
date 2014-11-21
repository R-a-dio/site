<?php namespace Amelia\Radio\Repositories\News;

interface PostRepository {

    /**
     * Get a post by ID.
     *
     * @param int $id
     * @return \Amelia\Radio\Models\Post
     */
    public function get($id);

    /**
     * Edit a post with the given attributes
     *
     * @param       $id
     * @param array $attributes
     * @return mixed
     */
    public function edit($id, $attributes = array());

    /**
     * Soft-delete a Post by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);

    /**
     * Force-delete a post by ID from the store.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * Return a collection of all Posts
     *
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * Insert a news post via ID
     *
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes);

    /**
     * Return the most recent $limit news posts
     *
     * @param int $limit
     * @return mixed
     */
    public function preview($limit = 5);
}
