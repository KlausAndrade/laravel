# Dicas sobre rotas no laravel 8
```php
// Generating Redirects...
return redirect()->route('profile');

public function handle($request, Closure $next)
{
    if ($request->route()->named('profile')) {
        //
    }

    return $next($request);
}

Route::middleware(['first', 'second'])->group(function () {
    Route::get('/users', function () {
        // Uses first & second middleware...
    });

    Route::get('clients', function () {
        // Uses first & second middleware...
    });
});

Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        // Matches The "/admin/users" URL
    });
});

Route::name('admin.')->group(function () {
    Route::get('users', function () {
        // Route assigned name "admin.users"...
    })->name('users');
});
```
## Fallback Routes

Using the Route::fallback method, you may define a route that will be executed when no other route matches the incoming request. Typically, unhandled requests will automatically render a "404" page via your application's exception handler. However, since you may define the fallback route within your routes/web.php file, all middleware in the web middleware group will apply to the route. You are free to add additional middleware to this route as needed:
```php
Route::fallback(function () {
    //
});
```
Accessing The Current Route

You may use the current, currentRouteName, and currentRouteAction methods on the Route facade to access information about the route handling the incoming request:
```php
$route = Route::current();

$name = Route::currentRouteName();

$action = Route::currentRouteAction();


Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('login', [userLogin::class, 'showLoginForm'])->name('login');

```


