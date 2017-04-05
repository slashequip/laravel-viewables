# Laravel Viewables
Like Laravel's Mailables, Viewables allow you to take a
class based approach to working with and handling your
views in Laravel.

### Install via Composer
```
composer require "haganjones/laravel-viewables"
```

### Include Service Provider
In `config/app.php` add the below to your service providers array:
```
HaganJones\LaravelViewables\Providers\ServiceProvider::class,
```

## Writing Viewables

All of a viewable class' configuration is done in the `build` method. 
Within this method, you may call various methods such as `view` and
`with` to render and pass data to the view.

### Configuring The View

Within a viewable class' `build` method, you may use the `view` method
to specify which template should be used when rendering the view:

```
/**
 * Build the message.
 *
 * @return $this
 */
public function build()
{
    return $this->view('dashboard');
}
```

### View Data

#### Via Public Properties

Typically, you will want to pass some data to your view that you can utilize
when rendering the view's HTML. There are two ways you may make data
available to your view. First, any public property defined on your
viewable class will automatically be made available to the view.
So, for example, you may pass data into your viewable class'
constructor and set that data to public properties defined
on the class:

```
<?php
namespace App\View;
 
use App\User;
use HaganJones/LaravelViewables/View/Viewable;
 
class DashboardView extends Viewable
{
    /**
     * The user instance.
     *
     * @var User
     */
    public $user;
 
    /**
     * Create a new viewable instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
 
    /**
     * Build the view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('dashboard');
    }
}
```

Once the data has been set to a public property, it will automatically
be available in your view, so you may access it like you would
access any other data in your Blade templates:

```
<div>
    Logged in as: {{ $user->name }}
</div>
```
#### Via The `with` Method:

If you would like to customize the format of your view's data before it is
sent to the template, you may manually pass your data to the view via
the `with` method. Typically, you will still pass data via the
viewable class' constructor; however, you should set this
data to `protected` or `private` properties so the data
is not automatically made available to the template.
Then, when calling the `with` method, pass an
array of data that you wish to make available
to the template:

```
<?php
namespace App\View;
 
use App\User;
use HaganJones/LaravelViewables/View/Viewable;
 
class DashboardView extends Viewable
{
    /**
     * The user instance.
     *
     * @var User
     */
    protected $user;
 
    /**
     * Create a new viewable instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('dashboard')
            ->with([
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
            ]);
    }
}
```
Once the data has been passed to the `with` method, it will automatically be available
in your view, so you may access it like you would access any other data in your
Blade templates:

```
<div>
    Logged in as: {{ $userName }}
</div>
```

## Rendering The View

To serve a view, use the helper function `viewable()`. You may pass an
instance of your viewable class to this helper function:

```
<?php
namespace App\Http\Controllers;
 
use App\User;
use App\View\DashboardView;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
 
class DashboardController extends Controller
{
    /**
     * Show the dashboard page
     *
     * @return Response
     */
    public function get()
    {
        return viewable(
            new DashboardView(Auth::user())
        );
    }
}
```

## TODO
- Write some tests!
- Make Viewable command
