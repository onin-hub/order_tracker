// synchronous javascript
// js code runs on a single thread
// synchronous code waits for 1 action to complete before moving on to the next
// do not wait for some callback-function
// synchronous request waits for the response to return before executing the next instruction/code

// asynchronous
// asynchronous request set a request and while waiting for the response proceed to the next instruction/code
// a callback-function will fire when the asynchronous request has been returned and completed
// the asynchronous request will be pass to another thread outside js tread (cause js runs in a single thread) and proceed to the next instruction/code

// ways to control asynchronous requests:
// callbacks, promises, generators

// ajax request
// grabbing data from somewhere and bringing it back(by making ajax request), without loading the page
// communicate with a server by making http request

// using vanilla js to make a request
window.onload = function() {
	// making a new xml http request object
	var xhttp = new XMLHttpRequest(); // allow us to make http request and get back data from the server
	// making the request using methods from the object (in this case "http" object)
	// parameters: type of request, location of data(url), synch or asynch type(true = asynch, false = synch)
	xhttp.open("GET","data/tweets.json",true); // open(), method to setup the request
	xhttp.send(); // send(), send the request and grab the data back

	console.log(http); // log the data response from the server
};
// listening to the readyState of the request
// object (XMLHttpRequest) has different ready state value while processing
/* ready states and value:
	0 - request not initialized
	1 - request has been set up
	2 - request has been sent
	3 - request is in process (grabbing the data)
	4 - request is complete (data has been returned)
*/
window.onload = function() {
	var xhttp = new XMLHttpRequest();
	
	// listening to the state changes while being made
	// the function will fire everytime the readyState is changing
	xhttp.onreadystatechange = function() {
		console.log(http); // log the response everytime readyState changes
	}

	xhttp.open("GET","data/tweets.json",true);
	xhttp.send();
};

window.onload = function() {
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		// listening when the readyState value is 4 (meaning the data is retrieve and the request is completed)
		// and the status is 200 (meaning "OK", 404 is "not found")
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			console.log(JSON.parse(xhttp.response)); // getting the data and parsing it to a json object format (using JSON.parse())
		}
	}

	xhttp.open("GET","data/tweets.json",true); // you can change the boolean type by false to make the behavior synchronous (bad practice and deprecated)
	xhttp.send();
	// when using asychronous js behavior, 
	// the request will be sent outside js thread and will execute the next line of instruction while waiting for the server response
};

// using jquery method to make request
window.onload = function() {
	// $.get(), one method and does everything including initializing the request
	// parameters: url, callback-function
	// callback-function will fire after the data has been retrieved
	$.get("data/tweets.json",function(data) { // passing the retrieved data into the function parameter and then you can use it
		console.log(data);
	});
	console.log("test asynchronous"); // asynchronous test, this line of code should be executed without waiting for the request to be completed
};

// callback-function
// runs when the request has been completed
// synchronous way, the callback-function will be called synchronously
// it will call the function right away and then proceed to the next line of code/instruction
window.onload = function() {
	var fruits = ["banana","apple","pear"];
	// callback-function was pass to the parameter of the forEach() method
	// passing the values of items in the array 
	fruits.forEach(function(data) {
		console.log(data);
	});
};
// another way of calling callback-function is by giving it a name
window.onload = function() {
	var fruits = ["banana","apple","pear"];
	// callback-function was pass to the parameter of the forEach() method
	// passing the values of items in the array 
	function callBack(data) {
		console.log(data);
	}
	fruits.forEach(callBack);
};

// callback-function
// asynchronous way, start now and finish up later
window.onload = function() {
	/* the data request will be sent and proceed to the next line of code/instruction 
	and when it is completed the callback-function will fire and retrieve the data */
	$.get("data/tweets.json",function(data) {
		console.log(data);
	});
	console.log("test asynchronous"); // next line of code
};

