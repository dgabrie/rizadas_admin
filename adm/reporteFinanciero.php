<?php
session_start();

if (isset($_SESSION['admin']['usuario'])) {
	$bandera=0;
	for ($i=0; $i < count($_SESSION['admin']['Permisos']) ; $i++) { 
		
		if ($_SESSION['admin']['Permisos'][$i]=='Administrador' || $_SESSION['admin']['Permisos'][$i]=='Marketing' || $_SESSION['admin']['Permisos'][$i]=='Doctor' || $_SESSION['admin']['Permisos'][$i]=='Citas') {
			$bandera=1;

		}

	}

	if ($bandera!=1) {


		?>
		<script type="text/javascript">
			swal("error","No tienes permisos para estar aqui","error");
			location.href="./";
		</script>

		<?php
	}else{
		?>
		<div class="container">
			<div class="row">
				<div class="col-12 card table-responsive">


					<h3>Reporte Financiero de Citas Atendidas</h3>

					<form id="busqueda">
						<div class="row">
							<div class="col-lg-6">
								Fecha Inicio:
								<input type="date" name="fechaI" value="<?= date("Y-m-d", strtotime("-1 week")) ?>" class="form-control">
							</div>
							<div class="col-lg-6">
								Fecha Fin:
								<input type="date" name="fechaF" value="<?= date("Y-m-d", strtotime("+1 month"))  ?>" class="form-control">
							</div>

							<div class="col-lg-12">
								<br>
								<button class="btn btn-primary form-control">Enviar</button>
							</div>
						</div>
						
					</form>
					<div class="" id="respuesta">
					</div>
				</div>
			</div>

			<script type="text/javascript">
				//==========================================================
				$('#busqueda').on("submit",function(e){

					e.preventDefault();
					$.ajax({
						url:'adm/reporteFinanciero_data.php',
						method:'POST',
						data: new FormData(this),
						contentType:false,
						cache:false,
						processData:false,
						success: function(respuesta){
							$("#respuesta").html(respuesta);
						},
						error:function(XMLHttpRequest,textStatus, errorThrown){
							$("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
						}
					})


				})
			</script>


			<?php
		}
	}else{
		header("Location: login.php");
	}
?>