<?php
// or # single line comment
/* multiline comment */ 
// outputting string/var
// echo = doesn't return a value, but faster
// print = return a value of 1
echo ''; 
print '';

# variables
/* rules:
- prefix with $
- start with letter
- only letters, numbers or _
- case sensitive
*/

$variable = '';

# data types
// string, integer, floats, booleans, arrays, objects, null, resource

$string = 'string';
$integer = 4;
$float = 4.4;
$boolean = true;

// concatination
// use .
$str1 = 'Hello';
$str2 = 'World';
$cont = $str1.$str2;
$cont = $str1.' '.$str2;
// '' - will not parse the variable inside
// "" - will parse the variable inside

// escaping string
// will only escape matching quotes/character
$string = 'They\'re here';

// constant
// constant are varialbe that never change
// define('constant name','value',true); - function to define constant
// add value of 'true' to make it not case sensitive
// capitalize constant name for convention
define('CONSTANT', 'Value');
echo CONSTANT;

# arrays
// arrays are variable that holds multiple values
// types: indexed, associative, multi dimensional
// arrays are zero 0 base, means index starts with 0
$myArray = array();
// as of php 5.4 you can use brackets instead of parentheses
$myArray = [];

// indexed arrays
$myArray = ['John','Peter','Rose'];
// accessing data from array
echo $myArray[1]; 
// output: Peter
// changing data
$myArray[1] = 'Joshua';
// adding data
$myArray[] = 'Maria';
// using var_dump function to output the structure of the variable
var_dump($myArray);
// use count() to get the number of data in the array
count($myArray);

// associative arrays
// key => value pairs
$myArray = ['key' => 'value'];
// accessing data 
echo $myArray['key'];
// adding data
$myArray['newKey'] = 'value';

// multi-dimensional arrays
// array within an array
$myArray = [[],[],[]];
$myArray = [
	['toyota',22],
	['honda',24],
	['ford',30]
];
// access data by index
$myArray[0][1];
// output: 22

// array functions
// adding data into array
array_push($array, $items);	
array_push($array, 'apple','banana');

// flipping array, exchanging key / value pair
// key to value | value to key
$flipped = array_flip($array);

// search data in array and return its key
$searched = array_search($needle, $haystack);
$searched = array_search('needle', $array);
echo $searched;		

// search data if it exists in the array
in_array($needle, $haystack);

// return keys for arrays
$keys = array_keys($array);
// return key of specified value
$key = array_keys($array, 'needle');

// return values of arrays in indexed format
$values = array_values($array);

// array_merge — Merge one or more arrays
// returns the resulting array
array_merge($array1,$array2);

// This function shuffles (randomizes the order of the elements in) an array
// It uses a pseudo random number generator that is not suitable for cryptographic purposes
shuffle($numbers);

# loops
// loops excute a block of codes multiple times on a set condition
// for loop
// for loop is use if you know the number of times it will executed
// parameter: initializer, condition, iteration/increment
// example below loop will continue as long as the condition is true
for ($i = 0; $i < 10 ; $i++) { 
	echo $i;
}

// while loop
// use while loop if you dont know the time to stop the loop
$i = 0;

while ($i < 10) {
	echo $i;
	$i++;
}

// do while loop
// means DO the instruction, WHILE the condition is true
// always run once no matter what
$i = 0;
do {
	echo $i;
	$i++;
}
while ($i <= 10);

// foreach loop
// only work for arrays and objects
// parameter: array, key, value
/* 2 syntaxes: 
foreach($array as $value){} - commonly use for indexed array
foreach($array as $key => $value){} - commonly use for associative array
*/
$people = ['Peter','John','Rose'];

foreach ($people as $person) {
	echo $person;
}

$people = [
	11 => 'Peter', 
	12 => 'John',
	13 => 'Rose'
];

foreach ($people as $id => $person) {
	echo $id.' '.$person;
}

# function
// function are block of code that can be repeatedly called
function myFunction() {
	// some code here
}
// calling a function
myFunction();

// function with arguments/parameters
// $name='value' - putting a default value for parameter
function sayHello($name) {
	echo 'Hello my name is'.$name;
}
myFunction($name);

