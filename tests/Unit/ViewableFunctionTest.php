<?php
namespace HaganJones\LaravelObserveProperties\Tests\Unit;

use HaganJones\LaravelObserveProperties\Tests\App\Views\FakeViewable;
use HaganJones\LaravelObserveProperties\Tests\App\Views\RealViewable;
use HaganJones\LaravelObserveProperties\Tests\TestCase;

class ViewableFunctionTest extends TestCase
{
    /** @test */
    function viewable_function_fails_without_viewable_contract_object()
    {
        try {
            viewable(new FakeViewable());
        } catch(\TypeError $e) {
            $this->assertTrue(true, 'Viewable function threw error.');
        }
    }

    /** @test */
    function viewable_function_succeeds_with_viewable_contract_object()
    {
        try {
            viewable(new RealViewable());
            $this->assertTrue(true, 'Viewable function passed successfully.');
        } catch(\TypeError $e) {
            $this->assertTrue(false, 'Viewable function threw error.');
        }
    }
    
}