
<?php

  $fecha=$_GET['fecha'];
   $id_doc=$_GET['id_doc'];
  include '../Backend/ConexionClass.php';
  class db extends ConexionDB
{
  //----------------------------------------------------------------------------------------------------//
    public function manteminientos($tabla, $id = "", $id2 = "")
    {

        switch ($tabla) {
//----------------------------------------------------------------------------------------------------------------------------------------//
            case 'citasProximas':
                $sql = "SELECT * FROM citas ci  WHERE estado!='Cancelado' and fecha_cita >='".$_GET['fecha']."' and id_doctor='".$_GET['id_doc']."' order by fecha_cita asc";
                break;
            case 'HorasDisponibles':
                $sql = "SELECT fecha_cita,hora_inicio,hora_fin FROM citas WHERE  estado!='Cancelado' and fecha_cita>='".$_GET['fecha']."' and id_doctor='".$_GET['id_doc']."'  ORDER BY fecha_cita ASC, hora_inicio ASC, hora_fin ASC ";
                break;


            default:
                $sql = null;
                break;
        }

        try {
            $conexion  = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($sql);


            $sentencia->execute();

            $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return [true, "La consulta se ejecuto correctamente", $result];

        } catch (PDOException $e) {
            return [false, "Error en la consulta de datos", $e->getMessage()];
        }

    }

}

?>

    <style>
      
        #chart {
      max-width: 650px;
      margin: 35px auto;
    }
      
    </style>

    
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    

    

    
  </head>

  <body>
    <?php
    $vardb = new db();
    $citas=$vardb->manteminientos('citasProximas');
    $horario=$vardb->manteminientos('HorasDisponibles');

    $fecha='';
    $hora=strtotime('06:00');
    $horasdisponibles=$horario[2];

    if (count($citas[2])>0) {
      
    
    ?>
     <div id="chart"></div>

<h2>Horarios disponibles</h2>
<table class="table" id="table-horas">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Hora disponible</th>
      <th>Hora Fin</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    for ($i=0; $i <count($horasdisponibles) ; $i++) { 
      
      if ($fecha!=$horasdisponibles[$i]['fecha_cita']) {

          if ($hora>strtotime($horasdisponibles[$i]['hora_inicio'])) {
            echo "<tr>";
            echo "<td>".date("d/m/Y",strtotime($fecha))."</td>";
            echo "<td>".date("h:i a",($hora))."</td>";
            echo "<td>".date("h:i a",strtotime("19:00"))."</td>";
            echo "</tr>";
            
          }
          $hora=strtotime('07:00');
          
         
          if ($hora<strtotime($horasdisponibles[$i]['hora_inicio'])) {
            echo "<tr>";
            echo "<td>".date("d/m/Y",strtotime($horasdisponibles[$i]['fecha_cita']))."</td>";
            echo "<td>".date("h:i a",$hora)."</td>";
            echo "<td>".date("h:i a",strtotime($horasdisponibles[$i]['hora_inicio']))."</td>";
            echo "</tr>";
          }
          
      }else{
       
        if ($hora<strtotime($horasdisponibles[$i]['hora_inicio'])) {
          echo "<tr>";
            echo "<td>".date("d/m/Y",strtotime($horasdisponibles[$i]['fecha_cita']))."</td>";
            echo "<td>".date("h:i a",$hora)."</td>";
            echo "<td>".date("h:i a",strtotime($horasdisponibles[$i]['hora_inicio']))."</td>";
            echo "</tr>";
          }

           if ($hora>strtotime($horasdisponibles[$i]['hora_fin'])) {
            echo "<tr>";
            echo "<td>".date("d/m/Y",strtotime($horasdisponibles[$i]['fecha_cita']))."</td>";
            echo "<td>".date("h:i a",strtotime($horasdisponibles[$i]['hora_inicio']))."</td>";
            echo "<td>".date("h:i a",$hora)."</td>";
            echo "</tr>";
          }
      }
      $hora=strtotime($horasdisponibles[$i]['hora_fin']);
      $fecha=$horasdisponibles[$i]['fecha_cita'];
      
    }

     ?>
  </tbody>
</table>



    <script>
      
        var options = {
          tooltip: {
            x: {
              format: "hh:mm tt"
            }
          },
          series: [
          {
            name:'Citas',
            data: [
              <?php
              foreach ($citas[2] as $key => $value) {
                
              
              ?>
              {
                x: '<?= $value['fecha_cita'] ?>',
                y: [
                  new Date('<?= date("Y-m-d") ?>T<?= $value['hora_inicio'] ?>').getTime(),
                  new Date('<?= date("Y-m-d") ?>T<?= $value['hora_fin'] ?>').getTime()
                ]
              },
              <?php
              }
              ?>
            ]
          }
        ],
        fill: {
          colors: ['#0FC0C9', '#DD4578', '#F4B619']
        },
          chart: {
          height: 350,
          type: 'rangeBar'
        },
        plotOptions: {
          bar: {
            horizontal: true
          }
        },
        xaxis: {
                type: 'datetime',
                labels: {
                  datetimeUTC: false,
                  datetimeFormatter: {
                    year: 'yyyy',
                    month: 'MMM \'yy',
                    day: 'dd MMM',
                    hour: 'hh:mm tt'
                  }
                }
            }
        };

        setTimeout(function(){ 
          var chart = new ApexCharts(document.querySelector("#chart"), options); 
          chart.render();
        }, 500);
        
        
      
      $('#table-horas').DataTable({"language": {
                "url": "js/Spanish.json"
              },


              "lengthMenu": [ 10, 40, 100 ]         ,
              "sDom": "<'dt-panelmenu clearfix'Bfl>tr<'dt-panelfooter clearfix'ip>",
            "dom": "Bfltip",
             "aaSorting":false,

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
                    }
                    

                    ]
              });
    </script>

    <?php
    }else{
      echo '<div class="alert alert-danger">No hay citas programadas </div> ';
    }
    ?>
  </body>