// returning value from a function
function myFunction($num1,$num2) {
	return $num1 + $num2;
}
echo myFunction(3,5);

// by referrence
// passing the value of a variable into the function by referrence
// by referrence means the function will able to change the value of a variable
$myNum = 10;

function myFunction(&$num) {
	$num += 5;
}
myFunction($myNum);

echo $myNum;

# coditionals
/*  
	== - equal value
	=== - equal value and data type
	= - assignment operator
	.= - append value
	< - less than
	> - greater than
	<= - less than or equal to
	>= - greater than or equal to
	!= - not equal
	!== - not equal both value and data types
*/

# logical operator
// and &&, or || xor
// xor - one condition must be true but not both

// switch
// match cases
$favColor = 'red';

switch ($favColor) {
	case 'red':
		echo "color is red";
		break;
	case 'blue':
		echo "color is blue";
		break;
	default:
		echo "no color";
		break;
}

# dates and time
/* 
parameter: 
d - day
m - month
Y - year
l - day of the week
h - hour
i - minute
s - seconds
a - am/pm
*/
date($format);
echo date('Y/m/d');
echo date('h:i:sa');

// set Time Zone
date_default_timezone_set($timezone_identifier);
date_default_timezone_set('Asia/Manila');

// create time
$timestamp = mktime($h,$i,$s,$m,$d,$Y);

// convert timestamp into readable date
date('m/d/Y', $timestamp);

// string to time
$timestamp = strtotime('7:00pm March 22 2015');

// adding days/months/year
$date = strtotime('+2 Months');
$date = date('Y-m-d', strtotime("+5 days"));

// adding hour/min/s
$addh = strtotime('+1 hour');
$addm = strtotime('+10 minutes');
$adds = strtotime('+20 seconds');
$addhm = strtotime('+1 hour, +20 minutes');
$ctime = date('h:i:s', $addh);

// date and time format
$cdate      = date('m/d/Y');
$cmonth     = date('F');
$ctime      = date('h:i a');
$ctime		= date('h:i:s');
$cdatetime  = date('m/d/Y h:i a');

# include & require
// require - script will not continue if require file failed to load
include 'path/';
require 'path/'; 

// require_once - will only require a file once
require_once 'path/';

# superglobals
// are system variable, can access everywhere scope
// you can find more server & client data in php manual
$server = [
	'Host Server Name' => $_SERVER['SERVER_NAME'],
	'Document Root' => $_SERVER['DOCUMENT_ROOT'], // root of you document
	'Current Page' => $_SERVER['PHP_SELF'], 
	'Script Name' => $_SERVER['SCRIPT_NAME'],
	'Absolute Path' => $_SERVER['SCRIPT_FILENAME'] // complete absolute path of the page
];

echo $server['Host Server Name'];

# post & get method
// get method sending/fetching the data through the url
// post method sending the data through the http header
// post & get method will only work if a data has been submitted / set and not NULL

$_GET["key"];
$_POST["key"];

// checking data if submitted / set and not NULL
isset($var);

if (isset($_POST['submit'])) {}

// unset a variable and turn it into NULL, will return false
unset();

// return a string of data that has been submitted
$_SERVER['QUERY_STRING'];

# string
// returns a portion of a string
substr('string', $start, $length);
// start - index where to start
// length - length of the string
substr('Hello', 1);
// output: ello
substr('Hello', 1, 3);
// output: ell

// length of string
strlen('string');

// position of substring
strpos('haystack', 'needle');

// last occurance of substring
stristr($haystack, $needle);

// first occurance of the string
strrpos('haystack', 'needle');

// trim white spaces
trim('string');

// specifying character to be trim
// right trim
rtrim($string, $char);
rtrim('string/','/');

// string to uppercase / lowercase
strtoupper('string');
strtolower('string');

// replacing a string
// search = needle, replace = new string, subject = haystack
str_replace($search, $replace, $subject);

// repeat a string multiple times
str_repeat($input, $multiplier);
echo str_repeat('string', 10);

// check if string
is_string($string);

// capitalize every word in string
ucwords('string');

# filters & validation

