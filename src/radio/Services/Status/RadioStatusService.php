<?php namespace Amelia\Radio\Services\Status;

use Amelia\Radio\Models\Status;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class RadioStatusService implements StatusService {

    /**
     * Cache instance
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * An identifier to use within the cache
     *
     * @var string
     */
    protected $name = "radio::status::current";

    /**
     * Inject dependencies
     *
     * @param \Illuminate\Contracts\Cache\Repository $cache
     */
    public function __construct(Repository $cache) {
        $this->cache = $cache;
    }

    /**
     * Get the current status as an array
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        if ($cache = $this->cache->get($this->name))
            return new Collection(json_decode($cache));

        $status = Status::find(1); // status is always ID 1
        $status = $status ? $status->toArray() : [];
        $this->cache($status);

        return new Collection($status);
    }

    /**
     * Cache a status entry for 1 second
     *
     * @param array $status
     * @return void
     */
    protected function cache(array $status) {
        $this->cache->put($this->name, json_encode($status), 1 / 60);
    }

    /**
     * Return the currently playing song.
     *
     * @return string|null
     */
    public function playing()
    {
        return $this->get()->np;
    }

    /**
     * Return if we're on air or not.
     *
     * @return bool
     */
    public function online()
    {
        return ! empty($this->get());
    }

    /**
     * Return if we're accepting requests
     *
     * @return bool
     */
    public function requests()
    {
        return $this->get()->requesting;
    }

    /**
     * If the AFK streamer is currently playing
     *
     * @return bool
     */
    public function afk()
    {
        return $this->get()->isafkstream;
    }

    /**
     * Dynamically get status entries via cache.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        if (method_exists($this, $name))
            return $this->{$name}();

        return $this->get()->{$name};
    }
}
