<?php namespace Amelia\Radio\Repositories\News;

interface CommentRepository {

    /**
     * Get a comment by ID.
     *
     * @param int $id
     * @return \Amelia\Radio\Models\Comment
     */
    public function get($id);

    /**
     * Edit a comment with the given attributes
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
     * Force-delete a comment by ID from the store.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * Return a collection of all Comments on a given Post
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($id);

    /**
     * Insert a comment on a given post ID
     *
     * @param int   $id
     * @param array $attributes
     * @return mixed
     */
    public function insert($id, array $attributes);
}
