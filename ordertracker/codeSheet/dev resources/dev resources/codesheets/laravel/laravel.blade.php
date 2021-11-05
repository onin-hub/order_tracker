{{-- 
refer to the respective documentation for installation instructions
// install composer
// install node js
// install laravel

// on project directory
// commands: 
--}}

composer                    - check if composer is installed
node -v                     - check if node is installed
npm -v                      - check if npm is installed
laravel                     - check if laravel is installed
laravel new [app name]      - create new laravel app
php artisan                 - list all artisan commands
php artisan serve           - create new server for laravel app

{{-- create authentication scaffolding: (laravel v6^)  --}}
composer require laravel/ui  
php artisan ui vue --auth

composer require laravel/ui
php artisan ui:auth

building the frontend / with js
{{-- install npm --}}
npm install
{{-- compile npm --}}
{{-- need to compile npm before you can use it --}}
{{-- run twice until successful compilation --}}
npm run dev

{{-- configure database --}}
{{-- go to .env file --}}
{{-- migrate database: --}}
php artisan migrate             - migrate database to the latest state
ctrl + c                        - refresh the server

{{-- directories/folder: --}}
laravelapp/resources/views      - the view, html/frontend layout 
laravelapp/app/Http/Controllers - the controllers, controller files
laravelapp/app/User.php 		- sample model class for User, one model class represents one row in database

{{-- interacting to your app through commandline --}}
{{-- useful in debugging --}}
php artisan tinker				- useful in debugging your app 
User::all();					- using the User model fetching all user data in user table
exit							- close the tinker

{{-- instanciating a class --}}
$profile = new \App\Profile();
{{-- assigning value --}}
$profile->name = 'Nice Name';
{{-- saving the data --}}
$profile->save();
{{-- dump the object --}}
$profile;

{{-- push changes into the database --}}
$user->profile->url = 'sampleurl.org';
$user->push();

{{-- whenever you make changes to your database --}}
{{-- you need to remake your database --}}
{{-- note: will lose all data in database --}}
php artisan migrate:fresh		- deleting everything and making everything again basically refreshing your database

{{-- creating a controller --}}
php artisan help make:controller							- show information/options about the command 
php artisan make:controller [options] [controller name] 	- create a new controller class

{{-- creating a model --}}
php artisan make:model						- create a new Eloquent model class
php artisan make:model [model name] -m		- 'm' means the model will also create a migration file as soon as it is created


