<?php namespace Amelia\Radio\Services\Status;

/**
 * @property string|null $playing
 * @property bool        $online
 * @property bool        $requests
 * @property bool        $afk
 */
interface StatusService {

    /**
     * Get the current status as an array
     *
     * @return array
     */
    public function get();
}
