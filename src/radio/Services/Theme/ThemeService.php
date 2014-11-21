<?php namespace Amelia\Radio\Services\Theme;

interface ThemeService {

    /**
     * Get the current theme
     *
     * @return string
     */
    public function getName();

    /**
     * Return a view name scoped to a theme
     *
     * @param string $name
     * @return mixed
     */
    public function view($name);
}
