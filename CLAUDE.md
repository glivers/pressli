# Rachie Documentation - API Reference

## Getting Started

### Overview
Rachie is a lightweight PHP MVC framework with automatic URL routing, annotation-driven models, and built-in template engine. Roline CLI generates complete working code from templates.

### Requirements
- PHP 7.4+, Composer, MySQL/PostgreSQL/SQLite
- Install: `composer create-project glivers/rachie myapp`

### Directory Structure
```
application/
  controllers/  → Controller classes
  models/       → Model classes (database)
  views/        → View templates
  libraries/    → Custom helpers (Lib\ namespace)
config/
  settings.php  → Framework config (timezone, dev mode)
  database.php  → Database connection
  routes.php    → Custom routes (optional)
public/
  index.php     → Entry point
vault/
  cache/, logs/, sessions/, tmp/
```

### Naming Conventions (CRITICAL)
**Models - MUST be singular:**
- Class: `TodoModel` (singular + Model)
- Roline pluralizes → table: `todos`

**Controllers/Views - singular OR plural (user's choice):**
- `TodosController` + `views/todos/` OR
- `TodoController` + `views/todo/`
- URLs follow naming: `/todos` or `/todo`

### Automatic URL Routing
No route definitions needed:
```
/todos          → TodosController@index()
/todos/show/5   → TodosController@show($id)
/todos/create   → TodosController@create()
```

**HTTP Verb Prefixes (optional but recommended):**
```php
public function getIndex()    // GET only
public function postCreate()  // POST only
public function putUpdate()   // PUT only
public function deleteRemove() // DELETE only
```

**URL Parameters:**
```php
public function show($id)                    // /todos/show/5
public function edit($id, $action = 'edit')  // /todos/edit/10/preview
```

**Input Access:**
```php
Input::get('name')    // GET or POST
Input::post('email')  // POST only
Input::all()          // All input as array
```

### Roline CLI Workflow
```bash
# Database
php roline db:create

# Generate files
php roline controller:create Todos
php roline view:create todos
php roline model:create Todo

# Table operations (reads @column annotations)
php roline model:table-create Todo
php roline model:table-update Todo    # Sync after model edits
```

### Model Annotations
**Format:** Description required, one annotation per line, no spaces in values

```php
<?php namespace Models;
use Rackage\Model;

class TodoModel extends Model
{
    protected static $table = 'todos';
    protected static $timestamps = true;  // Auto-manage created_at/updated_at

    /** @column @autonumber */
    protected $id;

    /** @column @varchar 255 */
    protected $title;

    /** @column @text @nullable */
    protected $description;

    /** @column @enum pending,completed @default pending @index */
    protected $status;

    /** @column @datetime @nullable */
    protected $created_at;
}
```

**Common Annotations:**
- `@column` - Required for all database columns
- `@autonumber` - INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `@varchar N` - String with max length
- `@text` - Long text (64KB)
- `@int` - Integer
- `@datetime` - DATETIME
- `@enum val1,val2` - Enum (NO SPACES!)
- `@default value` - Default value
- `@nullable` - Allow NULL (default is NOT NULL)
- `@index` - Create index
- `@unique` - Unique constraint

### Query Builder
```php
// Retrieve
TodoModel::all()
TodoModel::getById(5)
TodoModel::where('status', 'pending')->all()
TodoModel::where('priority', 'high')->first()
TodoModel::where('status', 'completed')->count()

// Chaining
TodoModel::where('status', 'pending')
    ->where('priority', 'high')
    ->order('created_at', 'desc')
    ->limit(10)
    ->all()

// Save/Update
TodoModel::save(['title' => 'New Todo'])
TodoModel::where('id', 5)->save(['status' => 'completed'])

// Delete
TodoModel::deleteById(5)
TodoModel::where('status', 'old')->delete()
```

**Returns arrays, not objects:** `$item['title']` not `$item->title`

### Template Syntax
```php
{{ $variable }}              // Escaped output (safe)
{{{ $html }}}                // Raw output (trusted HTML only)

@if($condition)
@elseif($other)
@else
@endif

@foreach($items as $item)
@endforeach

@loopelse($items as $item)
    // Loop content
@empty
    // Empty state
@endloop

@isset($var)
@endisset

@extends('todos/layout')
@section('title', 'Page Title')
@section('content')
    <h1>Content</h1>
@endsection
@yield('content')
@parent                      // Include parent section content

// Operators
{{ $item['title'] or 'Default' }}
```

### Helper Classes (auto-available in views)
```php
Url::link('todos/show/5')
Url::assets('css/todos.css')
Url::base()

Html::escape($text)
Html::link('todos', 'View Todos')

Date::format($date, 'M j, Y')
Date::now('Y-m-d H:i:s')

Session::get('user_id')
Session::set('key', 'value')
Session::flash('success', 'Saved!')

Input::get('field')
Input::post('field')
Input::all()

Redirect::to('todos')
Redirect::back()
```

### Controller Pattern
```php
<?php namespace Controllers;

use Rackage\{Controller, View, Input, Session, Redirect};
use Models\TodoModel;

class TodosController extends Controller
{
    public function getIndex()
    {
        $data['todos'] = TodoModel::all();
        View::render('todos/index', $data);
    }

    public function postCreate()
    {
        TodoModel::save([
            'title' => Input::get('title'),
            'status' => Input::get('status')
        ]);
        Session::flash('success', 'Created!');
        Redirect::to('todos');
    }

    public function getDelete($id)
    {
        TodoModel::deleteById($id);
        Session::flash('success', 'Deleted!');
        Redirect::to('todos');
    }
}
```

### View Pattern
```php
@extends('todos/layout')

@section('title', 'Todos')

@section('content')
    <h1>Todos</h1>

    @if(Session::flash('success'))
        <div class="alert">{{ Session::flash('success') }}</div>
    @endif

    @loopelse($todos as $item)
        <div>
            <h3>{{ $item['title'] }}</h3>
            <a href="{{ Url::link('todos/edit/' . $item['id']) }}">Edit</a>
        </div>
    @empty
        <p>No todos yet</p>
    @endloopelse
@endsection
```

### Configuration
**config/settings.php:**
```php
'timezone' => 'America/New_York',
'dev' => true,  // true = debug mode, false = production (streams views from memory)
```

**config/database.php:**
```php
'mysql' => [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'myapp',
    'port' => '3306',
    'charset' => 'utf8mb4',
]
```

**config/autoload.php (Custom Namespaces):**
```php
// Register additional PSR-4 namespaces beyond Controllers, Models, and Lib
return [
    'Themes\\'   => 'themes/',
    'Plugins\\'  => 'plugins/',
    'Modules\\'  => 'modules/',
    'Services\\' => 'application/services/',
];
```

**How it works:**
- Loaded during bootstrap, registered with Composer's PSR-4 autoloader
- Namespace must end with `\\`
- Path is relative to application root
- Allows organizing code outside standard Controllers/Models/Lib structure

**Usage:**
```php
// File: themes/Aurora/ThemeController.php
<?php namespace Themes\Aurora;

class ThemeController {
    public function render() {
        // Theme logic
    }
}

// Access from anywhere (no require/include needed)
use Themes\Aurora\ThemeController;
$theme = new ThemeController();
$theme->render();
```

**Use Cases:**
- **CMS themes:** Theme-specific classes in `themes/{theme-name}/`
- **Plugins:** Plugin classes in `plugins/{plugin-name}/`
- **Multi-tenant:** Tenant-specific code in `tenants/{tenant-id}/`
- **Modular architecture:** Module classes in `modules/{module}/`
- **Services layer:** Business logic in `application/services/`

### Common Patterns
**Flash messages after actions:**
```php
Session::flash('success', 'Record created!');
Redirect::to('controller/method');
```

**Check before edit/delete:**
```php
$item = TodoModel::getById($id);
if (!$item) {
    Session::flash('error', 'Not found!');
    Redirect::to('todos');
}
```

**Array access with fallbacks:**
```php
{{ $item['title'] or 'Untitled' }}
```

### Generated Code Samples

### Layout View (application/views/todos/layout.php)
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My Application</title>
    <link rel="stylesheet" href="{{ Url::assets('css/todos.css') }}">
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ Url::link('todos') }}" class="brand">Todo Manager</a>
            <div class="nav-links">
                <a href="{{ Url::link('todos') }}">List</a>
                <a href="{{ Url::link('todos/create') }}">Create New</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @if(Session::flash('success'))
            <div class="alert alert-success">
                {{{ Session::flash('success') }}}
            </div>
        @endif

        @if(Session::flash('error'))
            <div class="alert alert-error">
                {{{ Session::flash('error') }}}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} My Application. Built with Rachie Framework.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
```

### Index View (application/views/todos/index.php)
```php
@extends('todos/layout')

@section('title', 'Todos')

@section('content')
    <div class="page-header">
        <h1>Todos</h1>
        <a href="{{ Url::link('todos/create') }}" class="btn btn-primary">Create New</a>
    </div>

    <div class="cards-grid">
        @loopelse($todos as $item)
            <div class="task-card">
                <div class="task-header">
                    <h3>{{ $item['title'] or 'Untitled' }}</h3>
                    <div class="task-badges">
                        <span class="badge badge-{{ $item['status'] or 'pending' }}">
                            {{ $item['status'] or 'pending' }}
                        </span>
                        <span class="badge badge-{{ $item['priority'] or 'low' }}">
                            {{ $item['priority'] or 'low' }}
                        </span>
                    </div>
                </div>
                <div class="task-body">
                    @isset($item['description'])
                        <p>{{ $item['description'] }}</p>
                    @endisset
                    <div class="task-footer">
                        @isset($item['created_at'])
                            <small class="text-muted">
                                Created: {{ Date::format($item['created_at'], 'M j, Y') }}
                            </small>
                        @endisset
                        <div class="task-actions">
                            <a href="{{ Url::link('todos/show/' . $item['id']) }}" class="btn btn-sm">View</a>
                            <a href="{{ Url::link('todos/edit/' . $item['id']) }}" class="btn btn-sm">Edit</a>
                            <a href="{{ Url::link('todos/delete/' . $item['id']) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this item?')">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>No todos yet</h2>
                <p>Your todos will appear here</p>
                <a href="{{ Url::link('todos/create') }}" class="btn btn-primary">Create your first one</a>
            </div>
        @endloopelse
    </div>
@endsection
```

**Other generated views:**
- `show.php` - Detail view with single todo display + edit/delete buttons
- `create.php` - Form with title, description, status, priority inputs + CSRF token
- `edit.php` - Same form pre-filled with `$todos` data
- `public/css/todos.css` - Professional responsive CSS (326 lines)

### Controller (application/controllers/TodosController.php)
```php
<?php namespace Controllers;

use Rackage\View;
use Rackage\Controller;
use Rackage\CSRF;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Models\TodoModel;

class TodosController extends Controller
{
    public function getIndex()
    {
        $data['todos'] = TodoModel::all();
        $data['title'] = 'Todos List';
        View::render('todos/index', $data);
    }

    public function getShow($id)
    {
        $todos = TodoModel::getById($id);
        View::render('todos/show', [
            'id' => $id,
            'todos' => $todos
        ]);
    }

    public function getCreate()
    {
        View::render('todos/create');
    }

    public function postCreate()
    {
        TodoModel::save([
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'status' => Input::get('status'),
            'priority' => Input::get('priority')
        ]);
        Session::flash('success', 'Record created successfully!');
        Redirect::to('todos');
    }

    public function getEdit($id)
    {
        $todos = TodoModel::getById($id);
        if (!$todos) {
            Session::flash('error', 'Record not found!');
            Redirect::to('todos');
        }
        View::render('todos/edit', [
            'id' => $id,
            'todos' => $todos
        ]);
    }

    public function postUpdate($id)
    {
        TodoModel::where('id', $id)->save([
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'status' => Input::get('status'),
            'priority' => Input::get('priority')
        ]);
        Session::flash('success', 'Record updated successfully!');
        Redirect::to('todos/show/' . $id);
    }

    public function getDelete($id)
    {
        TodoModel::deleteById($id);
        Session::flash('success', 'Record deleted successfully!');
        Redirect::to('todos');
    }
}
```

### Model (application/models/TodoModel.php)
```php
<?php namespace Models;

use Rackage\Model;

class TodoModel extends Model
{
    protected static $table = 'todos';
    protected static $timestamps = true;

    /**
     * Primary key identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Todo title
     * @column
     * @varchar 255
     */
    protected $title;

    /**
     * Todo description and details
     * @column
     * @text
     * @nullable
     */
    protected $description;

    /**
     * Completion status
     * @column
     * @enum pending,completed
     * @default pending
     * @index
     */
    protected $status;

    /**
     * Priority level
     * @column
     * @enum low,medium,high
     * @default low
     */
    protected $priority;

    /**
     * When todo was created
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * When todo was last modified
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;
}
```

**Generated SQL from annotations:**
```sql
CREATE TABLE todos (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM('pending','completed') DEFAULT 'pending',
    priority ENUM('low','medium','high') DEFAULT 'low',
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    INDEX idx_status (status)
);
```

### Critical Rules
1. Models: Singular names only (Roline pluralizes for table)
2. Enum annotations: No spaces (`@enum pending,completed`)
3. One annotation per line
4. Query results are arrays, not objects
5. `@column` required for all database fields
6. HTTP verb prefixes: `getMethod()`, `postMethod()`

### Development Server
```bash
cd public
php -S localhost:8000 server.php
```

### Full Docs
https://rachie.dev/docs

---

## Routing in Rachie

Rachie uses **automatic routing** - URLs map to controllers without configuration. Custom routes in `config/routes.php` override automatic routing.

**Requirements:** Apache mod_rewrite enabled, `.htaccess` files in root and `public/`.

### Automatic Routing

**Pattern:** `/controller/method/param1/param2`

```
URL                          Controller              Method          Parameters
/blog                       BlogController          index()         []
/blog/show/123              BlogController          show()          ["123"]
/user/edit/5/draft          UserController          edit()          ["5", "draft"]
```

**Controller structure:**
```php
<?php namespace Controllers;  // Required namespace
use Rackage\Controller;

class BlogController extends Controller {  // Must extend Controller
    public function show($slug) {  // Public method, params from URL
        $post = PostModel::where('slug', $slug)->first();
        if (!$post) View::error(404);
        View::render('blog/show', ['post' => $post]);
    }
}
```

**Location:** `application/controllers/NameController.php`

### Custom Routes

**Define in `config/routes.php`:**
```php
return array(
    'about' => 'Pages@about',                    // Basic route
    'blog' => 'Posts',                           // Defaults to index()
    'profile' => 'User@show/id',                 // Named parameter
    'order' => 'Orders@show/id/action',          // Multiple named params
    'blog/*' => 'Blog@show/slug',                // Single wildcard
    'admin/users' => 'AdminUsers',               // Compound route (2 segments)
    'admin/users/*' => 'AdminUsers@show/id',     // Compound wildcard
);
```

**Priority:** Exact compound → Compound wildcard → Exact single → Single wildcard → Automatic routing → Catch-all → 404

### Compound Routes (Namespaced Routes)

**Compound routes** match TWO URL segments instead of one. Also called **namespaced routes**. Used for admin panels, API endpoints, or avoiding URL conflicts.

**How it works:**
- Route consumes first TWO segments of URL
- Method extraction starts at segment offset 2 (instead of 1)
- Remaining segments become method + parameters

```php
// Exact compound route
'admin/users' => 'AdminUsers'
URL: /admin/users/edit/5
Matched: 'admin/users' consumed → method from segment[2]='edit', param from segment[3]='5'
Result: AdminUsersController::edit('5')

// Compound wildcard route
'admin/users/*' => 'AdminUsers@show/id'
URL: /admin/users/john-doe
Matched: 'admin/users' consumed → wildcard captures 'john-doe'
Result: AdminUsersController::show('john-doe')

URL: /admin/users/edit/5
Matched: 'admin/users' consumed → wildcard captures 'edit/5'
Result: AdminUsersController::show('edit/5')
```

**Priority matching** (URL: `/admin/users/edit/5`):
1. Checks `'admin/users'` (exact compound) ✓
2. Checks `'admin/users/*'` (compound wildcard)
3. Checks `'admin'` (exact single)
4. Checks `'admin/*'` (single wildcard)

**Compound vs Single:**
```php
// Single route
'admin' => 'Admin'
URL: /admin/users/edit → AdminController::users()  // 'users' is method

// Compound route
'admin/users' => 'AdminUsers'
URL: /admin/users/edit → AdminUsersController::edit()  // 'edit' is method
```

### URL Parameters

**Method arguments (primary):**
```php
// URL: /blog/show/my-post
public function show($slug) {
    // $slug = "my-post"
}

// URL: /post/update/42/draft
public function update($id, $status) {
    // $id = "42", $status = "draft"
}

// Optional parameters
public function list($category = null) {
    // $category is optional
}
```

**Type hints work (PHP converts strings automatically):**
```php
public function edit(int $id, string $action = 'view') {
    // PHP converts URL string to int
}
```

### Named Parameters

Route definition names make parameters accessible via `Input::get('name')`.

**Route:** `'profile' => 'User@show/id'`
**URL:** `/profile/123`
```php
public function show($id) {
    // Method arg: $id = "123"
    // Via Input: Input::get('id') = "123"
}
```

**Multiple named:** `'order' => 'Orders@show/id/action'`
```php
public function show($id, $action) {
    // Input::get('id'), Input::get('action')
}
```

**Extra unnamed params get numeric indexes:**
```php
// Route: 'profile' => 'User@show/id'
// URL: /profile/123/extra/stuff
Input::get('id')   // "123" (named)
Input::get(0)      // "extra" (numeric)
Input::get(1)      // "stuff" (numeric)
```

### Pattern Routes (Wildcards)

**Route:** `'blog/*' => 'Blog@show/slug'`

```
URL                              Captured                Method
/blog/my-first-post             "my-first-post"         Blog->show("my-first-post")
/blog/2024/january/news         "2024/january/news"     Blog->show("2024/january/news")
```

**Wildcards capture full path after prefix (including slashes).**

**Exact routes override wildcards:**
```php
'blog' => 'Blog@index',            // /blog
'blog/featured' => 'Blog@featured',   // /blog/featured
'blog/*' => 'Blog@show/slug',         // /blog/anything-else
```

### HTTP Verb Routing

**Prefix methods with HTTP verbs:**
```php
class UserController extends Controller {
    public function getProfile() {  // GET /user/profile
        View::render('user/profile');
    }

    public function postProfile() {  // POST /user/profile
        UserModel::where('id', Session::get('user_id'))->save(['name' => Input::post('name')]);
        Redirect::to('user/profile')->flash('success', 'Updated!');
    }
}
```

**Supported:** `getMethod()`, `postMethod()`, `putMethod()`, `deleteMethod()`, `patchMethod()`
**Fallback:** If `getUsers()` doesn't exist, falls back to `users()` if it exists.

### Input Class

```
Method                          Source          Escaped     Description
Input::get('key', 'default')   URL/POST/GET    Yes         Priority: URL > POST > GET
Input::post('key', 'default')  POST            Yes         Form data only
Input::url('key')              URL routing     No          URL parameters (raw)
Input::has('key')              All             N/A         Check if exists
```

**Examples:**
```php
$query = Input::get('q');           // From any source
$name = Input::post('name');        // POST only
$id = Input::url('id');             // URL routing only
$page = Input::get('page', 1);      // With default
if (Input::has('filter')) { }       // Check exists
```

**Security:** `get()` and `post()` auto-escape HTML. `url()` returns raw.

### URL Generation

```
Method                                  Returns
Url::base()                            https://yoursite.com/
Url::link('blog', 'show', 'slug')      /blog/show/slug
Url::link(['blog', 'show', 'slug'])    /blog/show/slug (array)
Url::link('blog/show/slug')            /blog/show/slug (string)
Url::assets('css/app.css')             /css/app.css (from public/)
Url::safe('search', $userInput)        URL-encodes parameters
```

**In views (Url auto-imported):**
```php
<a href="{{ Url::link('blog', 'show', $post['slug']) }}">Read</a>
<img src="{{ Url::assets('images/logo.png') }}">
```

### Redirects

```
Method                                      Description
Redirect::to('path')                       Internal redirect
Redirect::away('https://external.com')     External URL
Redirect::back()                           Previous page
Redirect::home()                           Homepage
Redirect::refresh()                        Reload page
```

**With flash messages:**
```php
Redirect::to('dashboard')->flash('success', 'Welcome!');
```

**With query params:**
```php
Redirect::to('search', ['q' => 'test', 'page' => 2]);  // /search?q=test&page=2
```

### Routing Configuration

**`config/settings.php`:**

**Default controller/method:**
```php
'default' => array('controller' => 'home', 'action' => 'index'),  // Handles /
```

**Catch-all routing:**
```php
'routing' => array(
    'catch_all' => true,
    'controller' => 'pages',
    'method' => 'show',
),
// Sends unmatched URLs to PagesController->show($url)
```

**Error pages:**
```php
'error_pages' => array(404 => 'errors/404', 500 => 'errors/500'),
```

Trigger: `View::error(404);`

### Filters & Caching

**Filters:** Execute code before/after controller methods. Enable: `$enable_filters = true`. Use `@before` and `@after` annotations in docblocks. See https://rachie.dev/docs/filters

**Caching:** Serves cached HTML before controllers execute. Enable in `config/cache.php`. See https://rachie.dev/docs/cache

### Routing Troubleshooting

**Controller not found:**
- File: `application/controllers/NameController.php`
- Namespace: `namespace Controllers;`
- Extends: `extends Rackage\Controller`

**Method not found:**
- Must be public
- Check HTTP verb prefix (getIndex vs postIndex)

**Parameters null:**
- Method must accept: `public function show($id)`
- URL must have param: `/blog/show/123`

**Route not matching:**
- Syntax: `'blog' => 'Posts@index'` (@ not :)
- Clear cache: `php roline cleanup:cache`

**404 on valid URLs:**
- Enable mod_rewrite: `sudo a2enmod rewrite`
- Apache config: `AllowOverride All`
- Check .htaccess files exist

### Routing Quick Reference

**Route syntax:**
```php
'url' => 'Controller@method/param1/param2'
```

**HTTP verbs:**
```php
getIndex(), postIndex(), putIndex(), deleteIndex(), patchIndex(), index() (fallback)
```

**Input priority (highest first):**
```
1. URL parameters (routing)
2. POST data
3. GET query string
```

### Routing Best Practices
- Use method arguments for parameters (primary)
- Use Input::get() for optional params or in views
- Use Url::safe() for user input in URLs
- Check auth in protected methods or use @before filters

### Critical Routing Rules
1. Input priority: URL params > POST > GET
2. Wildcard routes capture everything including slashes
3. HTTP verb methods: getMethod(), postMethod() - NOT get_method()
4. Custom routes override automatic routing
5. Method arguments are primary, Input::get() is secondary
6. Input::get() and Input::post() auto-escape, Input::url() is raw

**See also:** [Filters documentation](https://rachie.dev/docs/filters), [Cache documentation](https://rachie.dev/docs/cache), [Controllers documentation](https://rachie.dev/docs/controllers)

---

## Filters & Middleware in Rachie

Filters are Rachie's docblock-based middleware system that executes before/after controller methods.

### Enable Filters

Filters are disabled by default in Rachie. Enable per-controller:

```php
<?php namespace Controllers;
use Rackage\Controller;

class AdminController extends Controller
{
    public $enable_filters = true;  // Required
}
```

### Syntax

#### Internal (Controller Method)
```php
/**
 * @before methodName
 * @after methodName
 */
```
Calls `$this->methodName()` on current controller.

#### External (Separate Class)
```php
/**
 * @before Lib\ClassName, methodName
 * @after Lib\ClassName, methodName
 */
```
Creates instance: `(new Lib\ClassName())->methodName()`

External filters go in `application/libraries/` with `Lib\` namespace.

### Execution Order

#### Single Method
```php
/**
 * @before first
 * @before second
 * @after third
 * @after fourth
 */
public function action() {}
```
Runs: first → second → action() → third → fourth

#### Class + Method Filters
```php
/**
 * @before classB1
 * @after classA1
 */
class Controller {
    /**
     * @before methodB1
     * @after methodA1
     */
    public function action() {}
}
```
Runs: classB1 → methodB1 → action() → methodA1 → classA1

Class filters wrap method filters (outside-in for @before, inside-out for @after).

### Stopping Execution

@before filters can prevent controller method from running by stopping execution.

**Three ways:**
```php
// 1. View::halt() - Recommended
View::halt(['error' => 'Unauthorized'], 401);

// 2. Redirect - Auto-exits
Redirect::to('login');

// 3. View + exit - Manual
View::json(['error' => 'Denied'], 403);
exit;
```

If you don't stop execution, controller method still runs.

### Critical: @after Filters

**@after filters ONLY run if method completes normally.**

If method calls `Redirect::to()`, `View::halt()`, or `exit`, @after filters are **skipped**.

```php
/**
 * @after clearCache  // Won't run
 */
public function update() {
    UserModel::save();
    Redirect::to('users');  // Exits, @after skipped
}

// Fix: Do it before redirect
public function update() {
    UserModel::save();
    Cache::delete('users');  // Do first
    Redirect::to('users');
}
```

Use @after with methods that use `View::render()` or `View::json()` without halt/exit.

### Complete Example

```php
<?php namespace Controllers;
use Rackage\Controller;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\View;
use Rackage\Input;

/**
 * @before checkAuth  // All methods
 */
class AdminController extends Controller
{
    public $enable_filters = true;

