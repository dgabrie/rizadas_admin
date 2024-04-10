<?php
session_start();

if (isset($_SESSION['admin']['usuario'])) {
	$bandera=0;
	for ($i=0; $i < count($_SESSION['admin']['Permisos']) ; $i++) { 
		
		if ($_SESSION['admin']['Permisos'][$i]=='Administrador' || $_SESSION['admin']['Permisos'][$i]=='Marketing') {
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



		$datarespuesta=json_decode($_POST['response']);
		$dato=$datarespuesta->{'data'};  	

		?>
		<div class="container">
			<div class="row">
				<div class="col-12 card table-responsive">

					<h3>Ver Historias</h3>
					<table class="table" id="listado">
						<thead  style="text-align:center;">
							<tr>	
								<th>Administrar</th>
								<th>Nombre</th>
								<th>N. Citas</th>
								<th>Creación</th>


							</tr>
						</thead>
						<tbody  style="text-align:center;">
							<?php
							foreach ($dato as $key => $value) {

								echo '<tr>
								<td style="text-align:center;">
								<div class="btn-group">
								<button title="ver Historial" class="btn btn-primary" onclick="ver('.$value->{'id'}.')" > <span class="fas fa-eye"></span></button>
								
								</div>
								</td>
								<td>'.$value->{'nombre'}.'</td>
								<td>'.$value->{'citas'}.'</td>
								<td>'.date("d/m/Y",strtotime($value->{'fecha_creacion'})).'</td>


								</tr>';

							}
							?>
						</tbody>
					</table>	
				</div>
				<div class="col-12">

				</div>
			</div>		
		</div>

	</script>
	<div class="modal fade" id="Modal_Historial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="Modal_titulo_Historial">Ver Historial</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" id="Modal_body_Historial">
					

				</div>
				<div class="modal-footer" id="Modal_footer_admin">

				</div>

			</div>
		</div>
	</div>
	<style type="text/css">
		@media print {
			#accordionSidebar, #btnAgregar, .dt-buttons, .navbar, #listado_filter, .dataTables_length{
				display: none;	
			}

		}
	</style>
	<script type="text/javascript">
		$('#listado').DataTable({"language": {
			"url": "js/Spanish.json"
		},


		"lengthMenu": [ 10, 40, 100 ] 				,
		"sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
		"dom": "Bfltip",
		"columnDefs": [

		],
		"order": [[ 2, "desc" ]],

		"buttons":[

		{

			text:      'Exportar a: <br>',

		},
		{
			extend:    'excelHtml5',
			text:      '<button class="btn btn-success btn-xl">  EXCEL <span class="fas fa-file-excel"> </span></button>&nbsp;',
			titleAttr: 'Excel'
		},
		{
			extend:    'csvHtml5',
			text:      '<button class="btn btn-info btn-xl"> CSV <span class="fas fa-file-alt">  </span></button> &nbsp;',
			titleAttr: 'CSV'
		},
		{
			text:'<button class="btn btn-warning btn-xl" onclick="window.print()"> Imprimir <span class="fas fa-print">  </span></button>',
			titleAttr: 'Imprimir'
		}

		]
	});

  	//==========================================================


  	function ver(id){
			$.post('../adm/verHistorico.php',{
	            id:id

		    }).done(function(response){
		     	$("#Modal_body_Historial").html(response);

	      	 
					$('#Modal_Historial').modal();
		    }).fail(function(error){
		            swal("error",'No se puede obtener los datos','error');
		    });
		}


  	//==========================================================


  	function edita(id){

  		$("#Modal_titulo_Historial").html("Modificar Servicio");
  		$.post('../../Backend/Controller.php',{
  			request:'Listar',
  			tabla:'LlenarHistorial',
  			id:id

  		}).done(function(response){




  			$('#Modal_Historial').modal();
  		}).fail(function(error){
  			swal("error",'No se puede obtener los datos','error');
  		});
  	}




  </script>
  <?php
}
}else{
	header("Location: login.php");
}
?>