// nested callbacks
// callback hell
window.onload = function() {
	// making request using the method .ajax()
	// passing object in the .ajax() method
	$.ajax({
		type: "GET", // type of request
		url: "data/tweets.json", // url, the location of the data
		success: function(data) { // code to execute when the request was success/completed and returned
			// in this case we pass a callback-function and retrieve the returned data to the console
			console.log(data);
			// after successfully got the request and completed we execute another ajax request()
			// callback after callback after callback
			$.ajax({
				type: "GET",
				url: "data/friends.json", 
				success: function(data) { 
					console.log(data);
					// after successfully got the request and completed we execute another ajax request()
					$.ajax({
						type: "GET",
						url: "data/videos.json",
						success: function(data) { 
							console.log(data);
						},
						error: function(jqXHR,textStatus,error) {
							console.log(error);
						}
					});
				},
				error: function(jqXHR,textStatus,error) { 
					console.log(error);
				}
			});
		},
		error: function(jqXHR,textStatus,error) { // code to execute when there is an error in the request
			// in this case we call a function with parameters: jqXHR Object, textStatus of the error, the error itself
			console.log(error); // not a proper way of handling error, but this is just an example
		}
	});
};

// proper way of structuring multiple/nested callbacks
window.onload = function() {
	// separating the error, by making function 
	function handleError(jqXHR,textStatus,error) {
		console.log(error);
	}
	// making the first ajax request
	$.ajax({
		type: "GET", 
		url: "data/tweets.json", 
		success: cbTweets, // calling the callback function on success
		error: handleError
	});
	// separating callback function, and sending another ajax request
	function cbTweets(data) {
		console.log(data);
		$.ajax({
			type: "GET",
			url: "data/friends.json", 
			success: cbVideos,
			error: handleError
		});
	}

	function cbVideos(data) { 
		console.log(data);
		$.ajax({
			type: "GET",
			url: "data/videos.json",
			success: function(data) { 
				console.log(data);
			},
			error: handleError // calling the error handler function
		});
	}
};

// javascript promises
// organize callbacks in a much easier to maintain
// promise, is an object that represent an action that hasn't finish yet but will do at some point down the line
// placeholder for somekind of asynchronous operation
// when a http request is sent a promise object will return before the requested data is retrieve and return
// within the promise you can register a callback that will run when the request is complete
// using native promise library (note: there more promises library such as "Q" which supports all browser)
// creating a simple promise:
window.onload = function() {
	// creating the function that will pass the url
	function get(url) {
		// return the promise object before the request has been completed
		return new Promise(function(resolve,reject) { // the function will pass the resolve and reject parameters and return the value
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET",url,true);
			// .onload(), no need to worry about the readyState change
			xhttp.onload = function() {
				if (xhttp.status == 200) {
					resolve(JSON.parse(xhttp.response));
				} else {
					reject(xhttp.statusText);
				}
			};
			xhttp.onerror = function() {
				reject(xhttp.statusText);
			};
			xhttp.send();
		});
	}

	// passing the url to the function
	// the promise is returned before the data is retrieved
	var promise = get("data/tweets.json");
	// registering callbacks on success or failure
	// .then(), when the data is returned the callback-function will fire
	promise.then(function(tweets) {
		console.log(tweets);
		// returning a new promise when the callback was fired
		return get("data/friends.json");
	}).then(function(friends) {
		console.log(friends);
		return get("data/videos.json");
	}).then(function(videos) {
		console.log(videos);
	}).catch(function(error) { // .catch(), handle the error, the callback-function will fire when there is an error
		console.log(error);
	});
};

// jquery promises
window.onload = function() {
	// the .get() will return the promise interface so you can use the .then() method
	$.get("data/tweets.json").then(function(tweets) {
		console.log(tweets);
		return $.get("data/friends.json");
	}).then(function(friends) {
		console.log(friends);
		return $.get("data/videos.json");
	}).then(function(videos) {
		console.log(videos);
	});
};

// javascript generators
window.onload = function() {
	// creating generator by putting * at the function
	function* gen() {
		var x = yield 10; // yield, pause the function process at the certain point
		console.log(x);
	}
	var myGen = gen(); // it doesn't fire the function it just prepares them, and will return an interval object
	console.log(myGen.next()); // .next(), use to start generating the code, will return an object with properties: value & done
	// (in this case it will read the first part of the code and return a value which is 10 and pause it when it reads the yield keyword)
	console.log(myGen.next(20)); // generate the next code and pass a value to the variable "x"
};