// some list of filters
// validate if input is valid
#FILTER_VALIDATE_BOOLEAN
#FILTER_VALIDATE_EMAIL 
#FILTER_VALIDATE_FLOAT 
#FILTER_VALIDATE_INT 
#FILTER_VALIDATE_IP 
#FILTER_VALIDATE_REGEXP 
#FILTER_VALIDATE_URL 

// sanitize and remove illegal characters
#FILTER_SANITIZE_EMAIL
#FILTER_SANITIZE_NCODED 
#FILTER_SANITIZE_NUMBER_FLOAT 
#FILTER_SANITIZE_NUMBER_INT 
#FILTER_SANITIZE_SPECIAL_CHARS 
#FILTER_SANITIZE_STRING 
#FILTER_SANITIZE_URL 

// check if variable with specified type exists
// syntax: filter_has_var(type, variable_name);
// can also be use to check if data has been submitted and not null
// INPUT_POST, INPUT_GET, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV
filter_has_var(INPUT_POST, 'field_name');

// filters an input
// syntax: filter_input(type, variable_name/field_name, filter);
filter_input(INPUT_POST, 'field_name', FILTER_VALIDATE_EMAIL);

// filter variable
// syntax: filter_var(variable, filter);
$email = $_POST['data'];
filter_var($email, FILTER_SANITIZE_EMAIL);

// filter input array
// filter arrays of inputs
// you can refer to php manual for filter, flags, options
// syntax: filter_input_array(type, variable);
$filters = [
	'email' => FILTER_VALIDATE_EMAIL,
	'number' => [
		'filter' => FILTER_VALIDATE_INT,
		'options' => [
			'min_range' => 1,
			'max_range' => 100
		]
	]
];

filter_input_array(INPUT_POST, $filters);

// filter var array
// apply filters to variables
$array = [
	'name' => 'john cena',
	'age' => 45,
	'email' => 'johncena@email.com'
];

// FILTER_CALLBACK - Call function to filter data.
$filters = [
	'name' => [
		'filter' => FILTER_CALLBACK,
		'options' => 'ucwords'
	],
	'age' => [
		'filter' => FILTER_VALIDATE_INT,
		'options' => [
			'min_range' => 1,
			'max_range' => 120
		]
	],
	'email' => FILTER_VALIDATE_EMAIL
];

filter_var_array($array, $filters);

# validation snippet
// check for valid email
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	$errors[] = 'You must enter a valid email.';
}


// check for valid mobile number
if(preg_match("/^[0-9]{11}$/", $tel) == true || preg_match("/^\+[0-9]{12}$/", $tel) == true) {

} else {
	$errors[] = 'Please enter a valid mobile number.';
}

// check for valid telephone number
if(preg_match("/^[0-9]{3}-[0-9]{4}$/", $mob) == false) {
	$errors[] = 'Please enter a valid telephone number.';
}

// check for valid characters
if (ctype_alpha(str_replace(' ', '', $fname)) === false) {
	$errors[] = 'Name must contain letters and spaces only';
}

// check for valid denomination
if (strlen(preg_replace('/[^\d]/', '', $bill)) > 5) {
	$errors[] = 'Please enter a valid denomination.';
}

// check for special characters
if (preg_match('/[^a-zA-Z0-9,._ -]/', $title) || preg_match('/[^a-zA-Z0-9,._ -]/', $description)) {
    $errors[] = 'Fields with special characters are not allowed.';
}

// check for numeric input
if (!is_numeric($_POST['bill'])) {
	$errors[] = 'You must enter a valid cash';
} 

// validation for empty array field
$required = array('code','discount_type');

foreach($required as $field) {
    if ($_POST[$field] == '') {
        $empty = true;
        break;
    }
} 

# session
// variable that can be access across the page
// stored on the server
// start a session in every page that you want to use the data
session_start();   

// storing data to session 
$_SESSION['sessionName'] = $_POST['data'];

// calling session
$var = $_SESSION['sessionName'];
echo $var;

// unset individual session
unset($_SESSION['sessionName']);

// checking the session if set
isset($_SESSION['sessionName']);

// destroy sessions
session_destroy();

# cookies
// data stored on the client machine
// setting a cookie
// syntax: setcookie('key','value',expiration,'path','domain',httpsecure,httponly);
// note: you shouldn't store sensitive data into the cookie
setcookie('cookieName', $value, time()+3600);
// time()+3600 = 1 hour

