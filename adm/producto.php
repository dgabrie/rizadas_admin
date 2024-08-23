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
				<h3>Administrar Productos</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
                            <th>Marca</th>
                            <th>Nombre</th>
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
                            $colorCat="";
                            if ($value->{"est_marca"} == '0'){
                                $colorCat='background-color:#ffafaf; color:black;';
                            }

                            echo '<tr  style="'.$bgcolor.'">
									<td style="text-align:center;">
										<div class="btn-group">
										
											<button title="'.$titleestado.' Producto" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar Producto" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td style="'.$colorCat.'">'.$value->{'marca'}.'</td>
									<td>'.$value->{'nombre'}.'</td>
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
			$("#Modal_titulo_addProducto").html("Agregar Producto");
			$('#Modal_addProducto').modal();
            $('#subcategoria').val(null).trigger('change');
            document.getElementById("Agregar").reset();

        }
	</script>
	<div class="modal fade" id="Modal_addProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addProducto">Agregar Producto</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addProducto">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearProducto">
        		<input type="hidden" name="id" id="codigo" >

        		<div class="row">

                    <div class="col-lg-12">
                        <label class="h5">Marca: </label>
                        <select class="form-control" style="width: 100%;"  name="marca" id="marca" required="">
                            <option value=""></option>

                        </select>
                    </div>
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
        			</div>
                    <div class="col-lg-12">
                        <label class="h5">Sub Categoria: </label>
                        <select class="form-control" style="width: 100%;" name="subcategoria" id="subcategoria" required="" multiple>

                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Temporada: </label>
                        <select class="form-control" style="width: 100%;" name="temporada" id="temporada" required="" multiple>

                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Estado: </label>
                        <select class="form-control" name="estado" id="estado" required="">
                            <option value=""></option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>


                    <div class="col-lg-12 table-respon">
                        <label class="h5">Adicionales: </label>
                        <div class="row">
                            <div class="text-left btn-group" style="padding:10px;">

                                <button type="button" class="btn btn-success"
                                        onclick="agregarFila('tbl_adicionales');"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger"
                                        onclick="eliminarFila('tbl_adicionales'); "><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <table class="table" id="">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_adicionales">

                            </tbody>

                        </table>

                    </div>
                    <div class="col-lg-12">
                        <label class="h5">Imagenes: </label>
                        <input type="file" class="form-control" style="width: 100%;" name="imagenes[]" id="imagenes" accept="image/*" required="" multiple />
                        <div id="frames"></div>
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

              $(document).ready(function(){
                  $('#imagenes').change(function(){
                      $("#frames").html('');
                      for (var i = 0; i < $(this)[0].files.length; i++) {
                          $("#frames").append('<img src="'+window.URL.createObjectURL(this.files[i])+'" width="20%" height="20%"/>');
                      }
                  });
              });


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
    $("#Modal_titulo_addProducto").html("Modificar Producto");
        function cargarSelect() {
            const select = document.getElementById("marca");

            $.post('Backend/Controller.php', {
                request: 'Listar',
                tabla: 'AdminMarcaActivo'

            }).done(function (response) {
                for (let i = 0; i < response.data.length; i++) {

                    const option = document.createElement("option");
                    option.value = response.data[i].id;
                    option.text = response.data[i].nombre;
                    select.appendChild(option);
                }


            }).fail(function (error) {
                swal("error", 'No se puede obtener los datos', 'error');
            });
        }
    $(document).ready(function() {
        $("#marca").select2({
            dropdownParent: $("#Modal_body_addProducto")

        });
    });


    function cargarSubCategoria() {
        const select = document.getElementById("subcategoria");

        $.post('Backend/Controller.php', {
            request: 'Listar',
            tabla: 'AdminSubCategoriaActivo'

        }).done(function (response) {
            for (let i = 0; i < response.data.length; i++) {

                const option = document.createElement("option");
                option.value = response.data[i].id;
                option.text = response.data[i].categoria+" | "+response.data[i].nombre;
                select.appendChild(option);
            }
            $("#subcategoria").select2({
                tags: true,
                createTag: function(params) {
                    return undefined;
                }
            });
        }).fail(function (error) {
            swal("error", 'No se puede obtener los datos', 'error');
        });
    }

    function cargaTemporada() {
        const select = document.getElementById("temporada");

        $.post('Backend/Controller.php', {
            request: 'Listar',
            tabla: 'AdminTemporadaActivo'

        }).done(function (response) {
            for (let i = 0; i < response.data.length; i++) {

                const option = document.createElement("option");
                option.value = response.data[i].id;
                option.text = response.data[i].nombre;
                select.appendChild(option);
            }
            $("#temporada").select2({
                tags: true,
                createTag: function(params) {
                    return undefined;
                }
            });
        }).fail(function (error) {
            swal("error", 'No se puede obtener los datos', 'error');
        });
    }


    window.onload = cargarSelect();
    window.onload=cargarSubCategoria();
    window.onload=cargaTemporada();


    //==========================================================


  	function edita(id){
        $('#categoria').val(null).trigger('change');

        $("#Modal_titulo_addProducto").html("Modificar Producto");
		$.post('Backend/Controller.php',{
            request:'Listar',
            tabla:'getProducto',
            id:id

	    }).done(function(response){
	        	
                $('#codigo').val(response.data[0].id);
				$('#nombre').val(response.data[0].nombre);
                $('#marca').val(response.data[0].id_marca);
                $('#estado').val(response.data[0].estado);
				
            $('#Modal_addProducto').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}
    //==========================================================


    function desactivar(id){
        $('#categoria').val(null).trigger('change');

        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar la Producto!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addProducto").html("Desactivar Producto");
                $.post('Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getProducto',
                    id: id

                }).done(function (response) {

                    $('#codigo').val(response.data[0].id);
                    $('#nombre').val(response.data[0].nombre);
                    $('#marca').val(response.data[0].marca);

                    if (response.data[0].estado == 1) {
                        $('#estado').val(0);
                    } else {
                        $('#estado').val(1);
                    }
                    $("#btnguardar").click();

                    //$('#Modal_addProducto').modal();

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
                  text: "No se guardo el Producto, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addProducto').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el Producto.",
              icon: "success",
          }).then((seguro) => {
              cargar('AdminProducto','adm/Producto.php','Controller');
          });
      }
          
      },
          error:function(XMLHttpRequest,textStatus, errorThrown){
          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
          }
      })

   
});
    var id_adicional_selec = [];
	//==========================================================
    //----------------------------------------------------
    function eliminarFila(idtabla) {
        var table = document.getElementById(idtabla);
        var rowCount = table.rows.length;
        //console.log(rowCount);
        id_adicional_selec.splice(rowCount - 1);
        if (rowCount > 0) {
            $('#tbladicional_' + idtabla + '_' + (rowCount - 2)).removeAttr('disabled');
            id_adicional_selec.pop();
        }
        if (rowCount <= 0) {
            swal("Error", 'No se puede eliminar el encabezado', "error");
            id_adicional_selec.splice(rowCount - 1);
        } else {
            table.deleteRow(rowCount - 1);

        }
    }

    //----------------------------------------------------
    //===========================================================================
    function agregarFila(idtabla) {


        var table = document.getElementById(idtabla);
        var rowCount = table.rows.length;
        if (rowCount > 0) {

            if ($("#txtNombre_" + idtabla + '_' + (rowCount - 1)).val() !== '' && $("#txtValor_" + idtabla + '_' + (rowCount - 1)).val() !== '') {


                var htmltd = '<td>' + (rowCount+1) + '</td>' +
                    '<td><input type="text" class="form-control"  name="txtNombre_' + idtabla + '_' + rowCount + '" id="txtNombre_' + idtabla + '_' + rowCount + '" style="width: 100% !important;" required></td>' +
                    '<td><textarea  class="form-control"  name="txtValor_' + idtabla + '_' + rowCount + '" id="txtValor_' + idtabla + '_' + rowCount + '"style="width: 100% !important;" onkeydown="AgregarFilaKey (event,'+"'"+ idtabla +"'"+ ',' +"'"+ rowCount +"'"+')" required></textarea></td>';

                document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;

            } else {
                swal("Error", 'No se puede agregar una fila sin establecer la info de la fila actual', "error");
            }


        }else{
            var htmltd = '<td>' + (rowCount+1) + '</td>' +
                '<td><input type="text" class="form-control"  name="txtNombre_' + idtabla + '_' + rowCount + '" id="txtNombre_' + idtabla + '_' + rowCount + '" style="width: 100% !important;" required></td>' +
                '<td><textarea  class="form-control"  name="txtValor_' + idtabla + '_' + rowCount + '" id="txtValor_' + idtabla + '_' + rowCount + '"style="width: 100% !important;" onkeydown="AgregarFilaKey (event,'+"'"+ idtabla +"'"+ ',' +"'"+ rowCount +"'"+')" required></textarea></td>';

            document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;
        }
    }

    function AgregarFilaKey(e, idtabla, row) {
        console.log(e);
        if (e.which == 9) {
            agregarFila(idtabla);
        }
    }

        //----------------------------------------------------



  </script>
<?php
	}
  }else{
        header("Location: login.php");
  }
?>