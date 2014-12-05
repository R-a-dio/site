<?php namespace Amelia\Radio;

use function \app; // When Laravel namespaces these
                   // (which would mean we're at PHP7)
                   // I will cheer.

/**
 * Get the evaluated view contents for the given view.
 * Modified to return a themed view.
 *
 * @param  string  $view
 * @param  array   $data
 * @return \Illuminate\View\View
 */
function theme($view = null, $data = array())
{
    $factory = app('Illuminate\Contracts\View\Factory');
    $theme = app('Amelia\Radio\Services\Themes\ThemeService');

    if (func_num_args() === 0)
        return $factory;

    return $factory->make($theme->view($view), $data, $theme->extra());
}