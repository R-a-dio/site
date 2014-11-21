<?php namespace Amelia\Radio;

use function app;

/**
 * Get the evaluated view contents for the given view.
 * Modified to return
 *
 * @param  string  $view
 * @param  array   $data
 * @param  array   $mergeData
 * @return \Illuminate\View\View
 */
function theme($view = null, $data = array(), $mergeData = array())
{
    $factory = app('Illuminate\Contracts\View\Factory');
    $theme = app('Amelia\Radio\Services\Themes\ThemeService');

    if (func_num_args() === 0)
    {
        return $factory;
    }

    $view = $theme->view($view);
    $data = $theme->addFields($data);

    return $factory->make($view, $data, $mergeData);
}