// calling the cookie
$_COOKIE['cookieName'];

// unsetting cookie by giving it an expired time
setcookie('cookieName', $value, time()-3600);
// itme()+3600 = 1 hour ago

// checking if there are cookies set
count($_COOKIE);

// storing multiple data in a cookie
$user = [
	'id' => 102,
	'name' => 'John',
	'email' => 'john@email.com'
];

// using serialize by preparing the data to be store
$user = serialize($user);
setcookie('user', $user, time() + (86400 * 30));
// time() + (86400 * 30) = 1 month
//86400 s in 1 day multiplied by 30 equals 30 days

// unserialize to extract data 
$user = unserialize($_COOKIE['user']);

echo $user['name'];

# file system function
// return filename
$path = '/dir1/myfile.php';
basename($path);

// return filename without extension
basename($path, '.php');

// return directory name from path
dirname($path);

// file exists, will check even in folder
file_exists($filename);

// get absolute path
realpath($filename);

// if writable / readalble
is_writable($filename);
is_readable($filename);

// get file size
filesize($filename);

// create / delete (if empty) a directory/folder
mkdir($name);
rmdir($dirname);

// copy file
copy($source, $dest);

// rename file
rename($oldname, $newname);

// delete file
unlink($filename);

// get file content to string
file_get_contents($filename);

// write / replace string to the file 
file_put_contents($filename, $data);

// open file for reading
$handle = fopen($filename, $mode);
fread($handle, $length);
// always close file after reading / writing
fclose($handle);

// open file for writing
fwrite($handle, 'string');

// check if method exists in a certain class
method_exists($object, $method_name);

# mysqli
// procedural
// create connection to database
$conn = mysqli_connect('host','username','password','database');

// check for connection error
if(mysqli_connect_errno()) {
	// output error:
	echo mysqli_connect_errno();
}

// you can also check for specific error using
mysqli_error($conn);

// fetching data
// create query
$query = 'SELECT * FROM posts';

// get result
$result = mysqli_query($conn, $query);

// data into array
// mysqli_fetch_all(data, array type);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result/ freeze from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn);

// output data
var_dump($posts);

// turn one row of data into associative array
$query = "SELECT * FROM posts WHERE id=1";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

// escaping any unnecessary characters
// syntax: mysqli_real_escape_string(conn, var);
$id = mysqli_real_escape_string($conn, $_GET['id']);

# oop object oriented programming
// advantages: create a modulus structure and easy to maintain codes
// creating class 
// attributes in form of variables
// methods are functions inside class
// public, private - access modifier
// public - variable can access everywhere
// private - can access only inside the class
// protected - can access only inside the class and other extension (class inherited from another class)
class Person {
	// declare variable here same as name of the property key specify its access modifier/visibility
	public $name;
	public $email;
}

// creating new instance of the class, class into object
$person = new Person;

// accessing property
$person->name = 'John';
echo $person->name;

// good practice:
// naming file convention: Person.php
// making class private and creating function to access properties
class Person {
	private $name;
	private $email;
}

// creating methods 
// setters, getters,
class Person {
	private $name;
	private $email;

	public function setName($param_name) {
		// assigning property value to a key
		// syntax: this keyword, key, value
		// this - keyword for referencing from the current class
		$this->name = $param_name;
	}

	public function getName() {
		return $this->name;
	}
}

$person = new Person;
$person->setName('John');

echo $person->getName();

// defining property keys & value with constructor
// constructor - runs at the beginning when an object is instanciated
// destructor - runs at the end when an object is instanciated
class Person {
	private $name;
	private $email;

	// creating a constructor
	// runs when you instanciate a class
	// passing parameters to the constructor to define it's property
	public function __construct($param_name, $param_email) {
		$this->name = $param_name;
		$this->email = $param_email;
	}

	public function getName() {
		return $this->name;
	}
}

// passing values to the constructor
$person = new Person('John','email@email.com');

echo $person->getName();

// inheritance
// inherit properties and methods from other class
// extends
class Customer extends Person {
	private $balance;

	// extending class parameters
	public function __construct($param_name, $param_email, $param_balance) {
		// getting the method of the parent class
		// calling the parent constructor
		parent::__construct($param_name, $param_email);
		$this->balance = $param_balance;
	}

