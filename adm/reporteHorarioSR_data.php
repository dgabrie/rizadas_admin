<?php


	if (!isset($_POST)) {

	
		?>
		<script type="text/javascript">
			swal("error","No tienes permisos para estar aqui","error");
			location.href="./";
		</script>

		<?php
	}else{
		include "../Backend/Controller.php";
		$conn=new Controller();
		extract($_POST);

	if ($_SESSION['admin']['id']==4) {
        $id_doc=4;
    }else{
        $id_doc=0;
    }
		$result=$conn->ReporteHorarioSR($fechaI, $id_doc);
	
		$dato=$result[2];

	  //var_dump($result);

      if (count($dato)>0){
?>
<div class="container">
	<div class="row">
			<div class="col-12 card table-responsive">


				<h3>Citas sin reservar entre <?= date("d/m/Y", strtotime($fechaI)) ?> </h3>
                <table class="table" id="listado">
                    <thead  style="text-align:center;">
                    <tr>

                        <th>Fecha</th>
                        <th>Hora</th>


                    </tr>
                    </thead>
                    <tbody  style="text-align:center;">
                    <?php

                    foreach ($dato as $key => $value) {
                        echo '<tr>
									
									<td>'.date("d/m/y",strtotime($value['fecha'])).'</td>
                        
									<td>'.date("H:i",strtotime($value['hora'])).'</td>
									
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
	

  <style type="text/css">
  	@media print {
  		#accordionSidebar, #btnAgregar, .dt-buttons, .navbar, #listado_filter, .dataTables_length{
  			display: none;	
  		}

  	}
  </style>
  <script type="text/javascript">
  	function EnviarRecordatorio (telefono,nombre) {
  			if (telefono !='' && nombre !='') {
  				var pnombre=nombre.split(" ");
  				window.open("https://api.whatsapp.com/send?phone="+telefono+"&text=Buenas%20tardes%20"+pnombre[0]+"%20%2C%0ALe%20saludamos%20de%20CD%20Gabrie%20Centro%20Dental%2C%20comunicarle%20que%20han%20transcurrido%206%20meses%20de%20su%20última%20limpieza%20dental%20periódica.%0A%0APara%20continuar%20el%20cuidado%20de%20su%20salud%20dental%2C%20podemos%20agendarle%20su%20nueva%20cita%20e%20incluye%20su%20evaluación%20dental%20general.%0A¿Que%20día%20desea%20podamos%20programarle%20su%20limpieza%20dental%3F");
  			}
  	}


  	$("#HoraInicio").on("change",function(e){
  			$("#HoraFin").attr("min",e.target.value);
  	})

  	function wha (telefono,nombre,fecha,hora) {

  		if (telefono!='' && nombre!='' && fecha !='' && hora!='') {
  			var pnombre=nombre.split(" ");
  			window.open("https://api.whatsapp.com/send?phone="+telefono+"&text=Buenas%20tardes%20"+pnombre[0]+"%2C%20%0Aun%20gusto%20saludarle%20nuevamente%20le%20escribo%20para%20confirmarle%20y%20recordarle%20su%20cita%20para%20fecha%3A%20"+fecha+"%20a%20las%3A%20"+hora);
  		}else{
  			swal("Error","Ocurrio un problema con el envio de whatsapp", "error")
  		}
  	}



  	$('#listado').DataTable({"language": {
      					"url": "js/Spanish.json"
      				},


      				"lengthMenu": [ 20, 40, 100, 300 ] 				,
      				"order":[],
      				"sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
						"dom": "Bfltip",
						"columnDefs": [

            			        				],
        <?php
        if ($_SESSION['admin']['id']!=4) {
        ?>
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
        <?php
        }
        ?>
      				});

  	//==========================================================



  </script>
<?php
        }else{
          echo "No hay datos";
      }
    }
  
?>