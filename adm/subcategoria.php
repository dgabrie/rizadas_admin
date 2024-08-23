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
				<h3>Administrar SubSubcategorias</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
                            <th>Categoria</th>
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
                            if ($value->{"est_cat"} == '0'){
                                $colorCat='background-color:#ffafaf; color:black;';
                            }

                            echo '<tr  style="'.$bgcolor.'">
									<td style="text-align:center;">
										<div class="btn-group">
										
											<button title="'.$titleestado.' Subcategoria" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar Subcategoria" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td style="'.$colorCat.'">'.$value->{'categoria'}.'</td>
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
			$("#Modal_titulo_addSubcategoria").html("Agregar Subcategoria");
			$('#Modal_addSubcategoria').modal();
            document.getElementById("Agregar").reset();
		}
	</script>
	<div class="modal fade" id="Modal_addSubcategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addSubcategoria">Agregar Subcategoria</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addSubcategoria">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearSubcategoria">
        		<input type="hidden" name="id" id="codigo" >

        		<div class="row">

                    <div class="col-lg-12">
                        <label class="h5">Categoria: </label>
                        <select class="form-control" name="categoria" id="categoria" required="">
                            <option value=""></option>

                        </select>
                    </div>
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
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
    $("#Modal_titulo_addSubcategoria").html("Modificar Subcategoria");

    function cargarSelect() {
        const select = document.getElementById("categoria");

        $.post('Backend/Controller.php', {
            request: 'Listar',
            tabla: 'AdminCategoriaActivo'

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
    window.onload = cargarSelect();

  	//==========================================================


  	function edita(id){

			$("#Modal_titulo_addSubcategoria").html("Modificar Subcategoria");
		$.post('Backend/Controller.php',{
            request:'Listar',
            tabla:'getSubcategoria',
            id:id

	    }).done(function(response){
	        	
                $('#codigo').val(response.data[0].id);
				$('#nombre').val(response.data[0].nombre);
                $('#categoria').val(response.data[0].id_categoria);
                $('#estado').val(response.data[0].estado);
				
            $('#Modal_addSubcategoria').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}
    //==========================================================


    function desactivar(id){
        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar la Subcategoria!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addSubcategoria").html("Desactivar Subcategoria");
                $.post('Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getSubcategoria',
                    id: id

                }).done(function (response) {

                    $('#codigo').val(response.data[0].id);
                    $('#nombre').val(response.data[0].nombre);
                    $('#categoria').val(response.data[0].categoria);

                    if (response.data[0].estado == 1) {
                        $('#estado').val(0);
                    } else {
                        $('#estado').val(1);
                    }
                    $("#btnguardar").click();

                    //$('#Modal_addSubcategoria').modal();

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
                  text: "No se guardo el Subcategoria, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addSubcategoria').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el Subcategoria.",
              icon: "success",
          }).then((seguro) => {
              cargar('AdminSubCategoria','adm/subcategoria.php','Controller');
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