    protected function checkAuth() {
        if (!Session::has('user_id')) {
            Redirect::to('login');
        }
    }

    public function dashboard() {
        View::render('admin/dashboard');
    }

    /**
     * @before checkAdmin
     * @before validateInput
     * @after logActivity
     */
    public function createUser() {
        // Order: checkAuth → checkAdmin → validateInput → createUser() → logActivity
        $id = UserModel::save(Input::post());
        View::json(['id' => $id]);  // @after will run
    }

    /**
     * @before checkAdmin
     */
    public function deleteUser($id) {
        UserModel::delete($id);
        Cache::delete('users');  // Before redirect
        Redirect::to('admin/users');
    }

    protected function checkAdmin() {
        if (Session::get('role') !== 'admin') {
            View::halt(403);
        }
    }

    protected function validateInput() {
        if (empty(Input::post('name'))) {
            View::halt(['error' => 'Name required'], 400);
        }
    }

    protected function logActivity() {
        ActivityLog::create(Session::get('user_id'), 'user.create');
    }
}
```

### External Filters in Rachie

**application/libraries/AuthFilter.php:**
```php
<?php namespace Lib;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\View;

class AuthFilter
{
    public function check() {
        if (!Session::has('user_id')) {
            Redirect::to('login');
        }
    }

    public function admin() {
        if (Session::get('role') !== 'admin') {
            View::halt(403);
        }
    }
}
```

**Use in multiple controllers:**
```php
/**
 * @before Lib\AuthFilter, check
 * @before Lib\AuthFilter, admin
 */
class AdminController extends Controller {
    public $enable_filters = true;
}
```

### Best Practices

1. **Always halt on failure** - Use `View::halt()`, `Redirect::to()`, or manual `exit`
2. **Filter methods are protected** - Not public (prevents URL access)
3. **Order matters** - Auth before validation
4. **External for reusability** - Shared filters in `Lib\` namespace
5. **Enable only where needed** - Public controllers don't need filters

### Common Mistakes

**Forgot enable flag:**
```php
public $enable_filters = true;  // Required!
```

**Forgot to halt:**
```php
// Bad
if (!Session::has('user_id')) { }  // Execution continues

// Good
if (!Session::has('user_id')) {
    Redirect::to('login');  // Stops
}
```

**Wrong syntax:**
```php
// Bad - capital B
/**
 * @Before checkAuth
 */

// Good
/**
 * @before checkAuth
 */
```

### How Rachie Processes Filters

```
Request → Rachie Router → Check $enable_filters → Parse docblocks
→ Execute class @before → Execute method @before → Controller method
→ Execute method @after → Execute class @after → Response
```

Rachie's Router uses reflection to read docblocks and execute filters in order.

### Performance

- **Disabled:** 0ms overhead (Rachie doesn't check)
- **Enabled:** ~0.1-0.5ms docblock parsing
- **Real cost:** What your filters do

Keep auth lightweight (session checks, not DB queries). Cache expensive operations.

**Rachie Filters Reference** - Docblock middleware for authentication, authorization, validation, and logging in the Rachie PHP framework.

**See also:** [Full filters documentation](https://rachie.dev/docs/filters)

---

## Controllers in Rachie

Controllers handle incoming requests in Rachie. Public methods become actions accessible via URL routing.

### How Rachie Routes to Controllers

```
URL: /blog/show/my-post

1. Rachie Router parses → controller: "Blog", action: "show", params: ["my-post"]
2. Loads BlogController from application/controllers/
3. Checks for HTTP verb method (getShow, postShow, etc.)
4. Calls getShow('my-post') or falls back to show('my-post')
5. Controller renders response
```

### File Structure

```
application/controllers/
├── HomeController.php
├── BlogController.php
└── AdminController.php
```

### Creating Controllers

**application/controllers/BlogController.php:**
```php
<?php namespace Controllers;

use Rackage\View;
use Rackage\Controller;

class BlogController extends Controller
{
    public function index()
    {
        View::render('blog/index');
    }

    public function show($slug)
    {
        $post = PostModel::where('slug', $slug)->first();

        if (!$post) {
            return View::error(404);
        }

        View::render('blog/show', ['post' => $post]);
    }
}
```

**Requirements:**
- Namespace: `Controllers`
- Extend: `Rackage\Controller`
- Class name matches filename
- Public methods = actions

**URL Mapping:**
- `/blog` → `BlogController::index()`
- `/blog/show/my-post` → `BlogController::show('my-post')`

### HTTP Verb Routing

Rachie routes by HTTP verb. Verb methods take priority over base method.

**Supported:** GET, POST, PUT, DELETE, PATCH

```php
class UserController extends Controller
{
    // GET /user/profile
    public function getProfile()
    {
        $user = UserModel::find(Session::get('user_id'));
        View::render('user/profile', ['user' => $user]);
    }

    // POST /user/profile
    public function postProfile()
    {
        UserModel::where('id', Session::get('user_id'))->save(Input::post());
        Redirect::to('user/profile')->flash('success', 'Updated');
    }
}
```

**Priority Rules:**
- If `profile()` exists → called for ALL verbs
- If no `profile()` → Rachie checks `getProfile()`, `postProfile()`, etc.
- No matching verb method → 404

### Controller Properties

#### $this->settings
All settings from `config/settings.php`:
```php
$devMode = $this->settings['dev'];
$appTitle = $this->settings['title'];
```

#### $this->site_title
Application title:
```php
View::render('home', ['title' => $this->site_title . ' - Welcome']);
```

#### $this->_requestExecutionTime()
Request execution time in seconds:
```php
$time = $this->_requestExecutionTime();
View::render('blog', ['time' => round($time * 1000, 2) . 'ms']);
```

#### $this->enable_filters
Enable Rachie's filter system:
```php
class AdminController extends Controller
{
    public $enable_filters = true;

    /**
     * @before checkAuth
     */
    public function dashboard()
    {
        View::render('admin/dashboard');
    }

    protected function checkAuth()
    {
        if (!Session::has('admin_id')) {
            Redirect::to('admin/login');
        }
    }
}
```

See Filters & Middleware section above or [full documentation](https://rachie.dev/docs/filters) for details.

### Request Parameters

#### URL Parameters
```php
// /blog/show/my-post
public function show($slug) {
    echo $slug;  // "my-post"
}

// /blog/123 (type hint converts string to int)
public function show(int $id) {
    echo $id;  // 123 (integer)
}

// /user/john/edit (multiple params)
public function profile($username, $action = null) {
    echo $username;  // "john"
    echo $action;    // "edit"
}
```

#### GET/POST Parameters
```php
use Rackage\Input;

// /search?q=kenya&page=2
public function search() {
    $query = Input::get('q');        // "kenya"
    $page = Input::get('page', 1);   // 2 (default: 1)
}

public function postLogin() {
    $email = Input::post('email');
    $password = Input::post('password');
}
```

### Example: Form Display + Submission

```php
<?php namespace Controllers;

use Rackage\View;
use Rackage\Input;
use Rackage\Redirect;
use Rackage\Controller;
use Models\PostModel;

class PostController extends Controller
{
    // GET /post - list all
    public function index()
    {
        $posts = PostModel::orderBy('created_at', 'DESC')->all();
        View::render('post/index', ['posts' => $posts]);
    }

    // GET /post/show/123 - show single
    public function show($id)
    {
        $post = PostModel::where('id', $id)->first();
        if (!$post) return View::error(404);
        View::render('post/show', ['post' => $post]);
    }

    // GET /post/create - show form
    public function getCreate()
    {
        View::render('post/create');
    }

    // POST /post/create - process form
    public function postCreate()
    {
        $id = PostModel::save([
            'title' => Input::post('title'),
            'content' => Input::post('content')
        ]);

        Redirect::to('post/show/' . $id)->flash('success', 'Created');
    }
}
```

Pattern extends to: `getEdit($id)`, `postEdit($id)`, `postDelete($id)`, etc.

### Best Practices

#### 1. Use return to Stop Method
```php
// Bad - both execute
if (!$post) { View::error(404); }
View::render('post/show', ['post' => $post]);

// Good - return stops method
if (!$post) { return View::error(404); }
View::render('post/show', ['post' => $post]);
```

**Note:** `return` stops the method but `@after` filters still run. Use `Redirect::to()` or `View::halt()` to stop everything including filters.

#### 2. Use HTTP Verb Methods
```php
// Good
public function getLogin() { /* show form */ }
public function postLogin() { /* process */ }

// Bad - manual check
public function login() {
    if (Request::method() === 'POST') { /* process */ }
}
```

#### 3. Validate Input
```php
use Rackage\Validation;

public function postCreate()
{
    $validator = Validation::make(Input::post(), [
        'title' => 'required|max:255',
        'email' => 'required|email'
    ]);

    if ($validator->fails()) {
        Redirect::back()->flash('errors', $validator->errors());
    }

    // Process valid data
}
```

#### 4. Handle Missing Resources
```php
public function show($id)
{
    $post = PostModel::find($id);
    if (!$post) return View::error(404);
    View::render('post/show', ['post' => $post]);
}
```

#### 5. Early Returns (Reduce Nesting)
```php
// Bad - nested
if ($post) {
    if ($post['published']) {
        View::render('post/show', ['post' => $post]);
    }
}

// Good - flat
if (!$post) return View::error(404);
if (!$post['published']) return View::error(403);
View::render('post/show', ['post' => $post]);
```

### Common Issues

#### Controller Not Found
```php
// File: application/controllers/BlogController.php
<?php namespace Controllers;  // Required namespace

use Rackage\Controller;

class BlogController extends Controller { }  // Match filename
```

#### Method Not Found
Methods must be `public`:
```php
public function show($id) { }     // Works
protected function show($id) { }  // 404 error
```

#### URL Parameters Are Strings
```php
// /blog/123
public function show($id) {
    if ($id === 123) { }  // False - "123" !== 123
}

// Fix: Type hint or cast
public function show(int $id) {
    if ($id === 123) { }  // True
}
```

#### Verb Method Not Called
```php
public function index() { }      // Called for ALL verbs
public function getIndex() { }   // Never called (index exists)

// Fix: Remove base method to enable verb methods
public function getIndex() { }   // Now called for GET
public function postIndex() { }  // Called for POST
```

#### View Not Rendering
```php
// Bad - can't do both
View::render('blog/index');
Redirect::to('home');  // Sends headers, view lost

// Good - choose one
View::render('blog/index');
// OR
Redirect::to('home');
```

### Common Imports

```php
<?php namespace Controllers;

use Rackage\Controller;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\Validation;
use Models\YourModel;
```

### Quick Reference

**Render:**
```php
View::render('blog/index', ['data' => $data]);
View::error(404);
View::json(['results' => $results]);
```

**Input:**
```php
Input::get('q');           // GET/POST/URL
Input::post('email');      // POST only
Input::get('page', 1);     // With default
```

**Database:**
```php
PostModel::all();
PostModel::where('id', $id)->first();
PostModel::save(['title' => 'New']);
PostModel::where('id', $id)->delete();
```

**Redirect:**
```php
Redirect::to('blog');
Redirect::back();
Redirect::to('blog')->flash('success', 'Saved!');
```

**Session:**
```php
Session::set('user_id', 123);
Session::get('user_id');
Session::has('user_id');
```

**Rachie Controllers Reference** - Request handling and routing in the Rachie PHP framework.

**See also:** [Full controllers documentation](https://rachie.dev/docs/controllers)

---

## Caching in Rachie

Caching stores frequently-accessed data in memory or on disk so you don't have to regenerate or fetch it from the database every time. This dramatically speeds up your application by reducing expensive operations like database queries, API calls, and complex calculations.

Two independent systems:
1. **Page Cache**: Router-level, automatic HTML caching (before controller)
2. **Data Cache**: Developer-level, manual data caching (controller always runs)

---

### Page Caching (Router-Level)

### Execution Flow
```
Request → Router::dispatch()
  ↓
Router::checkCache()
  ├─ Cache hit → echo cached HTML → exit (controller NEVER runs)
  └─ Cache miss → continue to controller
       ↓
    Controller executes → View::render()
       ↓
    Router captures output (ob_start/ob_get_clean)
       ↓
    Router::storeCache() → saves HTML
       ↓
    Response sent
```

### Configuration
File: config/cache.php

| Setting | Type | Description |
|---------|------|-------------|
| enabled | bool | Enable page cache (does NOT affect data cache) |
| lifetime | int | Seconds (3600 = 1 hour) |
| methods | array | ['GET','HEAD'] - only these cached |
| exclude_urls | array | URLs to skip caching |
| default | string | Driver: 'file'\|'memcached'\|'redis' |

### Cache Key Generation
```php
$uri = Request::fullUri();  // "/search?q=laptop&page=2" from $_SERVER['REQUEST_URI']
$key = 'page:' . md5($uri);
```

**Critical:** Query params matter - different params = different cache
- /search?q=laptop → page:8f3d1e5a...
- /search?q=phone → page:9a1b2c3d... (separate entry)

### URL Exclusion Matching
```php
'exclude_urls' => [
    '/admin',      // Exact: /admin only (not /admin/users)
    '/admin/*',    // Wildcard: /admin and all subpaths
    '/user/*',     // All user paths
]
```

Matches against Request::path() (no query string).

### What Gets Cached
Complete rendered HTML output from View::render():
- Full DOCTYPE, <html>, <head>, <body>
- Compiled template result
- Does NOT cache: redirects, JSON responses, errors

### Cache Check Logic (Router)
```php
if (!$config['enabled']) return false;                    // Disabled globally
if (!in_array(Request::method(), $config['methods'])) return false;  // POST/PUT/DELETE
if ($this->isExcluded(Request::path())) return false;     // In exclude_urls
if (!Cache::has($cacheKey)) return false;                 // No cache entry

// All checks passed - serve cache
echo Cache::get($cacheKey);
exit;  // Stop execution
```

### Performance
- Cache hit: ~1-2ms (echo HTML)
- Cache miss (first request): Normal timing + cache write (~5ms overhead)
- Subsequent: 1-2ms (50-500x faster than no cache)

---

### Data Caching (Developer-Level)

Controller ALWAYS executes. You cache specific data (queries, API calls, calculations).
Works independently of page cache 'enabled' setting.

### Methods

| Method | Parameters | Returns | Behavior |
|--------|------------|---------|----------|
| set(key, val, mins) | string, mixed, int | bool | Store with TTL. Returns false on failure |
| get(key) | string | mixed\|**false** | Returns FALSE on miss (not null, not empty) |
| has(key) | string | bool | Check exists + not expired |
| delete(key) | string | bool | Remove entry |
| flush() | None | bool | Delete ALL cache entries |
| remember(key, mins, callback) | string, int, callable | mixed | Get or execute+store+return |
| forever(key, val) | string, mixed | bool | Store for 525600 mins (1 year) |

**Critical:** get() returns FALSE on miss - check with `=== false`, not `!$val` (breaks on cached falsy values).

### remember() Internals
```php
Cache::remember('key', 60, function() {
    return ExpensiveQuery::all();
});

// Equivalent to:
if (Cache::has('key')) {
    return Cache::get('key');  // Cache hit
}
$result = $callback();         // Cache miss - execute
Cache::set('key', $result, 60);
return $result;
```

Callback ONLY executes on cache miss.

### Drivers

**File Cache (default)**
- Storage: vault/cache/{md5(key)}.cache
- Format: Serialized PHP with expiration timestamp
- Expiration check: On every get(), compares time() to stored timestamp
- Concurrency: Not locked (last write wins)
- Cleanup: Manual (old files remain until flush/overwrite)

**Memcached**
- Storage: RAM (lost on restart)
- Expiration: Automatic (Memcached handles)
- Concurrency: Thread-safe
- Eviction: LRU when memory full

**Redis**
- Storage: RAM + optional disk persistence
- Expiration: Automatic with TTL
- Concurrency: Thread-safe
- Features: Advanced data structures, pub/sub

Config:
```php
'drivers' => [
    'file' => ['path' => 'vault/cache'],
    'memcached' => ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100],
    'redis' => ['host' => '127.0.0.1', 'port' => 6379, 'password' => '', 'database' => 0],
]
```

---

### Common Patterns

### Basic Query Caching
```php
$posts = Cache::remember('posts_all', 60, fn() => PostModel::all());
```

### Parameterized Caching
```php
$key = 'posts_cat_' . $slug;
$posts = Cache::remember($key, 30, fn() => PostModel::where('category',$slug)->all());
```

### User-Specific Caching
```php
$userId = Session::get('user_id');
$key = 'user_' . $userId . '_dashboard';
$data = Cache::remember($key, 60, fn() => UserModel::getDashboardData($userId));
```

### Fragment Caching (Multiple Lifetimes)
```php
$recent = Cache::remember('widget_recent', 30, fn() => PostModel::orderBy('created_at','DESC')->limit(5)->all());
$popular = Cache::remember('widget_popular', 120, fn() => PostModel::orderBy('views','DESC')->limit(5)->all());
```

### Cache Invalidation (Critical)
```php
PostModel::save($data);
Cache::delete('posts_all');               // Granular
Cache::delete('posts_cat_' . $category); // Specific category
Cache::delete('widget_recent');          // Fragment

