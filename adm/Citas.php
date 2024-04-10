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
					<button class="btn btn-primary" onclick="Agregar()" id="btnAgregar"><span class="fas fa-plus"></span> Agregar</button>

					<h3>Administrar Citas</h3>
					<table class="table" id="listado">
						<thead  style="text-align:center;">
							<tr>	
								<th>Administrar</th>
								<th>Nombre</th>
								<?php
								if ($_SESSION['admin']['id']!=4) {
									?>
									<th>Telefono</th>
									<?php
								}
								?>

								<th>Motivo</th>
								<th>Fecha</th>
                                <?php
                                if ($_SESSION['admin']['id']!=4) {
                                ?>
								<th>Hora Inicio</th>
                                <?php
                                }
                                ?>
							</tr>
						</thead>
						<tbody  style="text-align:center;">
							<?php

							foreach ($dato as $key => $value) {
								echo '<tr>
								<td style="text-align:center;">
								<div class="btn-group">
								<button title="Editar Cita" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
								<button title="Cancelar Cita" class="btn btn-danger" onclick="deshabilitar('.$value->{'id'}.')" > <span class="fas fa-ban"></span></button>';

								
								if ($_SESSION['admin']['id']!=4) {
                                    $telefonos=explode(',',$value->{'telefono'});
                                    if(count($telefonos)==1){
                                        echo '<button title="Enviar Whatsapp num: '.$value->{'telefono'}.' " class="btn btn-success" onclick="wha('."'".$value->{'telefono'}."'".','."'".$value->{'nombre'}."'".','."'".date("d/m/Y",strtotime($value->{'fecha_cita'}))."'".','."'".date("g:i a",strtotime($value->{'hora'}))."'".')" > <span class="fab fa-whatsapp"></span></button>';
                                    }else{
                                        foreach ($telefonos as $item) {
                                            echo '<button title="Enviar Whatsapp num: '.$item.' " class="btn btn-success" onclick="wha('."'".$item."'".','."'".$value->{'nombre'}."'".','."'".date("d/m/Y",strtotime($value->{'fecha_cita'}))."'".','."'".date("g:i a",strtotime($value->{'hora'}))."'".')" > <span class="fab fa-whatsapp"></span></button>';
                                        }

                                    }

								}	
								echo '</div>
								</td>
								<td>'.$value->{'nombre'}.'</td>';

								if ($_SESSION['admin']['id']!=4) {
									echo '<td>'.$value->{'telefono'}.'</td>';


								}


								echo '<td>'.$value->{'motivo'}.'</td>
								<td>'.date("d/m/Y",strtotime($value->{'fecha_cita'})).'</td>';

                                if ($_SESSION['admin']['id']!=4) {

								    echo '<td>'.date("h:i a",strtotime($value->{'hora'})).'</td>';
								}
								echo '</tr>';

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
								
								<option value="4">Ivonne </option>
							</select>
							<br>

							<label class="h5">Paciente</label><br>

							<select style="width:200px" id="paciente" name="paciente">
								<?php
								if ($_SESSION['admin']['id']!=4) {
									?>
									<option value="New">Nuevo</option>
									<?php
								}else{
									?>
									<option></option>
									<?php
								}
								?>


							</select>
							<br>


                            <?php
                            if ($_SESSION['admin']['id']!=4) {
                            ?>
                                <br>
                             <br>
                            <div class="oculto" id="oculto" >
                                <label class="h5">Nombre Paciente</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required="">
                                <br>
								<label class="h5">Telefono Paciente</label>
								<h6>Ingrese el telefono con el codigo de area "+504" para Honduras </h6>
								<input type="text" class="form-control" name="telefono" id="telefono" required="" >

								<br>
								<label class="h5">Correo Paciente</label>
								<input type="email" class="form-control" name="correo" id="correo">
							</div>
                                <br>
                            <?php
                            }
                            ?>

							<label class="h5">Motivo cita</label>
							<select class="form-control" name="motivo" id="motivo" required="" >
                                <option value="">Seleccione una opción</option>
                                <option value="Brackeo">Brackeo</option>
                                <option value="Ajuste">Ajuste</option>
                                <option value="Otro">Otro</option>
                            </select>

							<br>
							<label class="h5">Fecha</label>
							<input type="date" class="form-control" name="fecha" id="fecha" required="" min="<?php echo date('Y-m-d'); ?>">

                            <br>
                            <label class="h5">Horario</label>
                            <select class="form-control" name="Hora" id="hora" required="" >
                                <option value="">Seleccione una fecha</option>
                            </select>


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
		</div>
		<style type="text/css">
			@media print {
				#accordionSidebar, #btnAgregar, .dt-buttons, .navbar, #listado_filter, .dataTables_length{
					display: none;	
				}

			}
			.oculto{
				display: none;
			}
		</style>
		<script type="text/javascript">
            $("#hora").on("blur",function(e) {

            });

			function wha (telefono,nombre,fecha,hora) {

				if (telefono!='' && nombre!='' && fecha !='' && hora!='') {
					var pnombre=nombre.split(" ");
					window.open("https://api.whatsapp.com/send?phone="+telefono+"&text=Buenas%20tardes%20"+pnombre[0]+"%2C%20%0Aun%20gusto%20saludarle%20nuevamente%20le%20escribo%20para%20confirmarle%20y%20recordarle%20su%20cita%20para%20fecha%3A%20"+fecha+"%20a%20las%3A%20"+hora);
				}else{
					swal("Error","Ocurrio un problema con el envio de whatsapp", "error")
				}
			}
			<?php
			if ($_SESSION['admin']['id']!=4) {
				?>
				$("#oculto").removeAttr('class');
				<?php
			}
			?>

			var tmppaciente;
			function Agregar(){
				document.getElementById("Agregar").reset();
				$("#nombre").removeAttr("readonly");
				$("#telefono").removeAttr("readonly");
				$("#correo").removeAttr("readonly");

				$.post('../../Backend/Controller.php',{
					request:'Listar',
					tabla:'getPacientes'

				}).done(function(response){
					var pacientes=response.data;
					$('#paciente').empty();
					<?php
					if ($_SESSION['admin']['id']!=4) {
						?>
						$("#paciente").append('<option value="New">Nuevo</option>');
						<?php
					}else{
						?>
						$("#paciente").append('<option value=""></option>');
						<?php
					}
					?>
                    tmppaciente=pacientes;
					for (var i = 0; i < pacientes.length; i++) {

						$("#paciente").append('<option value="'+pacientes[i].id+'">'+pacientes[i].id+' - '+pacientes[i].nombre+' '+pacientes[i].apellido+'</option>');
					}


				}).fail(function(error){
					swal("error",'No se puede obtener los datos','error');
				});


				$("#Modal_titulo_addCita").html("Agregar Cita");
				$('#Modal_addCita').modal();

			}
		//--------------------------------------------------------------------------------------------------------------

		$('#paciente').on('select2:select', function (e) {
			var valor = e.params.data.id;
			if (valor=='New') {
				$("#nombre").val('');
				$("#telefono").val('');
				$("#correo").val('');
				$("#nombre").removeAttr("readonly");
				$("#telefono").removeAttr("readonly");
				$("#correo").removeAttr("readonly");
			}else{


				var tmpvalor = tmppaciente.find(function(post, index) {
					if(post.id == valor) return true;
				});

				$("#nombre").val(tmpvalor.nombre+" "+tmpvalor.apellido);
				$("#telefono").val(tmpvalor.telefono);
				$("#correo").val(tmpvalor.correo);
				$("#nombre").attr("readonly","readonly");
				$("#telefono").attr("readonly","readonly");
				$("#correo").attr("readonly","readonly");
			}

		});

		//--------------------------------------------------------------------------------------------------------------
		$(document).ready(function() {
			$("#paciente").select2({
				width: '100%',
				dropdownParent: $('#Modal_addCita .modal-body')
			});

		});

        function resetcmb(id){
            var cmbDesc=document.getElementById(id);
            //console.log(id);
            var option = document.createElement("option");
            option.text = '';
            option.value = '';

            $('#'+id+' option').each(function() {
                $(this).remove();
            });
            cmbDesc.add(option);
        }

        $("#fecha").on("blur",function(e){
            resetcmb('hora');
            var fecha=$("#fecha").val();
            $.post('../../Backend/Controller.php',{
                request:'Listar',
                tabla:'getHorario',
                id: fecha
            }).done(function(response){
                var horario=response.data;
                for (var i = 0; i < horario.length; i++) {
                    var option = document.createElement("option");
                    var paciente="";
                    if(horario[i].paciente.includes("Default")){
                        paciente="Sin Reservar";
                    }else{
                        paciente=horario[i].paciente;
                    }
                    <?php
                    if ($_SESSION['admin']['id']==4) {
                    ?>
                    if(paciente==="Sin Reservar"){
                        option.text = horario[i].hora+" | "+paciente;
                        option.value = horario[i].hora;
                        document.getElementById('hora').add(option);
                    }

                    <?php
                    }else{
                    ?>
                    option.text = horario[i].hora+" | "+paciente;
                    option.value = horario[i].hora;
                    document.getElementById('hora').add(option);
                    <?php
                    }
                    ?>

                }
                if (horario.length==0){
                    var option = document.createElement("option");
                    option.text = "No hay horarios disponibles";
                    option.value = "";
                    document.getElementById('hora').add(option);
                }
            }).fail(function(error){
                swal("error",'No se puede obtener los datos','error');
            });
        });

