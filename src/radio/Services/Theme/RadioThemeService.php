<?php namespace Amelia\Radio\Services\Theme;

use Amelia\Radio\Models\Theme;
use Illuminate\Contracts\Cache\Repository as Cache,
    Illuminate\Contracts\Config\Repository as Config;

class RadioThemeService implements ThemeService {

    /**
     * Config repository instance
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Cache repository instance
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Inject dependencies.
     *
     * @param \Illuminate\Contracts\Cache\Repository $cache
     */
    public function __construct(Cache $cache, Config $config) {
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Get the current theme
     *
     * @return string
     */
    public function getName()
    {
    }

    /**
     * Return a view name scoped to a theme
     *
     * @param string $name
     * @return mixed
     */
    public function view($name)
    {
        // TODO: Implement view() method.
    }
}