{{-- Collections --}}
{{-- interacting with the Eloquent ORM --}}
{{-- available method: https://laravel.com/docs/6.x/eloquent-collections#available-methods --}}
<?php 
use App\User;

User::find($uid); // get user with given id
User::findOrFail($uid); // throw a 404 error if a data is not found
?>  

{{-- passing variable into routes --}}
{{-- in creating routes for controller refer to the documentation: --}}
{{-- https://laravel.com/docs/6.x/controllers#resource-controllers --}}
<?php Route::get('/profile/{uid}', 'UserProfileController@showDetails')->name('profile'); ?>

{{-- You may register many resource controllers at once by passing an array to the resources method: --}}
<?php
Route::resources([
    'photos' => 'PhotoController',
    'posts' => 'PostController'
]);
?>

{{-- die and dump function, useful in debugging --}}
<?php dd($var); ?>   

{{-- passing data from controller to view --}}
{{-- code in UserProfileController.php : --}}
<?php
use App\User;

class UserProfileController extends Controller {
	
    public function showDetails($uid) {

    	// dd(User::find($user));

    	$user = User::find($uid);

    	return view('profile', [
    		'var' => $user
    	]);
    }
}
?>
{{-- code in profile.blade.php : --}}
<p>username: {{ $var->username }} </p>

{{-- locating a file inside a directory --}}
{{-- example: create.blade file inside a posts folder inside views directory --}}
{{-- you can use a period or a slash --}}
<?php
return view('posts.create');
return view('posts/create');
?>

{{-- database migration structure --}}
{{-- available column type : https://laravel.com/docs/6.x/migrations#creating-columns --}}
<?php $table->bigIncrements('id'); ?>

{{-- available column modifiers: https://laravel.com/docs/6.x/migrations#column-modifiers --}}
<?php $table->string('name')->nullable(); ?>

<?php
public function up()
{
	Schema::create('profiles', function (Blueprint $table) {
		$table->bigIncrements('id');
		$table->string('name')->nullable();
		$table->timestamps();
	});
}
?>

{{-- table relationship --}}
{{-- one to one relationship --}}
{{-- in this example the Profile belongs to one User and a User has one Profile --}}
<?php
class Profile extends Model
{
    public function user() {
       return $this->belongsTo(User::class);
    }
}
?>
{{-- reversely one User has one Profile --}}
<?php
class User extends Authenticatable
{
    public function profile() {
        return $this->hasOne(Profile::class);
    }
}
?>

{{-- one to many relationship --}}
{{-- in this example a Post belongs to one User and a User has many post --}}
{{-- a post belongs to one user --}}
<?php
class Post extends Model
{
    public function user() {
       return $this->belongsTo(User::class);
    }
}
?>
{{-- reversely one User has many posts --}}
<?php
class User extends Authenticatable
{
    // observe singular and plural naming convention
    public function posts() {
        return $this->hasMany(Post::class);
    }
}
?>

{{-- *********************************************************************************************** --}}
{{-- process of creating new feature/function --}}
{{-- #1 - first create a model :
in this example were going to make a post feature    
--}}
php artisan make:model [model name] -m		- 'm' means the model will also create a migration file as soon as it is created
php artisan make:model Post -m

{{-- #2 - edit the newly created migration file --}}
{{-- /database/migrations --}}
{{-- create the structure of your database table --}}
{{-- available column type : https://laravel.com/docs/6.x/migrations#creating-columns --}}
<?php $table->bigIncrements('id'); ?>

{{-- available column modifiers: https://laravel.com/docs/6.x/migrations#column-modifiers --}}
<?php $table->string('name')->nullable(); ?>

<?php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id');
        $table->string('caption');
        $table->string('image');
        $table->timestamps();
        $table->index('user_id');
    });
}
?>

{{-- #3 - migrate the database --}}
php artisan migrate     - migrate database to the latest state

{{-- #4 - create a table relationship if any --}}
{{-- one to many relationship --}}
{{-- in this example a Post belongs to one User and a User has many posts --}}
{{-- a post belongs to one user --}}
<?php
class Post extends Model
{
    public function user() {
       return $this->belongsTo(User::class);
    }
}
?>
{{-- reversely one User has many posts --}}
<?php
class User extends Authenticatable
{
    // observe singular and plural naming convention
    public function posts() {
        return $this->hasMany(Post::class);
    }
}
?>

{{-- #5 - create routes --}}
{{-- /routes/web.php --}}
{{-- in creating routes for controller refer to the documentation: --}}
{{-- https://laravel.com/docs/6.x/controllers#resource-controllers --}}
<?php Route::get('/p', 'PostsController@create'); ?>

{{-- #6 - create the controller and method --}}
php artisan make:controller [options] [controller name] 	- create a new controller class
php artisan make:controller PostsController

{{-- modify the controller file and create necessary method --}}
{{-- app/Http/Controllers --}}
<?php
class PostsController extends Controller
{
    public function create() {
        // you can use period or slash for declaring path
        return view('posts.create');
    }
}
?>

{{-- #6 - creating the views and forms --}}
{{-- blade templating: --}}
{{-- yield is use to call the extended component --}}
@yield('content')

{{-- extend component --}}
@extends('layouts.app')

@section('content')
    <form action="/p" enctype="multipart/form-data" method="post">
        {{-- insert fields here --}}
    </form>
@endsection

{{-- *********************************************************************************************** --}}














