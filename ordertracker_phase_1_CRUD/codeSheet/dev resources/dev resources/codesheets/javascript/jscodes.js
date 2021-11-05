// - single line comment
/* this is a multi-line comment */
// javascript is case sensitive but not sensitive on whitespace or linebreaks
// js scripts runs from top to bottom
alert("Hello World!");

// variables
// declaring a variable
var myVariable;
// defining variable by giving them value
myVariable = 10;
myVariable = "Hello";
/* js works in dynamic datatypes meaning type of variables may change
unlike in other pl that you need to specify its type */

//declaring multiple variables
var myObj, i, x = "";

// common operators
// = - assignment operator, + - * /
// note: = is an assignment operator while == is a comparison operator
// assigning 5 as the value of myVar 
var myVar = 5;
// changing the value of myVar, now its value is 15
myVar = myVar + 10;

// concatenate using + operator
myVar = 5 + "hello!"; // result: "5hello!"

// shorthand notation for operator
myVar += 5; // taking the value of myVar and adding 5 to it, same as myVar = myVar + 5;
myVar++; // print out the value of a variable and add 1 to it
++myVar; // add 1 to a variable before it prints out the value of the variable

// printing out the value on the document
var myVar = "Oh Yeah!";
document.write(myVar); // result: "Oh Yeah!"
// printing out the value on the console
var myVar = "Oh Yeah!";
console.log(myVar); // result: "Oh Yeah!"

// boolean
// value that represents true or false
var myVar = true; // value of myVar is true
// note that boolean value are not string
7 = 7; // will give you an error because 7 is already 7 and you cannot use an assignment operator to this
7 == 7; // means 7 is equal to 7, value is true
7 == 5; // value is false

// evaluating value if it is true or false using Boolean function
Boolean();
Boolean(5 > 7); // value is false
Boolean(5); // value is true, because its a number
Boolean(0); // value is false, because the value of 0 is always false
Boolean("hello"); // value is true, because it has a value of string on it
Boolean(""); // value is false, because the string is empty

// control flow
// if statement
var youLikeMeat = true;
if (youLikeMeat) {
	// if the expression/condition is true the code will executed else it proceed to the next condition/else statement
	document.write("Here is the meaty menu");
}

// comparison operator
/*
> - greater than
< - less than
== - equal to, compare the value if they are equal
=== - triple equal, compare both value and datatype (e.g. string, integer) if they are equal
!= - not equal, negation operator
!== - not equal, both value and datatype
*/

// logical operator
/*
&& - and operator, both expression/condition should be true
|| - or operator, one condition should be true
*/

// loops
// while loop
// while the condition is true it will loop and execute the code
var i = 5;
var sum = 0;
while (i <= 10) {
	document.write(i + "</br>");
	sum = i + sum; // take the value of sum and add the value of i
	i++; // add 1 to the variable each loop
	document.write(sum + "</br>");
}

// when the condition is false it will break out of the loop and execute the next line of statement
document.write(sum);

// for loop
// components: initialization, condition, iteration
for (i = 5; i <= 10; i++) {
	document.write(i);
}

// break and continue
for (i = 1; i <= 10; i++) {
	document.write(i);
	if (i === 7) {
		break; // break - broke out of the loop at a certain point
	}
}
for (i = 1; i <= 10; i++) {
	if (i === 5 || i === 3) {
		continue; // continue - broke out of the loop and continue to the next iteration
	}
	document.write(i);
}

// for in loop
// loops through the properties of an object
var myObj, i, x = "";

myObj = {
    "name":"John",
    "age":30,
    "cars":[ "Ford", "BMW", "Fiat" ]
};

for (i in myObj.cars) {
    x += myObj.cars[i];
}

// forEach
// the forEach() method calls a provided function once for each element in an array, in order
// syntax: array.forEach(function(currentValue, index, arr), thisValue)
var button = document.getElementsByTagName("button");
var element = document.getElementById("demo");
var numbers = [4, 9, 16, 25];

function myFunction(item, index) {
    element.innerHTML = element.innerHTML + "index[" + index + "]: " + item + "<br>"; 
}

button.onclick = function function_name() {
	numbers.forEach(myFunction);
}

