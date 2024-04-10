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
				<h3>Administrar usuarios</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
							<th>Nombre</th>
							<th>Usuario</th>
                            <th>Permiso</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
             			</tr>
					</thead>
					<tbody  style="text-align:center;">
						<?php
						foreach ($dato as $key => $value) {

                            if ($value->{'estado'} == 'y') {
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
                            if ($value->{'estado'}=='y'){
                                $estado2='Activo';
                            }else{
                                $estado2='Inactivo';
                            }
                            echo '<tr  style="'.$bgcolor.'">
									<td style="text-align:center;">
										<div class="btn-group">
										
											<button title="'.$titleestado.' usuario" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar usuario" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td>'.$value->{'nombre'}.'</td>
									<td>'.$value->{'usuario'}.'</td>
									<td>'.$value->{'permiso'}.'</td>
									<td>'.$estado2.'</td>
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
			$("#Modal_titulo_addusuario").html("Agregar usuario");
			$('#Modal_addusuario').modal();

		}
	</script>
	<div class="modal fade" id="Modal_addusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addusuario">Agregar usuario</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addusuario">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="Crearusuario">
        		<input type="hidden" name="id" id="codigo" >
                <input type="hidden" name="estado" id="estado" value="y">
        		<div class="row">
        		
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
        			</div>
                    <div class="col-lg-12">
                        <label class="h5">Usuario: </label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required="">
                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Correo: </label>
                        <input type="email" class="form-control" name="correo" id="correo" required="">
                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Contraseña: </label>
                        <input type="text" class="form-control" name=pass" id="pass" required="">
                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Permisos: </label>
                        <select class="form-control" name="permisos" id="permisos" required="" multiple>
                            <option></option>

                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Estado: </label>
                        <select class="form-control" name="estado" id="estado" required="">
                            <option value="y">Activo</option>
                            <option value="n">Inactivo</option>

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

			$("#Modal_titulo_addusuario").html("Modificar usuario");
		$.post('../../Backend/Controller.php',{
            request:'Listar',
            tabla:'getusuario',
            id:id

	    }).done(function(response){
	        	
                $('#codigo').val(response.data[0].id);
				$('#nombre').val(response.data[0].nombre);
                $('#usuario').val(response.data[0].usuario);
                $('#correo').val(response.data[0].correo);
                $('#pass').val("Contraseña encriptada");
                $('#estado').val(response.data[0].estado);


				
            $('#Modal_addusuario').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}
    //==========================================================


    function desactivar(id){
        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar el producto del usuario!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addusuario").html("Desactivar usuario");
                $.post('../../Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getusuario',
                    id: id

                }).done(function (response) {

                    $('#codigo').val(response.data[0].id);
                    $('#nombre').val(response.data[0].nombre);
                    $('#descripcion').val(response.data[0].descripcion);
                    $('#estado').val(response.data[0].estado);

                    if (response.data[0].estado == 'Activo') {
                        $('#estado').val('Inactivo');
                    } else {
                        $('#estado').val('Activo');
                    }
                    $("#btnguardar").click();

                    //$('#Modal_addusuario').modal();

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
                  text: "No se guardo el usuario, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addusuario').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el usuario.",
              icon: "success",
          }).then((seguro) => {
              cargar('Adminusuario','adm/usuario.php','Controller')
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