// Nuclear option (use sparingly)
Cache::flush();  // Clears EVERYTHING including page cache
```

### Conditional Caching
```php
// Cache for guests only
if (!Session::has('user_id')) {
    $posts = Cache::remember('posts_public', 60, fn() => PostModel::where('public',1)->all());
} else {
    $posts = PostModel::all();  // Logged in - skip cache
}
```

---

### Critical Gotchas

### 1. Cache::get() Returns FALSE
```php
// WRONG - fails if cached value is 0, "", [], false
if (!$data) { $data = ExpensiveQuery(); }

// CORRECT
$data = Cache::get('key');
if ($data === false) { $data = ExpensiveQuery(); }

// BEST - use remember()
$data = Cache::remember('key', 60, fn() => ExpensiveQuery());
```

### 2. Key Collisions
```php
// WRONG - different types, same ID
Cache::set('123', $user);
Cache::set('123', $post);  // Overwrites user!

// CORRECT - namespace
Cache::set('user_123', $user);
Cache::set('post_123', $post);
```

### 3. Stale Cache After Updates
```php
// WRONG
PostModel::where('id',$id)->save($data);
Redirect::to('posts');  // Cache still has old data!

// CORRECT
PostModel::where('id',$id)->save($data);
Cache::delete('posts_all');
Cache::delete('post_'.$id);
Redirect::to('posts');
```

### 4. Page Cache with User-Specific Content
```php
// WRONG - everyone sees same cached HTML
public function dashboard() {
    $user = UserModel::getById(Session::get('user_id'));
    View::render('dashboard', ['user' => $user]);
}

// CORRECT - exclude from page cache
// config/cache.php
'exclude_urls' => ['/dashboard', '/user/*', '/admin/*']
```

### 5. Forgetting Query Params in Keys
```php
// WRONG - same cache for all pages
$posts = Cache::remember('posts', 30, fn() => PostModel::paginate(20, $page));

// CORRECT - include param in key
$page = Input::get('page', 1);
$posts = Cache::remember('posts_page_'.$page, 30, fn() => PostModel::paginate(20, $page));
```

---

### Troubleshooting

| Problem | Cause | Fix |
|---------|-------|-----|
| Cache::set() returns false | vault/cache/ not writable | chmod 755 vault/cache |
| Page cache not working | 'enabled' => false | Set to true in config/cache.php |
| Controller always runs | URL in exclude_urls | Remove from array or use data cache |
| Stale data after update | Forgot Cache::delete() | Invalidate related keys after save/delete |
| Cache keys colliding | Reusing same key | Namespace: 'user_123', 'post_123' |
| Memcached/Redis error | Server not running | Check server, PHP extension, config |

---

### Performance Guidelines

**Cache when:**
- Database query > 50ms
- External API calls
- Complex calculations (aggregations, loops)
- Data changes < hourly

**Don't cache when:**
- Simple queries (WHERE id = ?)
- Real-time data requirements
- User-specific content (page cache)
- Already fast operations

**Expiration times:**
- Rarely changes: 1440+ mins (24h+)
- Sometimes changes: 60 mins
- Frequently changes: 15-30 mins
- Real-time with tolerance: 1-5 mins

---

**Caching in Rachie** provides two independent systems for dramatic performance improvements: router-level page caching that serves cached HTML before controllers execute, and developer-level data caching for queries, API calls, and calculations.

See also: [Rachie Cache Documentation](https://rachie.dev/docs/cache)


## Templates & Views in Rachie

Concise reference for rendering views and using template syntax in Rachie applications.

### View Rendering

#### Basic Rendering

```php
// Render view with template compilation
View::render('blog/show', [
    'post' => $post,
    'comments' => $comments
]);

// Render as plain PHP (no template compilation)
View::plain('exports/csv', ['rows' => $data]);

// JSON response
View::json(['status' => 'success', 'data' => $results], 200);

// Error pages
View::error(404);
View::error(500, ['message' => 'Database error']);

// Chain data
View::with(['user' => $user])
    ->with(['posts' => $posts])
    ->render('dashboard');
```

#### Path Resolution

```php
View::render('blog/show')
→ application/views/blog/show.php

View::render('admin/users/edit')
→ application/views/admin/users/edit.php
```

All view files must end with `.php`. Don't include the extension when rendering.

#### Custom View Paths

Configure additional view directories in `config/settings.php` to load templates from custom locations. Useful for themes, plugins, and multi-tenant applications.

**Configuration:**
```php
// config/settings.php
'view_paths' => [
    'themes/',
    'plugins/',
    'application/custom_views/'
],
```

**Resolution Order:**
1. Checks each custom path in order
2. Falls back to `application/views/` if not found

**Example:**
```php
// With view_paths = ['themes/']
View::render('aurora/home')
→ themes/aurora/home.php (if exists)
→ application/views/aurora/home.php (fallback)

// With view_paths = ['themes/', 'plugins/']
View::render('gallery/index')
→ themes/gallery/index.php (checked first)
→ plugins/gallery/index.php (checked second)
→ application/views/gallery/index.php (fallback)
```

**Use Cases:**
- **Themes:** Store theme templates in `themes/` directory
- **Plugins:** Plugin-specific views in `plugins/plugin-name/views/`
- **Multi-tenant:** Tenant-specific templates in `tenants/{tenant_id}/views/`
- **Modular apps:** Module views in `modules/{module}/views/`

**Notes:**
- Paths are relative to application root
- `application/views` is automatically skipped if listed (always used as fallback)
- Duplicate paths are ignored

#### Data Passing

Variables passed to views are extracted into local scope:

```php
View::render('products/show', [
    'product' => $product,
    'rating' => 4.5
]);

// In view:
{{ $product['name'] }}
{{ $rating }}
```

### Template Syntax

#### Echo Tags

```php
// Escaped (secure by default) - USE FOR ALL USER INPUT
{{ $variable }}
{{ $user['name'] }}
{{ $post['title'] }}

// Raw (unescaped) - ONLY FOR TRUSTED HTML
{{{ $htmlContent }}}
{{{ $wysiwyg_output }}}

// With default value
{{ $name or 'Guest' }}
{{ $price or '0.00' }}
{{ $title or 'Untitled' }}
```

**Security Rule:** Always use `{{ }}` for user-generated content. Only use `{{{ }}}` for HTML you control.

#### Control Structures

```php
// If / Else
@if($user)
    <p>Welcome, {{ $user['name'] }}</p>
@endif

@if($role === 'admin')
    <a href="/admin">Admin Panel</a>
@elseif($role === 'editor')
    <a href="/editor">Editor</a>
@else
    <a href="/dashboard">Dashboard</a>
@endif

// Isset check
@isset($user)
    <p>User is set</p>
@endisset

@isset($user, $posts)
    <p>User has {{ count($posts) }} posts</p>
@endisset
```

#### Loops

```php
// Foreach
@foreach($posts as $post)
    <article>{{ $post['title'] }}</article>
@endforeach

@foreach($users as $key => $user)
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $user['name'] }}</td>
    </tr>
@endforeach

// For loop
@for($i = 0; $i < 10; $i++)
    <div>Item {{ $i }}</div>
@endfor

// While loop
@while($condition)
    <div>Processing...</div>
@endwhile

// Foreach with empty fallback
@loopelse($products as $product)
    <div>{{ $product['name'] }}</div>
@empty
    <p>No products found.</p>
@endloop

// Break and Continue
@foreach($items as $item)
    @continue($item['hidden'])
    @break($item['id'] === 100)

    <div>{{ $item['name'] }}</div>
@endforeach
```

#### Layout Inheritance

```php
// Child view extends parent layout
@extends('layouts/main')

@section('title', 'Page Title')

@section('content')
    <h1>Page Content</h1>
    <p>This goes into the content section.</p>
@endsection

@section('scripts')
    <script src="custom.js"></script>
@endsection
```

```php
// Parent layout defines structure
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - My Site</title>
</head>
<body>
    <nav>Navigation</nav>

    @yield('content')

    <footer>Footer</footer>

    <script src="app.js"></script>
    @yield('scripts')
</body>
</html>
```

#### Section with @parent

```php
// Parent layout
@section('scripts')
    <script src="jquery.js"></script>
@endsection

// Child view - prepend to parent's content
@section('scripts')
    @parent  <!-- Parent's scripts load first -->
    <script src="my-script.js"></script>
@endsection
// Result: jquery.js, then my-script.js

// Child view - append to parent's content
@section('scripts')
    <script src="my-script.js"></script>
    @parent  <!-- Parent's scripts load after -->
@endsection
// Result: my-script.js, then jquery.js
```

#### File Inclusion

```php
@include('partials/header')
@include('partials/footer')
```

All variables from parent view are available in included partials.

#### Raw PHP Blocks

```php
@php
    $total = array_sum($prices);
    $discount = $total * 0.1;
    $finalPrice = $total - $discount;
@endphp

<p>Total: {{ $finalPrice }}</p>
```

Use sparingly - complex logic belongs in controllers.

#### Escape Directives

```php
@@if($condition)
// Outputs: @if($condition)

<code>
    @@section('content')
    @@yield('title')
</code>
// Outputs literal @section and @yield
```

### Complete Directive Reference

| Directive | Syntax | Description |
|-----------|--------|-------------|
| `{{ }}` | `{{ $var }}` | Escaped echo (secure) |
| `{{{ }}}` | `{{{ $html }}}` | Raw echo (unescaped) |
| `@if` | `@if($cond) ... @endif` | Conditional |
| `@elseif` | `@elseif($cond)` | Else if |
| `@else` | `@else` | Else |
| `@isset` | `@isset($var) ... @endisset` | Check if set |
| `@foreach` | `@foreach($items as $item) ... @endforeach` | Loop array |
| `@for` | `@for($i=0; $i<10; $i++) ... @endfor` | For loop |
| `@while` | `@while($cond) ... @endwhile` | While loop |
| `@loopelse` | `@loopelse($items as $item) ... @empty ... @endloop` | Foreach with fallback |
| `@break` | `@break` or `@break($cond)` | Exit loop |
| `@continue` | `@continue` or `@continue($cond)` | Skip iteration |
| `@extends` | `@extends('layout')` | Extend parent layout |
| `@section` | `@section('name') ... @endsection` | Define section |
| `@yield` | `@yield('name')` | Section placeholder |
| `@parent` | `@parent` | Include parent's section content |
| `@include` | `@include('partial')` | Include partial view |
| `@php` | `@php ... @endphp` | Raw PHP block |
| `@@` | `@@directive` | Escape directive |

### Common Patterns

#### User Dashboard

```php
<!-- Controller -->
View::render('dashboard', [
    'user' => $user,
    'stats' => $stats,
    'recentActivity' => $activity
]);

<!-- View -->
@extends('layouts/app')

@section('content')
    <div class="dashboard">
        <h1>Welcome, {{ $user['name'] }}</h1>

        <div class="stats">
            @foreach($stats as $label => $value)
                <div class="stat">
                    <span class="label">{{ $label }}</span>
                    <span class="value">{{ $value }}</span>
                </div>
            @endforeach
        </div>

        <h2>Recent Activity</h2>
        @loopelse($recentActivity as $activity)
            <div class="activity">
                {{ $activity['description'] }}
                <time>{{ Date::format($activity['timestamp'], 'M j') }}</time>
            </div>
        @empty
            <p>No recent activity.</p>
        @endloop
    </div>
@endsection
```

#### Flash Messages

```php
<!-- Layout -->
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-error">
        {{ Session::get('error') }}
    </div>
@endif

<!-- Controller -->
Session::flash('success', 'Post created successfully!');
Redirect::to('blog');
```

#### Pagination

```php
<!-- Controller -->
View::render('blog/index', [
    'posts' => $posts,
    'page' => $page,
    'totalPages' => $totalPages
]);

<!-- View -->
@foreach($posts as $post)
    <article>{{ $post['title'] }}</article>
@endforeach

<div class="pagination">
    @if($page > 1)
        <a href="?page={{ $page - 1 }}">Previous</a>
    @endif

    @for($i = 1; $i <= $totalPages; $i++)
        <a href="?page={{ $i }}" class="{{ $i === $page ? 'active' : '' }}">
            {{ $i }}
        </a>
    @endfor

    @if($page < $totalPages)
        <a href="?page={{ $page + 1 }}">Next</a>
    @endif
</div>
```

#### Conditional Assets

```php
<!-- Layout -->
<head>
    <link rel="stylesheet" href="{{ Url::assets('css/app.css') }}">
    @yield('styles')
</head>
<body>
    @yield('content')

    <script src="{{ Url::assets('js/app.js') }}"></script>
    @yield('scripts')
</body>

<!-- Child view adds page-specific assets -->
@section('styles')
    <link rel="stylesheet" href="{{ Url::assets('css/datatables.css') }}">
@endsection

@section('scripts')
    <script src="{{ Url::assets('js/datatables.js') }}"></script>
@endsection
```

#### Nested Loops

```php
@foreach($categories as $category)
    <div class="category">
        <h2>{{ $category['name'] }}</h2>

        @loopelse($category['products'] as $product)
            <div class="product">
                <h3>{{ $product['name'] }}</h3>
                <p>{{ $product['price'] }}</p>

                @foreach($product['images'] as $image)
                    <img src="{{ $image['url'] }}" alt="{{ $product['name'] }}">
                @endforeach
            </div>
        @empty
            <p>No products in this category.</p>
        @endloop
    </div>
@endforeach
```

### File Structure

```
application/
  controllers/
    BlogController.php       → blog methods
    UserController.php       → user methods
  views/
    blog/
      layout.php              → admin layout
      index.php              → blog listing
      show.php               → single post
    errors/
      404.php                → not found page
      500.php                → server error page
  libraries/                 → custom helper classes (Lib\ namespace)
    Currency.php
```

### Custom View Helpers

Create helper class:

```php
<?php namespace Lib;

class Currency
{
    public static function format($amount)
    {
        return '$' . number_format($amount, 2);
    }
}
```

Location: `application/libraries/Currency.php`

Add to `config/settings.php`:

```php
'view_helpers' => array(
    // ... existing helpers ...
    'Lib\Currency',
),
```

Use in views:

```php
<span>{{ Currency::format($price) }}</span>
```

### Security Notes

1. **Always use `{{ }}` for user input** - automatically escapes HTML
2. **Only use `{{{ }}}` for trusted HTML** - your CMS content, not user input
3. **Include Csrf tokens in forms**:
   ```php
   <form method="POST">
       {{ Csrf::field() }}
   </form>
   ```
4. **Validate and sanitize in controllers** - don't trust any user input

### Quick Tips

- View files must be in `application/views/` and end with `.php`
- Layout inheritance uses text replacement (no runtime overhead)
- Variables from parent view are available in `@include` partials
- Use `@loopelse` when you need empty state handling
- Keep complex logic in controllers, not views
- View helpers are auto-imported in views only (controllers need `use` statements)

**Rachie Template Engine Reference** - View rendering and template syntax for the Rachie PHP framework.

**See also:** [Full template documentation](https://rachie.dev/docs/templates)

---

## Models & Database in Rachie

**Rachie Model** is the database layer for Rachie Framework applications. Provides chainable query builder for MySQL/PostgreSQL/SQLite. All values auto-escaped via `mysqli->real_escape_string()`.

**Architecture:** Hybrid static/instance - call static methods (`PostModel::where()`), internally creates fresh instances per query chain to prevent state pollution.

**Usage:** Create models in `application/models/`, extend `Rackage\Model`. Works with Roline CLI for schema management via `@column` annotations.

**Connections:** Singleton-based, shared across models. Four types: sync (default), async, stream, fresh.


### Model Setup

**Location:** `application/models/YourModel.php`
```php
<?php namespace Models;
use Rackage\Model;