// loops practical example
// javascript is zero (0) base, arrays and index always start at 0
var links = document.getElementsByTagName("a");
for (i = 0; i <= links.length; i++) {
	document.write("link #" + i);
}
// appending classname to an element
var links = document.getElementsByTagName("a");
for (i = 0; i < links.length; i++) {
	links[i].className = "link-" + i;
}

// function
// components: keyword (function), name of function, parameters/argument, code to execute
function getAverage(a,b) {
	var average = (a + b)/2;
	document.write(average);
	return average; // return a value
}
getAverage(7,12); // call the function, and pass the value to the function's parameters respectively
var result = getAverage(7,12); // assigning the returned value of a function to a variable
document.write(result);

// variable scope
// determine the scope of variable where a certain code can use it
var myVar = 5; // global - variable at the top level of the js file
function myFunction(parameter) {
	var myVar = parameter; // local - variable define inside of a function, can only be use inside the function
}

// working with numbers
var a = 5; // number
var b = "5"; // string
console.log(typeof(a + b)); // getting the type of a value
console.log(Math.round(7.8));
// rounding a number using Math object
console.log(Math.max(7,4,9,8));
// show the highest number

// NaN - (Not a Number)
// isNaN - function to check if a value is not a number
var a = "apple";
var b = 5;
if (isNaN(a)) {
	console.log("that is not a number");
} else {
	console.log("that is a number");
}

// strings
// quotation inside a string and escaping a string
var myString = 'I\'m a "fun" string';
console.log(myString.length); // getting the length of a string
console.log(myString.toUpperCase()); // make uppercase strings
console.log(myString.indexOf("string")); // counting the place of the string
var string1 = "abc";
var string2 = "bcd";
console.log(string1 < string2);
// alphabet have higher value in order (e.g. a < b)
// small letter have higher value than capital

// slice and split a strings
var str = "hello, world!";
var str2 = str.slice(2,9);
// slice the string in this case from position 2 to 9 (positioning start from 0 index)
// result: "llo, wo"
var str3 = str.slice(2);
// result: "llo, world"
// split - splitting a string and put the parts into arrays
var tags = "meat,ham,salami,pork,beef,chicken"; // note: whitespaces affects the structure of arrays
var tagsArray = tags.split(","); // the parameter specify at what point to split the string (delimiter), in this case its comma "," 
// everytime the split function see the delimiter it will split the string
// result: Array [ "meat", "ham", "salami", "pork", "beef", "chicken" ]

// arrays
// arrays - is a single variable that can hold a multiple values or can be multiple variables
var myArray = []; // creating an empty array
// inserting value inside the array by specifying in which index to store the value
// you can store multiple values with different types in the array
myArray[0] = 25; // store the value of 25 in 0 index of the array
myArray[1] = 35;
myArray[2] = true;
myArray[3] = "hello";
myArray; // calling the array and all of its value
document.write(myArray);
// creating an array with its value
var myArray2 = [10,20,"hi",false];
myArray2.push("hello"); // push(), add an element in the end of the array list
myArray2.pop(); // pop(), remove the last element in the array and return its value
// creating a new instance of the array() object
var myArray3 = new Array(5); // using the array object you can specify the size of the array
// note: arrays also have properties and methods like objects
myArray3.length; // size of the array, result is: 5, .length is a property that's why it doesn't parenthesis on it

// syntax
var a = []; // creating empty array
var b = {}; // creating empty object

// objects
// 2 ways of creating objects
// using the Object object
var myCar = new Object();
// assigning properties to the object
myCar.driver = "Shaun Yao";
myCar.maxSpeed = 50;
// accessing value of properties
console.log(myCar.driver);
// or accessing this way:
console.log(myCar['driver']);
// adding method to the object
myCar.drive = function() {
	console.log("Now driving!");
};

// using shorthand notation for creating objects
var myCar2 = {
	"maxSpeed": 80,
	"driver": "David blane",
	drive: function() {
		console.log("Now driving!");
	}
};

// passing parameters to the object's method
var myCar3 = {
	"maxSpeed": 50,
	"driver": "Shaun Yao",
	drive: function(speed,time) {
		console.log("Your Speed is: " + (speed * time));
	}
};
myCar3.drive(50,3);