/*
		$("#fecha").on("blur",function(e){
			var hoy = new Date();
			var hora=hoy.getHours();
			var minutos=hoy.getMinutes();


			var res = hoy.getFullYear();

			if ((hoy.getMonth()+1)<9) {
				res=res+"-0"+(hoy.getMonth()+1)
			}else{
				res=res+"-"+(hoy.getMonth()+1)
			}


			if ((hoy.getDate())<9) {
				res=res+"-0"+(hoy.getDate())
			}else{
				res=res+"-"+(hoy.getDate())
			}

			if (hora<9) {
				hora="0"+hoy.getHours();
			}
			if (minutos<9) {
				minutos="0"+hoy.getMinutes();	
			}

			var dia=e.target.value;
			var doc=$("#doctor").val();

			$("#graficoTiempo").html("");
			$("#graficoTiempo").load('adm/chkHora.php?fecha='+$("#fecha").val()+'&id_doc='+doc);

			console.log(res+"="+dia);
			if (res==dia) {

				$("#hora").attr("min",hora+":"+minutos);
			}else{
				$("#hora").removeAttr("min");
			}
		})
            */

		$('#listado').DataTable({"language": {
			"url": "js/Spanish.json"
		},


		"lengthMenu": [ 40, 100, 300 ] 				,
		"sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
		"dom": "Bfltip",
		"columnDefs": [

		],
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
        //console.log(pacientes);
  		$('#paciente').empty();
  		$("#paciente").append('<option value="New">Nuevo</option>');
  		for (var i = 0; i < pacientes.length; i++) {
  			tmppaciente=pacientes;
             var valpaciente=pacientes[i].nombre+" "+pacientes[i].apellido;
            //console.log(paciente);
  			$("#paciente").append('<option value="'+pacientes[i].id+'">'+valpaciente+'</option>');
  		}


  	}).fail(function(error){
  		swal("error",'No se puede obtener los datos','error');
  	});

  	function edita(id){

  		$("#Modal_titulo_addCita").html("Modificar Cita");
  		$.post('../../Backend/Controller.php',{
  			request:'Listar',
  			tabla:'getCita',
  			id:id

  		}).done(function(response){

  			$('#codigo_Cita').val(response.data[0].id);
  			$('#paciente').val(response.data[0].paciente);
  			$('#nombre').val(response.data[0].nombre+" "+response.data[0].apellido);
  			$('#telefono').val(response.data[0].telefono);
  			$('#correo').val(response.data[0].correo);
  			$("#paciente").attr("readonly","readonly");
  			$("#nombre").attr("readonly","readonly");
  			$("#telefono").attr("readonly","readonly");
  			$("#correo").attr("readonly","readonly");
  			$('#fecha').val(response.data[0].fecha_cita);
  			$('#hora').val(response.data[0].hora);
  			$('#motivo').val(response.data[0].motivo);
  			$("#estado").val('Reprogramado');


  			$('#Modal_addCita').modal();
  		}).fail(function(error){
  			swal("error",'No se puede obtener los datos','error');
  		});
  	}
	//==========================================================

	function deshabilitar(id){
		swal({
			title: "Estas segur@?",
			text: "Desabilitara/habilitara el Cita "+id,
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
            if (willDelete) {

                $.post('../../Backend/Controller.php',{
                    request:'Listar',
                    tabla:'Cita_Cancelada',
                    id:id
                }).done(function(response){
                    swal({
                        title: "Éxito",
                        text: "Se Cancelo la Cita.",
                        icon: "success",
                    }).then((seguro) => {

                        cargar('AdminCitas2','adm/Citas.php','Controller')
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
		$("#btnguardar").attr("disabled","");
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
					$("#btnguardar").removeAttr("disabled");
				}else{
					$('#Modal_addCita').modal('hide');
					swal({
						title: "Éxito",
						text: "Se guardo el Cita.",
						icon: "success",
					}).then((seguro) => {

                        cargar('AdminCitas2','adm/Citas.php','Controller')
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