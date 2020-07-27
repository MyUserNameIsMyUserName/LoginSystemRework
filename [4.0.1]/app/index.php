<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="icon" href="data:,">
        <title>Rest API Authentication Example</title>
 
        <!-- Bootstrap 4 CSS and custom CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.0.3/dist/css/bootstrap-colorpicker.min.css" crossorigin="anonymous" />
		<link rel="stylesheet" type="text/css" href="custom.css" />
 
		<script>
			var frontConfig = {
				apiUrl : "http://192.168.1.50:8080/dev/LoginSystemRework/[4.0.1]/api/"
			}
		</script>
    </head>
<body>
 
<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="#" id='homepage'>Home</a>
            <a class="nav-item nav-link" href="#" id='aboutuspage'>About Us</a>
            <a class="nav-item nav-link" href="#" id='dashboard'>Dashboard</a>
            <a class="nav-item nav-link" href="#" id='update_account'>Account</a>
            <a class="nav-item nav-link" href="#" id='logout'>Logout</a>
            <a class="nav-item nav-link" href="#" id='login'>Login</a>
            <a class="nav-item nav-link" href="#" id='sign_up'>Sign Up</a>
        </div>
    </div>
</nav>
<!-- /navbar -->
 
<!-- container -->
<main role="main" class="starter-template">
	<!-- where prompt / messages will appear -->
	<div id="response"></div>

	<!-- where main content will appear -->
	<div id="content"></div>
</main>
<!-- /container -->
 
<!-- jQuery & Bootstrap 4 JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.0.3/dist/js/bootstrap-colorpicker.min.js"></script>
 