class PostModel extends Model {
    protected static $table = 'posts';           // Required: table name
    protected static $timestamps = true;         // Optional: auto-manage created_at/updated_at
}
```

**Schema:** Use `@column` annotations for Roline CLI integration.

**Config:** `config/database.php`
```php
return [
    'default' => 'mysql',
    'mysql' => ['host' => 'localhost', 'username' => 'root', 'password' => '', 'database' => 'db', 'charset' => 'utf8mb4']
];
```

---

### CREATE Methods

```
Method                          Returns    Description
save(data, [col])              int        Insert/update. Bulk: array[]. col: match key for bulk update
saveById(data)                 int        Update by ID (extracts 'id' from array)
saveUpdate(data, [fields])     int        Upsert. 1=insert, 2=update. fields: selective update on dup
saveIgnore(data)               int        INSERT IGNORE. Skip duplicates
increment(fields, [col])       int        Atomic add BY amount. Bulk: array[] + col. Prevents races
decrement(fields, [col])       int        Atomic subtract BY amount. NOTE: Unsigned cols error if <0
```

**Examples:**
```php
// save() - all variations
GOOD: $id = PostModel::save(['title' => 'Hello', 'status' => 'draft']);                        // Single insert
GOOD: $affected = PostModel::where('id', 5)->save(['title' => 'Updated']);                    // Update with WHERE
GOOD: PostModel::save([['title' => 'Post 1'], ['title' => 'Post 2']]);                        // Bulk insert
GOOD: ProductModel::save([['id' => 1, 'price' => 99.99], ['id' => 2, 'price' => 149.99]], 'id');  // Bulk update with match column
BAD: PostModel::save(Input::post());                                                            // Mass assignment vulnerability!

// saveById() - convenience wrapper
GOOD: PostModel::saveById(['id' => 5, 'title' => 'Updated', 'status' => 'published']);
// Equivalent to: PostModel::where('id', 5)->save(['title' => 'Updated', 'status' => 'published'])

// saveUpdate() - upsert patterns
GOOD: CacheModel::saveUpdate(['key' => 'foo', 'value' => 'bar', 'expires' => '2024-12-31']);
GOOD: PageModel::saveUpdate(['url_hash' => 'abc', 'url' => 'https://example.com', 'title' => 'Example', 'visits' => 1], ['title', 'visits']);  // Only update title+visits on dup
GOOD: PageViewModel::saveUpdate(['page_url' => $url, 'views' => 1], ['views' => 'views + 1']);  // Atomic counter on duplicate
GOOD: ProductModel::saveUpdate([['sku' => 'A1', 'name' => 'Product A', 'price' => 10], ['sku' => 'B2', 'name' => 'Product B', 'price' => 20]], ['name', 'price']);  // Bulk upsert

// saveIgnore() - skip duplicates
GOOD: $inserted = QueueModel::saveIgnore([['url' => 'https://a.com', 'url_hash' => 'abc'], ['url' => 'https://a.com', 'url_hash' => 'abc']]);  // Second skipped

// increment() - atomic operations
GOOD: ArticleModel::where('id', $id)->increment(['views']);                                     // Increment by 1
GOOD: UserModel::where('id', $userId)->increment(['score' => 10]);                             // Increment by 10
GOOD: PostModel::where('id', $postId)->increment(['views' => 1, 'shares' => 1]);              // Multiple fields
GOOD: PostModel::increment([['id' => 1, 'views' => 10], ['id' => 2, 'views' => 5]], 'id');   // Bulk atomic increment
BAD: $post = PostModel::getById($id); PostModel::save(['id' => $id, 'views' => $post['views'] + 1]);  // Race condition!

// decrement() - atomic subtract
GOOD: ProductModel::where('sku', $sku)->decrement(['stock']);                                   // Decrement by 1
GOOD: UserModel::where('id', $userId)->decrement(['credits' => 100]);                          // Decrement by 100
GOOD: ProductModel::decrement([['id' => 101, 'stock' => 2], ['id' => 102, 'stock' => 1]], 'id');  // Bulk atomic decrement
// NOTE: Unsigned columns: Decrementing below 0 throws error - check value first or use try-catch

// Timestamps: Auto-sets created_at on INSERT, updated_at on UPDATE when $timestamps = true
```

---

### READ - Fetching Methods

```
Method                Returns       Description
all()                array         All matching records. Empty array if none
first()              array|null    Single record or null
find(id)             array|null    Quick ID lookup (shorthand for getById). Returns null if not found
getById(id)          array         Quick ID lookup via first(). Empty array if not found
count()              int           Count without loading rows
select(cols)         QB            Choose columns. Default: SELECT *
```

**Examples:**
```php
// all() - fetch multiple
GOOD: $posts = PostModel::all();
GOOD: $posts = PostModel::where('status', 'published')->order('created_at', 'desc')->all();

// first() - fetch single
GOOD: $post = PostModel::where('id', 5)->first();
if (!$post) View::error(404);
// Access: $post['title'], $post['content']

// find() - quick ID lookup (shorthand)
GOOD: $post = PostModel::find(5);
if (!$post) View::error(404);

// getById() - quick lookup (classic)
GOOD: $post = PostModel::getById(5);
if (!empty($post)) { echo $post['title']; }

// count() - efficient counting
GOOD: $total = SubscriptionModel::count();
GOOD: $active = SubscriptionModel::where('status', 'active')->count();

// select() - specific columns
GOOD: $products = ProductModel::select(['id', 'name', 'price'])->all();
GOOD: $customers = CustomerModel::select(['id', 'name', 'avatar'])->where('status', 'active')->all();  // Avoid exposing password, tokens
```

---

### READ - Filtering Methods

```
Method                          Returns    Description
where(cond, ...vals)           QB         Filter with ? placeholders. Chains AND. Shorthand: where('col','val') for =
orWhere(cond, ...vals)         QB         Add OR condition
whereIn(col, array)            QB         Match any value in array
whereNotIn(col, array)         QB         Exclude values in array
whereBetween(col, min, max)    QB         Range query (inclusive)
whereLike(col, pattern)        QB         Pattern match. % = wildcard, _ = single char
whereNotLike(col, pattern)     QB         Exclude pattern
whereNull(col)                 QB         Find NULL values
whereNotNull(col)              QB         Find non-NULL values
whereDate(col, date)           QB         Match date (ignores time)
whereMonth(col, month)         QB         Match month 1-12
whereYear(col, year)           QB         Match year
```

**Examples:**
```php
// where() - basic filtering
GOOD: ProductModel::where('status = ?', 'active')->all();
GOOD: ProductModel::where('price > ?', 100)->all();
GOOD: ProductModel::where('status', 'active')->all();                                          // Equality shorthand
GOOD: SubscriptionModel::where('status', 'active')->where('tier', 'premium')->all();          // Multiple (AND)
GOOD: OrderModel::where('status = ? AND total > ?', 'paid', 100)->all();                      // Multiple in one where
GOOD: ProductModel::where('price > ?', 100)->all();                                            // Other operators need ?
BAD: ProductModel::where('price >', 100)->all();                                               // Won't work

// orWhere() - OR logic
GOOD: SubscriptionModel::where('status', 'active')->orWhere('status', 'trial')->all();
GOOD: DealModel::where('owner_id', 5)->where('status', 'open')->orWhere('priority', 'urgent')->all();  // SQL: WHERE owner_id = 5 AND status = 'open' OR priority = 'urgent'

// whereIn() - match any
GOOD: OrderModel::whereIn('id', [1, 2, 3, 4, 5])->all();
GOOD: DealModel::whereIn('stage', ['proposal', 'negotiation', 'contract'])->all();

// whereNotIn() - exclude
GOOD: OrderModel::whereNotIn('status', ['cancelled', 'refunded'])->all();

// whereBetween() - ranges
GOOD: ProductModel::whereBetween('price', 10.00, 50.00)->all();
GOOD: OrderModel::whereBetween('created_at', '2024-01-01', '2024-12-31')->all();

// whereLike() - patterns
GOOD: PropertyModel::whereLike('address', '%Main Street%')->all();
GOOD: CustomerModel::whereLike('email', '%@company.com')->all();
GOOD: ProductModel::whereLike('sku', 'ELC-%')->all();

// whereNotLike() - exclude patterns
GOOD: CustomerModel::whereNotLike('email', '%spam.com')->all();

// whereNull() / whereNotNull()
GOOD: PropertyModel::whereNull('photo_url')->all();
GOOD: CustomerModel::whereNotNull('verified_at')->all();

// whereDate() / whereMonth() / whereYear()
GOOD: OrderModel::whereDate('created_at', '2024-01-15')->all();
GOOD: CustomerModel::whereDate('created_at', date('Y-m-d'))->all();                            // Today
GOOD: OrderModel::whereMonth('created_at', 12)->all();                                         // December
GOOD: SubscriptionModel::whereMonth('expires_at', date('n'))->all();                           // Current month
GOOD: TransactionModel::whereYear('created_at', 2024)->all();
GOOD: OrderModel::whereYear('created_at', 2024)->whereMonth('created_at', 12)->all();         // Dec 2024

// Security: Always use ? placeholders
GOOD: ProductModel::where('category = ?', Input::get('category'))->all();
BAD: ProductModel::sql("SELECT * FROM products WHERE category = '" . Input::get('category') . "'");  // SQL injection!
```

---

### READ - Sorting & Limiting

```
Method                     Returns    Description
order(col, dir)           QB         Sort. dir: 'asc'/'desc'. Chain for multi-level
limit(count, [page])      QB         Cap results. page: offset calculation
paginate(perPage, page)   object     Pagination with metadata (data, total, last_page, etc)
unique()                  QB         DISTINCT. Use with select() for specific column
```

**Examples:**
```php
// order() - sorting
GOOD: OrderModel::order('created_at', 'desc')->all();                                          // Newest first
GOOD: ProductModel::order('price', 'asc')->all();                                              // Cheapest first
GOOD: TicketModel::order('priority', 'desc')->order('created_at', 'asc')->all();              // Multi-level sort

// limit() - cap results
GOOD: ProductModel::limit(10)->all();                                                          // First 10
GOOD: OrderModel::limit(20, 3)->all();                                                         // Page 3 (offset 40)
GOOD: DealModel::order('value', 'desc')->limit(5)->all();                                     // Top 5

// paginate() - with metadata
GOOD: $result = ProductModel::paginate(25, 1);
// $result->data (array), $result->current_page, $result->total, $result->last_page, $result->from, $result->to
GOOD: $result = CustomerModel::where('status', 'active')->order('name', 'asc')->paginate(50, Input::get('page', 1));

// unique() - distinct values
GOOD: ProductModel::select(['category'])->unique()->all();
GOOD: CustomerModel::select(['city'])->unique()->all();
GOOD: ArticleModel::select(['tag'])->where('status', 'published')->unique()->all();
```

---

### JOINS & GROUPING

```
Method                           Returns    Description
leftJoin(table, cond, cols)     QB         Include all from main table. cols from join table
innerJoin(table, cond, cols)    QB         Only matching records from both tables
groupBy(...cols)                QB         Group results by column(s)
having(cond, ...vals)           QB         Filter grouped results. Use after groupBy()
```

**Examples:**
```php
// leftJoin() - include all from main table
GOOD: PostModel::leftJoin('users', 'user_id = id', ['name', 'email'])->all();                 // Auto-prefix: posts.user_id = users.id
GOOD: OrderModel::leftJoin('customers', 'customer_id = id', ['name', 'email'])->leftJoin('products', 'product_id = id', ['name', 'price'])->all();  // Star pattern (both join to orders)
GOOD: OrderModel::leftJoin('customers', 'customer_id = id', ['name'])->leftJoin('addresses', 'customers.address_id = id', ['city'])->all();  // Chain joins (manual prefix on second)
GOOD: ProductModel::leftJoin('categories', 'category_id = id', ['name as category_name'])->leftJoin('brands', 'brand_id = id', ['name as brand_name'])->all();  // Aliases avoid conflicts
GOOD: PostModel::select(['id', 'title', 'content'])->leftJoin('users', 'user_id = id', ['name', 'email'])->all();  // Select from main + join
GOOD: PropertyModel::leftJoin('photos', 'id = property_id AND is_primary = 1', ['url'])->all();  // Additional join conditions

// innerJoin() - only matching records
GOOD: LeadModel::innerJoin('users', 'assigned_to = id', ['name'])->where('status', 'active')->all();
GOOD: SubscriptionModel::innerJoin('payment_methods', 'payment_method_id = id', ['type', 'last4'])->all();

// groupBy() - group results
GOOD: OrderModel::groupBy('status')->all();
GOOD: CustomerModel::groupBy('country', 'city')->all();
GOOD: OrderModel::where('created_at > ?', '2024-01-01')->groupBy('status')->all();

// having() - filter groups
GOOD: OrderModel::groupBy('customer_id')->having('customer_id > ?', 100)->all();
GOOD: OrderModel::where('status', 'paid')->groupBy('customer_id')->having('customer_id > ?', 50)->all();
```

---

### AGGREGATES

```
Method            Returns    Description
sum(col)         float      Calculate sum of column
avg(col)         float      Calculate average
min(col)         mixed      Find minimum value
max(col)         mixed      Find maximum value
pluck(col)       array      Extract single column as flat array
exists()         bool       Check if any records match
```

**Examples:**
```php
// sum() - total values
GOOD: $revenue = OrderModel::sum('total');
GOOD: $monthlyRevenue = OrderModel::whereMonth('created_at', date('n'))->whereYear('created_at', date('Y'))->sum('total');

// avg() - average
GOOD: $avgOrder = OrderModel::avg('total');
GOOD: $avgDealSize = DealModel::where('status', 'won')->avg('amount');

// min() / max()
GOOD: $lowestPrice = ProductModel::where('in_stock', 1)->min('price');
GOOD: $highestPrice = ProductModel::max('price');
GOOD: $lastOrderDate = OrderModel::where('customer_id', $customerId)->max('created_at');

// pluck() - flat array
GOOD: $productIds = ProductModel::where('in_stock', 1)->pluck('id');                           // Returns: [1, 2, 3, 4, 5]
GOOD: $emails = CustomerModel::where('subscribed', 1)->pluck('email');
GOOD: $categories = ProductModel::select(['category'])->unique()->pluck('category');

// exists() - check presence
GOOD: $exists = UserModel::where('username', $username)->exists();
GOOD: $hasOrders = OrderModel::where('status', 'active')->exists();
```

---

### DELETE

```
Method              Returns    Description
delete(id)         int        Delete by ID (shorthand). Pass $id or use with WHERE
deleteById(id)     int        Delete by ID (classic). Returns affected rows (1 or 0)
```

**Examples:**
```php
// delete() - with ID parameter (shorthand)
GOOD: $deleted = PostModel::delete(123);
if ($deleted > 0) echo "Deleted";

// delete() - with WHERE clause (no ID parameter)
GOOD: $deleted = CommentModel::where('status', 'spam')->delete();
GOOD: $deleted = PostModel::where('status', 'draft')->where('created_at < ?', '2024-01-01')->delete();
GOOD: $deleted = PostModel::where('author_id', $bannedId)->orWhereLike('content', '%spam%')->delete();
BAD: PostModel::delete();                                                                       // Deletes ALL records!

// deleteById() - quick delete (classic)
GOOD: $deleted = PostModel::deleteById(123);
if ($deleted > 0) echo "Deleted";

// Soft delete pattern (alternative)
GOOD: PostModel::where('id', $id)->save(['status' => 'deleted', 'deleted_at' => date('Y-m-d H:i:s')]);
// Query non-deleted: PostModel::where('status !=', 'deleted')->all();
```

---

### ADVANCED QUERYING

```
Method                                Returns         Description
whereFulltext(cols, search, [mode])  QB              Full-text search. Requires FULLTEXT index. mode: natural/boolean/expansion
sql(query, ...vals)                  mysqli_result   Raw SQL with ? escaping. For complex queries
toSql()                              QB              Debug mode. Shows SQL without executing
```

**NOTE: Base Model Class:**
Base `Model::` (without extending) has access to `sql()`, `async()`, `stream()`, `fresh()` - but NOT query builder methods (where, select, save, etc.) which require a defined model with `$table` property.

```php
GOOD: Model::sql('SELECT * FROM users WHERE id = ?', 5);                                      // Works
GOOD: Model::async()->sql('SELECT SUM(revenue) FROM orders');                                 // Works
GOOD: Model::stream()->sql('SELECT * FROM logs WHERE created_at > ?', '2024-01-01');         // Works
GOOD: Model::fresh()->async()->sql('SELECT COUNT(*) FROM pages');                            // Works

BAD: Model::where('id', 5)->all();                                                            // Error: No table!
BAD: Model::save(['title' => 'Test']);                                                        // Error: No table!

GOOD: UserModel::where('id', 5)->all();                                                       // Works - has $table = 'users'
GOOD: UserModel::async()->where('status', 'active')->all();                                  // Works - has table
```

**Examples:**
```php
// whereFulltext() - full-text search
GOOD: PostModel::whereFulltext(['title', 'content'], 'Rachie tutorial')->all();               // Natural language (default)
GOOD: DocModel::whereFulltext(['title', 'body'], 'database configuration')->where('status', 'published')->all();
GOOD: PostModel::whereFulltext(['content'], '+MySQL -Oracle', 'boolean')->all();              // Boolean: + = must include, - = exclude
GOOD: PostModel::whereFulltext(['content'], '+Rachie +(model controller)', 'boolean')->all(); // Must have Rachie AND (model OR controller)
GOOD: ArticleModel::whereFulltext(['content'], 'program*', 'boolean')->all();                 // Wildcard
GOOD: PostModel::whereFulltext(['content'], 'database', 'expansion')->all();                  // Query expansion (finds related terms)

// Schema annotation for FULLTEXT:
/**
 * @column
 * @text
 * @fulltext
 */
protected $content;

// sql() - raw SQL
GOOD: $result = ProductModel::sql('SELECT * FROM products WHERE price > ? AND stock > ?', 100, 0);
while ($row = $result->fetch_assoc()) { echo $row['name']; }

GOOD: $result = OrderModel::sql('SELECT SUM(total) as revenue FROM orders WHERE status = ?', 'paid');
$row = $result->fetch_assoc();
echo $row['revenue'];

GOOD: $result = ProductModel::sql('SELECT p.* FROM products p WHERE p.category_id IN (SELECT category_id FROM products GROUP BY category_id HAVING COUNT(*) > ?)', 10);  // Complex subquery

BAD: ProductModel::sql("SELECT * FROM products WHERE category = '" . Input::get('cat') . "'");  // SQL injection!
GOOD: ProductModel::sql('SELECT * FROM products WHERE category = ?', Input::get('cat'));

// toSql() - debug queries
GOOD: $sql = ProductModel::toSql()->where('price > ?', 100)->where('stock > ?', 0)->order('price', 'asc')->all();
echo $sql;  // Output: SELECT * FROM products WHERE price > '100' AND stock > '0' ORDER BY price ASC

