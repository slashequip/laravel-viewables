<?php
namespace HaganJones\LaravelViewables\View;

use Illuminate\Contracts\Support\Responsable;
use ReflectionClass;
use ReflectionProperty;
use BadMethodCallException;
use Illuminate\Support\Str;
use Illuminate\Container\Container;
use HaganJones\LaravelViewables\Contracts\Viewable as ViewableContract;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Viewable implements ViewableContract, Responsable
{
    /**
     * The view name to use for the view.
     *
     * @var string
     */
    public $view;

    /**
     * The view data for the view.
     *
     * @var array
     */
    public $viewData = [];

    /**
     * Abstract build function to force sub
     * classes to implement the function
     *
     * @return void
     */
    abstract public function build();

    public function toResponse($request)
    {
        return $this->render();
    }

    /**
     * Render the view
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        Container::getInstance()->call([$this, 'build']);

        return app(ViewFactory::class)->make($this->buildView(), $this->buildViewData());
    }

    /**
     * Build the view.
     *
     * @return string
     */
    protected function buildView()
    {
        return $this->view;
    }

    /**
     * Build the view data
     *
     * @return array
     */
    public function buildViewData()
    {
        $data = $this->viewData;

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->getDeclaringClass()->getName() != self::class) {
                $data[$property->getName()] = $property->getValue($this);
            }
        }

        return $data;
    }

    /**
     * Set the view and view data for the message.
     *
     * @param  string  $view
     * @param  array  $data
     * @return $this
     */
    public function view($view, array $data = [])
    {
        $this->view = $view;
        $this->viewData = array_merge($this->viewData, $data);

        return $this;
    }

    /**
     * Set the view data for the message.
     *
     * @param  string|array  $key
     * @param  mixed   $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->viewData = array_merge($this->viewData, $key);
        } else {
            $this->viewData[$key] = $value;
        }

        return $this;
    }

    /**
     * Dynamically bind parameters to the message.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return $this
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::snake(substr($method, 4)), $parameters[0]);
        }

        throw new BadMethodCallException("Method [$method] does not exist on viewable.");
    }
}