<script>
// jQuery codes
$(document).ready(function(){

	open_static_page('templates/static_pages/home_page/index.php');
	
	var jwtTest = getCookie('jwt');
	if (jwtTest != ""){
		showLoggedInMenu();
	}

    // show sign up / registration form
    $(document).on('click', '#sign_up', function(){
		show_register_form();
	});
 
    // trigger when registration form is submitted
	$(document).on('submit', '#sign_up_form', function(){
	 
	    // get form data
	    var sign_up_form=$(this);
	    var form_data=JSON.stringify(sign_up_form.serializeObject());
	 
	    // submit form data to api
	    $.ajax({
	        url:  frontConfig.apiUrl + "users/create_user.php",
	        type : "POST",
	        contentType : 'application/json',
	        data : form_data,
	        success : function(result) {
	            // if response is a success, tell the user it was a successful sign up & empty the input boxes
	            $('#response').html("<div class='alert alert-success'>Successful sign up. Please login.</div>");
	            sign_up_form.find('input').val('');
	        },
	        error: function(xhr, resp, text){
	            // on error, tell the user sign up failed
	            $('#response').html("<div class='alert alert-danger'>Unable to sign up. Please contact admin.</div>");
	        }
	    });
	 
	    return false;
	});
 
    // show login form
	$(document).on('click', '#login', function(){
	    showLoginPage();
	});
	 
	// trigger when login form is submitted
	$(document).on('submit', '#login_form', function(){
	 
	    // get form data
	    var login_form=$(this);
	    var form_data=JSON.stringify(login_form.serializeObject());
	 
	    // submit form data to api
		$.ajax({
		    url: frontConfig.apiUrl + "users/login.php",
		    type : "POST",
		    contentType : 'application/json',
		    data : form_data,
		    success : function(result){
		 
		        // store jwt to cookie
		        setCookie("jwt", result.jwt, 1);
		 
		        // show dashboard page & tell the user it was a successful login
		        showDashboardPage();
		        $('#response').html("<div class='alert alert-success'>Successful login.</div>");
				showLoggedInMenu();
		    },
		    error: function(xhr, resp, text){
			    // on error, tell the user login has failed & empty the input boxes
			    $('#response').html("<div class='alert alert-danger'>Login failed. Email or password is incorrect.</div>");
			    login_form.find('input').val('');
			}
		});
	 
	    return false;
	});
	 
	// show dashboard page
	$(document).on('click', '#dashboard', function(){
	    showDashboardPage();
	    clearResponse();
	});
	 
	// show dashboard page
	$(document).on('click', '#homepage', function(){
	    open_static_page('templates/static_pages/home_page/index.php');
	    clearResponse();
	});
	 
	// show dashboard page
	$(document).on('click', '#aboutuspage', function(){
	    open_static_page('templates/static_pages/about_us_page/index.php');
	    clearResponse();
	});
	 
	// show update account form
	$(document).on('click', '#update_account', function(){
	    showUpdateAccountForm();
	});
	 
	// trigger when 'update account' form is submitted
	$(document).on('submit', '#update_account_form', function(){
	 
	    // handle for update_account_form
	    var update_account_form=$(this);
	 
	    // validate jwt to verify access
	    var jwt = getCookie('jwt');
	 
	    // get form data
		var update_account_form_obj = update_account_form.serializeObject()
		 
		// add jwt on the object
		update_account_form_obj.jwt = jwt;
		 
		// convert object to json string
		var form_data=JSON.stringify(update_account_form_obj);
		 
		// submit form data to api
		$.ajax({
		    url:  frontConfig.apiUrl + "users/update_user.php",
		    type : "POST",
		    contentType : 'application/json',
		    data : form_data,
		    success : function(result) {
		 
		        // tell the user account was updated
		        $('#response').html("<div class='alert alert-success'>Account was updated.</div>");
		 
		        // store new jwt to coookie
		        setCookie("jwt", result.jwt, 1);
		    },
		 
		    // show error message to user
			error: function(xhr, resp, text){
			    if(xhr.responseJSON.message=="Unable to update user."){
			        $('#response').html("<div class='alert alert-danger'>Unable to update account.</div>");
			    }
			 
			    else if(xhr.responseJSON.message=="Access denied."){
			        showLoginPage();
			        $('#response').html("<div class='alert alert-success'>Access denied. Please login</div>");
			    }
			}
		});
	 
	    return false;
	});
	 
	// logout the user
	$(document).on('click', '#logout', function(){
	    showLoginPage();
	    $('#response').html("<div class='alert alert-info'>You are logged out.</div>");
	});

	// show login page
	function showLoginPage(){
	    // remove jwt
	    setCookie("jwt", "", 1);
		$("#content").load("templates/users/login.temp.html");
	    clearResponse();
	    showLoggedOutMenu();
	}
	 
	// function to set cookie
	function setCookie(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+ d.toUTCString();
	    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	 
	// if the user is logged out
	function showLoggedOutMenu(){
	    // show login and sign up from navbar & hide logout button
	    $("#login, #sign_up").show();
	    $("#logout").hide();
	}
	 
	// show dashboard page
	function showDashboardPage(){
	 
	    // validate jwt to verify access
	    var jwt = getCookie('jwt');
	    $.post( frontConfig.apiUrl + "users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
	 
	        // if valid, show dashboardpage
			var html = `
			    <div class="card">
			        <div class="card-header">Welcome to Dashboard!</div>
			        <div class="card-body">
			            <h5 class="card-title">You are logged in.</h5>
			            <p class="card-text">You won't be able to access the dashboard and account pages if you are not logged in.</p>
			        </div>
			    </div>
			    `;
			 
			$('#content').html(html);
			showLoggedInMenu();
	    })
	 
	    // show login page on error
		.fail(function(result){
		    showLoginPage();
		    $('#response').html("<div class='alert alert-danger'>Please login to access the dashboard page.</div>");
		});
	}
	 
	// if the user is logged in
	function showLoggedInMenu(){
	    // hide login and sign up from navbar & show logout button
	    $("#login, #sign_up").hide();
	    $("#logout").show();
	}
	 
	function showUpdateAccountFormOLD(){
	    // validate jwt to verify access
	    var jwt = getCookie('jwt');
	    $.post( frontConfig.apiUrl + "users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
		 
		        // if response is valid, put user details in the form
				var html = `
				        <h2>Update Account</h2>
				        <form id='update_account_form'>
				            <div class="form-group">
				                <label for="firstname">Firstname</label>
				                <input type="text" class="form-control" name="firstname" id="firstname" required value="` + result.data.firstname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="lastname">Lastname</label>
				                <input type="text" class="form-control" name="lastname" id="lastname" required value="` + result.data.lastname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="email">Email</label>
				                <input type="email" class="form-control" name="email" id="email" required value="` + result.data.email + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="password">Password</label>
				                <input type="password" class="form-control" name="password" id="password" />
				            </div>
				 
				            <button type='submit' class='btn btn-primary'>
				                Save Changes
				            </button>
				        </form>
				    `;
				 
				clearResponse();
				$('#content').html(html);
		    })
		 
		    // on error/fail, tell the user he needs to login to show the account page
			.fail(function(result){
			    showLoginPage();
			    $('#response').html("<div class='alert alert-danger'>Please login to access the account page.</div>");
			});
	}
	 
	function showUpdateAccountForm(){
	    // validate jwt to verify access
	    var jwt = getCookie('jwt');
	    $.post(frontConfig.apiUrl+"users/get_account_settings.php", JSON.stringify({ jwt:jwt })).done(function(result) {
		 
		        // if response is valid, put user details in the form
				var html = `
				        <h2>Update Account</h2>
				        <form id='update_account_form'>
				            <div class="form-group">
				                <label for="username">Username</label>
				                <input type="text" class="form-control" name="username" id="username" required value="` + result.data.username + `" />
				            </div>
				            <div class="form-group">
				                <label for="firstname">Firstname</label>
				                <input type="text" class="form-control" name="firstname" id="firstname" required value="` + result.data.firstname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="lastname">Lastname</label>
				                <input type="text" class="form-control" name="lastname" id="lastname" required value="` + result.data.lastname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="email">Email</label>
				                <input type="email" class="form-control" name="email" id="email" required value="` + result.data.email + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="password">Password</label>
				                <input type="password" class="form-control" name="password" id="password" />
				            </div>

							<div class="cp-container" id="cp2-container">
								<div class="input-group" title="Using input value">
									<input id="cp2" type="text" class="form-control" value="#ff9900" autocomplete="off"/>
									<div class="input-group-append">
										<button type="button" class="btn btn-primary colorpicker-input-addon"><i></i></button>
									</div>
								</div>
							</div>
				 
				            <button type='submit' class='btn btn-primary'>
				                Save Changes
				            </button>	
				        </form>
						<style>
							.cp-container {
								position: relative;
							}
							.cp-container .colorpicker-bs-popover {
								width: 100%;
								max-width: none;
							}
							.cp-container .colorpicker-bs-popover .colorpicker {
								width: 100%;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-bar {
								width: 100%;
								box-shadow: none;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation {
								height: 150px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation .colorpicker-guide {
								height: 10px;
								width: 10px;
								border-radius: 10px;
								margin: -5px 0 0 -5px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-bar {
								margin-top: 10px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								height: 30px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								background-size: 20px 20px;
								background-position: 0 0, 10px 10px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								font-size: 1rem;
								line-height: 1.75;
							}

							.cp-container {
								max-width: 350px;
								margin: 2rem auto;
							}
							</style>
				    `;
				 
				clearResponse();
				$('#content').html(html);
				init_colorpicker_fn( '#cp2', 'rgb' );
		    })
		 
		    // on error/fail, tell the user he needs to login to show the account page
			.fail(function(result){
			    showLoginPage();
			    $('#response').html("<div class='alert alert-danger'>Please login to access the account page.</div>");
			});
	}

 
	// function to make form values to json format
	$.fn.serializeObject = function(){
	 
	    var o = {};
	    var a = this.serializeArray();
	    $.each(a, function() {
	        if (o[this.name] !== undefined) 
	        {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    return o;
	};
});


	 
function showUpdateAccountForm(){
	    // validate jwt to verify access
	    var jwt = getCookie('jwt');
	    $.post(frontConfig.apiUrl+"users/get_account_settings.php", JSON.stringify({ jwt:jwt })).done(function(result) {
		 
		        // if response is valid, put user details in the form
				var html = `
				        <h2>Update Account</h2>
				        <form id='update_account_form'>
				            <div class="form-group">
				                <label for="username">Username</label>
				                <input type="text" class="form-control" name="username" id="username" required value="` + result.data.username + `" />
				            </div>
				            <div class="form-group">
				                <label for="firstname">Firstname</label>
				                <input type="text" class="form-control" name="firstname" id="firstname" required value="` + result.data.firstname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="lastname">Lastname</label>
				                <input type="text" class="form-control" name="lastname" id="lastname" required value="` + result.data.lastname + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="email">Email</label>
				                <input type="email" class="form-control" name="email" id="email" required value="` + result.data.email + `" />
				            </div>
				 
				            <div class="form-group">
				                <label for="password">Password</label>
				                <input type="password" class="form-control" name="password" id="password" />
				            </div>

							<div class="cp-container" id="cp2-container">
								<div class="input-group" title="Using input value">
									<input id="cp2" type="text" class="form-control" value="#ff9900" autocomplete="off"/>
									<div class="input-group-append">
										<button type="button" class="btn btn-primary colorpicker-input-addon"><i></i></button>
									</div>
								</div>
							</div>
				 
				            <button type='submit' class='btn btn-primary'>
				                Save Changes
				            </button>	
				        </form>
						<style>
							.cp-container {
								position: relative;
							}
							.cp-container .colorpicker-bs-popover {
								width: 100%;
								max-width: none;
							}
							.cp-container .colorpicker-bs-popover .colorpicker {
								width: 100%;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-bar {
								width: 100%;
								box-shadow: none;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation {
								height: 150px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-saturation .colorpicker-guide {
								height: 10px;
								width: 10px;
								border-radius: 10px;
								margin: -5px 0 0 -5px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-bar {
								margin-top: 10px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-hue,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								height: 30px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-alpha,
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								background-size: 20px 20px;
								background-position: 0 0, 10px 10px;
							}
							.cp-container .colorpicker-bs-popover .colorpicker .colorpicker-preview {
								font-size: 1rem;
								line-height: 1.75;
							}

							.cp-container {
								max-width: 350px;
								margin: 2rem auto;
							}
							</style>
				    `;
				 
				clearResponse();
				$('#content').html(html);
				init_colorpicker_fn( '#cp2', 'rgb' );
		    })
		 
		    // on error/fail, tell the user he needs to login to show the account page
			.fail(function(result){
			    showLoginPage();
			    $('#response').html("<div class='alert alert-danger'>Please login to access the account page.</div>");
			});
	}



function init_colorpicker_fn( id_str, format_str = 'hex' ) {
	
	if ( !id_str.startsWith( '#' ) ) {
		id_str = '#' + id_str;
	}
	
	var $picker_el = jQuery( id_str );

	$picker_el.colorpicker( {
		format: format_str,
		horizontal: true,
		popover: {
			container: id_str + '-container'
		},
		template: '<div class="colorpicker">' +
			'<div class="colorpicker-saturation"><i class="colorpicker-guide"></i></div>' +
			'<div class="colorpicker-hue"><i class="colorpicker-guide"></i></div>' +
			'<div class="colorpicker-alpha">' +
			'	<div class="colorpicker-alpha-color"></div>' +
			'	<i class="colorpicker-guide"></i>' +
			'</div>' +
			'<div class="colorpicker-bar">' +
			'	<div class="input-group">' +
			'		<input class="form-control input-block color-io" />' +
			'	</div>' +
			'</div>' +
			'</div>'
	} ).on( 'colorpickerCreate colorpickerUpdate', function( e ) {
		$picker_el.parent().find( '.colorpicker-input-addon>i' ).css( 'background-color', e.value );
	} ).on( 'colorpickerCreate', function( e ) {
		resize_color_picker_fn( $picker_el );
	} ).on( 'colorpickerShow', function( e ) {
		var cpInput_el = e.colorpicker.popupHandler.popoverTip.find( '.color-io' );

		cpInput_el.val( e.color.string() );

		cpInput_el.on( 'change keyup', function() {
			e.colorpicker.setValue( cpInput_el.val() );
		} );
	} ).on( 'colorpickerHide', function( e ) {
		var cpInput_el = e.colorpicker.popupHandler.popoverTip.find( '.color-io' );
		cpInput_el.off( 'change keyup' );
	} ).on( 'colorpickerChange', function( e ) {
		var cpInput_el = e.colorpicker.popupHandler.popoverTip.find( '.color-io' );

		if ( e.value === cpInput_el.val() || !e.color || !e.color.isValid() ) {
			return;
		}

		cpInput_el.val( e.color.string() );
	} );

	$picker_el.parent().find( '.colorpicker-input-addon>i' ).on( 'click', function( e ) {
		$picker_el.colorpicker( 'colorpicker' ).show();
	} );

	jQuery( window ).resize( function( e ) {
		resize_color_picker_fn( $picker_el );
	} );
}

function resize_color_picker_fn( $picker_el ) {
	var rem_int = parseInt( getComputedStyle( document.documentElement ).fontSize ),
		width_int = $picker_el.parent().width() - ( ( rem_int * .75 ) * 2 ) - 2,
		colorPicker_obj = $picker_el.colorpicker( 'colorpicker' ),
		slider_obj = colorPicker_obj.options.slidersHorz;

	slider_obj.alpha.maxLeft = width_int;
	slider_obj.alpha.maxTop = 0;

	slider_obj.hue.maxLeft = width_int;
	slider_obj.hue.maxTop = 0;

	slider_obj.saturation.maxLeft = width_int;
	slider_obj.saturation.maxTop = 150;

	colorPicker_obj.update();
}

function open_static_page( $page ){
	$.get( $page, function( data ) {
		$( '#content' ).html( data );
	});
}

function show_register_form(){
	
	var jwt = getCookie('jwt');
	if (jwt == ""){
		var html = `
			<div class="container">
			<h2>Sign Up</h2>
			<form id='sign_up_form'>
				<div class="form-group">
					<label for="firstname">Firstname</label>
					<input type="text" class="form-control" name="firstname" id="firstname" required />
				</div>

				<div class="form-group">
					<label for="lastname">Lastname</label>
					<input type="text" class="form-control" name="lastname" id="lastname" required />
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" id="email" required />
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password" required />
				</div>

				<button type='submit' class='btn btn-primary'>Sign Up</button>
			</form>
			</div>
			`;
		clearResponse();
		$('#content').html(html);
	} else {
		showUpdateAccountForm();
	}
};
 
// remove any prompt messages
function clearResponse(){
	$('#response').html('');
}
	 
// get or read cookie
function getCookie(cname){
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' '){
			c = c.substring(1);
		}

		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

</script>
 
</body>
</html>