// this 
// this keyword refers to what object currently owns the space
var myCar = {
	"maxSpeed": 80,
	"driver": "David blane",
	drive: function(parameter) {
		console.log("Now driving!");
	},
	test: function() {
		console.log(this); // this will log the this (current object) into the console
	}
};

// constructor
// constructor is a function to create an object
// constructor starts with capital letter for conventions
// components: constructor name, parameters, property name, values
var Car = function(d,s) {
	this.driver = d;
	this.maxSpeed = s;
	this.drive = function(speed,time) {
		console.log("Your speed is: " + (speed * time));
	};
	this.logDriver = function() {
		console.log("The driver is: " + this.driver);
	};
}

// another syntax for creating constructor:
function Car(d,s) {
	this.driver = d;
	this.maxSpeed = s;
	this.drive = function(speed,time) {
		console.log("Your speed is: " + (speed * time));
	};
	this.logDriver = function() {
		console.log("The driver is: " + this.driver);
	};
}

// creating object from constructor
var myCar2 = new Car("David",50);
var myCar3 = new Car("John",80);

// putting objects inside array
var people = [];
function Person(name,age) {  // Function constructor
	this.name = name;          // do not forget 'this.'
	this.age = age;
}

function addPerson(name,age) {    
	var p = new Person(name,age); // here we create instance
	people.push(p);
}

addPerson("Petia",80);
addPerson("Vasia",20);
function totalAge() {
	var total = 0;      // do not name local variables same as function
	var i;             // use var for i variable, otherwise it would be global variable 
	for (i = 0; i < people.length; i++){
		total += people[i].age; 
	}
	return total;
}

var total = totalAge();
console.log(total);

// returning value of parameters using object
function sayHello(name) {

    retVal = "hello " + name;
    return {code: 1, message: retVal};
}

//And while calling
var returnVal= sayHello("John");
var code = returnVal.code;
var msg= returnVal.message;
console.log(code);
console.log(msg);

// Date 
// the Date object is use to create dynamic date
var myDate = new Date(); 
console.log(myDate); // show the current date and time by default
// syntax: Date(yr,mo(0-11,Jan-Dec),day(1-31),hr,min,s);
var myPastDate = new Date(1993,11,2,10,30,15);
// Date methods
myDate.getFullYear();
myDate.getMonth();
myDate.getDay(); // (0-6, Sun-Sat)
myDate.getDate();
myDate.getHours();
myDate.getTime(); // get the exact number of milliseconds since 1st Jan 1970, this is useful in comparing date

// dom
// document object model - application programming interface where you can manipulate the document elements
// model is the structure of the element
// node is everything that you can change in the document (e.g. elements, text, attributes)

// get an object properties / methods
console.dir(document);

// getting nodes(dom elements) and store it into a variable
var myContent = document.getElementsByClassName("content"); // this will return an array of elements
// getting element inside an element
var myH2 = myContent[1].getElementsByTagName("h2"); // in this case, getting the h2 element inside a div element which is one of the elements ([1]index) in the array
// the ^ above variable will also return an array of elements
// change the element inside the element
myH2[0].innerHTML = "Hey! Whatsapp!";
document.getElementById("title").innerHTML = "NEW TITLE!"; 
// getElementById, this will return only one element because id is unique only in one element

// methods and properties used to manipulate the dom
var myBody = document.getElementsByTagName("body");
myBody.innerHTML; // this will return all the elements inside the body tag
var title = document.getElementById("title");
title.textContent; // get the text (only the text not tags) of an element

// changing and getting an element's attribute value (using methods)
var link = document.getElementById("link");
link.getAttribute("href"); // getting the attribute value of an element by passing its attribute name, result: "#"
link.getAttribute("class"); // result: "class-link"
// changing attribute value (using methods)
link.setAttribute("class","new-class") // change the attribute value by passing its "attribute name" & "attribute value"
link.setAttribute("name","someName"); // you can also add new attribute in an element by passing its "attribute name" & "attribute value"

// changing and getting an element's attribute value (using properties)
link.className; // return the value of the class attribute
link.className = "new-class"; // change the value of the class attribute
link.href; // return the "full" value of the href attribute

