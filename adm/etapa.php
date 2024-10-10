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
        <script src="https://unpkg.com/gojs@3.0.11/release/go.js"></script>


<div class="container">
	<div class="row">
			<div class="col-12 card table-responsive">
				<button class="btn btn-primary" onclick="Agregar()" id="btnAgregar"><span class="fas fa-plus"></span> Agregar</button>
				<h3>Administrar Etapa</h3>
				<table class="table" id="listado">
					<thead  style="text-align:center;">
						<tr>	
							<th>Administrar</th>
							<th>Nombre</th>
                            <th>Etapa Siguiente</th>
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
                            if ($value->{'etapa_sig'} != null) {
                                $etapa = array(json_decode($value->{'etapa_sig'}, true));

                            }else{
                                $etapa=[];
                            }

                            /*var_dump($value->{'etapa_sig'});
                            echo "<br>";
                            var_dump($etapa);
                            echo "<br><br>";*/
                            $etapas="";

                            for ($j = 0; $j < count($etapa); $j++) {

                                if ($etapa[$j]!=null) {
                                    for ($k = 0; $k <count($etapa[$j]) ; $k++) {
                                        if ($k>0) {
                                            $etapas=$etapas."<br>";
                                        }
                                        $etapas=$etapas.$etapa[$j][$k]['nombre'];
                                    }
                                }

                            }

                            echo '<tr  style="'.$bgcolor.'">
									<td style="text-align:center;">
										<div class="btn-group">
										
											<button title="'.$titleestado.' Etapa" class="btn btn-'.$colestado.'" onclick="desactivar('.$value->{'id'}.')" > <span class="fas fa-'.$estado.'"></span></button>
											<button title="Editar Etapa" class="btn btn-warning" onclick="edita('.$value->{'id'}.')" > <span class="fas fa-pen"></span></button>
											
										</div>
									</td>
									<td>'.$value->{'nombre'}.'</td>
									<td>'.$etapas.'</td>
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

                <div id="DiagrEtapa" class="p-4 w-full" style="width: 100%; height: 500px">

			</div>
		</div>		
</div>
	<script type="text/javascript">
		function Agregar(){
			$("#Modal_titulo_addEtapa").html("Agregar Etapa");
			$('#Modal_addEtapa').modal();
            document.getElementById("Agregar").reset();

		}
	</script>
	<div class="modal fade" id="Modal_addEtapa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal_titulo_addEtapa">Agregar Etapa</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Modal_body_addEtapa">
        	<form id="Agregar">
        		<input type="hidden" name="request" value="CrearEtapa">
        		<input type="hidden" name="id" id="codigo" >

        		<div class="row">
        		
        			<div class="col-lg-12">
        				<label class="h5">Nombre: </label>
        				<input type="text" class="form-control" name="nombre" id="nombre" required="">
        			</div>
                    <div class="col-lg-12">
                        <label class="h5">Etapa siguiente: </label>
                        <select class="form-control" style="width: 100%;"  name="etapa_sig[]" id="etapa_sig"  multiple>
                            <?php
                            foreach ($dato as $key => $value) {
                                echo '<option value="'.$value->{'id'}.'">'.$value->{'nombre'}.'</option>';
                            }
                            ?>
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

			$("#Modal_titulo_addEtapa").html("Modificar Etapa");
		$.post('Backend/Controller.php',{
            request:'Listar',
            tabla:'getEtapa',
            id:id

	    }).done(function(response){

                $('#codigo').val(response.data[0].id);
				$('#nombre').val(response.data[0].nombre);
                $('#estado').val(response.data[0].estado);

            var etapas=[];
            for (var i = 0; i < response.data.length; i++) {
                etapas.push(response.data[i].etapa_next);
            }
            console.log(etapas);
            $('#etapa_sig').val(etapas);



            $('#etapa_sig').trigger("change");


            $('#Modal_addEtapa').modal();
	    }).fail(function(error){
	            swal("error",'No se puede obtener los datos','error');
	    });
	}
    //==========================================================


    function desactivar(id){
        swal({
            title: "Estas segur@?",
            text: "Estas apunto de desactivar la Etapa!",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, estoy seguro!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $("#Modal_titulo_addEtapa").html("Desactivar Etapa");
                $.post('Backend/Controller.php', {
                    request: 'Listar',
                    tabla: 'getEtapa',
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

                    //$('#Modal_addEtapa').modal();

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
                  text: "No se guardo el Etapa, intentelo nuevamente.",
                  icon: "error"
              })
      }else{
      		$('#Modal_addEtapa').modal('hide');
          swal({
              title: "Éxito",
              text: "Se guardo el Etapa.",
              icon: "success",
          }).then((seguro) => {
              cargar('AdminEtapa','adm/Etapa.php','Controller')
          });
      }
          
      },
          error:function(XMLHttpRequest,textStatus, errorThrown){
          $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
          }
      })

   
});

	//==========================================================

    $(document).ready(function() {
        $("#etapa_sig").select2({
            dropdownParent: $("#Modal_body_addEtapa")

        });
    });


  </script>
