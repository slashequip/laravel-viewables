<?php
namespace HaganJones\LaravelObserveProperties\Tests\App\Views;

use HaganJones\LaravelViewables\View\Viewable;

class RealViewable extends Viewable
{

    public function build()
    {
        $this->view('testview::index');
    }
}