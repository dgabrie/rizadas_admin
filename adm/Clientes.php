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
				<h3>Administrar Pacientes</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
							<th>Nombre</th>
							<th>Telefonos</th>

                            <th>Citas</th>
                            <th>Citas Mes</th>

                        </tr>
					</thead>
					<tbody  style="text-align:center;">
						<?php
						foreach ($dato as $key => $value) {
							
							echo '<tr>
									<td style="text-align:center;">
										<div class="btn-group">
											<button title="Editar Paciente" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td>'.$value->{'nombre'}.' '.$value->{'apellido'}.'</td>
									<td>'.$value->{'telefono'}.'</td>
									<td>'.$value->{'citas'}.'</td>
									<td>'.$value->{'citas_reserva'}.'</td>
									
									
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
            agregarFila('precios')
            resetTb('precios')
            agregarFila('precios')
			$("#Modal_titulo_addPaciente").html("Agregar Paciente");
			$('#Modal_addPaciente').modal();

		}
	</script>
	<div class="modal fade" id="Modal_addPaciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addPaciente">Agregar Paciente</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addPaciente">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearPaciente">
        		<input type="hidden" name="id" id="codigo_Paciente" >
                <input type="hidden" name="inventariodata" id="inventariodat" >
        		<div class="row">
        		
        			<div class="col-lg-4">
        				<label class="h5" for="nombre_Paciente">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre_Paciente" required="">		
        			</div>
                    <div class="col-lg-4">
                        <label class="h5" for="apellido_Paciente">Apellido: </label>
                        <input type="text" class="form-control" name="apellido" id="apellido_Paciente" required="">
                    </div>
        			<div class="col-lg-4">
        				<label class="h5" for="telefono">Telefono: </label>
        				<input type="text" class="form-control" name="telefono" id="telefono" required="">
        			</div>
        			<div class="col-lg-4">
        				<label class="h5" for="correo">Correos: </label>
        				<input type="email" class="form-control" name="correo" id="correo" >
        			</div>
        			<div class="col-lg-4">
        				<label class="h5" for="fecha_nac">Fecha de Nacimiento</label>
								<input type="date" class="form-control" name="fecha_nac" id="fecha_nac">
        			</div>
                    <div class="col-lg-4">
                        <label class="h5" for="sexo">Sexo</label><br>
                        <select name="sexo" id="sexo"  class="form-control" required>
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                        </select>

                    </div>
                    <div class="col-lg-4">
        				<label class="h5" for="nombre_emergencia">Contacto de Emergencia</label>
								<input type="text" class="form-control" name="nombre_emergencia" id="nombre_emergencia">
        			</div>
        			<div class="col-lg-4">
        				<label class="h5" for="telefono_emergencia">Telefono de Emergencia</label>
						<input type="text" class="form-control" name="telefono_emergencia" id="telefono_emergencia">
        			</div>

        			

        		</div>
        		

        		<br><br>
                <div class="row">
                    <div class="col-lg-12">
                        Precios
                        <br>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" onclick="agregarFila('precios')"><i class="fas fa-plus"></i> Agregar</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarFila('precios')"><i class="fas fa-eraser"></i> Eliminar</button>

                            <label>Elimina y añade al final de la tabla, por lo que si se requiere eliminar el primer valor, lo mas recomendable es modificarlo.</label>
                        </div>
                        <table class="table table-responsive" >
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody id="precios"></tbody>
                        </table>

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
    <script>
        var tmpInventario=[];
        inicio();
        //----------------------------------------------------
        function eliminarFila(idtabla) {

            var table = document.getElementById(idtabla);
            var rowCount = table.rows.length;
            //console.log(rowCount);

            if (rowCount < 1) {
                swal("Error", 'No se puede eliminar el encabezado', "error");
            } else {
                table.deleteRow(rowCount - 1);

            }
        }
        //===========================================================================
        function agregarFila(idtabla) {
            var table = document.getElementById(idtabla);
            var rowCount = table.rows.length+1;
            if (rowCount > 1) {
                if ($("#precio_" + idtabla + '_' + (rowCount-1)).val()!='' && $("#cmbProducto_" + idtabla + '_' + (rowCount-1)).val()!='') {
                    var htmltd = '<td>' + rowCount + '</td>' +
                        '<td>' +
                            '<select  class="form-control"  id="cmbProducto_' + idtabla + '_' + rowCount + '" name="Producto_' + idtabla + '_' + rowCount+'"  required>' +
                                '<option value="">Seleccione una opcion</option>';
                                    for (let i = 0; i < tmpInventario.length ; i++) {
                                        htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'">'+tmpInventario[i].nombre+'</option>';
                                    }


                    htmltd=htmltd+'</select>'+
                        '</td>'+
                        '<td>' +
                            '<input type="text" class="form-control"  name="precio_' + idtabla + '_' + rowCount + '" id="precio_' + idtabla + '_' + rowCount + '"  required></td>' +
                        '</td>';
                    document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;
                }else{
                    swal("Error", 'No se puede agregar una fila sin establecer la columna anterior', "error");
                }

            }else{
                var htmltd = '<td>' + rowCount + '</td>' +
                    '<td>' +
                    '<select  class="form-control"  id="cmbProducto_' + idtabla + '_' + rowCount + '" name="Producto_' + idtabla + '_' + rowCount+'"  required>' +
                    '<option value="">Seleccione una opcion</option>';
                        for (let i = 0; i < tmpInventario.length ; i++) {
                            htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'">'+tmpInventario[i].nombre+'</option>';
                        }


                htmltd=htmltd+'</select>'+
                    '</td>'+
                    '<td>' +
                    '<input type="text" class="form-control"  name="precio_' + idtabla + '_' + rowCount + '" id="precio_' + idtabla + '_' + rowCount + '"  required></td>' +
                    '</td>';
                document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;
            }



        }
        function inicio(){


            $.post('../../Backend/Controller.php',{
                request:'Listar',
                tabla:'getInventarioAct'
            }).done(function(response){
                tmpInventario=response.data;
                //console.log(tmpInventario);

            }).fail(function(error){
                swal("error",'No se puede obtener los datos','error');
            });
        }


        function resetTb(id){
            var table = document.getElementById(id);
            var rowCount = table.rows.length;

            for (let i = 0; i < rowCount; i++) {
                table.deleteRow(0);
            }
        }
    </script>
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
        //agregarFila('precios')
        resetTb('precios');



			$("#Modal_titulo_addPaciente").html("Modificar Paciente");
		$.post('../../Backend/Controller.php',{
            request:'Listar',
            tabla:'getCliente',
            id:id

	    }).done(function(response){
	        	
            $('#codigo_Paciente').val(response.data[0].id);
            $('#nombre_Paciente').val(response.data[0].nombre);
            $('#apellido_Paciente').val(response.data[0].apellido);
            $('#telefono').val(response.data[0].telefono);
            $('#correo').val(response.data[0].correo);
            $('#fecha_nac').val(response.data[0].fecha_nac);
            $('#nombre_emergencia').val(response.data[0].nombre_emergencia);
            $('#telefono_emergencia').val(response.data[0].telefono_emergencia);
            $('#sexo').val(response.data[0].sexo);
            var inventario=[];
            if(response.data[0].inventario==null){
                inventario=[];
                agregarFila('precios');
            }else{
                inventario=response.data[0].inventario.split(";");
            }

            //console.log(inventario);
            for (let i = 0; i < inventario.length ; i++) {
                agregarFila('precios');
                var invdetalle=inventario[i].split('|');
                //console.log(invdetalle);
                if(invdetalle.length>0){
                    $("#cmbProducto_precios_"+(i+1)).val(invdetalle[0]);
                    $("#precio_precios_"+(i+1)).val(invdetalle[2]);
                }
            }

            $('#Modal_addPaciente').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}

	//==========================================================
$('#Agregar').on("submit",function(e){
  e.preventDefault();
    var table = document.getElementById('precios');
    var rowCount = table.rows.length;
    var dataInventario="";

    for (let i = 0; i < rowCount; i++) {
        if(i>0){
            dataInventario=dataInventario+";";
        }
        dataInventario=dataInventario+$("#cmbProducto_precios_"+(i+1)).val()+"|"+$("#precio_precios_"+(i+1)).val();
    }
    $("#inventariodat").val(dataInventario);

   if(rowCount>0){
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
                      text: "No se guardo el Paciente, intentelo nuevamente.",
                      icon: "error"
                  })
          }else{
                $('#Modal_addPaciente').modal('hide');
              swal({
                  title: "Éxito",
                  text: "Se guardo el Paciente.",
                  icon: "success",
              }).then((seguro) => {
                 cargar('AdminClientes','adm/Clientes.php','Controller')
              });
          }

          },
              error:function(XMLHttpRequest,textStatus, errorThrown){
              $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
              }
          })

   }else{
       swal("error","Ingrese por lo menos un producto del inventario","error");
   }
});

	//==========================================================
        