<script type="text/javascript">

    myDiagram = new go.Diagram('DiagrEtapa', {
        'animationManager.initialAnimationStyle': go.AnimationStyle.None,
        InitialAnimationStarting: (e) => {
            var animation = e.subject.defaultAnimation;
            animation.easing = go.Animation.EaseOutExpo;
            animation.duration = 800;
            animation.add(e.diagram, 'scale', 0.3, 1);
            animation.add(e.diagram, 'opacity', 0, 1);
        },

        // have mouse wheel events zoom in and out instead of scroll up and down
        'toolManager.mouseWheelBehavior': go.WheelMode.Zoom,
        // support double-click in background creating a new node
        'clickCreatingTool.archetypeNodeData': { text: 'new node' },
        // enable undo & redo
        'undoManager.isEnabled': true
    });


    const colors = {
        pink: '#facbcb',
        blue: '#b7d8f7',
        green: '#b9e1c8',
        yellow: '#faeb98',
        background: '#e8e8e8'
    };
    const colorsDark = {
        green: '#3fab76',
        yellow: '#f4d90a',
        blue: '#0091ff',
        pink: '#e65257',
        background: '#161616'
    };

    function loadDiagr() {


        myDiagram.model = go.Model.fromJson(
            {
                "class": "go.GraphLinksModel",
                "nodeKeyProperty": "id",
                "nodeDataArray": [

                    <?php

                    foreach ($dato as $key => $value) {
                        if ($value->{'nombre'} == 'Inicio') {
                            echo '{"id":' . $value->{'id'} . ', "loc":"155 -150", "type":"Start", "text":"' . $value->{'nombre'} . '" },
                            ';
                        } elseif ($value->{'nombre'} == 'Fin' || $value->{'nombre'} == 'Completado' || $value->{'nombre'} == 'Cancelado') {
                            echo '{"id":' . $value->{'id'} . ', "type":"End", "text":"' . $value->{'nombre'} . '" },
                            ';
                        } else {
                            echo '{"id":' . $value->{'id'} . ', "loc":"155 200", "type":"Process", "text":"' . $value->{'nombre'} . '"},
                            ';
                        }

                    }
                    ?>

                ],
                "linkDataArray": [

                    <?php
                    foreach ($dato as $key => $value) {
                        $etapa_next = $value->{'etapa_sig'};

                        if ($value->{'etapa_sig'} != null) {
                            $etapa = array(json_decode($value->{'etapa_sig'}, true));

                        } else {
                            $etapa = [];
                        }

                        //var_dump($etapa);
                        //echo "<br><br>";
                        $etapas = "";

                        for ($j = 0; $j < count($etapa); $j++) {

                            for ($k = 0; $k < count($etapa[$j]); $k++) {

                                echo '{"from":' . $etapa[$j][$k]['id'] . ', "to":' . $etapa[$j][$k]['id_sig'] . ', "progress": true, "text": "' . $etapa[$j][$k]['texto'] . '" },
                                ';
                            }

                        }


                    }
                    ?>


                ]
            }
        );
        myDiagram.div.style.backgroundColor = colors.background;


        myDiagram.nodeTemplate = new go.Node('Auto', {
            isShadowed: true,
            shadowBlur: 0,
            shadowOffset: new go.Point(5, 5),
            shadowColor: 'black'
        })

            .add(
                new go.Shape('RoundedRectangle', {
                    strokeWidth: 1.5,
                    fill: colors.blue,
                    portId: '',
                    fromLinkable: false, fromLinkableSelfNode: false, fromLinkableDuplicates: false,
                    toLinkable: false, toLinkableSelfNode: false, toLinkableDuplicates: false,
                    cursor: 'pointer'
                })
                    .bind('fill', 'type', (type) => {
                        if (type === 'Start') return colors.green;
                        if (type === 'End') return colors.pink;
                        return colors.blue;
                    })
                    .bind('figure', 'type', (type) => {
                        if (type === 'Start' || type === 'End') return 'Circle';
                        return 'RoundedRectangle';
                    }),
                new go.TextBlock({
                    font: 'bold small-caps 11pt helvetica, bold arial, sans-serif',
                    shadowVisible: false,
                    margin: 8,
                    font: 'bold 14px sans-serif',
                    stroke: '#333'
                }).bind('text')
            );





        // replace the default Link template in the linkTemplateMap
        myDiagram.linkTemplate = new go.Link({
            // shadow options are for the label, not the link itself
            isShadowed: true,
            shadowBlur: 0,
            shadowColor: 'black',
            shadowOffset: new go.Point(2.5, 2.5),

            curve: go.Curve.Bezier,
            curviness: 40,
            adjusting: go.LinkAdjusting.Stretch,
            reshapable: true,
            relinkableFrom: true,
            relinkableTo: true,
            fromShortLength: 8,
            toShortLength: 10
        })
            .bindTwoWay('points')
            .bind('curviness')
            .add(
                // Main shape geometry
                new go.Shape({ strokeWidth: 2, shadowVisible: false, stroke: 'black' })
                    .bind('strokeDashArray', 'progress', (progress) => (progress ? [] : [5, 6]))
                    .bind('opacity', 'progress', (progress) => (progress ? 1 : 0.5)),
                // Arrowheads
                new go.Shape({ fromArrow: 'circle', strokeWidth: 1.5, fill: 'white' }).bind('opacity', 'progress', (progress) => (progress ? 1 : 0.5)),
                new go.Shape({ toArrow: 'standard', stroke: null, scale: 1.5, fill: 'black' }).bind('opacity', 'progress', (progress) => (progress ? 1 : 0.5)),
                // The link label
                new go.Panel('Auto')
                    .add(
                        new go.Shape('RoundedRectangle', {
                            shadowVisible: true,
                            fill: colors.yellow,
                            strokeWidth: 0.5
                        }),
                        new go.TextBlock({
                            font: '9pt helvetica, arial, sans-serif',
                            margin: 1,
                            editable: true, // enable in-place editing
                            text: 'Action' // default text
                        }).bind('text')
                        // editing the text automatically updates the model data
                    )
            );




    }


    loadDiagr();
</script>







        <?php
	}
  }else{
        header("Location: login.php");
  }
?>