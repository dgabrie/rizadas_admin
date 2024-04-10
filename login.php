<?php
header("Access-Control-Allow-Origin: *");
session_set_cookie_params(["SameSite" => "Strict"]); //none, lax, strict
session_set_cookie_params(["Secure" => "true"]); //false, true
session_set_cookie_params(["HttpOnly" => "true"]); //false, true
session_start();
if (isset($_SESSION['admin']['usuario'])) {
    
		header("location: ./");
	}else{

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Login | CD Gabrie</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="src/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="src/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="src/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="src/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img  id="img-logo" alt="IMG" src="img/logo.png">
				</div>
				
				<form class="login100-form validate-form" id="form-login" style="
    margin-top: -20%;
">
					
					<span class="login100-form-title">
						Iniciar Sesión
						
					</span>
					<div id="alerta" class="login100-form"></div>
					<img src="img/foto.png" style="
					width:150px; border-radius:50%; margin-left: 25%;  "><br><br><br>
					<input type="hidden" name="request" value="Ingresar">
					<div class="wrap-input100 validate-input" data-validate = "El correo es necesario, ejemplo juan.perez@cdgabrie.com">
						<input class="input100" type="text" name="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Contraseña es necesaria">
						<input class="input100" type="password" name="clave" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Iniciar
						</button>
					</div>



					<div class="text-center p-t-50">
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="src/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="src/login/vendor/bootstrap/js/popper.js"></script>
	<script src="src/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="src/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="src/login/vendor/tilt/tilt.jquery.min.js"></script>
	<script type="text/javascript" src="src/alertas/sweetalert.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="src/login/js/main.js"></script>
	<script type="text/javascript">
		$("#form-login").on('submit',function(e){
			e.preventDefault();
			$.ajax({
                	url:'Backend/Controller.php',
                    method:'POST',
                    data: new FormData(this),
                    contentType:false,
                    cache:false,
                    processData:false,
                    success: function(data){
                    	
                    	swal(data.data[0], data.data[1],data.data[2]).then(() => {
                    		if (data.data[0]!='Error') {
                    			location.reload();
                    		}else{
                    			$("#alerta").html("<div class='alert alert-danger'>"+data.data[1]+"</div>");
                    		}
                    		
                    	});

                    },
                    error: function(XMLHttpRequest,textStatus, errorThrown){
                    $("#alerta").html("<div class='container'><div class='alert alert-warning'>Error no se pudo ejecutar la consulta</div></div> ");
                    }
     		})
		})



		
        			
        	
	</script>

</body>
</html>

<?php
}
?>