// Take an image URL, downscale it to the given width, and return a new image URL.
downscaleImage = function downscaleImage(dataUrl, newWidth, imageType, imageArguments) {
    "use strict";
    var image, oldWidth, oldHeight, newHeight, canvas, ctx, newDataUrl;

    // Provide default values
    imageType = imageType || "image/jpeg";
    imageArguments = imageArguments || 0.7;

    // Create a temporary image so that we can compute the height of the downscaled image.
    image = new Image();
    image.src = dataUrl;
    oldWidth = image.width;
    oldHeight = image.height;
    newHeight = Math.floor(oldHeight / oldWidth * newWidth)

    // Create a temporary canvas to draw the downscaled image on.
    canvas = document.createElement("canvas");
    canvas.width = newWidth;
    canvas.height = newHeight;
    var ctx = canvas.getContext("2d");

    // Draw the downscaled image on the canvas and return the new data URL.
    ctx.drawImage(image, 0, 0, newWidth, newHeight);
    newDataUrl = canvas.toDataURL(imageType, imageArguments);
//console.log(newDataUrl);
    return newDataUrl;
}



	// Take an image URL, downscale it to the given width, and return a new image URL.

        "use strict";

        var fileImage = document.getElementById("fileImage"),
            numWidth = 720,
            imgScaled = document.getElementById("imagen"),
            downscaleImage;

       $("#fileImage").on("change",function(){
					$('#botonActualizar').removeAttr('disabled');       		
       })

        $('#botonActualizar').on("click",function(){
           
            var scaledImageWidth = 720;
            // Should add "downscaleImage" to the scope.


            if (fileImage.files.length > 0) {
                var file = fileImage.files[0];
                var fileReader = new FileReader();
                fileReader.onload = function (e) {
                    var imageDataUrl = e.srcElement.result,
                    scaledImageDataUrl = downscaleImage(imageDataUrl, scaledImageWidth,file.type);  
                    
    								$("#img_subir").val(scaledImageDataUrl);
                    imgScaled.src = scaledImageDataUrl;
                }
                fileReader.readAsDataURL(file);
            }
        });        
    


  </script>
<?php
	}
  }else{
        header("Location: login.php");
  }
?>