	public function getBalance() {
		return $this->balance;
	}
}

$customer = new Customer('John','email.com',300);

echo $customer->getBalance();

// traits
// traits is a class that can be use by a class extended by another class
// traits can only be instanciated by the class that use it
// code in file: laser.php
trait Laser {}

// code in index.php
// class extends another class and use another class methods
class Galaxy extends Mobile {
	// multiple traits: use Traits,Traits,Traits;
	use Laser;
}

// traits method with same name collision
// supposed we have 2 traits with same method named power();
class Galaxy extends Mobile {
	use Laser, Projector {
		// using the method of the traits instead of the other traits method with same name
		Laser::power insteadof Projector;
		// giving alias to the method of the traits to avoid same name collision
		Projector::power as pPower;
	}
}

// static properties / methods
// means you don't have to instanciate the class to use the property or method
// you can use static specially for constant values that do not change
class Person {
	private $name;
	private $email;
	public static $age = 40;

}

// calling the property
echo Person::$age;

// creating static method
class Person {
	private static $name;
	
	public static function setName($param_name){
   		self::$name = $param_name;
	}

	public static function getName() {
		// access static property
		return self::$name;
	}
}
// assigning value
Person::setName('Peter');

// calling the property
echo Person::getName();

// constant 
// constant are variable with value that do not change
class Shape {
	const PI = 3.1416;

	public function getArea($r) {
		return ($r * 2) * self::PI;
	}
}
// invoking constant
$shape = new Shape();
echo $shape::PI;

// final class / method
// final class cannot be inherited and final method cannot be overridden
final class Person {
	final public function getName() {}
}

// abstract
// declaring abstract class and methods
// when you declare abstract class, you can only instanciate it as an extension (child)
abstract class Person {
	protected $name;
	protected $email;

	public function __construct($param_name, $param_email) {
		$this->name = $param_name;
		$this->email = $param_email;
	}
	// abstract method can only be in an abstract class
	// the body of the method of an abstract class can only have its body in its extension (child)
	abstract public function getName();
}

class Customer extends Person {
	public function __construct($param_name, $param_email) {
		parent::__construct($param_name, $param_email);
	}
	// method inherited from the parent class containing the body
	public function getName() {
		return $this->name;
	}
}

$customer = new Customer('John','john@email.com');

// dependency injection
// class dependent to another class
// class can use the methods/propeties of another class
// passing object as a parameter
class Database {
	public function query($sql) {
		echo $sql;
	}
}

class User {
	protected $db;
	// injecting a class as a parameter to the other class so you can access its properties & methods
	// specifiying the name of the class as a type hint to accept only that class as an argument
	public function __construct (Database $db) {
		$this->db = $db;
	}

	// type hint - declare a type for a certain parameter
	public function create(array $data) {
		// then you can use the method of the other class to manipulate the argument
		$this->db->query('INSERT INTO `users` ...');
	}
}

$user = new User(new Database);
$user->create(['username' => 'Terry']);

// instanciating a class with the use of static method
class Database {
	protected static $instance;

	public function query($sql) {
		echo $sql;
	}

	public static function getInstance() {
		// Create the instance if it does not exist.
		if (!static::$instance) {
			// instanciating the class itself using the late static binding keyword
			static::$instance = new self;
		}
		return static::$instance;
	}
}

class User {
	public function create(array $data) {
		// instanciating the object in another class created by the static method  to access its properties / methods
		$db = Database::getInstance();
		$db->query('INSERT INTO `users` ...');
	}
}

$user = new User();
$user->create(['username' => 'Terry']);

// interfaces
// An INTERFACE is provided so you can describe a set of functions and then "implement" it to a class 
// naming file convention: IDatabase.php, iDatabase.php, DatabaseInterface.php
interface IDatabase {
	public function listOrders();
	public function addOrder();
	public function removeOrder();
}

// implements
// implementing an interface
// Then let's say we start out using a MySQL database. So we write a class to access the MySQL database:
class MySqlDatabase implements IDatabase {
	public function listOrders() {}
	public function addOrder() {}
	public function removeOrder() {}
}