GOOD: $sql = PostModel::toSql()->leftJoin('users', 'user_id = id', ['name'])->where('status', 'published')->all();
GOOD: $sql = ProductModel::toSql()->where('stock', 0)->save(['status' => 'out_of_stock']);    // Debug UPDATE
```

---

### TRANSACTIONS & LOCKING

```
Method                    Returns    Description
begin()                  void       Start transaction. All queries until commit/rollback are atomic
commit()                 void       Save all transaction changes permanently
rollback()               void       Cancel all transaction changes. Use in catch blocks
updateLock([mode])       QB         Exclusive lock for UPDATE/DELETE. mode: null/skip/nowait
shareLock([mode])        QB         Shared lock for reading. Prevents changes. mode: null/skip/nowait
```

**Examples:**
```php
// Transactions - basic pattern
AccountModel::begin();
try {
    AccountModel::where('id', $senderId)->decrement(['balance' => 100]);
    AccountModel::where('id', $receiverId)->increment(['balance' => 100]);
    AccountModel::commit();
} catch (Exception $e) {
    AccountModel::rollback();
    echo "Transfer failed: " . $e->getMessage();
}

// Transactions - order processing
OrderModel::begin();
try {
    $orderId = OrderModel::save(['customer_id' => $cId, 'quantity' => 5, 'total' => 499.95]);
    $affected = ProductModel::where('id', $pId)->where('stock >= ?', 5)->decrement(['stock' => 5]);
    if ($affected === 0) throw new Exception("Insufficient stock");
    OrderModel::commit();
} catch (Exception $e) {
    OrderModel::rollback();
    echo "Order failed: " . $e->getMessage();
}

// updateLock() - exclusive lock
QueueModel::begin();
$job = QueueModel::where('status', 'pending')->order('created_at', 'asc')->updateLock('skip')->first();  // Skip locked rows (ideal for queues)
if ($job) {
    QueueModel::where('id', $job['id'])->save(['status' => 'processing']);
    QueueModel::commit();
    processJob($job);
}

// updateLock() - nowait mode
try {
    $account = AccountModel::where('id', $id)->updateLock('nowait')->first();                  // Fail immediately if locked
} catch (Exception $e) {
    echo "Account locked by another process";
}

// shareLock() - shared read lock
ProductModel::begin();
$product = ProductModel::where('id', $pId)->shareLock()->first();                              // Prevents changes during transaction
if ($product['stock'] >= $qty) {
    OrderModel::save(['product_id' => $pId, 'quantity' => $qty]);
    ProductModel::where('id', $pId)->decrement(['stock' => $qty]);
    ProductModel::commit();
}

// Distributed queue processing (multiple workers)
QueueModel::begin();
$job = QueueModel::where('status', 'pending')->order('priority', 'desc')->updateLock('skip')->first();  // Each worker gets different job
if ($job) {
    QueueModel::where('id', $job['id'])->save(['status' => 'processing']);
    QueueModel::commit();
    processJob($job);
}

// Lock modes:
// null (default): Wait for locked rows to become available
// 'skip': Skip locked rows, return unlocked ones (ideal for queues)
// 'nowait': Fail immediately if rows locked

// NOTE: Locks only work inside transactions - always call begin() first
// NOTE: Keep transactions short to avoid blocking other users
```

---

### PERFORMANCE - CONNECTION MODES

**Four cached connections:** sync (default), async, stream, server. Singleton per request.
**Fresh connections:** Create new connection each time. Use sparingly (4-6 max).

```
Method         Returns     Description
async()       QB          Non-blocking queries. Returns Promise. NOTE: Must be first
stream()      QB          Unbuffered mode for massive datasets. NOTE: Must be first
server()      QB          No database selected. Server-level operations. Manual DB.table in SQL
fresh()       QB          New uncached connection. For 4-6 parallel async only
```

**Examples:**
```php
// async() - heavy operations (NOTE: MUST be first before where/select/etc)
GOOD: $promise = PageModel::async()->sql("SELECT SUM(links) FROM pages WHERE quality > 0.5");
$stats = StatsModel::where('type', 'daily')->first();                                          // Runs while async executes
$result = $promise->await();                                                                    // Wait for async

GOOD: $promise = QueueModel::async()->where('status', 'active')->all();
$data = $promise->await();

BAD: QueueModel::where('status', 'active')->async()->all();                                   // Won't work - async must be first!

// Check if ready
if ($promise->ready()) {
    $data = $promise->await();
}

// Use for: Heavy JOINs, aggregations on millions of rows, complex calculations
// Don't use for: Simple queries (WHERE id = 5), dependent queries
// Limit: One async query at a time on async connection. Must await() before next

// stream() - massive datasets (NOTE: MUST be first)
GOOD: $result = LogModel::stream()->where('created_at > ?', '2024-01-01')->all();
$errorCount = 0;
while ($row = $result->fetch_assoc()) {
    if ($row['level'] === 'error') $errorCount++;
}

GOOD: $result = ProductModel::stream()->all();                                                 // Export millions
$file = fopen('export.csv', 'w');
while ($product = $result->fetch_assoc()) {
    fputcsv($file, [$product['id'], $product['name'], $product['price']]);
}
fclose($file);

BAD: ProductModel::select(['id', 'name'])->stream()->all();                                   // Won't work - stream must be first!

// Use for: 100K+ rows, exports, large data processing
// Don't use for: Small queries (<10K), when need count() first, multiple iterations
// Note: Forward-only, can't count rows, can't rewind

// fresh() - parallel async (NOTE: Use sparingly - can exhaust MySQL connection pool)
GOOD: $p1 = AnalyticsModel::fresh()->async()->sql("SELECT SUM(revenue) FROM orders WHERE YEAR(created_at) = 2024");
$p2 = AnalyticsModel::fresh()->async()->sql("SELECT SUM(revenue) FROM orders WHERE YEAR(created_at) = 2023");
$p3 = AnalyticsModel::fresh()->async()->sql("SELECT SUM(revenue) FROM orders WHERE YEAR(created_at) = 2022");
$rev2024 = $p1->await();
$rev2023 = $p2->await();
$rev2022 = $p3->await();

BAD: foreach ($urls as $url) {                                                                 // If $urls has 1000 items...
    $promises[] = QueueModel::fresh()->async()->where('url', $url)->first();                  // Creates 1000 connections!
}

// NOTE: fresh() warnings:
// - Each creates new TCP connection (authentication, RAM)
// - MySQL has connection limit (~151 default)
// - Can leak in long-running daemons if queries error
// - Prefer 3 cached connections for 99% of cases

// server() - server-level operations (NOTE: MUST be first)
GOOD: Model::server()->sql("SHOW DATABASES");
GOOD: Model::server()->sql("SHOW GLOBAL STATUS");
GOOD: Model::server()->sql("SELECT * FROM mysql.user");
GOOD: Model::server()->sql("SELECT * FROM database1.users WHERE id = ?", 5);  // Manual DB.table
GOOD: Model::server()->sql("SELECT COUNT(*) FROM database2.posts");

// Use for: Cross-database queries, server admin, schema operations
// Don't use for: Normal model queries (use sync connection)
// NOTE: Must specify database.table for table-specific queries
```

---

### SECURITY

**SQL Injection:** Auto-escaped via `mysqli->real_escape_string()`. Use ? placeholders.
```php
GOOD: UserModel::where('email = ?', Input::post('email'))->first();
GOOD: UserModel::sql('SELECT * FROM users WHERE email = ?', Input::post('email'));
BAD: UserModel::sql("SELECT * FROM users WHERE email = '" . Input::post('email') . "'");     // Vulnerable!
```

**Mass Assignment:** Whitelist fields before saving.
```php
BAD: UserModel::save(Input::post());                                                           // Attacker: role=admin, is_verified=1
GOOD: UserModel::save(['name' => Input::post('name'), 'email' => Input::post('email')]);
```

**CSRF Protection:** Verify tokens on state-changing operations.
```php
use Rackage\Csrf;
if (!Csrf::verify()) View::json(['error' => 'Invalid Csrf token'], 403);
PostModel::where('id', Input::post('id'))->save(['status' => 'published']);
```

**Password Hashing:** Use Security class.
```php
use Rackage\Security;

// Registration
UserModel::save(['email' => $email, 'password' => Security::hash(Input::post('password'))]);

// Login
$user = UserModel::where('email', Input::post('email'))->first();
if ($user && Security::verify(Input::post('password'), $user['password'])) {
    Session::refresh();                                                                         // Prevent session fixation
    Session::set('user_id', $user['id']);
}
```

**Authorization:** Verify ownership before operations.
```php
$post = PostModel::where('id', $postId)->where('author_id', Session::get('user_id'))->first();
if (!$post) View::json(['error' => 'Unauthorized'], 403);
PostModel::where('id', $postId)->save(['title' => Input::post('title')]);
```

---

### TROUBLESHOOTING

**Connection error:** Check `config/database.php`. Test: `php roline db:list`

**Table doesn't exist:** `php roline db:tables` then `php roline model:table-create ModelName`

**Column not found:** Add `@column` annotation to model, then `php roline model:table-update ModelName`

**Slow queries:** Add `@index` annotation, use `select()` for specific columns, use joins (avoid N+1).

**Memory issues:** Use `stream()` for large datasets, `limit()` results, `select()` specific columns.

**N+1 queries:**
```php
BAD: $posts = PostModel::all();
     foreach ($posts as $post) { $user = UserModel::getById($post['user_id']); }              // 1+N queries

GOOD: $posts = PostModel::leftJoin('users', 'user_id = id', ['name'])->all();                // 1 query
```

**Debug queries:**
```php
$sql = PostModel::toSql()->where('status', 'published')->all();
echo $sql;
```

---

### ROLINE CLI INTEGRATION

**Create table:** `php roline model:table-create Post`
**Update table:** `php roline model:table-update Post`
**View schema:** `php roline model:table-schema Post`

**Export/Import:**
```bash
php roline db:export backup.sql
php roline db:import backup.sql
php roline table:export products products.csv
```

**Annotations:**
```php
/**
 * @column
 * @varchar 255
 * @unique         // Single column unique index (don't add @index - redundant)
 * @index          // Single column index
 * @nullable
 * @default draft
 */
protected $status;

/**
 * Class-level annotations
 * @composite (author_id, status)                    // Multi-column index
 * @compositeUnique (sku, warehouse_id)              // Multi-column unique
 * @partition hash(source_id) 32                     // Partitioning for 100M+ rows
 * @fulltext                                          // Full-text search index
 */
```


**Rachie Model Reference** - Complete database layer with 40+ methods for CRUD, filtering, joins, aggregates, transactions, and performance optimization.

**See also:** [Full model documentation](https://rachie.dev/docs/models)

---

## Helpers in Rachie


**Helper classes** are static utility classes in the **Rachie PHP framework** providing common functionality (input handling, path resolution, etc.) without instantiation. They eliminate repetitive code and offer global access to frequently-needed operations.

**Namespace**: All helper classes are in the `Rackage` namespace.

**Availability**:
- **View templates**: Helpers are automatically available. No `use` statements needed.
- **Controllers & other classes**: Must import with `use Rackage\HelperName;`

```php
// In controllers/models/services
use Rackage\Input;
use Rackage\Path;

// In view templates (.php files in application/views/)
// No imports needed - just call directly:
{{ Input::get('username') }}
```

---

### Input

**Purpose**: Access HTTP input (GET/POST/URL) with automatic XSS protection and merge priority.

**Import**: `use Rackage\Input;` (not needed in views)

**Call**: `Input::get('username')`

### Initialization (Bootstrap Order)
```php
Input::setGet()->setPost();      // Load $_GET and $_POST
Input::setUrl(['id' => '123']);  // Called by router after parameter extraction
```

### Data Sources & Priority

| Source | Loaded From | Auto-Escaped | Priority | Access Methods |
|--------|-------------|--------------|----------|----------------|
| GET    | $_GET       | Yes          | 1 (low)  | `get()`, `has()` |
| POST   | $_POST      | Yes          | 2        | `post()`, `get()`, `has()` |
| URL    | Router      | **No**       | 3 (high) | `url()`, `get()`, `has()` |

**Merge Rule**: Same key in multiple sources → URL wins > POST > GET

### Methods

| Method | Sources | Returns | Escaping Behavior |
|--------|---------|---------|-------------------|
| `get($name, $default=false)` | All merged | string\|mixed | `htmlentities(ENT_QUOTES)` |
| `get()` | All merged | array | **None** (raw array) |
| `post($name, $default=false)` | POST only | string\|mixed | `htmlentities(ENT_QUOTES)` |
| `post()` | POST only | array | **None** (raw array) |
| `url($name, $default=false)` | URL only | string\|mixed | **None** (semi-trusted) |
| `url()` | URL only | array | **None** (raw array) |
| `has($name)` | All merged | bool | N/A (uses `array_key_exists()`) |

### Critical Behaviors
- `null` as `$name` → returns **unescaped** array for all methods
- Uses `array_key_exists()` → preserves `null` values
- Default return is `false` if not specified

### Examples

```php
// In controller
use Rackage\Input;

class UserController {
    public function update() {
        // Scenario: GET ?name=<script>, POST name=Jane, URL name=Jack
        $name = Input::get('name');   // 'Jack' (URL wins, escaped)
        $pass = Input::post('password'); // Only from POST (escaped)
        $id = Input::url('id');       // '123' (NOT escaped, from route)

        if (Input::has('email')) {
            // Check existence
        }
    }
}

// XSS Protection
// GET: ?user=<script>alert(1)</script>
Input::get('user')   // '&lt;script&gt;alert(1)&lt;/script&gt;' (safe)
Input::get()         // ['user' => '<script>alert(1)</script>'] (UNSAFE!)
```
---

### Path

**Purpose**: Resolve absolute file system paths for application directories.

**Import**: `use Rackage\Path;` (not needed in views)

**Call**: `Path::app()`

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `app()` | `{root}/application/` | Controllers, models, views directory |
| `base()` | `{root}/` | Application root directory |
| `sys()` | `{root}/system/` | Framework core files |
| `vault()` | `{root}/vault/` | Private data (logs, cache, sessions) |
| `tmp()` | `{root}/vault/tmp/` | Compiled views, temp files |
| `view($name)` | `{root}/application/views/{...}.php` | Resolves view name to absolute path |

**Note**: `{root}` = `Registry::settings()['root']` • Uses `DIRECTORY_SEPARATOR` for OS compatibility

### View Resolution

`view()` uses `url_separator` from settings to split view names into directory segments.

```php
// Settings: url_separator = '/'
Path::view('blog/show')   // {root}/application/views/blog/show.php
Path::view('errors/404')  // {root}/application/views/errors/404.php

// Settings: url_separator = '.'
Path::view('blog.show')   // {root}/application/views/blog/show.php
```

### Examples

```php
// In controller
use Rackage\Path;

class FileController {
    public function process() {
        $appPath = Path::app();    // /var/www/myapp/application/
        $basePath = Path::base();  // /var/www/myapp/
        $viewPath = Path::view('user/profile');  // /var/www/myapp/application/views/user/profile.php

        require Path::view('layouts/header');
        include Path::tmp() . 'compiled_view.php';
    }
}
```

---

### Url

**Purpose**: Generate application URLs, asset URLs, and links with protocol/base path handling.

**Import**: `use Rackage\Url;` (not needed in views)

**Call**: `Url::link('user', '123')`

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `base()` | None | string | Base URL (protocol + domain + install dir) |
| `assets($assetName)` | Asset path | string | Full URL to asset file |
| `link(...$params)` | Variadic/array | string | Application URL (NOT encoded) |
| `safe(...$params)` | Variadic/array | string | Application URL (URL-encoded) |

**Configuration**: Uses `protocol` ('auto', 'http', 'https') and `url_component_separator` ('/' default) from settings.

### Security: link() vs safe()

| Method | Encoding | Use Case |
|--------|----------|----------|
| `link()` | **None** | Trusted data (route names, IDs, slugs) |
| `safe()` | `urlencode()` | User input, special characters |

### Examples

```php
// In views
use Rackage\Url;

// Base and assets
Url::base()                        // https://example.com/myapp/
Url::assets('css/style.css')       // https://example.com/myapp/css/style.css
Url::assets('images/logo.png')     // https://example.com/myapp/images/logo.png

// Application links (trusted data)
Url::link('user', '123', 'edit')   // https://example.com/myapp/user/123/edit
Url::link(['blog', 'post', 'slug']) // https://example.com/myapp/blog/post/slug
Url::link()                        // https://example.com/myapp/

// Safe links (user input - encoded)
Url::safe('search', $_GET['q'])    // Encodes special chars
Url::safe('user', 'john doe')      // https://example.com/myapp/user/john%20doe
Url::safe(['blog', '../admin'])    // Prevents path traversal

// In view templates (no import needed)
<link href="{{ Url::assets('css/app.css') }}" rel="stylesheet">
<a href="{{ Url::link('blog', $post['slug']) }}">Read More</a>
<form action="{{ Url::link('search') }}" method="get">
```

---

### Session

**Purpose**: Manage session data and flash messages (one-request data for redirects).

**Import**: `use Rackage\Session;` (not needed in views)

**Call**: `Session::set('user_id', 123)`

**Note**: Session auto-started by framework. Flash messages auto-age after each request.

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `set($key, $data)` | Key, value | void | Store data in session |
| `get($key, $default=null)` | Key, default | mixed | Retrieve session value |
| `has($key)` | Key | bool | Check if key exists |
| `all()` | None | array | Get all session data |
| `remove($key)` / `forget($key)` | Key | void | Remove session key |
| `pull($key, $default=null)` | Key, default | mixed | Get value and remove it |
| `flash($key, $value=null)` | Key, value (omit to get) | mixed/void | Set/get flash data (1-request) |
| `getFlash($key, $default=null)` | Key, default | mixed | Get flash value |
| `hasFlash($key)` | Key | bool | Check if flash exists |
| `keep($keys)` | Key or array | void | Keep flash one more request |
| `reflash()` | None | void | Keep all flash one more request |
| `refresh($deleteOld=true)` | Delete old | bool | Regenerate ID (security) |
| `flush()` | None | void | Destroy session (logout) |

### Flash Message Lifecycle

Flash persists **exactly one request** (perfect for redirect success/error alerts).
**Flow**: Set → Auto-age → Available next request → Auto-removed

### Examples

```php
// In controller
use Rackage\Session;
use Rackage\Redirect;

class UserController {
    public function update() {
        // Basic session storage
        Session::set('user_id', 123);
        Session::set('cart', ['item1', 'item2']);

        $userId = Session::get('user_id'); // 123
        if (Session::has('cart')) { /* ... */ }

        // Get and remove
        $temp = Session::pull('temp_data');

        // Flash with Redirect (recommended)
        Redirect::to('dashboard')->flash('success', 'Profile updated!');

        // Or flash manually
        Session::flash('error', 'Something went wrong');
        Redirect::to('form');
    }

    public function logout() {
        Session::refresh(); // Regenerate ID (prevent fixation)
        Session::flush();   // Destroy all data
        Redirect::to('login')->flash('info', 'Logged out');
    }
}

// In view templates (no import needed)
@if(Session::has('success'))
    <div class="alert success">{{ Session::get('success') }}</div>
@endif

@if(Session::hasFlash('error'))
    <div class="alert error">{{ Session::flash('error') }}</div>
@endif

