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


	
	 $datarespuesta=json_decode($_POST['response']);
	$dato=$datarespuesta->{'data'};  	
	  
?>
<div class="container">
	<div class="row">
			<div class="col-12 card table-responsive">
				
				<h3>Atender Citas</h3>
				<button class="btn btn-danger" onclick="cancelarCitasAnteriores()"> <span class="fas fa-ban"></span> Cancelar citas del mes pasado?</button>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Atender</th>
							<th>Nombre</th>
							<?php
							if ($_SESSION['admin']['id']!=4) {
							?>
							<th>Telefono</th>
							<?php
							}
							?>
							<th>Citas Atendidas</th>
							<th>Fecha</th>

						</tr>
					</thead>
					<tbody  style="text-align:center;">
						<?php

						foreach ($dato as $key => $value) {
							echo '<tr>
									<td style="text-align:center;">
										<div class="btn-group">
											<button title="Atender Cita" class="btn btn-primary btn-sm btn-rounded" onclick="atender('.$value->{'paciente'}.','.$value->{'id'}.')" > <span class="fas fa-tooth"></span> <br>Atender</button>
											<button title="NSP Cita" class="btn btn-danger btn-sm btn-rounded" onclick="NSP('.$value->{'id'}.')" > <span class="fas fa-virus"></span><br> NSP</button>
										</div>
									</td>
									<td>'.$value->{'nombre'}.'</td>';

									if ($_SESSION['admin']['id']!=4) {
										echo '<td>'.$value->{'telefono'}.'</td>';
									}
									echo '<td>'.$value->{'citas_At'}.'</td>
									<td>'.date("d/m/Y",strtotime($value->{'fecha_cita'})).'</td>
									
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
	<div class="modal fade" id="Modal_addCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addCita">Agregar Cita</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addCita">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearCita">
        		<input type="hidden" name="id" id="codigo_Cita" >
        		<input type="hidden" name="estado" id="estado" value='Reservado' >
        		<label class="h5">Nombre Doctor</label>
        		<select class="form-control" id="doctor" name="doctor">
        			<option value="2">Gabriela Gabrie</option>
        		</select>
        		<br>

        		<label class="h5">Paciente</label><br>

        		<select style="width:200px" id="paciente" name="paciente">

        			<option value="New">Nuevo</option>
        			
        		</select>
        		<br>

        		<br>
        		<label class="h5">Nombre Paciente</label>
        		<input type="text" class="form-control" name="nombre" id="nombre" required="" >

        		<br>
        		<label class="h5">Telefono Paciente</label>
        		<input type="text" class="form-control" name="telefono" id="telefono" required="" >

        		<br>
        		<label class="h5">Correo Paciente</label>
        		<input type="email" class="form-control" name="correo" id="correo" required="" >

        		<br>
        		<label class="h5">Motivo cita</label>
        		<input type="text" class="form-control" name="motivo" id="motivo" >
        		
        		<br>
        		<label class="h5">Fecha</label>
        		<input type="date" class="form-control" name="fecha" id="fecha" required="" min="<?php echo date('Y-m-d'); ?>">
        		<table>
        			<tr>
        				<td>Hora Inicio</td>
        				<td>Hora Fin:</td>
        			</tr>
        			<tr>
        				<td><input type="time" name="HoraInicio" id="HoraInicio" step="900" class="form-control"></td>
        				<td><input type="time" name="HoraFin" id="HoraFin" class="form-control" step="900"></td>
        			</tr>
        		</table>
        		
        		<br>
        		
        		<button class="btn btn-success" id="btnguardar"> <span class="fas fa-save"></span> Guardar</button>
        		<br>
        		<br>
        		<div id="graficoTiempo"></div>
        		
        		<br>
        	</form>	
        	
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
  	function cancelarCitasAnteriores() {
  			$.post('../../Backend/Controller.php',{
	        request:'cancelarCitasAnteriores'
	        

			  }).done(function(response){
			      	swal(response.data[0],response.data[1],response.data[2]).then(()=>{
			      		cargar('AtenderCitas','adm/AtenderCitas.php','Controller');
			      	})

			  }).fail(function(error){
			          swal("error",'No se puede obtener los datos','error');
			  });
  	}

  	$('#listado').DataTable({"language": {
      					"url": "js/Spanish.json"
      				},


      				"lengthMenu": [ 25, 50, 100 ] 				,
      				"sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
						"dom": "Bfltip",
						"columnDefs": [],
                        "order": [],
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

$.post('../../Backend/Controller.php',{
	        request:'Listar',
	        tabla:'getPacientes'

	  }).done(function(response){
	      	var pacientes=response.data;
	      	$('#paciente').empty();
	      	$("#paciente").append('<option value="New">Nuevo</option>');
	    	for (var i = 0; i < pacientes.length; i++) {
	    		tmppaciente=pacientes;
	    		$("#paciente").append('<option value="'+pacientes[i].id+'">'+pacientes[i].nombre+'</option>');
	    	}
		
			 
	  }).fail(function(error){
	          swal("error",'No se puede obtener los datos','error');
	  });
  	
//==========================================================

function atender (id,id_cita) {

	    	$.post('../../Backend/Controller.php',{
                request:'Listar',
                tabla:'AtenderPaciente',
                id:id_cita

            }).done(function(response){
                $.post('adm/Atender.php',{
                   response:JSON.stringify(response)

                }).done(function(response){
                    $('#main').html(response);
                    document.body.style.overflow = 'auto';
                }).fail(function(error){
                    swal("error",'Fallo al traer la pagina','error');
                });

            }).fail(function(error){
                swal("error",'No se puede obtener los datos','error');
            });


			 

  	
}


	//==========================================================

function NSP(id){
	swal({
			  title: "Estas segur@?",
			  text: "Estableceras la cita como NSP ",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
			
		$.post('../../Backend/Controller.php',{
            request:'Listar',
            tabla:'Cita_NSP',
            id:id
        }).done(function(response){
            swal({
                title: "Éxito",
                text: "Se Cancelo la Cita.",
                icon: "success",
            }).then((seguro) => {

                cargar('AtenderCitas','adm/AtenderCitas.php','Controller')
            });

	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	  }else{
					swal("No se des/habilito nada!");
				}
				
			});
	}
	//==========================================================
$('#Agregar').on("submit",function(e){
  
  e.preventDefault();
   $.ajax({
      url:'../../Backend/Controller.php',
      method:'POST',
      data: new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      success: function(respuesta){

          if (respuesta.status=='Error') {
              swal({
                  title: "Error",
                  text: respuesta.message,
                  icon: "error"
              })
      }else{
      		$('#Modal_addCita').modal('hide');
          swal({
              title: "Éxito",
              text: "Se Cancelo la Cita.",
              icon: "success",
          }).then((seguro) => {

              cargar('AtenderCitas','adm/AtenderCitas.php','Controller')
          });
      }
          
      },
          error:function(XMLHttpRequest,textStatus, errorThrown){
          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
          }
      })

   
});

	


  </script>
<?php
	}
  }else{
        header("Location: login.php");
  }
?>