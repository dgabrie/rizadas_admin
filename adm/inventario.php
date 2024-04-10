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
        //var_dump($dato);
?>
<div class="container">
	<div class="row">
			<div class="col-12 card table-responsive">
				<button class="btn btn-primary" onclick="Agregar()" id="btnAgregar"><span class="fas fa-plus"></span> Agregar</button>
				<h3>Administrar Inventarios</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
							<th>Nombre</th>
							<th>Descripción</th>
                            <th>Tipo</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
             			</tr>
					</thead>
					<tbody  style="text-align:center;">
						<?php
						foreach ($dato as $key => $value) {

                            if ($value->{'estado'} == 'Activo') {
                                $estado='ban';
                                $titleestado='Desactivar';
                                $colestado='danger';
                                $bgcolor='color:black;';
                            }else{
                                $estado='plus';
                                $titleestado='Activar';
                                $colestado='success';
                                $bgcolor='background-color:#ffafaf; color:black;';
                            }

                            echo '<tr  style="'.$bgcolor.'">
									<td style="text-align:center;">
										<div class="btn-group">
										
											<button title="'.$titleestado.' Inventario" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar Inventario" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td>'.$value->{'nombre'}.'</td>
									<td>'.$value->{'descripcion'}.'</td>
									<td>'.$value->{'tipo'}.'</td>
									<td>'.$value->{'fecha_creacion'}.'</td>
									<td>'.$value->{'fecha_modificacion'}.'</td>
									
									
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
	<script type="text/javascript">
		function Agregar(){
			$("#Modal_titulo_addInventario").html("Agregar Inventario");
			$('#Modal_addInventario').modal();

		}
	</script>
	<div class="modal fade" id="Modal_addInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addInventario">Agregar Inventario</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addInventario">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearInventario">
        		<input type="hidden" name="id" id="codigo" >
                <input type="hidden" name="estado" id="estado" value="Activo">
        		<div class="row">
        		
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
        			</div>
                   <div class="col-lg-12">
        				<label class="h5">Descripción: </label>
                       <textarea class="form-control" name="descripcion" id="descripcion" required=""></textarea>
        			</div>
                    <div class="col-lg-12">
                        <label class="h5">Tipo: </label>
                        <select class="form-control" name="tipo" id="tipo" required="">
                            <option value="">Seleccione un tipo</option>
                            <option value="Cita Mensual">Cita Mensual</option>
                            <option value="Brackeo">Brackeo</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

        		</div>
        		

        		<br><br>
        		

        		
        		<br>
        		<button class="btn btn-success" id="btnguardar"> <span class="fas fa-save"></span> Guardar</button>
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
  	$('#listado').DataTable({"language": {
      					"url": "js/Spanish.json"
      				},


      				"lengthMenu": [ 10, 40, 100 ] 				,
      				"sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
						"dom": "Bfltip",
						"columnDefs": [

            			        				],
						 "order": [[ 3, "desc" ],[ 1, "asc" ]],

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


  	function edita(id){

			$("#Modal_titulo_addInventario").html("Modificar Inventario");
		$.post('../../Backend/Controller.php',{
            request:'Listar',
            tabla:'getInventario',
            id:id

	    }).done(function(response){
	        	
                $('#codigo').val(response.data[0].id);
				$('#nombre').val(response.data[0].nombre);
                $('#descripcion').val(response.data[0].descripcion);
                $('#tipo').val(response.data[0].tipo);
                $('#estado').val(response.data[0].estado);
				
            $('#Modal_addInventario').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}
    //==========================================================


    function desactivar(id){
        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar el producto del inventario!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addInventario").html("Desactivar Inventario");
                $.post('../../Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getInventario',
                    id: id

                }).done(function (response) {

                    $('#codigo').val(response.data[0].id);
                    $('#nombre').val(response.data[0].nombre);
                    $('#descripcion').val(response.data[0].descripcion);
                    $('#tipo').val(response.data[0].tipo);

                    if (response.data[0].estado == 'Activo') {
                        $('#estado').val('Inactivo');
                    } else {
                        $('#estado').val('Activo');
                    }
                    $("#btnguardar").click();

                    //$('#Modal_addInventario').modal();

                }).fail(function (error) {
                    console.log(error);
                    swal("error", 'No se puede obtener los datos', 'error');
                });
            }else{
                swal("Listo", 'No se desactivo/activo nada', 'success');
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
                  text: "No se guardo el Inventario, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addInventario').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el Inventario.",
              icon: "success",
          }).then((seguro) => {
              cargar('AdminInventario','adm/inventario.php','Controller')
          });
      }
          
      },
          error:function(XMLHttpRequest,textStatus, errorThrown){
          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
          }
      })

   
});

	//==========================================================

    


  </script>
<?php
	}
  }else{
        header("Location: login.php");
  }
?>