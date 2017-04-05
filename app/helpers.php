<?php

use HaganJones\LaravelViewables\Contracts\Viewable as ViewableContract;

/**
 * Get the evaluated view contents for a given viewable.
 *
 * @param  ViewableContract  $view
 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
 */
function viewable(ViewableContract $view)
{
    return $view->render();
}