// Keep flash for multiple redirects
Session::keep('success');           // Keep one
Session::keep(['success', 'error']); // Keep multiple
Session::reflash();                 // Keep all
```

---

### Redirect

**Purpose**: URL redirection with flash messages, query params, and security validation.

**Import**: `use Rackage\Redirect;` (not needed in views)

**Call**: `Redirect::to('dashboard')`

**Security**: Validates external URLs and referers to prevent open redirect vulnerabilities.

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `to($path, $query=[], $code=302)` | Path, query params, status | Redirect | Internal redirect (chainable) |
| `away($url, $code=302)` | External URL, status | void | External redirect (validates http/https) |
| `back($fallback=null)` | Fallback path | Redirect | Previous page (validates same domain) |
| `home()` | None | Redirect | Homepage redirect |
| `refresh()` | None | Redirect | Reload current page |
| `intended($fallback=null)` | Fallback path | void | Redirect to intended URL or fallback |
| `flash($key, $message)` | Key, message | Redirect | Add flash message (chainable) |
| `with($key, $value=null)` | Key/array, value | Redirect | Add query params (chainable) |

**Method Chaining**: `to()`, `back()`, `home()`, `refresh()` return instance for chaining with `flash()` and `with()`.

### Examples

```php
// In controller
use Rackage\Redirect;

class PostController {
    public function store() {
        // Basic redirect
        Redirect::to('posts');
        Redirect::to('blog/post/123');

        // With flash message (chained)
        Redirect::to('dashboard')->flash('success', 'Post created!');
        Redirect::back()->flash('error', 'Validation failed');

        // Multiple flash messages
        Redirect::to('dashboard')
            ->flash('success', 'Login successful')
            ->flash('info', 'You have 3 new messages');

        // With query parameters
        Redirect::to('search', ['q' => 'test', 'page' => 2]);
        // → /search?q=test&page=2

        // Query params via chaining
        Redirect::with('status', 'active')->with('sort', 'date')->to('posts');
        Redirect::with(['q' => 'test', 'page' => 2])->to('search');

        // External redirect (validates URL)
        Redirect::away('https://google.com');

        // Common shortcuts
        Redirect::back();           // Previous page
        Redirect::back('dashboard'); // With fallback
        Redirect::home();           // Homepage
        Redirect::refresh();        // Reload page

        // Post-login pattern
        Session::set('intended_url', '/admin/settings');
        Redirect::to('login')->flash('info', 'Please login');
        // After login:
        Redirect::intended('dashboard'); // → /admin/settings

        // HTTP status codes
        Redirect::to('moved-page', [], 301); // Permanent
        Redirect::to('found', [], 302);      // Temporary (default)
    }
}
```

---

### Security

**Purpose**: Password hashing, token generation, input sanitization, and HTTP security headers.

**Import**: `use Rackage\Security;` (not needed in views)

**Call**: `Security::hash($password)`

### Methods by Category

**Password Management (bcrypt)**

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `hash($password, $opts=[])` | Password, options | string | Hash password with bcrypt |
| `verify($password, $hash)` | Password, hash | bool | Verify password (timing-safe) |
| `needsRehash($hash, $opts=[])` | Hash, options | bool | Check if hash needs upgrade |

**Token Generation (cryptographically secure)**

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `randomBytes($length=32)` | Bytes count | string | Generate random bytes (binary) |
| `randomToken($bytes=32)` | Bytes count | string | Generate hex token (32 bytes = 64 chars) |
| `randomString($length=16)` | String length | string | Generate alphanumeric string |

**Input Sanitization (XSS prevention)**

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `escape($string)` | String | string | Escape HTML entities (XSS safe) |
| `clean($string, $allowed='')` | String, allowed tags | string | Remove HTML/PHP tags |
| `sanitize($string)` | String | string | Remove tags + trim whitespace |

**Cryptographic Utilities**

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `compare($known, $user)` | Known, user input | bool | Timing-safe string comparison |
| `hmac($data, $key, $algo='sha256')` | Data, key, algorithm | string | Generate HMAC signature |
| `verifyHmac($data, $sig, $key, $algo='sha256')` | Data, signature, key, algo | bool | Verify HMAC signature |

**HTTP Security Headers**

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `headers()` | None | void | Set common security headers |
| `csp($policy=[])` | CSP directives | void | Set Content Security Policy |
| `cors($origins=[], $opts=[])` | Allowed origins, options | void | Set CORS headers |

### Examples

```php
// In controller
use Rackage\Security;

class AuthController {
    public function register() {
        // Password hashing (bcrypt)
        $hash = Security::hash(Input::get('password'));
        $hash = Security::hash($password, ['cost' => 12]); // Higher cost

        $user = UserModel::save(['email' => $email, 'password' => $hash]);
    }

    public function login() {
        // Password verification (timing-safe)
        $user = UserModel::where('email = ?', Input::get('email'))->first();
        if ($user && Security::verify(Input::get('password'), $user['password'])) {
            // Upgrade hash if needed
            if (Security::needsRehash($user['password'])) {
                $newHash = Security::hash(Input::get('password'));
                UserModel::where('id = ?', $user['id'])->save(['password' => $newHash]);
            }
            Session::set('user_id', $user['id']);
            Redirect::to('dashboard');
        }
    }

    public function resetPassword() {
        // Token generation (cryptographically secure)
        $token = Security::randomToken();      // 64-char hex token
        $token = Security::randomToken(16);    // 32-char hex token
        $code = Security::randomString(6);     // "A7k9Bx" verification code

        PasswordResetModel::save(['email' => $email, 'token' => $token]);
    }

    public function verifyReset() {
        // Timing-safe token comparison
        $reset = PasswordResetModel::where('token = ?', $token)->first();
        if ($reset && Security::compare($token, $reset['token'])) {
            // Token is valid
        }
    }
}

class ApiController {
    public function __construct() {
        // CORS for API (allow specific origins)
        Security::cors(['https://app.example.com'], [
            'methods' => 'GET, POST, PUT, DELETE',
            'headers' => 'Content-Type, Authorization',
            'credentials' => true
        ]);

        // HMAC signature (webhook/API verification)
        $payload = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_SIGNATURE'];
        if (Security::verifyHmac($payload, $signature, env('WEBHOOK_SECRET'))) {
            // Process request
        }
    }
}

// Input sanitization (in controllers or views)
$username = Security::sanitize(Input::get('username')); // Remove tags + trim
$bio = Security::clean(Input::get('bio'), '<b><i>');    // Allow bold/italic
echo Security::escape($userInput);                      // XSS-safe output

// In view templates (no import needed)
{{ Security::escape($userContent) }}

// Security headers (in bootstrap or base controller)
Security::headers(); // X-Frame-Options, X-XSS-Protection, HSTS, etc.

Security::csp([
    'script-src' => "'self' https://cdn.example.com",
    'style-src' => "'self' 'unsafe-inline' https://fonts.googleapis.com"
]);
```

---

### Request

**Purpose**: HTTP request information (method, headers, URL, client data, content negotiation).

**Import**: `use Rackage\Request;` (not needed in views)

**Call**: `Request::isPost()`

### Methods by Category

**HTTP Method Detection**

| Method | Returns | Description |
|--------|---------|-------------|
| `method()` | string | Get HTTP method (GET, POST, PUT, DELETE, etc.) |
| `isGet()` / `isPost()` / `isPut()` / `isDelete()` / `isPatch()` | bool | Check specific method |
| `isMethod($method)` | bool | Check if matches given method (case-insensitive) |

**Request Type Checks**

| Method | Returns | Description |
|--------|---------|-------------|
| `ajax()` / `isAjax()` | bool | Check if AJAX request (X-Requested-With header) |
| `secure()` / `isSecure()` | bool | Check if HTTPS |

**Content Negotiation**

| Method | Returns | Description |
|--------|---------|-------------|
| `isJson()` | bool | Check if Content-Type is application/json |
| `expectsJson()` | bool | Check if Accept header includes application/json |
| `wantsJson()` | bool | True if AJAX or expects JSON |
| `accepts($type)` | bool | Check if client accepts content type |
| `contentType()` | string\|null | Get Content-Type header |

**URL & Path**

| Method | Returns | Description |
|--------|---------|-------------|
| `path()` | string | Request path without query string |
| `url()` | string | Full URL without query string |
| `fullUrl()` | string | Full URL with query string |
| `fullUri()` | string | Request URI (path + query, no domain) |
| `is($pattern)` | bool | Check if path matches pattern (supports `*` wildcard) |
| `segment($index, $default=null)` | string\|null | Get URL segment by index (1-indexed) |
| `segments()` | array | Get all URL segments |

**Query Parameters**

| Method | Returns | Description |
|--------|---------|-------------|
| `query($key, $default=null)` | mixed | Get query parameter value |
| `hasQuery($key)` | bool | Check if query parameter exists |
| `queryString()` | string\|null | Get full query string |

**Headers**

| Method | Returns | Description |
|--------|---------|-------------|
| `header($name, $default=null)` | string\|null | Get header value (case-insensitive) |
| `headers()` | array | Get all headers |
| `hasHeader($name)` | bool | Check if header exists |
| `bearer()` | string\|null | Extract Bearer token from Authorization header |

**Client Information**

| Method | Returns | Description |
|--------|---------|-------------|
| `ip()` | string | Get client IP (handles proxies) |
| `agent()` | string | Get user agent string |
| `referer()` | string\|null | Get HTTP referer |
| `isMobile()` | bool | Check if mobile device |
| `isBot()` | bool | Check if search bot |

### Examples

```php
// In controller
use Rackage\Request;

class ApiController {
    public function handle() {
        // Method detection
        if (Request::isPost()) {
            // Handle POST
        }

        // Content negotiation (auto-detect response format)
        if (Request::wantsJson()) {
            return View::json($data);  // AJAX or expects JSON
        }

        // Parse JSON request
        if (Request::isJson()) {
            $input = json_decode(file_get_contents('php://input'), true);
            UserModel::save($input);
        }

        // URL & Path
        $path = Request::path();        // "/blog/post/123"
        $url = Request::fullUrl();      // "https://example.com/blog/post/123?page=2"

        // URL segments (1-indexed)
        // URL: /blog/post/123
        $controller = Request::segment(1);  // "blog"
        $action = Request::segment(2);      // "post"
        $id = Request::segment(3);          // "123"

        // Pattern matching
        if (Request::is('admin/*')) {
            // Any admin route
        }

        // Query parameters
        $q = Request::query('q', '');
        $page = Request::query('page', 1);

        // Headers
        $token = Request::bearer();  // Extract from "Bearer {token}"
        $auth = Request::header('Authorization');
        if (Request::hasHeader('X-API-Key')) {
            $key = Request::header('X-API-Key');
        }

        // Client info
        $ip = Request::ip();         // Handles X-Forwarded-For
        $userAgent = Request::agent();

        if (Request::isMobile()) {
            return View::render('mobile/index');
        }

        if (Request::isBot()) {
            // Skip analytics
        }

        // HTTPS check
        if (!Request::secure()) {
            Redirect::away('https://' . $_SERVER['HTTP_HOST'] . Request::fullUri());
        }

        // AJAX check
        if (Request::ajax()) {
            return View::json($results);
        }
    }
}

// In view templates (no import needed)
@if(Request::isMobile())
    <div class="mobile-nav"></div>
@endif
```

---

### Date

**Purpose**: Date/time manipulation, formatting, arithmetic, and human-readable output with timezone support.

**Import**: `use Rackage\Date;` (not needed in views)

**Call**: `Date::now()`

**Note**: Uses timezone from `config/settings.php`. String intervals: `'3 months'`, `'2 hours'`, `'1 year'`, `'2 weeks'`, `'5 days 3 hours'`.

### Methods

| Category | Method | Parameters | Returns | Description |
|----------|--------|------------|---------|-------------|
| **Current** | `now($format='Y-m-d H:i:s')` | Format | string | Current datetime |
| **Format** | `format($date, $format='Y-m-d H:i:s')` | Date/timestamp, format | string | Format date to any format |
| **Human** | `ago($date)` | Date/timestamp | string | "2 hours ago" style |
| **Arithmetic** | `add($date, $amount, $format)` | Date, interval (int=days or string), format | string | Add time interval |
| | `subtract($date, $amount, $format)` | Date, interval (int=days or string), format | string | Subtract time interval |
| **Compare** | `diff($date1, $date2, $unit='days')` | Two dates, unit | int\|float | Difference (seconds/minutes/hours/days/weeks/months/years) |
| **Checks** | `isToday($date)` | Date/timestamp | bool | Check if today |
| | `isPast($date)` | Date/timestamp | bool | Check if in past |
| | `isFuture($date)` | Date/timestamp | bool | Check if in future |
| **Boundaries** | `startOfDay($date=null, $format)` | Date, format | string | 00:00:00 of date |
| | `endOfDay($date=null, $format)` | Date, format | string | 23:59:59 of date |
| | `startOfMonth($date=null, $format)` | Date, format | string | First day of month 00:00:00 |
| | `endOfMonth($date=null, $format)` | Date, format | string | Last day of month 23:59:59 |
| **Utilities** | `weekend($date)` | Date/timestamp | bool | Check if Sat/Sun |
| | `parse($date)` | Date string | int | Convert to Unix timestamp |

### Examples

```php
use Rackage\Date;

// Current & formatting
Date::now();                               // "2024-01-15 14:30:45"
Date::now('Y-m-d');                        // "2024-01-15"
Date::format($post['created_at'], 'F j, Y'); // "January 15, 2024"
Date::ago($post['created_at']);            // "2 hours ago"

// Arithmetic (numeric=days, string=flexible intervals)
Date::add(Date::now(), 7);                 // 7 days from now
Date::add('2024-01-15', '3 months');       // "2024-04-15 00:00:00"
Date::subtract(Date::now(), '1 week');     // 1 week ago

// Comparison & checks
$daysLeft = Date::diff(Date::now(), $subscription['expires_at']);
Date::isPast($subscription['expires_at']); // true if expired
Date::isFuture($event['start_date']);      // true if not started

// Date range queries
$start = Date::startOfDay(Date::now());
$end = Date::endOfDay(Date::now());
$posts = PostModel::where('created_at >= ?', $start)->where('created_at <= ?', $end)->all();

// In views
{{ Date::format($post['created_at'], 'F j, Y') }}
{{ Date::ago($comment['created_at']) }}
```

---

### Cache

**Purpose**: Cache data using file, Memcached, or Redis drivers (facade pattern).

**Import**: `use Rackage\Cache;` (not needed in views)

**Call**: `Cache::get('key')`

**Configuration**: Driver set in `config/cache.php` (file/memcached/redis).

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `get($key)` | Key | mixed | Get cached value (false if not found) |
| `set($key, $value, $minutes=60)` | Key, value, TTL minutes | bool | Store value with expiration |
| `has($key)` | Key | bool | Check if key exists and not expired |
| `delete($key)` | Key | bool | Delete cached value |
| `flush()` | None | bool | Clear all cached values |
| `remember($key, $minutes, $callback)` | Key, TTL, callable | mixed | Get or execute callback and cache |
| `forever($key, $value)` | Key, value | bool | Store permanently (no expiration) |

### Examples

```php
use Rackage\Cache;

// Basic get/set
Cache::set('user_123', $user, 60);     // Cache for 60 minutes
$user = Cache::get('user_123');        // Get cached value
if (Cache::has('user_123')) { /* ... */ }
Cache::delete('user_123');             // Remove from cache
Cache::flush();                        // Clear all cache

// remember() - cache-aside pattern (most common)
$posts = Cache::remember('recent_posts', 30, function() {
    return PostModel::orderBy('created_at', 'desc')->limit(10)->all();
});
// If cache exists: returns cached posts
// If cache miss: executes query, caches result, returns posts

// Permanent storage
Cache::forever('site_config', $config);  // No expiration

// In controller
class PostController {
    public function index() {
        $posts = Cache::remember('posts_page_1', 15, function() {
            return PostModel::paginate(1, 20);
        });
        return View::render('posts/index', ['posts' => $posts]);
    }

    public function update($id) {
        PostModel::where('id = ?', $id)->save($data);
        Cache::delete('recent_posts');  // Invalidate cache
        Cache::delete("posts_page_1");  // Clear cached pages
    }
}
```

---

### Cookie

**Purpose**: Secure cookie management with HttpOnly, Secure, and SameSite protection.

**Import**: `use Rackage\Cookie;` (not needed in views)

**Call**: `Cookie::set('name', 'value')`

**Security Defaults**: `httpOnly=true`, `sameSite='Lax'`, `secure=false` (set true in production).

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `set($name, $value, $minutes=0, $path='/', $secure=false, $httpOnly=true, $sameSite='Lax', $domain='')` | Name, value, TTL minutes, path, secure, httpOnly, sameSite, domain | bool | Set cookie (0=session cookie) |
| `get($name, $default=null)` | Name, default | mixed | Get cookie value |
| `has($name)` | Name | bool | Check if cookie exists |
| `delete($name, $path='/', $domain='')` | Name, path, domain | bool | Delete cookie |
| `forget($name, $path='/', $domain='')` | Name, path, domain | bool | Alias for delete() |
| `forever($name, $value, $path='/', $secure=false, $httpOnly=true, $sameSite='Lax', $domain='')` | Name, value, path, secure, httpOnly, sameSite, domain | bool | Set 5-year cookie |

**TTL Minutes**: `0`=session, `1440`=1 day, `10080`=1 week, `43200`=30 days.

**SameSite Options**: `'Strict'` (best security), `'Lax'` (recommended), `'None'` (requires `secure=true`).

### Examples

```php
use Rackage\Cookie;

// Basic usage
Cookie::set('theme', 'dark', 43200);       // 30 days
$theme = Cookie::get('theme', 'light');    // Get with default
if (Cookie::has('auth_token')) { /* ... */ }
Cookie::delete('session_id');

// Session cookie (expires when browser closes)
Cookie::set('temp_data', 'value');         // $minutes=0

// Secure cookie (HTTPS only, recommended for production)
Cookie::set('auth_token', $token, 1440, '/', true);

// Strict SameSite (best CSRF protection)
Cookie::set('csrf_token', $token, 0, '/', true, true, 'Strict');

// Long-lived cookie (5 years)
Cookie::forever('remember_token', $token);
Cookie::forever('language', 'en');

// Allow JavaScript access (NOT recommended for sensitive data)
Cookie::set('ui_state', $state, 525600, '/', false, false);

// Logout - delete cookies
Cookie::delete('remember_token');
Cookie::forget('session_id');  // Same as delete()
Session::flush();
```

---

### Csrf

**Purpose**: Cross-Site Request Forgery (CSRF) protection via token generation and validation.

**Import**: `use Rackage\Csrf;` (not needed in views)

**Call**: `Csrf::verify()`

**Security**: 64-char hex token (32 random bytes), session-specific, timing-safe validation with `hash_equals()`.

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `token()` | None | string | Get/generate CSRF token (64 hex chars) |
| `field()` | None | string | HTML hidden input `<input type="hidden" name="csrf_token" value="...">` |
| `meta()` | None | string | HTML meta tag `<meta name="csrf-token" content="...">` (for AJAX) |
| `verify()` | None | bool | Auto-validate from X-CSRF-TOKEN header or csrf_token POST field |
| `valid($token)` | Token string | bool | Manually validate specific token (timing-safe) |
| `regenerate()` | None | string | Destroy current token, generate new one (call after login/privilege change) |

**Validation Order**: `verify()` checks (1) X-CSRF-TOKEN header (AJAX), then (2) csrf_token POST field (forms).

**Note**: Use `{{{ }}}` (triple braces) to render HTML from `field()` and `meta()` methods.

### Examples

```php
use Rackage\Csrf;