// javascript generators
window.onload = function() {
	function genWrap(generator) {
		var gen = generator(); // prepare the generator
		function handle(yielded) { // passing the yielded object(in this case the request promise) to the function from the generator 
			if (!yielded.done) { // when the done property is equal to false(not done yet)
				yielded.value.then(function(data) { // passing and retrieving the data from the promise
					return handle(gen.next(data)); // returning back the handle and passsing the data(retrieve from the promise) and assigning the value to the variable
				});
			}
		}
		return handle(gen.next()); // calling the handle() function and passing an argument (starting the generator with .next method)
	}
	// passing the generator as an argument to the genWrap() function
	genWrap(function*() {
		var tweets = yield $.get("data/tweets.json"); // the function handle() will continue to fire until the generator is done
		console.log(tweets);
		var friends = yield $.get("data/friends.json");
		console.log(friends);
		var videos = yield $.get("data/videos.json");
		console.log(videos);
	});
};


// the famous jquery ajax call
var data = {"id" : id};

$.ajax({
	url : '../wp-content/themes/jvr/program-modal.php',
	method : "post",
	data : data,
	success : function(data){
		alert(data);
	},
	error : function(){
		alert("Something went wrong!");
	}
});


// check if a new data is inserted into the database
setInterval(() => {
    count_data();
}, 1000);

var old_count = 0;

function count_data() {
    var type = "count_data";

    $.ajax({
        url: "routes/router.php",
        type: "POST",
        data: {type : type},

        success : function(response){
            if (response != old_count) {
                loadData();
                old_count = response;
            }
        }
    });
}

// sample ajax crud and file import
// import file into database
$("#btn-import-driver").click(function() {

    var file_data = $('#input-import-driver').prop('files')[0];   
    var form_data = new FormData();      

    form_data.append('file', file_data);

    // alert(form_data);          

    $.ajax({
        url: '../web/drivers/ajax/import_driver.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(response){

            var response = JSON.parse(response);

            if (response['type'] == 'success') {
                Swal.fire({
                    icon: 'success',
                    text: response['msg'],
                }).then(function(){
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
            }
        }
     });
});

// adding data to database
$(document).on('click','#btn-add-driver',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var dname = $('#input-driver-name').val();
    var dnum = $('#input-driver-number').val();
	var id = $('#input-driver-id').val();

    $.ajax({
        url: '../web/drivers/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'dname' : dname,
            'dnum' : dnum,
            'id' : id,
        },                         
        type: 'post',
        success: function(response){

            var response = JSON.parse(response);
            
            if (response['type'] == 'success') {
                Swal.fire({
                    icon: 'success',
                    text: response['msg'],
                }).then(function(){
                    window.location.reload();
                });
            } else {
                var errors = response['msg'].toString();

                Swal.fire({
                    icon: 'error',
                    text: errors,
                })
            }
        }
     });
   
    return false;
});

// transfer data from one input to another input
$(document).on('click','#btn-edit-driver',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var dname = $(this).parent().siblings('.dname').text();
    var dnum = $(this).parent().siblings('.dnum').text();

    $('#input-driver-id').val(id);
    $('#input-driver-name').val(dname);
    $('#input-driver-number').val(dnum);
    $('#btn-add-driver').attr('data-type', 'edit');
    $('.card-title-driver').text('Update Driver')

    return false;
});

// clear all fields
$(document).on('click','#btn-clear-driver',function(e) {
    e.preventDefault();

    $('#input-driver-name').val('');
    $('#input-driver-number').val('');
    $('#btn-add-driver').attr('data-type', 'add');
    $('.card-title-driver').text('Add New Driver')

    return false;
});

// delete data
$(document).on('click','#btn-del-driver',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var dname = $('#input-driver-name').val();
    var dnum = $('#input-driver-number').val();

    Swal.fire({

        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '../web/drivers/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'dname' : dname,
                    'dnum' : dnum,
                    'id' : id,
                },                         
                type: 'post',
                success: function(response){
        
                    var response = JSON.parse(response);
                    
                    if (response['type'] == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: response['msg'],
                        }).then(function(){
                            window.location.reload();
                        });
                    } else {
                        var errors = response['msg'].toString();
        
                        Swal.fire({
                            icon: 'error',
                            text: errors,
                        })
                    }
                }
            });
        }
    })

    return false;
});


$('#FormUser').submit(function(event) {
	event.preventDefault();

	var form = $(this);

	$.ajax({
		url: 'postAccount.php',
		type: 'post',
		contentType: 'application/x-www-form-urlencoded',
		datatype : 'json/html',
		data: form.serialize(),
		success: function(data, textStatus, jQxhr) {
			$('#Alert').show();
			console.log(data);
		},
		error: function(jqXhr, textStatus, errorThrown) {
			console.log(errorThrown);
		}
	});
});
