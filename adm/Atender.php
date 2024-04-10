<?php
	session_start();

if (isset($_SESSION['admin']['usuario'])) {
$bandera=0;
for ($i=0; $i < count($_SESSION['admin']['Permisos']) ; $i++) { 
		
		if ($_SESSION['admin']['Permisos'][$i]=='Administrador' || $_SESSION['admin']['Permisos'][$i]=='Doctor' || $_SESSION['admin']['Permisos'][$i]=='Citas') {
			$bandera=1;

		}

}

	if ($bandera!=1) {

	
		?>
		<script type="text/javascript">
			swal("error","No tienes permisos para estar aqui","error").then((result) => {
				location.href="./";	
			});
			
		</script>

		<?php
	}else{

	 $datarespuesta=json_decode($_POST['response']);
	$dato=$datarespuesta->{'data'};

    $dataPrd1= explode("|",$dato[0]->{'Cita_Mensual'});



?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-sm-12 card table-responsive">
			<h3 class="text-center"><b>Atender cita paciente <?= $dato[0]->{'nombre'} ?></b></h3>
		</div>
		<br>
		<div class="col-lg-12 col-sm-12 card mt-3">
			<div onclick="activarPersonales()"><h3>Datos Personales:  <span id="Barrapersonales" class="fas fa-angle-down"></span></h3></div>
			<div id="Personales" >
				Nombre: <b><?=$dato[0]->{'nombre'}  ?></b><br>
				<?php
				if ($_SESSION['admin']['id']!=4) {
				?>
                    Telefono: <b><?= substr(base64_decode($dato[0]->{'telefono'}),5)  ?></b><br>
                    Correo: <b><?=substr(base64_decode($dato[0]->{'correo'}),5)   ?></b><br>
				<?php
				}
				?>
				Fecha de Nacimiento: <b><?=date("d/m/Y",strtotime($dato[0]->{'fecha_nac'}))  ?></b><br>
				Nombre en caso de Emergencia: <b><?=$dato[0]->{'telefono_emergencia'}  ?></b><br>
				Telefono en caso de Emergencia: <b><?=$dato[0]->{'nombre_emergencia'}  ?></b><br>
				
			</div>
		</div>


		<div class="col-lg-12 col-sm-12 card mt-6" style="margin-top:50px;">
			<div onclick="activarEvolucion()"><h3>Evolución del paciente  <span id="barraEvo" class="fas fa-angle-up"></span></h3></div>
					<div id="evolucion" class="table-responsive">
						<table class="table">
							<thead>
									<tr>
										<th>Fecha Cita</th>
										<th>Motivo</th>
										<th>Procedimiento realizado</th>
									</tr>
							</thead>
							<tbody>
								<?php
								$evo=explode(";", $dato[0]->{'historial'});
								
								if ($dato[0]->{'historial'}!=NULL) {
									
								
									foreach ($evo as $key => $value) {
										$tratamiento=explode("|", $value);
											?>
											<tr>
													<td nowrap=""><?= date("d/m/Y",strtotime($tratamiento[0])) ?></td>
													<td nowrap=""><?= $tratamiento[2] ?></td>
													<td ><?= $tratamiento[1] ?></td>
											</tr>
									<?php

									}
								}else{
									echo '<tr> <td colspan="6" class="text-center">No tiene citas atendidas</td></tr>';
								}
								?>
							</tbody>
						</table>

						


					</div>
		</div>
	</div>
		
	<br>
	<div class="card mt-3">
		<form id="Agregara">
			<input type="hidden" name="id" value="<?= $dato[0]->{'id'} ?>">
			<input type="hidden" name="request" value="agregarAtendido">
			<input type="hidden" name="id_paciente" value="<?= $dato[0]->{'paciente'} ?>">
            <input type="hidden" name="atencionesdat" id="atencionesdat">
            <h3>Citas:</h3>

            <label>Fecha:</label> <b><?= date("d/m/Y",strtotime($dato[0]->{'fecha_cita'})) ?></b>
            <br>
            <label>Motivo:</label> <b><?= $dato[0]->{'motivo'} ?></b>

            <br>
            <label>
				Procedimiento Realizado
			</label>
			<textarea name="procedimiento" class="form-control"></textarea>

			<br>
            <div class="btn-group">
                <button type="button" class="btn btn-warning" onclick="agregarFila('atenciones')"><i class="fas fa-plus"></i> Agregar</button>
                <button type="button" class="btn btn-danger" onclick="eliminarFila('atenciones')"><i class="fas fa-eraser"></i> Eliminar</button>
            </div>
            <table class="table table-responsive" >
                <thead>
                <tr>
                    <th>id</th>
                    <th style="text-align:center;">Producto</th>

                    <th colspan="3" style="text-align:center;">Cantidad</th>
                </tr>
                </thead>
                <tbody id="atenciones"></tbody>
            </table>

            <br>
            <h3>Agendar Cita:</h3>
            <select class="form-control" id="cmb_agendar_cita" name="agendar_cita" required>
                <option value=""></option>
                <option value="Si">Si</option>
                <option value="No">No</option>
            </select>
            <br>

            <div class="oculta" id="div_Prox_cita">
                <h3>Proxima Cita:</h3>
                <label class="h5">Nombre Doctor</label>
                <select class="form-control" id="doctor" name="doctor">
                    <option value="4">Ivonne </option>
                </select>
                <br>

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
            </div>
            <br>
            <br>
            <br>

			<button class="btn btn-success" id="btnguardar"><span class="fas fa-save"></span> Guardar</button>
		</form>
		
	</div>

</div>
<style type="text/css">
	.oculta{
		display: none;
	}
    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
    select[readonly]
    {
        pointer-events: none;
    }
</style>
    <script>
        $("#cmb_agendar_cita").on("change",function(){
            if ( $("#cmb_agendar_cita").val()=='Si'){
                $( "#div_Prox_cita").removeClass("oculta");
                $("#doctor").attr("required","required");
                $("#motivo").attr("required","required");
                $("#fecha").attr("required","required");
                $("#hora").attr("required","required");
            }else{
                $( "#div_Prox_cita").addClass("oculta");
                $("#doctor").removeAttr("required");
                $("#motivo").removeAttr("required");
                $("#fecha").removeAttr("required");
                $("#hora").removeAttr("required");
            }
        });
        //=============================================================================================================
        function cargado(){
            agregarFila('atenciones');
            $("#cmbProducto_atenciones_1").val(<?= $dataPrd1[0] ?>);
            $("#cantidad_atenciones_1").val(1);

            document.getElementById("cantidad_atenciones_1").setAttribute("readonly","readonly");
            document.getElementById("cmbProducto_atenciones_1").setAttribute("readonly","readonly");
            document.getElementById("Subir_Num_1").setAttribute("disabled","disabled");
            document.getElementById("Bajar_num_1").setAttribute("disabled","disabled");
        }
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
    </script>
<script type="text/javascript">

	//==========================================================
$('#Agregara').on("submit",function(e){
  
  e.preventDefault();
    document.getElementById("cmbProducto_atenciones_1").removeAttribute("disabled");


    var table = document.getElementById('atenciones');
    var rowCount = table.rows.length;
    var dataAtencion="";

    for (let i = 0; i < rowCount; i++) {
        if(i>0){
            dataAtencion=dataAtencion+";";
        }
        dataAtencion=dataAtencion+document.getElementById("cmbProducto_atenciones_"+(i+1)).value+"|"+$("#cantidad_atenciones_"+(i+1)).val();
    }
    $("#atencionesdat").val(dataAtencion);

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
              text: "Se atendió la Cita.",
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

   
})

//------------------------------------------------------------------------------




	function activarHistoria() {
		document.getElementById("historia").classList.toggle("oculta");
		document.getElementById("barra").classList.toggle("fa-angle-down");
		document.getElementById("barra").classList.toggle("fa-angle-up");
		
	}
	function activarPersonales() {
		document.getElementById("Personales").classList.toggle("oculta");
		document.getElementById("barrapersonales").classList.toggle("fa-angle-down");
		document.getElementById("barrapersonales").classList.toggle("fa-angle-up");
		
	}
	function activarExamen() {
		document.getElementById("odontograma").classList.toggle("oculta");
		document.getElementById("barraEx").classList.toggle("fa-angle-down");
		document.getElementById("barraEx").classList.toggle("fa-angle-up");
		
	}
	function activarEvolucion() {
		document.getElementById("evolucion").classList.toggle("oculta");
		document.getElementById("barraEvo").classList.toggle("fa-angle-down");
		document.getElementById("barraEx¿vo").classList.toggle("fa-angle-up");
		
	}
</script>
        <script>
            var tmpInventario=[];
            inicio();

            //----------------------------------------------------
            function eliminarFila(idtabla) {
                //agregarFila(idtabla);
                var table = document.getElementById(idtabla);
                var rowCount = table.rows.length;
                //console.log(rowCount);

                if (rowCount < 2) {
                    swal("Error", 'No se puede eliminar el encabezado', "error");
                }else{
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
                            '<select  class="form-control" onchange="buscarprd('+"'"+idtabla+"_"+rowCount+"'"+')""  id="cmbProducto_' + idtabla + '_' + rowCount + '" name="Producto_' + idtabla + '_' + rowCount+'"  required>' +
                            '<option value="" data-tipo="">Seleccione una opcion</option>';
                        for (let i = 0; i < tmpInventario.length ; i++) {
                            if (tmpInventario[i].tipo==="Cita Mensual"){
                                htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'" data-tipo="'+tmpInventario[i].tipo+'" disabled="disabled">'+tmpInventario[i].nombre+'</option>';
                            }else{
                                htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'" data-tipo="'+tmpInventario[i].tipo+'">'+tmpInventario[i].nombre+'</option>';
                            }

                        }


                        htmltd=htmltd+'</select>'+
                            '</td>'+
                            '<td style="text-align:center;">' +
                            '   <button class="btn btn-danger btn-circle" type="button" id="Bajar_num_'+rowCount+'" onclick="Bajar_num('+rowCount+')"><i class="fa fa-minus"></button>'+
                            '</td>' +
                            '<td>' +
                            '   <input type="number" min="1" class="form-control"  name="cantidad_' + idtabla + '_' + rowCount + '" id="cantidad_' + idtabla + '_' + rowCount + '"  required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                            '   <button class="btn btn-primary btn-circle" type="button" id="Subir_Num_'+rowCount+'" onclick="Subir_num('+rowCount+')"><i class="fa fa-plus"></button>'+
                            '</td>';
                        document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;
                    }else{
                        swal("Error", 'No se puede agregar una fila sin establecer la columna anterior', "error");
                    }

                }else{
                    var htmltd = '<td>' + rowCount + '</td>' +
                        '<td>' +
                        '<select  class="form-control" onchange="buscarprd('+"'"+idtabla+"_"+rowCount+"'"+')"  id="cmbProducto_' + idtabla + '_' + rowCount + '" name="Producto_' + idtabla + '_' + rowCount+'"  required>' +
                        '   <option value="" data-tipo="">Seleccione una opcion</option>';
                    for (let i = 0; i < tmpInventario.length ; i++) {
                        if (tmpInventario[i].tipo==="Cita Mensual"){
                            htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'" data-tipo="'+tmpInventario[i].tipo+'" disabled="disabled">'+tmpInventario[i].nombre+'</option>';
                        }else{
                            htmltd=htmltd+'<option value="'+tmpInventario[i].codigo+'" data-tipo="'+tmpInventario[i].tipo+'">'+tmpInventario[i].nombre+'</option>';
                        }
                    }


                    htmltd=htmltd+'</select>'+
                        '</td>'+
                        '<td style="text-align:center;">' +
                        '   <button class="btn btn-danger btn-circle" type="button" id="Bajar_num_'+rowCount+'" onclick="Bajar_num('+rowCount+')"><i class="fa fa-minus"></button>'+
                        '</td>' +
                        '<td>' +
                        '   <input type="number" min="1" class="form-control"  name="cantidad_' + idtabla + '_' + rowCount + '" id="cantidad_' + idtabla + '_' + rowCount + '"  required>' +
                        '</td>' +
                        '<td style="text-align:center;">' +
                        '   <button class="btn btn-primary btn-circle" type="button" id="Subir_Num_'+rowCount+'" onclick="Subir_num('+rowCount+')"><i class="fa fa-plus"></button>'+
                        '</td>';
                    document.getElementById(idtabla).insertRow(-1).innerHTML = htmltd;
                }



            }

            //============================================================================================================
            function buscarprd(rowCount){
                var selection = document.getElementById("cmbProducto_"+rowCount);

                selection.onchange = function(event){
                    var tipo = event.target.options[event.target.selectedIndex].dataset.tipo;
                    if(tipo=="Brackeo"){
                        document.getElementById("cantidad_"+rowCount).setAttribute("max",1);
                    }else if(tipo=="Otros"){
                        document.getElementById("cantidad_"+rowCount).setAttribute("max",26);
                    }else{
                        document.getElementById("cantidad_"+rowCount).removeAttribute("max");
                    }

                };
            }
            //============================================================================================================
            function Bajar_num(rowCount){
                var cantidad=$("#cantidad_atenciones_"+ rowCount).val();
                if(cantidad==""){
                    cantidad=1;
                }
                cantidad=parseInt(cantidad-1);
                $("#cantidad_atenciones_"+ rowCount).val(cantidad);
            }
            //============================================================================================================
            function Subir_num(rowCount){
                var cantidad= $("#cantidad_atenciones_"+ rowCount).val();
                if(cantidad==""){
                    cantidad=0;
                }
                cantidad=(parseInt(cantidad)+1);
                $("#cantidad_atenciones_"+ rowCount).val(cantidad);
            }

            //============================================================================================================

            function inicio(){
                $.post('../../Backend/Controller.php',{
                    request:'Listar',
                    tabla:'getInventarioAct2'
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

                for (let i = 1; i < rowCount; i++) {
                    table.deleteRow(0);
                }
            }


            setTimeout(function(){
                cargado();
                console.log('cargado');
            }, 1000);
        </script>


<?php
	}
}else{
    header("Location: login.php");
}
?>