// Then you can write your controller to use the interface as such:
$database = new MySqlDatabase();
foreach ($database->listOrders() as $order) {

}

// another class using the same interface
class OracleDatabase implements IDatabase {
	public function listOrders() {}
	public function addOrder() {}
	public function removeOrder() {}
}

// to switch to different class we only have to change ONE LINE of code:
$database = new OracleDatabase();
// code structure / methods on the class remain unchanged
foreach ($database->listOrders() as $order) {

}  

// you can use multiple interfaces separated by a comma (,)
// php oop comes with pre define interfaces to use its "signature" methods
class Collection implements Countable, JsonSerializable {
	protected $items = [];

	public function add($ite) {
		$this->items[] = $ite;
	}
	// jsonSerialize() is a "signature" of JsonSerializable interface
	public function jsonSerialize() { 
		return json_encode($this->items);
	}

	public function count() {
		return count($this->items);
	}
}

$items = new Collection();

$items->add('foo');
$items->add('bar');

// interface another example
interface iOperator {
	public function run($number, $result);
}

class Adder implements iOperator {
	// meaning that this class should implement a method - run(), because it implements the iOperator interface
	public function run($number, $result) {
		return $result + $number;
	}
}

class Calculator {
	protected $result;
	protected $operation;
	// type hinting the interface, argument that implements the interface is the only valid argument 
	public function setOperation(iOperator $operation) {
		$this->operation = $operation;
	}
}

$calculator = new Calculator();
$calculator->setOperation(new Adder);

// outputting the count of items inside the object
echo count($items);

// magic methods
// getting the name of the class
__CLASS__
// __set / __get magic methods recognize the methods to do without even calling to the actual function
public function __set($key, $value){
	$this->set($key, $value);
}

// method chaining
class Order {
	protected $dinner = 20;
	protected $drinks = 5;
	public $total;

	public function dinner($pax) {
		$this->total += $this->dinner * $pax;
		// will return this class for the method to be accessible
		return $this;
	}

	public function drinks($pax) {
		$this->total += $this->drinks * $pax;
		return $this;
	}
}

$order = new Order();
// invoking the returned class and accessing its method
$total = $order->dinner(2)->drinks(3)->total;

// namespace
// names space are virtual directory use to avoid name clashing / conflicts
// -----------------------------------
// declaring namespace in file x.php:
namespace myNamespace;

class Person {}

// using namespace to locate a class virtual directory
// locate class in its namespace
// code in file y.php
$person = new myNamespace\Person();
// -----------------------------------

// -----------------------------------
// accessing direct namespace
// example code in file: Person.php
namespace myNamespace;

class Person {}

// code in file: index.php
namespace myNamespace;

// here the object is an instance of the class from Person.php
$person = new Person();
// -----------------------------------

// classes without the specified namespaces are in the root namespace
// use this if there is a namespace declared at the top of the file
$date = new \DateTime();

// -----------------------------------
// import class into the current namespace
// code in file x.php
namespace app\models;

class Product {}

// code in file y.php
// import using use
use app\models\Product;

$product = new Product();
// -----------------------------------

// -----------------------------------
// or use with alias
use app\models\Product as CoreProduct;

$product = new CoreProduct();
// -----------------------------------

# PDO Php Data Object
// much secure way of connecting to database
// syntax works with multiple type of databases
/* PDO main classes:
	PDO - Represent a connection between php & database
	PDOStatement - Represents a prepared statement and after executed an associated result
	PDOException - Represents errors raised by pdo
*/
// database config
$host = 'hostname';
$user = 'username';
$password = 'password';
$dbname = 'databaseName';

// setting DSN - data source name
// string that has the associated data structure to describe a connection to data source
// this is where we declaring the database type you want to use
$dsn = 'mysql:host='.$host.';dbname='.$dbname;

// creating PDO instance
$pdo = new PDO($dsn, $user, $password);

// setting default attribute for fetch mode
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// turning off the emulation of default pdo substitute data in placeholder parameters
// this helps when using other operator with value in sql statements e.g. LIMIT operator
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// checking pdo available drivers
$drivers = PDO::getAvailableDrivers();

// error handling
// ERRMODE_EXCEPTION - Allows to handle errors
try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	// error message here
	// outputting the error
	echo $e->getMessage();
	// kiling the script
	die();
}

