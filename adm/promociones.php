<?php
	session_start();

if (isset($_SESSION['admin']['usuario'])) {
$bandera=0;



if ( !array_search("1",$_SESSION['admin']['Permisos']) || array_search("3",$_SESSION['admin']['Permisos']) ) {
    $bandera=1;

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
				<h3>Administrar Promocion</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
                            <th>Tipo Promo</th>
                            <th>Nombre Promo</th>
                            <th>Descripción</th>
                            <th>Aplican</th>
                            <th>Descuento Producto</th>
                            <th>Descuento Envio</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
							<th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
             			</tr>
					</thead>
					<tbody  style="text-align:center;">
						<?php
						foreach ($dato as $key => $value) {

                            if ($value->{'estado'} == '1') {
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
										
											<button title="'.$titleestado.' Promocion" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar Promocion" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td>'.$value->{'tipo_promo'}.'</td>
									<td>'.$value->{'nombre'}.'</td>
									<td>'.$value->{'descripcion'}.'</td>
									<td><ul style="margin-left: 15px; list-style: circle;">'.$value->{'productos'}.'</ul></td>
									<td>'.$value->{'desc_producto'}.'</td>
									<td>'.$value->{'desc_envio'}.'</td>
									<td>'.$value->{'fecha_inicio'}.'</td>
									<td>'.$value->{'fecha_fin'}.'</td>
									<td>'.$value->{'estado1'}.'</td>
									<td>'.$value->{'fec_creacion'}.'</td>
									<td>'.$value->{'fec_modificacion'}.'</td>
									
									
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
			$("#Modal_titulo_addPromocion").html("Agregar Promocion");
			$('#Modal_addPromocion').modal();
            document.getElementById("Agregar").reset();

		}

        $("#tipo").select2({
            tags: true,
            createTag: function(params) {
                return undefined;
            }
        });

        function changeTipo(){

            var tipo=$('#tipo_promo').val();
            $.post('Backend/Controller.php',{
                request:'Listar',
                tabla:'getTipoPromocion',
                id:tipo
            }).done(function(response){
                $('#tipo').html('');
                $.each(response.data,function(i,item){
                    $('#tipo').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                });
            }).fail(function(error){
                console.log(error);
            });



        }


	</script>
	<div class="modal fade" id="Modal_addPromocion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addPromocion">Agregar Promocion</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addPromocion">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearPromocion">
        		<input type="hidden" name="id" id="codigo" >

        		<div class="row">
                    <div class="col-lg-12">
                        <label class="h5">Tipo de Promoción: </label>
                        <select class="form-control" name="tipo_promo" onchange="changeTipo()" id="tipo_promo" required>
                            <option value=""></option>
                            <option value="temporada">Temporada</option>
                            <option value="categoria">Categoria</option>
                            <option value="subcategoria">Subcategoria</option>
                            <option value="marca">Marca</option>
                            <option value="producto">Producto</option>
                        </select>
                    </div>
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
        			</div>
                    <div class="col-lg-12">
                        <label class="h5">Descipción: </label>
                        <input type="text" class="form-control" name="descripcion" id="descripcion" required="">
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Aplican: </label>
                        <select class="form-control" style="width: 100%;" name="tipo[]" id="tipo" required="" multiple>

                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Descuento Envio: </label>
                        <input type="number" step="1" min="0" max="100" class="form-control" name="desc_env" id="desc_env" required="">
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Descuento Producto: </label>
                        <input type="number" step="1" min="0" max="100" class="form-control" name="desc_prod" id="desc_prod" required="">
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Fecha Inicio: </label>
                        <input type="date" class="form-control" name="fec_inicio" id="fec_inicio" required="">
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Fecha Fin: </label>
                        <input type="date" class="form-control" name="fec_fin" id="fec_fin" required="">
                    </div>

                   <div class="col-lg-12">
        				<label class="h5">Estado: </label>
                       <select class="form-control" name="estado" id="estado" required="">
                           <option value=""></option>
                           <option value="1">Activo</option>
                           <option value="0">Inactivo</option>
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

			$("#Modal_titulo_addPromocion").html("Modificar Promocion");
		    $('#Modal_addPromocion').modal();
            document.getElementById("Agregar").reset();
            $.post('Backend/Controller.php', {
                request: 'Listar',
                tabla: 'getPromocion',
                id: id

            }).done(function (response) {

                $('#codigo').val(response.data[0].id);
                $('#nombre').val(response.data[0].nombre);
                $('#descripcion').val(response.data[0].descripcion);
                $('#tipo_promo').val(response.data[0].tipo_promo);
                $('#desc_env').val(response.data[0].desc_envio);
                $('#desc_prod').val(response.data[0].desc_producto);
                $('#fec_inicio').val(response.data[0].fec_inicio);
                $('#fec_fin').val(response.data[0].fec_fin);
                $('#estado').val(response.data[0].estado);
                changeTipo();

                var tipo=[];

                tipo = response.data[0].id_tipo;
                var id_tipo=tipo.split(",");


                setTimeout(function(){
                    $('#tipo').val(id_tipo);
                    $("#tipo").trigger('change');
                },1000);




            }).fail(function (error) {
                console.log(error);
                swal("error", 'No se puede obtener los datos', 'error');
            });
	}
    //==========================================================


    function desactivar(id){
        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar la Promocion!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addPromocion").html("Desactivar Promocion");
                $.post('Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getPromocion',
                    id: id

                }).done(function (response) {

                    $('#codigo').val(response.data[0].id);
                    $('#nombre').val(response.data[0].nombre);

                    if (response.data[0].estado == 1) {
                        $('#estado').val(0);
                    } else {
                        $('#estado').val(1);
                    }
                    $("#btnguardar").click();

                    //$('#Modal_addPromocion').modal();

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
       url:'Backend/Controller.php',
      method:'POST',
      data: new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      success: function(respuesta){

          if (respuesta.status=='Error') {
              swal({
                  title: "Error",
                  text: "No se guardo el Promocion, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addPromocion').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el Promocion.",
              icon: "success",
          }).then((seguro) => {
              cargar('ListarPromociones','adm/promociones.php','Controller')
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