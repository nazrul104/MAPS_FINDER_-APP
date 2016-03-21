<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Maps Finder App - Login</title>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/style.css" />
  		<link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/icomoon.css"/> 
  		<script src="<?php echo base_url(); ?>js/lib/jquery.min.js"></script>
		
    </head>
    <body>
        <div class="container">

			<section class="main">
				<form class="form-login" action="login/login_check">
					<h1><span class="log-in">Maps Finder App</span></h1>
					<p class="float">
						<label for="login"><i class="icon-user"></i>Username</label>
						<input type="text" id="user_name" name="user_name" placeholder="Username">
					</p>
					<p class="float">
						<label for="password"><i class="icon-eye-blocked"></i>Password</label>
						<input type="password" id="user_password" name="user_password" placeholder="Password" class="showpassword">
					</p>
					<p class="clearfix"> 
						<input type="reset" class="log-btn" value="Cancel">  
						<input id="login" type="submit" name="submit" value="Log in">
					</p>
					<div id="message" align="center"></div>
				</form>​​
			</section>
			
        </div>
		<script type="text/javascript">
			$(function(){
				$("#login").click(function(){

				var action = $(".form-login").attr('action');
				var form_data = {
					username: $("#user_name").val(),
					password: $("#user_password").val()
				};

				$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response)
					{
						if(response == "success")
							$(".form-login").slideUp('slow', function(){
								$("#message").html('<p class="success">You have logged in successfully!</p><p>Redirecting....</p>').fadeIn(500);
								//redirect to secure page
				 				document.location='main';
							});
						else
							$("#message").html('<p class="error">ERROR: Invalid username and/or password.</p>').fadeIn(500);
			}
		});
		return false;
	});
	
			    $(".showpassword").each(function(index,input) {
			        var $input = $(input);
			        $("<p class='opt'/>").append(
			            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
			                var change = $(this).is(":checked") ? "text" : "password";
			                var rep = $("<input placeholder='Password' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
			             })
			        ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());
			    });

			    $('#showPassword').click(function(){
					if($("#showPassword").is(":checked")) {
						$('.icon-eye-blocked').addClass('icon-eye2');
						$('.icon-eye2').removeClass('icon-eye-blocked');    
					} else {
						$('.icon-eye2').addClass('icon-eye-blocked');
						$('.icon-eye-blocked').removeClass('icon-eye2');
					}
			    });
			});
		</script>
    </body>
</html>