// prepared statements 
// prepare and execute
// prepared statement - sql statement are separated from the users data
// 2 ways to create prepared statement - positional & named parameters
// positional params: uses a ? as a placehoder for variable data
$author = 'John';

$sql = 'SELECT * FROM posts WHERE author = ?';

$stmt = $pdo->prepare($sql);
// execute the prepared query and binding it with array of data variables
// in positional params, data is order sensitive
$stmt->execute([$author]);

// fetching the result of the query
// syntax: fetch(fetch options);
// fetching data as an array
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo $row['key'];
}

// fetching data as an object
while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	echo $row->key;
}

// fetching ALL data into multi dimensional array
// this is can be useful without using loop
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// using foreach to access each array of rows in the table
foreach($posts as $post) {
	echo $post['title'];
}

// named params:
$author = 'John';
$is_published = true;

// named params: uses a :name as a placehoder for variable data
$sql = 'SELECT * FROM posts WHERE author = :author && is_published = :is_published';
$stmt = $pdo->prepare($sql);
// execute the prepared query with associative array of data variables
// in named params data is not order sensitive
$stmt->execute(['author' => $author, 'is_published' => $is_published]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($posts as $post) {
	echo $post['title'];
}

// binding value into the parameter / placeholder before execute
$params = ['author' => $author, 'is_published' => $is_published];
foreach ($params as $key => $value) {
	// bind the value into the parameter / placeholder
	$stmt->bindValue($key, $value);
}

// row count
$postCount = $stmt->rowCount();
echo $postCount;

// last inserted id
$pdo->lastInsertId();

# pdo crud
// get data
$sql = 'SELECT * FROM posts WHERE author = :author && is_published = :is_published';
$stmt = $pdo->prepare($sql);
$stmt->execute(['author' => $author, 'is_published' => $is_published]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($posts as $post) {
	echo $post['title'];
}

// inserting data 
$sql = 'INSERT INTO posts (title, body, author) VALUES (:title, :body, :author)';
$stmt = $pdo->prepare($sql);
$stmt->execute(['title' => $title, 'body' => $body, 'author' => $author]);
echo "data inserted!";

// update data
$sql = 'UPDATE posts SET title = :title, body = :body, author = :author WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['title' => $title, 'body' => $body, 'author' => $author, 'id' => $id]);
echo "data updated!";

// delete data
$sql = 'DELETE FROM posts WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
echo "data deleted!";


// search data
// LIKE operator
// needle is wrapped with "%needle%"
$search = "%post%";
$sql = 'SELECT * FROM posts WHERE title LIKE :search';
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => $search]);

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo $result['title'];
}

// fetching data into a class
class Posts {
	// property variables should be same as the fieldnames on the database
	public $title, $body, $author, $entry;

	// the class will be instanciated as the fetch runs
	public function __construct () {
		$this->entry = 'Post Title is: '.$this->title.' Post: '.$this->body;
	}
}

// useful to separate logic into output
// setting the fetch mode and name of the class 
// the fetch result will be merge as the properties of the defined class
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Posts');

while ($result = $stmt->fetch()) {
	echo $result->entry .'<br>';
}

# stored procedures
// phpmyadmin > select a database > routines > add routines 
// routine name > parameters (optional) > SQL data access (CONTAINS SQL) > write the query on Definition field
// calling the procedure:
$sql = "CALL `getUsers`();";

$stmt = $pdo->prepare($sql);

