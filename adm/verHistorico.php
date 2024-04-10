<?php
    if(!isset($_SESSION)){
        session_start();
    }


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
        include "../Backend/Controller.php";
        $conn=new Controller();
        extract($_POST);

        $result=$conn->mantenimiento('VerHistorialUnico',$id);

        $dato=$result[2];
     ?>
        <div class="table-responsive-lg">
        <div class="row">
            <div class="col-lg-12 col-sm-12 card table-responsive">
                <h3 class="text-center"><b>Historico cita paciente <?= $dato[0]['nombre'] ?></b></h3>
            </div>
            <br>
            <div class="col-lg-12 col-sm-12 card mt-3">
                <div onclick="activarPersonales()"><h3>Datos Personales:  <span id="Barrapersonales" class="fas fa-angle-down"></span></h3></div>
                <div id="Personales" >
                    Nombre: <b><?=$dato[0]['nombre']  ?></b><br>
                    <?php
                    if ($_SESSION['admin']['id']!=4) {
                        ?>
                        Telefono: <b><?= substr(base64_decode($dato[0]['telefono']),5)  ?></b><br>
                        Correo: <b><?=substr(base64_decode($dato[0]['correo']),5)   ?></b><br>
                        <?php
                    }
                    ?>
                    Fecha de Nacimiento: <b><?=date("d/m/Y",strtotime($dato[0]['fecha_nac']))  ?></b><br>
                    Nombre en caso de Emergencia: <b><?=$dato[0]['telefono_emergencia']  ?></b><br>
                    Telefono en caso de Emergencia: <b><?=$dato[0]['nombre_emergencia']  ?></b><br>

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
                        $evo=explode(";", $dato[0]['historial']);

                        if ($dato[0]['historial']!=NULL) {


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


        <?php
    }

?>