// In forms (views)
<form method="POST" action="/user/update">
    {{{ Csrf::field() }}}
    <input type="text" name="username">
    <button>Update</button>
</form>

// In AJAX (layout head)
{{{ Csrf::meta() }}}
<script>
fetch('/api/update', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
});
</script>

// In controller - validate POST/PUT/DELETE (never GET)
class UserController {
    public function update() {
        if (!Csrf::verify()) {
            http_response_code(403);
            die('Invalid CSRF token');
        }
        // Process form safely
        UserModel::where('id = ?', Input::url('id'))->save(Input::post());
    }
}

// Regenerate after login/privilege change
Session::set('user_id', $user['id']);
Session::refresh();      // Regenerate session ID
Csrf::regenerate();      // Regenerate CSRF token
```

---

### Html

**Purpose**: HTML generation utilities (tags, links, assets, lists) with XSS protection.

**Import**: `use Rackage\Html;` (not needed in views)

**Call**: `Html::escape($input)`

**Note**: Use `{{{ }}}` (triple braces) to render HTML output from generator methods.

### Methods

| Category | Method | Parameters | Returns | Description |
|----------|--------|------------|---------|-------------|
| **Escaping** | `escape($string)` | String | string | Escape HTML entities (XSS prevention) |
| | `entities($string)` | String | string | Decode HTML entities |
| | `strip($string, $allowed='')` | String, allowed tags | string | Remove HTML/PHP tags |
| **Links/Media** | `link($url, $text, $attrs=[])` | URL, text, attributes | string | Generate `<a>` tag |
| | `image($src, $alt='', $attrs=[])` | Source, alt, attributes | string | Generate `<img>` tag |
| | `mailto($email, $text=null, $attrs=[])` | Email, text, attributes | string | Generate mailto link |
| **Assets** | `script($src, $attrs=[])` | Source, attributes | string | Generate `<script>` tag |
| | `style($href, $attrs=[])` | Href, attributes | string | Generate `<link rel="stylesheet">` tag |
| **Meta/Head** | `meta($name, $content, $attrs=[])` | Name, content, attributes | string | Generate `<meta>` tag |
| | `favicon($href, $type='image/x-icon')` | Href, MIME type | string | Generate favicon `<link>` tag |
| **Lists** | `ul($items, $attrs=[])` | Array, attributes | string | Generate `<ul>` list |
| | `ol($items, $attrs=[])` | Array, attributes | string | Generate `<ol>` list |
| | `dl($items, $attrs=[])` | Assoc array, attributes | string | Generate `<dl>` list (term => definition) |
| **Utilities** | `attributes($attrs)` | Array | string | Build attribute string from array |
| | `tag($tag, $content=null, $attrs=[])` | Tag name, content, attributes | string | Generate custom HTML tag |

### Examples

```php
use Rackage\Html;

// Escaping (XSS prevention)
echo Html::escape($userInput);           // Auto-escaped in {{ }} views
$decoded = Html::entities('&lt;p&gt;');  // "<p>"
$clean = Html::strip('<p><b>Hi</b></p>'); // "Hi"

// Links & media
{{{ Html::link('about', 'About Us', ['class' => 'btn']) }}}
{{{ Html::image('logo.png', 'Logo', ['width' => '200']) }}}
{{{ Html::mailto('hello@example.com', 'Email Us') }}}

// Assets (in layout head)
{{{ Html::style('app.css') }}}
{{{ Html::script('app.js', ['defer' => true]) }}}
{{{ Html::favicon('favicon.ico') }}}

// Meta tags
{{{ Html::meta('description', 'My site') }}}
{{{ Html::meta('viewport', 'width=device-width, initial-scale=1') }}}

// Lists
{{{ Html::ul(['Apple', 'Banana', 'Cherry'], ['class' => 'nav']) }}}
{{{ Html::ol(['Step 1', 'Step 2', 'Step 3']) }}}
{{{ Html::dl(['Term' => 'Definition', 'PHP' => 'Language']) }}}

// Utilities
$attrs = Html::attributes(['class' => 'btn', 'disabled' => true]);
// Returns: ' class="btn" disabled'

{{{ Html::tag('div', 'Content', ['class' => 'container']) }}}
// <div class="container">Content</div>
```

---

### Upload

**Purpose**: Secure file upload handling with validation (type, size, MIME) and unique naming.

**Import**: `use Rackage\Upload;` (not needed in views)

**Call**: `Upload::file('fieldName')`

**Configuration**: Default path in `config/settings.php` → `upload_path` (e.g., `public/uploads/`).

**Security**: MIME validation, path sanitization, SHA1 unique naming, auto-create dirs with 0755.

### Methods (Chainable)

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `file($fileName)` | Form field name | static | Initialize upload (e.g., `<input name="avatar">`) |
| `path($directory)` | Directory path | static | Custom upload dir (relative to app root) |
| `allowedTypes($types)` | Array of extensions | static | Restrict file types (validates extension + MIME) |
| `maxSize($bytes)` | Size in bytes | static | Set max file size |
| `save()` | None | UploaderResponse | Execute upload, returns response object |

### Response Object Properties

| Property | Type | Description |
|----------|------|-------------|
| `success` | bool | Upload succeeded |
| `error` | bool | Upload failed |
| `errorMessage` | string | Error description |
| `fileName` | string | Original file name |
| `savedFileName` | string | Unique name on disk (SHA1) |
| `fileSize` | int | Size in bytes |
| `fileType` | string | Extension (jpg, pdf, etc.) |
| `mimeType` | string | MIME type |
| `fullPath` | string | Absolute server path |
| `relativePath` | string | Path from app root |
| `publicUrl` | string | Public URL (if in public dir) |
| `width` | int | Image width (images only) |
| `height` | int | Image height (images only) |

**File Size Reference**: 1MB = `1024 * 1024`, 2MB = `2 * 1024 * 1024`, 5MB = `5 * 1024 * 1024`.

### Examples

```php
use Rackage\Upload;

// Basic upload
$result = Upload::file('avatar')->save();
if ($result->success) {
    UserModel::where('id = ?', $userId)->save(['avatar' => $result->relativePath]);
} else {
    echo $result->errorMessage;  // Show validation error
}

// Image upload with validation
$result = Upload::file('profile_photo')
    ->allowedTypes(['jpg', 'png', 'gif'])
    ->maxSize(2 * 1024 * 1024)  // 2MB
    ->save();

if ($result->success) {
    echo "Uploaded: {$result->width}x{$result->height}";
    echo "URL: {$result->publicUrl}";
}

// Document upload with custom path
$result = Upload::file('document')
    ->path('application/storage/documents')
    ->allowedTypes(['pdf', 'doc', 'docx'])
    ->maxSize(5 * 1024 * 1024)  // 5MB
    ->save();

if ($result->success) {
    DocumentModel::save([
        'name' => $result->fileName,
        'path' => $result->relativePath,
        'size' => $result->fileSize,
        'type' => $result->fileType
    ]);
    Redirect::to('documents')->flash('success', 'Document uploaded!');
} else {
    Redirect::back()->flash('error', $result->errorMessage);
}
```

---

### File

**Purpose**: File system operations (read/write files, directories, paths) with FileResponse objects.

**Import**: `use Rackage\File;` (not needed in views)

**Call**: `File::read('path.txt')`

**Returns**: FileResponse object with `success`, `error`, `errorMessage`, `content`, `path`, `size`, `exists`, `files`, etc.

### Methods (46 total)

| Category | Method | Parameters | Returns | Description |
|----------|--------|------------|---------|-------------|
| **Read** | `read($path)` | Path | FileResponse | Read entire file content |
| | `readLines($path)` | Path | FileResponse | Read as array of lines |
| | `readJson($path, $assoc=true)` | Path, assoc | FileResponse | Read and decode JSON |
| | `readCsv($path, $delim=',')` | Path, delimiter | FileResponse | Read CSV as array |
| | `lines($path, $callback)` | Path, callable | FileResponse | Process large file line-by-line (memory efficient) |
| **Write** | `write($path, $content)` | Path, content | FileResponse | Write/overwrite file |
| | `append($path, $content)` | Path, content | FileResponse | Append to end |
| | `prepend($path, $content)` | Path, content | FileResponse | Prepend to beginning |
| | `writeJson($path, $data, $pretty=false)` | Path, data, pretty | FileResponse | Write JSON file |
| | `writeCsv($path, $data, $delim=',')` | Path, array, delimiter | FileResponse | Write CSV file |
| **Ops** | `copy($src, $dest)` | Source, destination | FileResponse | Copy file |
| | `move($src, $dest)` | Source, destination | FileResponse | Move/rename file |
| | `delete($paths)` | Path or array | FileResponse | Delete file(s) |
| | `exists($path)` | Path | FileResponse | Check if exists (`$result->exists`) |
| | `missing($path)` | Path | FileResponse | Check if missing |
| **Info** | `isFile($path)` / `isDir($path)` | Path | FileResponse | Check type |
| | `isReadable($path)` / `isWritable($path)` | Path | FileResponse | Check permissions |
| | `size($path)` | Path | FileResponse | Get size (`$result->size`) |
| | `extension($path)` | Path | FileResponse | Get extension (`$result->extension`) |
| | `name($path)` | Path | FileResponse | Filename without extension |
| | `basename($path)` | Path | FileResponse | Filename with extension |
| | `mimeType($path)` | Path | FileResponse | Get MIME type |
| | `lastModified($path)` | Path | FileResponse | Get timestamp |
| | `hash($path, $algo='sha256')` | Path, algorithm | FileResponse | Get file hash |
| **Dirs** | `makeDir($path, $perm=0755, $rec=true)` | Path, perms, recursive | FileResponse | Create directory |
| | `ensureDir($path, $perm=0755)` | Path, perms | FileResponse | Create if not exists |
| | `deleteDir($path)` | Path | FileResponse | Delete dir + contents (recursive) |
| | `cleanDir($path)` | Path | FileResponse | Delete contents, keep dir |
| | `files($path)` | Path | FileResponse | Get files (non-recursive) |
| | `allFiles($path)` | Path | FileResponse | Get files (recursive) |
| | `dirs($path)` | Path | FileResponse | Get subdirectories |
| | `glob($pattern, $flags=0)` | Pattern, flags | FileResponse | Find by glob pattern (`*.php`, `**/*.json`) |
| **Advanced** | `chmod($path, $perm)` | Path, permissions | FileResponse | Change permissions |
| | `getPermissions($path)` | Path | FileResponse | Get permissions |
| | `sharedGet($path)` | Path | FileResponse | Read with shared lock (concurrent-safe) |
| | `exclusivePut($path, $content)` | Path, content | FileResponse | Write with exclusive lock |
| | `replace($search, $replace, $path)` | Search, replace, path | FileResponse | Find and replace |
| | `replacePattern($pattern, $replace, $path)` | Regex, replace, path | FileResponse | Regex find and replace |
| | `requireFile($path)` / `requireOnce($path)` | Path | mixed | Require PHP file |
| **Path Utils** | `join(...$paths)` | Path components | string | Join paths safely |
| | `normalize($path)` | Path | string | Clean path (fix slashes, remove `..`) |
| | `realpath($path)` | Path | string\|false | Get absolute path |
| | `relativePath($from, $to)` | Base, target | string | Calculate relative path |

### Examples

```php
use Rackage\File;

// Read files
$result = File::read('config.json');
if ($result->success) {
    $config = json_decode($result->content, true);
}

$data = File::readJson('settings.json');
$lines = File::readLines('data.txt');

// Write files
File::write('output.txt', 'Hello World');
File::append('log.txt', "New entry\n");
File::writeJson('config.json', $data, true);  // Pretty print

// File operations
File::copy('source.txt', 'backup.txt');
File::move('old.txt', 'new.txt');
File::delete(['temp1.txt', 'temp2.txt']);

if (File::exists('config.json')->exists) { /* ... */ }

// File info
$size = File::size('photo.jpg')->size;
$ext = File::extension('photo.jpg')->extension;  // 'jpg'
$mime = File::mimeType('file.pdf')->mimeType;   // 'application/pdf'

// Directories
File::makeDir('storage/uploads');
File::ensureDir('cache/views');  // Create if not exists
File::cleanDir('temp');          // Delete contents, keep dir

$result = File::files('uploads');
foreach ($result->files as $file) {
    echo $file;
}

// Find files (glob patterns)
$phpFiles = File::glob('*.php');                  // All PHP files in current dir
$allPhp = File::glob('**/*.php');                 // PHP files recursively
$configs = File::glob('config/*.{php,json}');     // PHP or JSON in config dir
$errorLogs = File::glob('logs/error-*.log');      // Error logs with pattern

// Large file processing (memory-efficient)
File::lines('huge.log', function($line, $lineNumber) {
    if (str_contains($line, 'ERROR')) {
        echo "Line {$lineNumber}: {$line}\n";
    }
    // Processes line-by-line, doesn't load entire file
});

// Concurrent-safe read/write (multiple processes)
$config = File::sharedGet('config.json');         // Shared lock (multiple readers)
File::exclusivePut('counter.txt', $newCount);     // Exclusive lock (single writer)

// Path utilities
$path = File::join('application', 'controllers', 'Home.php');
// 'application/controllers/Home.php'

$clean = File::normalize('path//to/../file.txt'); // 'path/file.txt'
```
---

### Seeder

**Purpose**: Base class for database seeding with orchestration, transaction support, and table truncation.

**Import**: `use Rackage\Seeder;` (extend this class)

**Location**: `application/database/seeders/`

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `call($seederClass)` | Fully qualified class name | void | Execute another seeder (orchestration) |
| `truncate($tables)` | Table name or array | void | Clear table(s) and reset auto-increment |
| `transaction($callback)` | Callable | void | Wrap operations in database transaction |
| `run()` | None | void | Override this method to define seeding logic |

**Note**: TRUNCATE cannot be rolled back even in transactions. Use DELETE if rollback is needed.

### Examples

```php
use Rackage\Seeder;
use Models\UserModel;
use Rackage\Security;

// Individual seeder (application/database/seeders/UsersSeeder.php)
class UsersSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        $this->truncate('users');

        // Insert sample users
        UserModel::save([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Security::hash('password123')
        ]);

        UserModel::save([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Security::hash('secret456')
        ]);
    }
}

// Master seeder for orchestration (application/database/seeders/DatabaseSeeder.php)
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run seeders in dependency order
        $this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostsSeeder::class);      // Depends on users + categories
        $this->call(CommentsSeeder::class);   // Depends on posts
    }
}

// Transaction pattern for data integrity
class OrdersSeeder extends Seeder
{
    public function run()
    {
        $this->transaction(function() {
            $userId = UserModel::save(['name' => 'Customer']);
            OrderModel::save(['user_id' => $userId, 'total' => 99.99]);
            // If order fails, user is also rolled back
        });
    }
}

// Multiple tables
$this->truncate(['users', 'posts', 'comments']);

// Running seeders (CLI)
// php roline db:seed              // Run DatabaseSeeder
// php roline db:seed Users        // Run UsersSeeder only
```
---

### Log

**Purpose**: Application logging with multiple severity levels, structured context data, and custom log files.

**Import**: `use Rackage\Log;` (not needed in views)

**Call**: `Log::error('message')`

**Log Directory**: Automatically determined from `error_log` setting in `config/settings.php` (extracts directory path)

### Log Levels

| Level | File | Use For |
|-------|------|---------|
| ERROR | error.log | Runtime errors, exceptions, failures |
| WARNING | warning.log | Exceptional occurrences, slow queries, deprecated APIs |
| INFO | info.log | User activity, important events, successful operations |
| DEBUG | debug.log | Detailed debug information, variable dumps, traces |

**Note**: All log levels are always written. No filtering based on configuration.

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `error($msg, $context=[])` | Message, context array | void | Log error to error.log |
| `warning($msg, $context=[])` | Message, context array | void | Log warning to warning.log |
| `info($msg, $context=[])` | Message, context array | void | Log info to info.log |
| `debug($msg, $context=[])` | Message, context array | void | Log debug to debug.log |
| `to($filename)` | Filename | Log | Create instance for custom file |

**Log Format**: `[2024-01-15 14:30:45] [ERROR] message {"context":"json"}`

### Examples

```php
use Rackage\Log;

// Each level writes to its own file
Log::error('Database connection failed');          // → error.log
Log::warning('Cache miss rate high');              // → warning.log
Log::info('User registered');                      // → info.log
Log::debug('API response received');               // → debug.log

// With structured context
Log::error('Payment gateway timeout', ['gateway' => 'stripe', 'order_id' => 12345]);
Log::info('User login', ['email' => $user['email'], 'ip' => Request::ip()]);

