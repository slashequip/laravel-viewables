<?php
namespace HaganJones\LaravelViewables\Contracts;

use Illuminate\View\View;

interface Viewable
{
    /**
     * Render the view
     *
     * @return View
     */
    public function render();
}