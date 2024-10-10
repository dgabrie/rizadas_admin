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
											<button title="Editar Imagen Producto" class="btn btn-primary" onclick="editaIMG('.$value->{'id'}.')" > <span class="fas fa-camera"></span></button>
											<button title="Añadir Inventario" class="btn btn-secondary" onclick="agregarInventario('.$value->{'id'}.')" > <span class="fas fa-plus-circle"></span></button>
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
            $("#btnguardar").removeAttr('disabled');
            $('#categoria').val(null).trigger('change');
            $('#subcategoria').val(null).trigger('change');
            $('#temporada').val(null).trigger('change');
            document.getElementById("Agregar").reset();
            $("#frames").html("");
            $("#imagenes").removeAttr("disabled");


			$("#Modal_titulo_addProducto").html("Agregar Producto");
			$('#Modal_addProducto').modal();

        }

	</script>
	<div class="modal fade" id="Modal_addProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addProducto">Agregar Producto</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addProducto" enctype="multipart/form-data">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearProducto">
        		<input type="hidden" name="id" id="codigo" >

                <input type="hidden" name="adicionales" id="adicionales" >

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
                        <select class="form-control" style="width: 100%;" name="subcategoria[]" id="subcategoria" required="" multiple>

                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="h5">Temporada: </label>
                        <select class="form-control" style="width: 100%;" name="temporada[]" id="temporada"  multiple>

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
                        <input type="file" class="form-control" style="width: 100%;" name="imagenes[]" id="imagenes" accept="image/*"  multiple />
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

        <div class="modal fade" id="Modal_addInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Modal_titulo_addInventario">Agregar Inventario</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="Modal_body_addProducto" enctype="multipart/form-data">
                        <form id="frmAgregarInventario">
                            <input type="hidden" name="request" value="AgregarInventario">
                            <input type="hidden" name="producto" id="id_inv" >

                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="h5">Nombre: </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre_inv" required="" readonly>
                                </div>


                                <div class="col-lg-12">
                                    <label class="h5">Cantidad: </label>
                                    <input type="number" class="form-control" step="1" min="1" name="cantidad" id="cantidad" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label class="h5">Precio Compra</label>
                                    <input type="number" class="form-control" step="0.01" min="0.01" name="precio_compra" id="precio_compra" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label class="h5">Precio Venta</label>
                                    <input type="number" class="form-control" step="0.01" min="0.01" name="precio_venta" id="precio_venta" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label class="h5">Fecha Vencimiento: </label>
                                    <input type="date" class="form-control"  name="fec_venc" id="fec_vencimiento" >
                                </div>
                                <div class="col-lg-12">
                                    <label class="h5">Lote: </label>
                                    <input type="text" class="form-control" name="lote" id="lote" >
                                </div>

                            </div>


                            <br><br>



                            <br>
                            <button class="btn btn-success" id="btnguardar_inv"> <span class="fas fa-save"></span> Guardar</button>
                        </form>

                        <div class="col-lg-12">
                            ultimos 10 cargas de inventario Agregado
                            <table class="table table-responsive" id="tabla_inv">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Acción</th>
                                    <th>Fecha Entrada</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Cantidad</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Lote</th>
                                </thead>
                                <tbody id="tbl_inventario">

                                </tbody>

                            </table>
                        </div>

                    </div>
                    <div class="modal-footer" id="Modal_footer_admin">

                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="Modal_addImgProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Modal_titulo_EditaImagen">Administrar Imagenes</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="Modal_body_EditaImagen" enctype="multipart/form-data">

                            <input type="hidden" name="request" value="CrearProducto">
                            <input type="hidden" name="id" id="codigo" >

                            <input type="hidden" name="adicionales" id="adicionales" >

                            <div class="row">

                                <div class="col-lg-12">
                                    <form id="AgregarImg">
                                        <input type="hidden" name="request" value="AgregarImagenProducto">
                                        <input type="file" accept="image/*" name="imagenes_add[]" id="img_add" required multiple>
                                        <input type="hidden" name="id" id="idImg">
                                        <br>
                                        <div id="frames_img"></div><br>
                                        <br>
                                        <button class="btn btn-success" id="btnguardar_img"> <span class="fas fa-save"></span> Guardar</button>
                                    </form>
                                <div class="col-lg-12">
                                    Eliminar Imagenes
                                    <table class="table table-responsive" >
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Acción</th>
                                            <th>Imagen</th>
                                        </thead>
                                        <tbody id="tbl_img">

                                        </tbody>

                                    </table>
                                </div>
                            </div>

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
                          var url=window.URL.createObjectURL(this.files[i]);
                          $("#frames").append('<img src="'+url+'" width="20%" height="20%" style="margin-left:10px;" />');
                      }
                  });

                  $('#img_add').change(function(){
                      $("#frames_img").html('');
                      for (var i = 0; i < $(this)[0].files.length; i++) {
                          var url=window.URL.createObjectURL(this.files[i]);
                          $("#frames_img").append('<img src="'+url+'" width="20%" height="20%" style="margin-left:10px;" />');
                      }
                  });
              });

      function reset (idtabla) {
          var table = document.getElementById(idtabla);
          var rowCount = table.rows.length;
          //console.log(rowCount)

          if (rowCount>1) {
              for (var i = 1; i < rowCount; i++) {
                  eliminarFila(idtabla);
              }
          }else{
              eliminarFila(idtabla);
          }

      }

      function converttoBlob(url){
          var xhr = new XMLHttpRequest();
          xhr.open('GET',url, true);
          xhr.responseType = 'blob';
          xhr.onload = function(e) {
              if (this.status == 200) {
                  var myBlob = this.response;
                  // myBlob is now the blob that the object URL pointed to.
              }
          };
          xhr.send();
      }
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


              function agregarInventario(id){
                  $('#tabla_inv').DataTable().destroy();
                  document.getElementById("frmAgregarInventario").reset();
                    $("#tbl_inventario").html("");
                  $.post('Backend/Controller.php',{
                      request:'Listar',
                      tabla:'getInvProducto',
                      id:id
                  }).done(function(response){
                      $("#id_inv").val(id);
                      $("#nombre_inv").val(response.data[0].nombre);
                      for (var i = 0; i < response.data.length; i++) {
                          if (response.data[i].cantidad!=null) {
                              var html="<tr>" +
                                  "<td>"+(i+1)+"</td>" +
                                  "<td><button class='btn btn-danger' type='button' onclick='Eliminarinv("+response.data[i].id+")'><span class='fas fa-ban'></span></button></td>" +
                                  "<td nowrap='nowrap'>"+response.data[i].fec_creacion+"</td>" +
                                  "<td>"+response.data[i].precio_compra.toFixed(2)+"</td>" +
                                  "<td>"+response.data[i].precio_venta.toFixed(2)+"</td>" +
                                  "<td>"+response.data[i].cantidad+"</td>" +
                                  "<td nowrap='nowrap'>"+response.data[i].fecha_vencimiento+"</td>" +
                                  "<td>"+response.data[i].lote+"</td>" +
                                  "</tr>";


                              $("#tbl_inventario").append(html);
                          }

                      }


                      $("#tabla_inv").dataTable();



                      $('#Modal_addInventario').modal();
                  }).fail(function(error){
                      swal("error",'No se puede obtener los datos','error');
                  });
              }
              //==========================================================

          function editaIMG(id){

              document.getElementById("AgregarImg").reset();
              $("#frames_img").html("");
              $("#tbl_img").html("");
              $.post('Backend/Controller.php',{
                  request:'Listar',
                  tabla:'getImgProducto',
                  id:id
              }).done(function(response){
                  $("#idImg").val(id);
                    for (var i = 0; i < response.data.length; i++) {
                        var html="<tr>" +
                                    "<td>"+(i+1)+"</td>" +
                                    "<td><button class='btn btn-danger' type='button' onclick='EliminarImgProducto("+response.data[i].id+")'><span class='fas fa-ban'></span></button></td>" +
                                    "<td><img src='data:"+response.data[i].tipo+";base64,"+response.data[i].imagen+"' width='25%' height='25%'/td>" +
                                "</tr>";


                        $("#tbl_img").append(html);

                    }

                  $('#Modal_addImgProducto').modal();
              }).fail(function(error){
                  swal("error",'No se puede obtener los datos','error');
              });
          }


  	function edita(id){
        $("#btnguardar").removeAttr('disabled');
        $('#categoria').val(null).trigger('change');
        $('#subcategoria').val(null).trigger('change');
        $('#temporada').val(null).trigger('change');
        document.getElementById("Agregar").reset();
        $("#frames").html("");
        $("#imagenes").attr("disabled",true);

        reset('tbl_adicionales');

        $("#Modal_titulo_addProducto").html("Modificar Producto");
		$.post('Backend/Controller.php',{
            request:'Listar',
            tabla:'getProducto',
            id:id

	    }).done(function(response) {
            reset('tbl_adicionales');
            $('#codigo').val(response.data[0].id);
            $('#nombre').val(response.data[0].nombre);
            $('#marca').val(response.data[0].id_marca);
            $('#estado').val(response.data[0].estado);

            if(response.data[0].subcategoria!=null){
                if (response.data[0].subcategoria.search("#") != -1) {
                    var subcategoria2 = response.data[0].subcategoria.split("#");
                    $('#subcategoria').val(subcategoria2);
                }else{
                    $('#subcategoria').val(response.data[0].subcategoria);
                }
            }

            if(response.data[0].temporada!=null){
                if (response.data[0].temporada.search("#") !=-1) {
                    var temporada = response.data[0].temporada.split("#");
                    $('#temporada').val(temporada);
                }else{
                    $('#temporada').val(response.data[0].temporada);
                }
            }


            if(response.data[0].variable!=null) {
                if (response.data[0].variable.search("#") != -1) {

                    var adicionales = response.data[0].variable.split("#");

                    for (var i = 0; i < adicionales.length; i++) {

                        var adicional = adicionales[i].split("|");
                        //console.log(i);
                        //console.log(adicional);
                        if ($('#txtNombre_tbl_adicionales_' + i).val() == undefined) {
                            agregarFila('tbl_adicionales');
                        }

                        $('#txtNombre_tbl_adicionales_' + i).val(adicional[0]);

                        var adiciona=adicional[1];

                        $('#txtValor_tbl_adicionales_' + i).val(adiciona.replaceAll("<br>",'\n'));
                        //console.log(adiciona.replaceAll("<br>",'\n'));
                    }
                } else {

                    var adicional = response.data[0].variable.split("|");
                    agregarFila('tbl_adicionales');
                    $('#txtNombre_tbl_adicionales_0').val(adicional[0]);

                    if (adicional[1].search("<br>") != -1) {
                        var adiciona = adicional[1].replaceAll("<br>", '\n');
                    } else {
                        var adiciona = adicional[1];
                    }


                    $('#txtValor_tbl_adicionales_0').val(adiciona);


                }
            }


            $('#marca').trigger("change");
            $('#subcategoria').trigger("change");
            $('#temporada').trigger("change");


            $('#Modal_addProducto').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}

              //==========================================================


              function Eliminarinv(id){

                  swal({
                      title: "Estas segur@?",
                      text: "Estas apunto de eliminar el inventario del Producto!",
                      icon: "warning",
                      buttons: [
                          'No, Cancelar!',
                          'Si, estoy seguro!'
                      ],
                      dangerMode: true,
                  }).then(function(isConfirm) {
                      if (isConfirm) {
                          $.post('Backend/Controller.php', {
                              request: 'Listar',
                              tabla: 'EliminarinvProducto',
                              id: id

                          }).done(function (response) {
                              swal({
                                  title: "Éxito",
                                  text: "Se elimino correctamente",
                                  icon: "success",
                              }).then((seguro) => {
                                    agregarInventario($("#id_inv").val());
                              });


                          }).fail(function (error) {
                              console.log(error);
                              swal("error", 'No se puede obtener los datos', 'error');
                          });
                      }else{
                          swal("Listo", 'No se elimino nada', 'success');
                      }
                  });
              }

              //==========================================================


              function EliminarImgProducto(id){
                  $('#categoria').val(null).trigger('change');

                  swal({
                      title: "Estas segur@?",
                      text: "Estas apunto de eliminar la imagen del Producto!",
                      icon: "warning",
                      buttons: [
                          'No, Cancelar!',
                          'Si, estoy seguro!'
                      ],
                      dangerMode: true,
                  }).then(function(isConfirm) {
                      if (isConfirm) {
                          $.post('Backend/Controller.php', {
                              request: 'Listar',
                              tabla: 'EliminarImgProducto',
                              id: id

                          }).done(function (response) {
                              swal({
                                  title: "Éxito",
                                  text: "Se elimino correctamente",
                                  icon: "success",
                              }).then((seguro) => {
                                  editaIMG($("#idImg").val());
                              });


                          }).fail(function (error) {
                              console.log(error);
                              swal("error", 'No se puede obtener los datos', 'error');
                          });
                      }else{
                          swal("Listo", 'No se elimino nada', 'success');
                      }
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
                    tabla: 'DesactivaProducto',
                    id: id

                }).done(function (response) {
                    swal({
                        title: "Éxito",
                        text: "Se desactivo/activo correctamente",
                        icon: "success",
                    }).then((seguro) => {
                        cargar('AdminProducto','adm/producto.php','Controller');
                    });


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
              $('#frmAgregarInventario').on("submit",function(e){

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
                                  agregarInventario($("#id_inv").val());
                              });
                          }

                      },
                      error:function(XMLHttpRequest,textStatus, errorThrown){
                          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
                      }
                  })


              });
              //==========================================================
              $('#AgregarImg').on("submit",function(e){

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
                                  editaIMG($("#idImg").val());
                              });
                          }

                      },
                      error:function(XMLHttpRequest,textStatus, errorThrown){
                          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
                      }
                  })


              });
	//========================================================
$('#Agregar').on("submit",function(e){

    e.preventDefault();

    $("#btnguardar").attr('disabled','disabled');
    var idtabla='tbl_adicionales';
    var table = document.getElementById(idtabla);
    var rowCount = table.rows.length;
    var adicionales_select='';

    if (rowCount > 0) {

        for (var i = 0; i < rowCount; i++) {
            var nombre = $('#txtNombre_' + idtabla + '_' + i).val();
            var valor = $('#txtValor_' + idtabla + '_' + i).val();

            if (i == 0) {
                adicionales_select = nombre + "|" + valor;
            } else {
                adicionales_select = adicionales_select + "#" + nombre + "|" + valor;
            }
        }

        $("#adicionales").val(adicionales_select);
    }


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
              cargar('AdminProducto','adm/producto.php','Controller');
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
            //swal("Error", 'No se puede eliminar el encabezado', "error");
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