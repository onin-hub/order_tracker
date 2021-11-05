<?php 

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

?>