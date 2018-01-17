<?php
namespace HaganJones\LaravelObserveProperties\Tests\Unit;

use HaganJones\LaravelObserveProperties\Tests\App\Views\FakeViewable;
use HaganJones\LaravelObserveProperties\Tests\App\Views\RealViewable;
use HaganJones\LaravelObserveProperties\Tests\TestCase;
use Illuminate\Contracts\Support\Responsable;

class ResponsableInterfaceTest extends TestCase
{
    /** @test */
    function responsable_interface_is_implemented_in_viewable()
    {
        $response = new RealViewable();

        $this->assertTrue($response instanceof Responsable, "Response should be an instance of Responsable Interface.");
    }

}