$stmt->execute(['fname' => $fname]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// passing parameter into the procedure
$sql = "CALL `getUsers`(:uid);";

# other useful functions
// output buffering / flushing content
// This function will turn output buffering on. 
// While output buffering is active no output is sent from the 
// script (other than headers), instead the output is stored in an internal buffer.
ob_start();
// get the content of output buffer
ob_get_contents();
// flush the content
ob_end_flush();

// json_encode will encode an associative array into json string
// JSON_FORCE_OBJECT - will encode the non-associative array into object
$json = json_encode($array, JSON_FORCE_OBJECT);

// json_decode will decode the json string into associative array
// the true value parameter will force json to decode it into associative array rather than any sort of objects
$array = json_decode($json, true);

// explode / implode
// explode string into array
// delimiter = string separator
explode($delimiter, string);
// implode array into string
// glue - the boundaries of string
// pieces - the array of string
implode($glue, $pieces);

// explode string separated by new line (enter)
$string = 'DEC.21 BOOSTER 20
DEC.22 ITEM2 45
DEC.23 ITEM3 50';

$msg = preg_split("/\\r\\n|\\r|\\n/", $string);

// convert variable into float / int
$var = (int)$var;
$var = (float)$var;

// return an item of argument pass in the function
func_get_arg();

// return an array of arguments pass in the function
func_get_args();

// autoloading
// autoload will load automatically and run when a class is instanciated
spl_autoload_register();
// here the autoloader will load the file named same as the class name
spl_autoload_register(function($class) {
	require_once "path/{$class}.php";
});

# ternary operators & shorthand syntaxes
(condition) ? 'ifTrue' : 'ifFalse';

# embedding to html
/* 
<?php if() : ?>
<?php endif; ?> 

<?php foreach() : ?>
<?php endforeach; ?>
*/

if ($condition) :
	// some code here
else :
	// some code here
endif;

// shorthand for echo
/*
<?= ... ?>
*/

// useful debugging fuction is exit() / die()
// stops the execution of script and output a message
die($query);
exit($query);

// call a function and pass a parameter to the callback function
call_user_func_array($function, $param_arr);

# security
// csrf cross-site request forgery
// a request from another site that has a function to manipulate the target website.
// checking for the valid method used
if ($_SERVER['REQUEST_METHOD'] === 'POST') {} 

// creating a token that is only available to the current user
// token generate very submission and the posted token should match the current token value.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['token']) || ($_POST['token'] !== $_SESSION['token'])) {
		die('unmatched token');
	}
}

// directory listing
// prevent other user to view site file directory 
// code in .htaccess
Options -Indexes

// error reporting
// use error logging when in production (live) website
// in php.ini configuration make sure display errror is off
display_errors = off;
// or use this line of code on your config file:
ini_set('display_errors', 'off');
// or this:
error_reporting(0);

// httponly cookies
// turn on httponly secure to limit the access in data stored in cookies
// syntax: setcookie('key','value',expiration,'path','domain',httpsecure,httponly);
// note: you shouldn't store sensitive data into the cookie
$date = new DateTime('+1 week');
setcookie('key', 'value', $date->getTimestamp(), '/', null, null, true);

// password hashing
// using the password hashing api
// syntax: password_hash('password', constant, options);
// hashing the use password:
password_hash('password123', PASSWORD_DEFAULT, ['cost' => 10]);
// checking the password:
// syntax: password_verify($password, $hash);
// will return false if failed, true if successfully matched
password_verify($password, $hash);

// sql injection
// injecting an attack from a users form
// sample attack code: '; DROP TABLE tableName; --
// using pdo prepared statement can prevent this kind of attack

// escaping any unnecessary characters can also help
// syntax: mysqli_real_escape_string(conn, var);
$id = mysqli_real_escape_string($conn, $_GET['id']);

// xss
// cross site scripting
// execution of malicious script to a website to get data
// it is also a good practice to sanitize output data from external source
// sanitizing input
htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

// spams
// protecting form form automated spams
// hide an input, thus when filled in by bots, kill the page
if (isset($_POST['input']) && !empty($_POST['input'])) {
	die();
}

// get days difference between two dates
$delivery_date = get_field('delivery_date', $order->ID);
// convert it into a timestamp.
$delivery_date = strtotime($delivery_date);
// get the current timestamp.
$now = time();
// calculate the difference.
$difference = $now - $delivery_date;
// convert seconds into days.
$days = floor($difference / (60*60*24) );
// output days
echo $days;

// generate random string
function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

// convert given number of minutes to hours and mins
$time = $rtrip[0]['dpt_time'];
$ctime = date('h:i:sa');
$total_time = strtotime($ctime) - strtotime($time);
$total_time = $total_time / 60;
$total_time = convertToHoursMins($total_time, '%02d h %02d min');

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

// put this on .htaccess live server to display error
php_value display_errors 1

// rounding value
round($var, 1);































?>
