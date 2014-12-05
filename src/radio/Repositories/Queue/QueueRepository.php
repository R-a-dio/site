<?php namespace Amelia\Radio\Repositories\Queue;

interface QueueRepository {

    /**
     * Return the current queue
     *
     * @return \Illuminate\Support\Collection
     */
    public function get();
}
