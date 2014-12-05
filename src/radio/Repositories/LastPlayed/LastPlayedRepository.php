<?php namespace Amelia\Radio\Repositories\LastPlayed;

interface LastPlayedRepository {

    /**
     * Return a collection of Last Played objects, paginated.
     *
     * @param int $page
     * @return \Illuminate\Support\Collection
     */
    public function paginate($page);
}