// styles
// changing styles of an element
link.style; // return the inline style properties (css rules) of an element
link.setAttribute("style","position:relative;"); // adding style attribute & style property in an element
link.setAttribute("style","position:relative;");
link.style.left = "20px"; // changing the value of a specific property & adding a new property of an element
link.style.backgroundColor = "#fff"; // we use camelcase to add a hyphenated property to avoid getting error

// elements
// creating new element
var newLi = document.createElement("li");
var newA = document.createElement("a");
// placing the newly created element in the dom
var menu = document.getElementById("main-nav").getElementsByTagName("ul")[0]; // getting the first ul element ([0]index) in the array
menu.appendChild(newLi); // append/add a new element
newLi.appendChild(newA);
newA.innerHTML = "blog";
// placing the element before the list of element in the array
menu.insertBefore(newLi,menu.getElementsByTagName("li")[0]); // parameters: (new element, position before the target element in the array)

// adding element with event listeners
// listening to multiple buttons wrapped in div with id
// element references
var parent = document.getElementById('list');
var buttons = document.getElementById('buttons');

// single #buttons event delegate
buttons.addEventListener('click', function(event) {
  // event.target contains the element that was clicked
  // targeting the value of "data-myitem='string'" html attribute 
  var item = event.target.dataset.myitem;
  if (item === undefined) return false;
  var li = document.createElement('li');
  var textNode = document.createTextNode(item);
  parent.appendChild(li).appendChild(textNode);
});

// removing an element by array index
// option 1
var parent = document.getElementById("main-nav").getElementsByTagName("ul")[0]; // getting the parent element
var child = parent.getElementsByTagName("li")[0];
parent.removeChild(child); // remove one of the child of the parent element
var removed = parent.removeChild(child); // store the removed element into a variable, so you can restore it again

// removing first / last child of an element
parent.removeChild(parent.firstChild);
parent.removeChild(parent.lastChild);

// remove all element
// option1 
var parent = document.getElementById("foo");
parent.innerHTML = '';

// option2
// individually remove by while loop from first to last
var parent = document.getElementById("foo");
while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
}

// javascript events
// events, are action that will trigger/fire a certain function or code
// adding an event to an element
var link = document.getElementById("link");
// adding the event and assigning an anonymous function (function without a name)
link.onclick = function() {
	alert("Hooraayy!!");
};

// window onload event
// useful if you place a jsscript at the head section of the html
function setUpEvents() {
	// some code here
}
// fire a function after the window has fully loaded (and all elements has been loaded)
window.onload = function() {
	setUpEvents();
}

// javascript timers
function showMessage() {
	document.write("MESSAGE!");
}

// setTimeout()
// setTimeout(), calling a function with specific time conditions
// parameters: function name, duration(time(ms) for the function to fire)
setTimeout(showMessage,3000);
// setInterval()
var box = document.getElementById("box");
var colours = ["red","blue","yellow","pink","green"];
var i = 0;
function changeColor() {
	if (i < colours.length) {
		box.style.backgroundColor = colours[i];
		i++;
	} else {
		i = 0;
	}
}

// setInterval(), repeatedly calling a function with specific time conditions
setInterval(changeColor,3000);
// note: add parenthesis to the function (changeColor()), if you want to pass the return value of the function to the setInterval's parameter
// clearTimeout() & clearInterval(), use to stop a timer
var interval = setInterval(changeColor,3000); // store interval into a variable 
// stop the timer when clicked
box.onclick = function() {
	clearInterval(interval);
	box.innerHTML = "Timer Stopped!";
};

// getting form elements
document.forms.myForm;
var myForm = document.forms.myForm;
myForm.txtBox; // getting the input with a name="name"
myForm.txtBox.value; // getting the value of the input

// adding event
// onfocus, when an element is on focus
myForm.txtBox.onFocus = function() {
	myForm.txtBox.style.border = "4px solid pink";
};

// onblur, when an element is out of focus
myForm.txtBox.onBlur = function() {
	myForm.txtBox.style.border = "none";
};

// onSubmit event
// onSubmit, interrupts with server before the data is submitted
// useful for client side validations
var myForm = document.forms.myForm;
var message = document.getElementById("message");
myForm.onsubmit = function() {
	if (myForm.txtBox.value == "") {
		message.innerHTML = "Please enter a name.";
		return false; // throw in an error to prevent the form from being submitted to the server
	} else {
		message.innerHTML = "";
		return true;
	}
}