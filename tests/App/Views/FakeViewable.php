<?php
namespace HaganJones\LaravelObserveProperties\Tests\App\Views;

class FakeViewable
{
    public function build()
    {
        $this->view('testview::index');
    }
}