// Exception logging
try {
    $result = riskyOperation();
} catch (Exception $e) {
    Log::error($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
}

// Custom log files
Log::to('security.log')->warning('Failed login', ['ip' => Request::ip()]);
Log::to('cron.log')->info('Backup completed', ['size_mb' => $size]);

// Config (directory auto-detected from error_log path)
'error_log' => 'vault/logs/error.log',  // All logs → vault/logs/
```

**Features**:
- Non-blocking writes with exclusive locks (LOCK_EX)
- Auto-creates log directory if missing
- Silently fails on errors (never crashes app)
- JSON-encoded context for easy parsing
- Separate file per log level
- Directory path cached after first call
- File permissions: directories 0755, files 0644

---

### Queue

**Purpose**: In-memory FIFO (First In, First Out) queue data structure for sequential processing.

**Import**: `use Rackage\Queue;` (not needed in views)

**Call**: `Queue::push('queue_name', $item)`

**Storage**: In-memory only (cleared when request/script ends). Use database-backed queues for persistence.

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `push($name, $item)` | Queue name, item | void | Add item to back of queue |
| `pop($name)` | Queue name | mixed\|null | Remove and return front item (null if empty) |
| `pushMany($name, $items)` | Queue name, array | void | Add multiple items at once |
| `popMany($name, $count)` | Queue name, count | array | Remove and return multiple items |
| `peek($name)` | Queue name | mixed\|null | View front item without removing |
| `isEmpty($name)` | Queue name | bool | Check if queue has no items |
| `count($name)` | Queue name | int | Get number of items in queue |
| `has($name)` | Queue name | bool | Check if queue exists |
| `clear($name)` | Queue name | void | Remove all items from queue |
| `toArray($name)` | Queue name | array | Convert queue to array (non-destructive) |
| `flush()` | None | void | Remove all queues |

**Performance**: All operations are O(1) constant time using SplQueue.

### Examples

```php
use Rackage\Queue;

// URL crawler queue (FIFO: first in, first out)
Queue::push('urls', 'https://example.com');
Queue::push('urls', 'https://example.com/about');

while (!Queue::isEmpty('urls')) {
    $url = Queue::pop('urls');  // Gets first URL pushed
    processPage($url);
}

// Email queue with structured data
foreach ($users as $user) {
    Queue::push('emails', ['to' => $user['email'], 'subject' => 'Newsletter']);
}

while (!Queue::isEmpty('emails')) {
    $email = Queue::pop('emails');
    Mail::to($email['to'])->subject($email['subject'])->send();
}

// Job queue with types
Queue::push('jobs', ['type' => 'resize_image', 'path' => 'photo.jpg']);
Queue::push('jobs', ['type' => 'send_email', 'user_id' => 123]);

while (!Queue::isEmpty('jobs')) {
    $job = Queue::pop('jobs');
    match($job['type']) {
        'resize_image' => resizeImage($job['path']),
        'send_email' => sendNotification($job['user_id'])
    };
}

// Batch operations
Queue::pushMany('urls', ['https://a.com', 'https://b.com', 'https://c.com']);
$batch = Queue::popMany('urls', 100);  // Get up to 100 items

// Peek without removing
$nextJob = Queue::peek('jobs');
if ($nextJob && $nextJob['type'] === 'expensive') {
    Log::info('Deferring expensive job');
} else {
    executeJob(Queue::pop('jobs'));
}

// Utilities
$count = Queue::count('batch_import');
$items = Queue::toArray('urls');  // Preview without removing
Queue::clear('failed_jobs');       // Clear specific queue
Queue::flush();                    // Clear all queues
```

**Use Cases**: URL crawling, email sending, batch processing, job queues, image processing, CSV imports

---

### Mail

**Purpose**: Email sending with support for SMTP, Sendmail, and PHP mail() drivers. Chainable builder pattern.

**Import**: `use Rackage\Mail;` (not needed in views)

**Call**: `Mail::to('user@example.com')`

**Configuration**: `config/mail.php` - driver, SMTP settings, default from address

### Drivers

| Driver | Description | Use Case |
|--------|-------------|----------|
| smtp | Native SMTP with TLS/SSL | Production (Gmail, SendGrid, Mailgun, etc.) |
| sendmail | Server sendmail binary | Linux servers with sendmail installed |
| mail | PHP mail() function | Simple hosting, development |

### Methods

| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| `to($address, $name='')` | Email, name | Mail | Create instance with recipient (static) |
| `from($address, $name='')` | Email, name | Mail | Create instance with custom from (static) |
| `error()` | None | string\|null | Get last error message (static) |
| `cc($address, $name='')` | Email, name | $this | Add CC recipient |
| `bcc($address, $name='')` | Email, name | $this | Add BCC recipient (hidden) |
| `replyTo($address, $name='')` | Email, name | $this | Set reply-to address |
| `subject($subject)` | Subject line | $this | Set email subject |
| `body($body)` | Content | $this | Set plain text or HTML body |
| `template($view, $data=[])` | View name, data | $this | Render Rachie view template as body |
| `attach($path, $name='')` | File path, name | $this | Attach file to email |
| `send()` | None | bool | Send email (returns true on success) |

### Examples

```php
use Rackage\Mail;

// Simple text email
Mail::to('user@example.com')
    ->subject('Welcome!')
    ->body('Thanks for signing up.')
    ->send();

// HTML email with Rachie template
Mail::to($user['email'])
    ->subject('Password Reset')
    ->template('emails/password-reset', ['token' => $token, 'user' => $user])
    ->send();

// Multiple recipients with CC/BCC
Mail::to(['user1@example.com', 'user2@example.com'])
    ->cc('manager@example.com')
    ->bcc('archive@example.com')
    ->subject('Team Update')
    ->body('Latest team update...')
    ->send();

// Email with attachments
Mail::to('admin@example.com')
    ->subject('Monthly Report')
    ->attach(Path::vault() . 'reports/january.pdf')
    ->attach(Path::vault() . 'reports/summary.xlsx')
    ->template('emails/report', ['month' => 'January'])
    ->send();

// Custom from address
Mail::from('support@example.com', 'Support Team')
    ->to('user@example.com')
    ->subject('Your Support Ticket')
    ->template('emails/support-ticket', ['ticket' => $ticket])
    ->send();

// Error handling
$sent = Mail::to('user@example.com')
    ->subject('Test')
    ->body('Test message')
    ->send();

if (!$sent) {
    Log::error('Mail failed: ' . Mail::error());
    Session::flash('error', 'Failed to send email');
}

// Template example (application/views/emails/welcome.php)
<h1>Welcome, {{ $user['name'] }}!</h1>
<p>Thanks for joining {{ Registry::settings()['title'] }}.</p>
<p><a href="{{ Url::link('verify', $token) }}">Verify Email</a></p>

// Config (config/mail.php)
return [
    'driver' => 'smtp',
    'from_email' => 'noreply@example.com',
    'from_name' => 'My App',
    'smtp' => [
        'host' => 'smtp.mailtrap.io',
        'port' => 2525,
        'username' => 'your-username',
        'password' => 'your-password',
        'encryption' => 'tls',  // tls, ssl, or null
    ],
];
```

---

**Helpers in Rachie** provides 18 essential utility classes for streamlined development. From input handling and security to file operations and caching, these static classes eliminate boilerplate code and offer consistent APIs across your application.

See also: [Rachie Helpers Documentation](https://rachie.dev/docs/helpers)

---

## Roline CLI in Rachie

Command-line toolkit for Rachie Framework - Generates code, manages databases, scaffolds resources via model annotations.

**Working Directory:** All commands must be run from project root (directory containing `roline`, `application/`, `public/`, `config/`).

**Project Settings:** Update `config/settings.php` with your name, copyright, license, version before generating code. These appear in @author/@copyright/@license/@version tags in generated files.

**Core Philosophy:** Your model IS your schema. Define columns with `@column` annotations in model properties. Roline reads annotations and creates/updates database tables automatically. No separate migration files needed (migrations optional for deployment tracking).

**Entry Point:** `php roline <command> [args]`
- Thin wrapper in project root: `roline`
- Bootstraps Rachie via `public/index.php`
- All CLI logic in `vendor/glivers/roline`

---

### Directory Structure

```
application/
  models/               {Name}Model.php (e.g., UserModel.php)
  controllers/          {Name}Controller.php (e.g., PostsController.php)
  views/{name}/         layout.php, index.php, show.php, create.php, edit.php
  database/
    migrations/         {timestamp}_{description}.php
    schemas/            {timestamp}_{description}.json (migration snapshots)
    seeders/            {Name}Seeder.php, DatabaseSeeder.php

public/
  css/                  {name}.css (generated with views)

vault/                  (temporary/cache files - safe to delete)
  cache/                Application cache
  tmp/                  Compiled view templates
  logs/                 error.log
  sessions/             PHP session files

config/
  database.php          Database connection config (default DB for db: commands)
```

---

### CODE GENERATION RULES (CRITICAL)

### 1. One Annotation Per Line
**NEVER compress. ALWAYS separate lines.**

```php
// ✗ WRONG
/** @column @varchar 255 @unique @nullable */
protected $email;

// ✓ CORRECT
/**
 * User email address for login
 * @column
 * @varchar 255
 * @unique
 * @nullable
 */
protected $email;
```

### 2. Non-Static Properties Only
```php
// ✗ WRONG - ignored by parser
protected static $username;

// ✓ CORRECT
protected $username;
```

### 3. Description Required
```php
// ✗ WRONG - no description
/**
 * @column
 * @varchar 255
 */
protected $email;

// ✓ CORRECT - description before annotations
/**
 * User email address for login and notifications
 * @column
 * @varchar 255
 */
protected $email;
```

---

### Command Families

```
model:*        → Tables WITH models (99% of cases)
               → Reads @column annotations from model
               → Keeps model and DB in sync
               → ALWAYS use for model-backed tables

table:*        → Tables WITHOUT models ONLY
               → Direct DB operations, bypasses models
               → For legacy/temp/lookup tables
               → NEVER use on model-backed tables (causes schema drift)

db:*           → Database-level operations (all tables, entire DB)
               → Default: database from config/database.php
               → Override: provide db name as arg

migration:*    → Version control for schema changes
               → Captures DB state for deployment
               → CRITICAL: Run model:table-update BEFORE migration:make
```

**Golden Rule:** Never mix model: and table: commands on same table.

---

### Commands Quick Reference

### Model Commands
```
model:create <Name> [table]              → application/models/{Name}Model.php
                                           Optional: specify custom table name
model:append <Name>                      → Add properties interactively (name/type only)
model:delete <Name>                      → Delete model file (table untouched)
model:rename <Old> <New>                 → Rename model file and class name
model:table-create <Name>                → DROP+CREATE table (DESTRUCTIVE)
model:table-update <Name>                → ALTER table (SAFE, preserves data)
model:table-drop <Name>                  → DROP table permanently
model:table-rename <Name> <new_table>    → RENAME table + update model $table (NO data loss)
model:table-schema <Name>                → Show table structure
model:table-empty <Name>                 → DELETE rows (keep auto-increment)
model:table-reset <Name>                 → TRUNCATE (reset auto-increment)
model:table-export <Name> [file]         → Export SQL/CSV

Name format: User (not UserModel), case-insensitive, PascalCase convention
Table names: Auto-pluralized (User → users), snake_cased (OrderItem → order_items)
Custom tables: model:create Data datum OR model:table-rename Data datum (both work)
```

### Controller Commands
```
controller:create <Name>                 → application/controllers/{Name}Controller.php
controller:append <Name> <method>        → Add method to controller
controller:delete <Name>                 → Delete controller file
controller:rename <Old> <New>            → Rename controller file and class name
controller:complete <name>               → Full MVC: controller+model+views+CSS
```

### View Commands
```
view:create <view>                       → application/views/{view}/ + templates + CSS
view:add <directory> <file>              → Add single view file
view:delete <view>                       → Delete directory (prompts for CSS deletion)
view:rename <old> <new>                  → Rename directory (prompts for CSS rename)
```

### Table Commands (non-model tables only)
```
table:create <name> [--sql=file]         → Interactive or from SQL
table:copy <src> <dst> [--empty]         → Duplicate table
table:delete <name>                      → DROP table
table:rename <old> <new>                 → RENAME (doesn't update models)
table:schema <name>                      → Show structure
table:empty <name>                       → DELETE rows
table:reset <name>                       → TRUNCATE
table:export <name> [file]               → Export SQL/CSV
table:partition <table> <type> <count>   → Add partitioning
table:unpartition <table>                → Remove partitioning
```

### Migration Commands
```
migration:make <name>                    → Create from DB diff (run AFTER table update)
migration:run                            → Execute pending migrations
migration:rollback [steps]               → Revert last batch
migration:status                         → Show ran vs pending
```

### Database Commands
```
db:list                                  → List all databases
db:tables [database]                     → List tables with row counts
db:create [database]                     → CREATE DATABASE
db:drop [database]                       → DROP DATABASE (triple confirm)
db:drop-tables                           → DROP all tables (keep DB)
db:reset                                 → TRUNCATE all tables
db:schema                                → Show complete schema
db:seed [seeder]                         → Run seeders
db:export [file]                         → Export entire DB
db:import <file>                         → Import SQL dump
```

### Cache Commands
```
cleanup:cache                            → Clear vault/cache/
cleanup:views                            → Clear vault/tmp/
cleanup:logs                             → Truncate vault/logs/error.log
cleanup:sessions                         → Clear vault/sessions/ (logs out ALL users)
cleanup:all                              → All cleanup operations
```

---

### Annotations Reference

### Numeric Types
```
@tinyint [len]       TINYINT(4)           -128 to 127 (0-255 unsigned), 1 byte
@smallint [len]      SMALLINT(6)          -32K to 32K (0-65K unsigned), 2 bytes
@mediumint [len]     MEDIUMINT(9)         -8M to 8M (0-16M unsigned), 3 bytes
@int [len]           INT(11)              -2B to 2B (0-4B unsigned), 4 bytes
@bigint [len]        BIGINT(20)           -9Q to 9Q (0-18Q unsigned), 8 bytes
@decimal P,S         DECIMAL(10,2)        Exact decimals (ALWAYS for money)
@float               FLOAT                ~7 digits (NEVER for money)
@double              DOUBLE               ~15 digits (NEVER for money)
```

### String Types
```
@char [len]          CHAR(255)            Fixed-length, max 255
@varchar len         VARCHAR(255)         Variable-length, max 65535
@text                TEXT                 Max 64KB
@mediumtext          MEDIUMTEXT           Max 16MB
@longtext            LONGTEXT             Max 4GB
```

### Date/Time Types
```
@date                DATE                 YYYY-MM-DD, 1000-01-01 to 9999-12-31
@time                TIME                 HH:MM:SS, can be negative
@year                YEAR                 1901 to 2155, 1 byte
@datetime            DATETIME             No timezone, 5 bytes
@timestamp           TIMESTAMP            Timezone-aware, 1970-2038, 4 bytes
```

### Special Types
```
@boolean             TINYINT(1) DEFAULT 0           True/false (0/1)
@enum a,b,c          ENUM('a','b','c')              One value (no spaces in list)
@set a,b,c           SET('a','b','c')               Multiple values
@json                JSON                           MySQL 5.7.8+
@autonumber          INT UNSIGNED AUTO_INCREMENT    Primary key (auto: INT, UNSIGNED, AUTO_INC, PRIMARY)
@uuid                CHAR(36) PRIMARY KEY           36-char UUID, generate in app
@blob                BLOB                           Binary, max 64KB
@mediumblob          MEDIUMBLOB                     Binary, max 16MB
@longblob            LONGBLOB                       Binary, max 4GB
@point               POINT                          GPS coordinates
@linestring          LINESTRING                     Routes/paths
@polygon             POLYGON                        Areas/boundaries
@geometry            GEOMETRY                       Any geometry type
```

### Constraints
```
@primary             PRIMARY KEY                    Auto-indexed, NOT NULL, one per table
@unique              UNIQUE                         Prevents duplicates, allows multiple NULLs
@nullable            NULL                           Default is NOT NULL
@unsigned            UNSIGNED                       Numeric only, doubles positive range
@default val         DEFAULT val                    String: no quotes. CURRENT_TIMESTAMP for datetime
@check expr          CHECK (expr)                   MySQL 8.0.16+, e.g., @check price > 0
```

### Indexes (property docblock)
```
@index [name]        INDEX                          Auto-names if omitted
@fulltext            FULLTEXT INDEX                 TEXT/VARCHAR only, for MATCH() AGAINST()
```

### Indexes (class docblock)
```
@composite (col1,col2)                              INDEX idx_col1_col2
@compositeUnique (col1,col2)                        UNIQUE INDEX unq_col1_col2
@partition hash(col) N                              PARTITION BY HASH PARTITIONS N
```

### Relationships
```
@foreign table(col)  FOREIGN KEY REFERENCES         Types must match exactly
@ondelete ACTION     ON DELETE {CASCADE|RESTRICT|SET NULL|NO ACTION}
@onupdate ACTION     ON UPDATE {CASCADE|RESTRICT|SET NULL|NO ACTION}
```

### Modifiers
```
@comment "text"      Column comment                 Stored in DB schema
@tablecomment "text" Table comment                  Class docblock only
@after col           Position after column          model:table-update only
@first               Position first                 model:table-update only
@drop                Mark for deletion              model:table-update only, then remove property
@rename old_name     Rename preserving data         Property name = new, annotation = old
```

---

### Critical Patterns

### Foreign Key (Type Matching)
```php
// Parent table
/**
 * @column
 * @autonumber
 */
protected $id;  // Creates: INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY

// Child table - types MUST match exactly
/**
 * User who created this post
 * @column
 * @int
 * @unsigned              // ← CRITICAL: Must match parent's UNSIGNED
 * @foreign users(id)
 * @ondelete CASCADE
 */
protected $user_id;
```

### Composite Index (Class Docblock)
```php
/**
 * User Model
 *
 * @composite (last_name, first_name)
 * @compositeUnique (email, deleted_at)
 */
class UserModel extends Model
{
    // Order matters: leftmost columns most important
}
```

### Rename Column (Preserves Data)
```php
/**
 * User email address
 * @column
 * @varchar 255
 * @rename email_addr     // ← Old name
 */
protected $email;          // ← New name

// Run: php roline model:table-update User
// Then remove @rename annotation
```

### Drop Column
```php
/**
 * @column
 * @drop                  // ← Mark for deletion
 */
protected $old_field;

// Run: php roline model:table-update User
// Then delete entire property from model
```

---

### Critical Rules

### Command Selection
1. Model-backed tables: **ALWAYS** `model:` commands
2. Non-model tables: `table:` commands
3. **NEVER mix** both on same table
4. Database-wide: `db:` commands

### Migration Workflow
```bash
# ✓ CORRECT ORDER:
1. Edit model annotations
2. php roline model:table-update User
3. php roline migration:make add_field

# ✗ WRONG ORDER (migration empty):
1. Edit model
2. php roline migration:make add_field  # No DB changes yet!
3. php roline model:table-update User
```

### Annotation Syntax
1. Every column needs `@column`
2. One annotation per line (NEVER compress)
3. Description required before annotations
4. Non-static properties only
5. `@foreign` types must match exactly (parent @autonumber = child @int @unsigned)
6. `@enum`/`@set`: no spaces (active,inactive NOT active, inactive)
7. `@unsigned` only on numeric types
8. `@decimal` format: `@decimal 10,2`
9. `@rename`: property name = new, annotation value = old

### Type Selection
1. Money: **ALWAYS** `@decimal`, **NEVER** `@float`/`@double`
2. Booleans: Use `@boolean` for clarity
3. IDs: Use `@autonumber` for primary keys
4. Text >255 chars: Use `@text` not `@varchar`

### Foreign Keys
1. Types must match exactly (including UNSIGNED)
2. Referenced column must exist (create parent first)
3. Referenced column must be PRIMARY or UNIQUE
4. Cascade: Use `@ondelete CASCADE` for dependent data

---

### Common Errors & Fixes

```
"Column not found"
→ php roline model:table-update User

"Cannot add foreign key constraint"
→ Check types match exactly (parent @autonumber = child @int @unsigned)
→ Parent table exists and referenced column is indexed

"Migration file empty"
→ Run model:table-update BEFORE migration:make

"NULL value in NOT NULL column"
→ Add @nullable or @default
```

---

### Complete Model Example

```php
<?php namespace Models;

use Rackage\Model;

/**
 * User Model
 *
 * @composite (last_name, first_name)
 */
class UserModel extends Model
{
    protected static $table = 'users';
    protected static $timestamps = true;

    /**
     * Unique user identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * User email for login
     * @column
     * @varchar 255
     * @unique
     */
    protected $email;

    /**
     * Hashed password (bcrypt)
     * @column
     * @varchar 255
     */
    protected $password;

    /**
     * User's first name
     * @column
     * @varchar 100
     */
    protected $first_name;

    /**
     * User's last name
     * @column
     * @varchar 100
     */
    protected $last_name;

    /**
     * Account status
     * @column
     * @enum active,inactive,suspended,banned
     * @default active
     * @index
     */
    protected $status;

    /**
     * User role/permission level
     * @column
     * @int
     * @unsigned
     * @foreign roles(id)
     * @ondelete RESTRICT
     */
    protected $role_id;

    /**
     * User preferences and settings
     * @column
     * @json
     * @nullable
     */
    protected $settings;

    /**
     * When user registered
     * @column
     * @datetime
     */
    protected $created_at;

    /**
     * When profile last updated
     * @column
     * @datetime
     */
    protected $updated_at;

    /**
     * Soft delete timestamp
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $deleted_at;
}
```

---


**Roline CLI in Rachie** is the command-line toolkit that powers model-driven development. From scaffolding complete MVC resources to managing database schemas via annotations, Roline eliminates boilerplate and keeps your models in perfect sync with your database structure.

See also: [Rachie Roline CLI Documentation](https://rachie.dev/docs/roline)
