<?php namespace Amelia\Radio\Services\Status;

interface StatusService {

    /**
     * Get the current status as an array
     *
     * @return array
     */
    public function get();
}