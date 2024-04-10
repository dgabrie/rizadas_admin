
<?php
include "ConexionClass.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;



class db extends ConexionDB
{




    protected function envioCorreo ($fecha,$nombre,$telefono,$correo,$HoraInicio,$estado){

        require '../vendor/autoload.php';


        try {
         $mail = new PHPMailer;
         $mail->isSMTP();
         $mail->CharSet = 'UTF-8';
         $mail->Host = 'smtp.titan.com';
         $mail->Port = 587;
            $mail->SMTPAuth = true;                                // Enable SMTP authentication

            $mail->Username   = 'notificaciones@cdgabrie.com';                     // SMTP username
            $mail->Password   = 'Clinica##2021';                               // SMTP password
            
                                            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('notificaciones@cdgabrie.com');
            $mail->addAddress('ggabrie@cdgabrie.com');
            $mail->addAddress('navila@cdgabrie.com');

                // Add a recipient
            $mail->isHTML(true);

            $ical_content = 'BEGIN:VCALENDAR
            PRODID:-//Microsoft Corporation//Outlook 16.0 MIMEDIR//EN
            VERSION:2.0
            METHOD:PUBLISH
            X-MS-OLK-FORCEINSPECTOROPEN:TRUE
            BEGIN:VTIMEZONE
            TZID:SA Pacific Standard Time
            BEGIN:STANDARD
            DTSTART:16010101T000000
            TZOFFSETFROM:-0500
            TZOFFSETTO:-0500
            END:STANDARD
            END:VTIMEZONE
            BEGIN:VEVENT
            CLASS:PUBLIC
            CREATED:'.date("Ymd").'T'.date('His').'
            DESCRIPTION:Cita paciente '.$nombre.'\n
            DTEND;TZID="America/Tegucigalpa Time":20191210T220000
            DTSTAMP:20191203T124654Z
            DTSTART;TZID="America/Tegucigalpa Time":20191210T150000
            LAST-MODIFIED:'.date("Ymd").'T'.date('His').'
            LOCATION:Metropolis
            PRIORITY:5
            SEQUENCE:0
            SUMMARY;LANGUAGE=es:Event
            TRANSP:OPAQUE
            UID:040000008200E00074C5B7101A82E00800000000A06260CDADA9D501000000000000000
            010000000FC95C5664F74B04B8AEB1601B7F04AD6
            X-ALT-DESC;FMTTYPE=text/html:<html xmlns:v="urn:schemas-microsoft-com:vml" 
            xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-mic
            rosoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/

            X-MICROSOFT-CDO-BUSYSTATUS:BUSY
            X-MICROSOFT-CDO-IMPORTANCE:1
            X-MICROSOFT-DISALLOW-COUNTER:FALSE
            X-MS-OLK-AUTOFILLLOCATION:FALSE
            X-MS-OLK-CONFTYPE:0
            BEGIN:VALARM
            TRIGGER:-PT15M
            ACTION:DISPLAY
            DESCRIPTION:Reminder
            END:VALARM
            END:VEVENT
            END:VCALENDAR';


            $Body= ' 
            <html lang="es" title="correo">
                
            <head>
            
            <meta charset="UTF-8">
            <title>correo</title>
            </head> 
            <body>
            <div style="border: 1px solid black; padding: 15px;">
            <img src="https://cdgabrie.com/img/index/logo_limpio_xs.png" style="width: 150px; height: auto;" alt="">
            <h3>Se ' .$estado.' una nueva cita para fecha: '.date('d/m/Y',strtotime($fecha)).'</h3>

            <table style="border: 1px solid black;">

            <tr>
            <td  style="border: 1px solid black;">Nombre: </td>
            <td  style="border: 1px solid black;"><b>'.$nombre.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Telefono: </td>
            <td  style="border: 1px solid black;"><b>'.$telefono.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">correo: </td>
            <td  style="border: 1px solid black;"><b>'.$correo.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Fecha de Cita: </td>
            <td  style="border: 1px solid black;">'.date("d/m/Y",strtotime($fecha)).'</td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Hora de Cita: </td>
            <td  style="border: 1px solid black;">'.date("H:i:s",strtotime($HoraInicio)).'</td>
            </tr>
            </table>

            <h3>Para mas informacion, favor ingrese a <a href="https://cdgabrie.com/admin">cdgabrie.com</a> en la seccion CITAS</h3>
            </div>


            </body>
            </html>';

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Se ".$estado." una nueva cita | Clinica Dental Gabrie";
            $mail->Body    = $Body;
            //$mail->addStringAttachment($ical_content,'ical.ics','base64','text/calendar');
            $mail->send();
            return [TRUE,"Se creo la cita correctamente!",'Exito'];
        } catch (Exception $e) {
           return [FALSE,"Se creo la cita, pero problema con el correo ".$fecha,$e->errorInfo()];
       }
   }

   protected function envioCorreoPaciente ($fecha,$nombre,$telefono,$correo,$HoraInicio){

    require '../vendor/autoload.php';
    if ($correo!='') {


        try {
         $mail = new PHPMailer;
         $mail->isSMTP();
         $mail->CharSet = 'UTF-8';
         $mail->Host = 'smtp.titan.com';
         $mail->Port = 587;
            $mail->SMTPAuth = true;                                // Enable SMTP authentication

            $mail->Username   = 'notificaciones@cdgabrie.com';                     // SMTP username
            $mail->Password   = 'Clinica##2021';                               // SMTP password
            
                                            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('notificaciones@cdgabrie.com');
            $mail->addAddress($correo); 
            

                // Add a recipient
            $mail->isHTML(true);

            $Body= ' 
            <html lang="es" title="correo">
                
            <head>
            <meta charset="UTF-8"><title>correo</title>
            </head> 
            <body>
            <div style="border: 1px solid black; padding: 15px;">
            <img src="https://cdgabrie.com/img/index/logo_limpio_xs.png" style="width: 150px; height: auto;" alt="">
            <h3>Se reservo una cita dental para fecha: ' .date('d/m/Y',strtotime($fecha)).'</h3>

            <table style="border: 1px solid black;">

            <tr>
            <td  style="border: 1px solid black;">Nombre: </td>
            <td  style="border: 1px solid black;"><b>'.$nombre.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Telefono: </td>
            <td  style="border: 1px solid black;"><b>'.$telefono.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">correo: </td>
            <td  style="border: 1px solid black;"><b>'.$correo.'</b></td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Fecha de Cita: </td>
            <td  style="border: 1px solid black;">'.date("d/m/Y",strtotime($fecha)).'</td>
            </tr>
            <tr>
            <td  style="border: 1px solid black;">Hora de inicio de Cita: </td>
            <td  style="border: 1px solid black;">'.date("H:i:s",strtotime($HoraInicio)).'</td>
            </tr>
            </table>

            <h3>Para mas informacion, enviar <a href="https://api.whatsapp.com/message/AYOWY63O3E2EI1">whatsapp</a></h3>
            <h4 style="text-align: center;">Gracias por confiar en nostros</h4>
            </div>


            </body>
            </html>';

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Se reservo una nueva cita a su nombre | Clinica Dental Gabrie";
            $mail->Body    = $Body;
            $mail->send();
            return [TRUE,"Se creo la cita correctamente!",'Exito'];
        } catch (Exception $e) {
           return [FALSE,"Se creo la cita, pero problema con el correo ".$fecha,$e->errorInfo()];
       }
        // code...
   }
}

    //------------------------------------------------------------------------------------------------------------------------------//
protected function CrearCita($id,$doctor,$paciente,$fecha,$Hora,$motivo,$estado,$nombre="",$telefono="",$correo=""){

    try{
        $querySelect="SELECT count(*) as cita FROM citas where id_paciente=? and estado IN ('Reservado','Reprogramado')";



        $conexion = ConexionDB::ConexionLocalPDO();


                if ($paciente=='New') {
                    $sqlInsert="INSERT into cit_pacientes(nombre,telefono,correo) values(?,?,?)";
                    $sentenciaInsert = $conexion->prepare($sqlInsert);
                    $sentenciaInsert->bindParam(1, $nombre);
                    $sentenciaInsert->bindParam(2, $telefono);
                    $sentenciaInsert->bindParam(3, $correo);

                    if($sentenciaInsert->execute()){
                        $sqlSelectPaciente="SELECT max(id) as id from cit_pacientes";

                        $sentenciaSelectPaciente = $conexion->prepare($sqlSelectPaciente);

                        if($sentenciaSelectPaciente->execute()){
                            $resultSelectPaciente = $sentenciaSelectPaciente->fetchAll(PDO::FETCH_ASSOC);
                            $paciente=$resultSelectPaciente[0]['id'];
                        }
                    }
                }
                
                if ($id!=0 || $id!='') {
                    $query = "UPDATE citas
                    set id_doctor=?,
                    id_paciente=?,
                    fecha_cita=?,
                    hora=?, 
                    motivo=?,
                    estado=?

                    WHERE id=?";
                }else{


                    $query="INSERT INTO citas (id_doctor,id_paciente,  fecha_cita,hora,motivo, estado) VALUES (?,?,?,?,?,?)";
                }


                try{


                    $sentencia = $conexion->prepare($query);
                    $sentencia->bindParam(1, $doctor);
                    $sentencia->bindParam(2, $paciente);
                    $sentencia->bindParam(3, $fecha);
                    $sentencia->bindParam(4, $Hora);
                    $sentencia->bindParam(5, $motivo);
                    $sentencia->bindParam(6, $estado);

                    if ($id!=0 || $id!='') {
                        $sentencia->bindParam(7, $id);
                    }

                    $sentenciaSelect = $conexion->prepare($querySelect);
                    $sentenciaSelect->bindParam(1, $paciente);
                    $sentenciaSelect->execute();
                    $resultSelect = $sentenciaSelect->fetchAll(PDO::FETCH_ASSOC);

                    //var_dump($resultSelect);
                    if($resultSelect[0]['cita']==0 || $id!=0 || $id!=''){
                        if($sentencia->execute()){
                            $estatus="";
                            if ($estado=='Cancelado') {
                                $estatus="cancelo";
                            }else if($estado=='Reservado'){
                                if ($correo=='' || $correo=='0' || $correo==null) {

                                }else{
                                    db::envioCorreoPaciente ($fecha,$nombre,$telefono,$correo,$Hora);
                                }
                                $estatus="reservo";

                             }else if ($estado=='Reprogramado') {
                                 $estatus="Reprogramado";
                             }
                             if ($estado!='NSP') {
                                 return db::envioCorreo ($fecha,$nombre,$telefono,$correo,$Hora, $estatus);
                             }else{
                               return [TRUE,"Se creo la cita correctamente!",'Exito'];
                                }

                       }else{
                            return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
                       }
                    }else{
                        return [FALSE,"No se guardo la cita porque el paciente ya tiene una cita programada",'Error'];
                    }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }


}



    //------------------------------------------------------------------------------------------------------------------------------//
protected function ReporteCita($fechaI, $fechaF, $id_doc)
{
        if ($_SESSION['admin']['id']==4) {
            $query = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, ct.*,
                        (select group_concat(i.nombre SEPARATOR ' | ') detalle FROM cita_detalle cd INNER JOIN cit_inventario i ON i.id=cd.id_inventario WHERE cd.id_cita=ct.id ) detalle
                        from citas ct 
                            INNER join cit_pacientes pa on pa.id=ct.id_paciente
                        WHERE id_doctor='".$id_doc."' and fecha_cita  between ? and ? and estado in ('Atendido')
                        order by fecha_cita asc, hora asc";
        }else{
            $query = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, ct.*,
                        (select group_concat(i.nombre SEPARATOR ' | ') detalle FROM cita_detalle cd INNER JOIN cit_inventario i ON i.id=cd.id_inventario WHERE cd.id_cita=ct.id ) detalle
                        from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente
                        WHERE  fecha_cita  between ? and ? and estado in ('Atendido')
                        order by fecha_cita asc, hora asc";
        }


    try{

        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        
        $sentencia->bindParam(1, $fechaI);
        $sentencia->bindParam(2, $fechaF);

        //var_dump($sentencia);
        if($sentencia->execute()){


             $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

              // var_dump($result);
               return [true, "La consulta se ejecuto correctamente ", $result];



        }else{
            return [FALSE,"Error al retornar los dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }


}

//------------------------------------------------------------------------------------------------------------------------------//
    protected function ReporteHorarioSR($fechaI,  $id_doc)
    {
        $query = "";

        $begin = new DateTime( $fechaI);

        if ($_SESSION['admin']['id']==4) {
            $query = null;
        }else{

                $query= "SELECT '".$begin->format("Y-m-d")."' fecha,hora
                     FROM citas a
                     LEFT JOIN cit_pacientes b ON a.id_paciente=b.id
                     WHERE a.fecha_cita IS NULL 
                     AND    hora not IN (SELECT hora FROM citas c WHERE  c.fecha_cita='".$begin->format("Y-m-d")."')
                     AND estado='Default'";



        }


        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);



            //var_dump($sentencia);
            if($sentencia->execute()){


                $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                // var_dump($result);
                return [true, "La consulta se ejecuto correctamente ", $result];



            }else{
                return [FALSE,"Error al retornar los dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }


    //------------------------------------------------------------------------------------------------------------------------------//
    protected function ReporteFinanciero($fechaI, $fechaF, $id_doc)
    {
        if ($_SESSION['admin']['id']==4) {
            $query = null;
        }else{
            $query = "SELECT ct.id AS id_cita,pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, 
 		   		   		   	concat(group_concat(CONCAT('| ',i.nombre,' | ',cd.cantidad,' | ',ifnull(cp.precio,(SELECT cp2.precio FROM cit_pac_precios cp2 WHERE cp2.id_inventario=cd.id_inventario AND cp2.id_paciente=0)*cantidad),' | ') SEPARATOR '<br>\r\n')) descripcion,
 		   		   		   	SUM(ifnull(cp.precio,(SELECT cp2.precio FROM cit_pac_precios cp2 WHERE cp2.id_inventario=cd.id_inventario AND cp2.id_paciente=0))*cd.cantidad) total,
ct.*
                        from citas ct 
								inner join cit_pacientes pa on pa.id=ct.id_paciente
								INNER JOIN cita_detalle cd ON cd.id_cita=ct.id
								INNER JOIN cit_inventario i ON i.id=cd.id_inventario									
								LEFT JOIN cit_pac_precios cp ON cp.id_paciente=ct.id_paciente AND cp.id_inventario=cd.id_inventario
                        WHERE  fecha_cita  BETWEEN ? AND ? and ct.estado in ('Atendido')
                        GROUP BY ct.id
                        order by fecha_cita asc, hora asc";
        }


        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);

            $sentencia->bindParam(1, $fechaI);
            $sentencia->bindParam(2, $fechaF);

            //var_dump($sentencia);
            if($sentencia->execute()){


                $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                // var_dump($result);
                return [true, "La consulta se ejecuto correctamente ", $result];



            }else{
                return [FALSE,"Error al retornar los dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }


protected function ACENTOS(){

   $conexion  = ConexionDB::ConexionLocalPDO();

   return $conexion;
}

    //---------------------------------------------------------------------------------//
protected function Listar($tabla, $id = "")
{

    for ($i=0; $i < count($_SESSION['admin']['Permisos']) ; $i++) {

        if ($_SESSION['admin']['Permisos'][$i]=='Citas') {
            $id_doc=4;
        }else{
            $id_doc=2;
        }

    }



    switch ($tabla) {
//----------------------------------------------------------------------------------------------//
//                                                                                              //
//                                        REGISTRO                                              //
//                                                                                              //
//----------------------------------------------------------------------------------------------//
        //------------------------------------------------------------------------------//
        case 'ListarUsuarios':
            $sql="SELECT * FROM usuarios";
            break;


        //------------------------------------------------------------------------------//
        case 'DelPrecios':
            $sql="DELETE from cit_pac_precios where id_paciente=".$id;
            break;

             //------------------------------------------------------------------------------//
        case 'AdminInventario':
        $sql = "SELECT * from cit_inventario";
        break;


                //------------------------------------------------------------------------------//
        case 'getInventario':
        $sql = "SELECT * from cit_inventario WHERE id=".$id;
        break;

        //------------------------------------------------------------------------------//
        case 'Cita_NSP':
            $sql = "UPDATE citas set estado='NSP' where id=".$id;
            break;

        //------------------------------------------------------------------------------//
        case 'Cita_Cancelada':
            $sql = "UPDATE citas set estado='Cancelada' where id=".$id;
            break;
                //------------------------------------------------------------------------------//
        case 'getHorario':
            $sql = "SELECT hora, concat(b.nombre,' ',b.apellido) paciente
                     FROM citas a
                     LEFT JOIN cit_pacientes b ON a.id_paciente=b.id
                     WHERE a.fecha_cita IS NULL 
                     AND    hora not IN (SELECT hora FROM citas c WHERE  c.fecha_cita='".$id."')
                     AND estado='Default'
                    union
                SELECT hora, concat(b.nombre,' ',b.apellido) paciente
                     FROM citas a
                     LEFT JOIN cit_pacientes b ON a.id_paciente=b.id
                     WHERE fecha_cita='".$id."'
                     and estado='Reservado'  
                    ORDER BY hora asc";
            break;

        //------------------------------------------------------------------------------//
        case 'getInventarioAct':
            $sql = "SELECT id as codigo,nombre as nombre, tipo from cit_inventario WHERE estado='Activo'";
        break;
        //------------------------------------------------------------------------------//
        case 'getInventarioAct2':
            $sql = "SELECT id as codigo,nombre, tipo from cit_inventario WHERE estado='Activo'";
            break;
            //------------------------------------------------------------------------------//
        case 'AdminClientes':
        $sql = "SELECT a.id, a.nombre, apellido, telefono, (select COUNT(c.id) from citas c where c.id_paciente=a.id and estado='Atendida') as citas
                ,(select COUNT(c.id) from citas c where c.id_paciente=a.id and estado='Reservado' and fecha_cita>NOW()) as citas_reserva
                from cit_pacientes a
                order by id desc";
        break;

            //------------------------------------------------------------------------------//
        case 'getCliente':

        $sql = "SELECT a.*,
                GROUP_CONCAT(CONCAT(i.id,'|',i.nombre,'|', b.precio) SEPARATOR ';') AS inventario
                from cit_pacientes a
                left JOIN cit_pac_precios b ON a.id=b.id_paciente
                LEFT JOIN cit_inventario i ON i.id=b.id_inventario where a.id=? order by tipo desc";
        break;




//------------------------------------------------------------------------------//
        case 'ReporteFinanciero':
            $sql =null;
            break;

 //------------------------------------------------------------------------------//
        case 'ReporteCitas':
            $sql =null;
           /* if ($_SESSION['admin']['id']==4) {
                $sql = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, ct.*
                        from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente
                        WHERE id_doctor='" . $id_doc . "' and fecha_cita is not null and estado in ('Atendido')
                        order by fecha_cita asc, hora asc";
            }else{
                $sql = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, ct.*
                        from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente
                        WHERE fecha_cita is not null and estado in ('Atendido')
                        order by fecha_cita asc, hora asc";
            }*/

        break;


 //------------------------------------------------------------------------------//
        case 'AdminCitas':
            $sql = "SELECT pa.id as paciente,pa.nombre,pa.telefono, pa.correo, ct.* from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente WHERE estado in ('Reservado','Reprogramado') and fecha_cita>='".date("Y-m-d")."' and id_doctor=2 order by fecha_cita asc, hora asc";
        break;


        case 'AdminCitas2':
            $sql = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo, ct.* from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente WHERE estado in ('Reservado','Reprogramado') and fecha_cita>='".date("Y-m-d")."' and id_doctor=4  order by fecha_cita asc, hora asc";
        break;

        case 'getPacientes':
             $sql = "SELECT * from cit_pacientes where id>0";
        break;


//------------------------------------------------------------------------------//
        case 'getCita':
        $sql = "SELECT pa.id as paciente,pa.nombre,pa.telefono, pa.correo, ct.* from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente WHERE ct.id=".$id;
        break;

 //------------------------------------------------------------------------------//
        case 'AtenderCitas':
        if ($_SESSION['admin']['id']==4){
            $sql = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,(SELECT count(*) from citas cta where cta.id_paciente=ct.id_paciente AND estado='Atendido') as citas_At,  ct.* 
                from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente 
                WHERE estado in ('Reservado','Reprogramado') AND ct.id_doctor='".$_SESSION['admin']['id']."'
                order by fecha_cita asc, hora asc";
        }else if ($_SESSION['admin']['id']==1 || $_SESSION['admin']['id']==2 || $_SESSION['admin']['id']==3){
            $sql = "SELECT pa.id as paciente,concat(pa.nombre,' ',apellido) nombre,pa.telefono, pa.correo,(SELECT count(*) from citas cta where cta.id_paciente=ct.id_paciente AND estado='Atendido') as citas_At,  ct.* 
                from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente 
                WHERE estado in ('Reservado','Reprogramado')
                order by fecha_cita asc, hora asc";
        }

        break;




//------------------------------------------------------------------------------//
        case 'AtenderPaciente':
        $sql = "SELECT 
                IFNULL(
                        (SELECT concat(i.id,'|', i.nombre,'|',i.tipo) FROM cit_inventario i INNER JOIN cit_pac_precios p ON p.id_inventario=i.id WHERE p.id_paciente=ct.id_paciente AND i.tipo='Cita Mensual' LIMIT 1),
                        (SELECT concat(i.id,'|', i.nombre,'|',i.tipo)  FROM cit_inventario i INNER JOIN cit_pac_precios p ON p.id_inventario=i.id WHERE p.id_paciente=0 AND i.tipo='Cita Mensual' LIMIT 1)
                ) AS Cita_Mensual,
                pa.id paciente,concat(pa.nombre,' ',apellido) nombre,TO_BASE64(concat('conca',pa.telefono)) telefono, TO_BASE64(concat('conca',pa.correo)) correo,pa.nombre_emergencia, pa.telefono_emergencia,  pa.fecha_nac , ct.*,
                (SELECT GROUP_CONCAT(CONCAT(ct2.fecha_cita,'|',ct2.procedimiento,'|',ct2.motivo) SEPARATOR ';') historial FROM citas ct2 WHERE ct.id_paciente=ct2.id_paciente AND ct2.estado='Atendido' order by fecha_cita desc limit 5) historial
                from citas ct 
                inner join cit_pacientes pa on pa.id=ct.id_paciente         
                  WHERE ct.id=".$id;
        break;



//------------------------------------------------------------------------------//
        case 'getAtenderCita':
        $sql = "SELECT pa.id as paciente,pa.nombre,pa.telefono, pa.correo, ct.* from citas ct inner join cit_pacientes pa on pa.id=ct.id_paciente WHERE id=".$id;
        break;
//------------------------------------------------------------------------------//

        case 'citas2dias':
        if ($id_doc==4){
            $sql="SELECT 'Hoy' AS 'dia',COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita=CURDATE() AND hour(hora)>=".date('H')." and id_doctor='".$id_doc."' and estado in ('Reservado','Reprogramado') union
            SELECT 'Mañana' AS 'dia',COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita=(CURDATE() + INTERVAL 1 day)  and id_doctor='".$id_doc."' and estado in ('Reservado','Reprogramado')";
        }else{
            $sql="SELECT 'Hoy' AS 'dia',COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita=CURDATE() AND hour(hora)>=".date('H')." and estado in ('Reservado','Reprogramado') union
            SELECT 'Mañana' AS 'dia',COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita=(CURDATE() + INTERVAL 1 day)   and estado in ('Reservado','Reprogramado')";
        }
        break;

        case 'citasmes':
            if ($id_doc==4) {
                $sql = "SELECT estado,COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita >= DATE_ADD(CURDATE(), INTERVAL - DAY(CURDATE())+1 DAY)  and id_doctor='" . $id_doc . "' GROUP BY estado";
            }else{
                $sql = "SELECT estado,COUNT(*) AS 'Conteo' FROM citas cit WHERE cit.fecha_cita >= DATE_ADD(CURDATE(), INTERVAL - DAY(CURDATE())+1 DAY)   GROUP BY estado";
            }
        break;

        case 'citas1anio':
            if ($id_doc==4) {
                $sql = "SELECT 
                        MONTH(fecha_cita) as mes,YEAR(fecha_cita) as año,COUNT(*) as citas,COUNT( case when estado='Atendido' then 1 END) AS atendido,COUNT( case when estado='Cancelado'  then 1  when estado='NSP' then 1 END) AS cancelada 
                        FROM citas 
                        WHERE fecha_cita >= DATE_ADD(CURDATE(), INTERVAL - 12 month) and id_doctor='" . $id_doc . "'
                        GROUP BY MONTH(fecha_cita),YEAR(fecha_cita)
                        order by fecha_cita asc";
            }else{
                $sql = "SELECT 
                        MONTH(fecha_cita) as mes,YEAR(fecha_cita) as año,COUNT(*) as citas,COUNT( case when estado='Atendido' then 1 END) AS atendido,COUNT( case when estado='Cancelado'  then 1  when estado='NSP' then 1 END) AS cancelada 
                        FROM citas 
                        WHERE fecha_cita >= DATE_ADD(CURDATE(), INTERVAL - 12 month) 
                        GROUP BY MONTH(fecha_cita),YEAR(fecha_cita)
                        order by fecha_cita asc";
            }
        break;

        case 'medioscitas':

            $sql = "SELECT estado, COUNT(*) conteo 
                    FROM citas AS ch 
                    WHERE fecha_cita BETWEEN cast(DATE_ADD(NOW(), INTERVAL - DAY(NOW()) DAY) AS DATE) and last_day(cast(NOW() AS DATE)) and estado!='Cancelada'
                    GROUP BY estado;";

        break;

        case 'VerHistorialTodos': 
        $sql="SELECT pa.id,concat(pa.nombre,' ', pa.apellido) nombre ,COUNT( case when estado='Atendido' then 1 END) AS citas, min(pa.fecha_creacion) AS fecha_creacion
        FROM cit_pacientes pa 
        LEFT JOIN citas cit ON cit.id_paciente=pa.id
        WHERE pa.id!=0 
        GROUP BY pa.id,pa.nombre 
        HAVING citas>0
        order by COUNT(cit.id) desc";
        break;


        case 'VerHistorialUnico':
            $sql = "SELECT 
                IFNULL(
                    (SELECT concat(i.id,'|', i.nombre,'|',i.tipo) FROM cit_inventario i INNER JOIN cit_pac_precios p ON p.id_inventario=i.id WHERE p.id_paciente=pa.id AND i.tipo='Cita Mensual' LIMIT 1),
                        (SELECT concat(i.id,'|', i.nombre,'|',i.tipo)  FROM cit_inventario i INNER JOIN cit_pac_precios p ON p.id_inventario=i.id WHERE p.id_paciente=0 AND i.tipo='Cita Mensual' LIMIT 1)
                ) AS Cita_Mensual,
                pa.id paciente,concat(pa.nombre,' ',apellido) nombre,TO_BASE64(concat('conca',pa.telefono)) telefono, TO_BASE64(concat('conca',pa.correo)) correo,pa.nombre_emergencia, pa.telefono_emergencia,  pa.fecha_nac , 
                (SELECT GROUP_CONCAT(CONCAT(ct2.fecha_cita,'|',ct2.procedimiento,'|',ct2.motivo) SEPARATOR ';') historial FROM citas ct2 WHERE pa.id=ct2.id_paciente AND ct2.estado='Atendido') historial
                from cit_pacientes pa 
                  WHERE pa.id=".$id;
            break;

//----------------------------------------------------------------------------------------------//
//                                                                                              //
//                                       FIN REGISTRO                                           //
//                                                                                              //
//----------------------------------------------------------------------------------------------//

        default:
        $sql = null;
        break;
    }

    try {
        $conexion  = db::ACENTOS();
        $sentencia = $conexion->prepare($sql);

        switch ($tabla){
            case 'getCliente':
                $sentencia->bindParam(1, $id);
                break;
        }


       $sentencia->execute();
       $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($sql);
       return [true, "La consulta de se ejecuto correctamente ".$id."-".$_SESSION['admin']['id'], $result];

   } catch (PDOException $e) {
    return [false, "Error en la consulta de datos", $e->getMessage()];
}

}



    //------------------------------------------------------------------------------------------------------------------------------//
    protected function CrearInventario($id,$nombre,$descripcion,$tipo, $estado)
    {
        if ($id!=0 || $id!='') {
            $query = "UPDATE cit_inventario
        set nombre=?,
            descripcion=?,
            tipo=?,
            estado=?
        WHERE id=?";
        }else{
            $query="INSERT INTO cit_inventario (nombre,descripcion,tipo, estado) VALUES (?,?,?,?)";
        }


        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $descripcion);
            $sentencia->bindParam(3, $tipo);
            $sentencia->bindParam(4, $estado);

            if ($id!=0 || $id!='') {
                $sentencia->bindParam(5, $id);
            }


            if($sentencia->execute()){


                return [TRUE,"Se guardo el registro con exito!","Exito"];


            }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[0],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }
    //------------------------------------------------------------------------------------------------------------------------------//
protected function CrearPaciente($id,$nombre,$apellido,$telefono,$correo,$fecha_nac,$nombre_emergencia,$telefono_emergencia,$sexo,$inventario)
{
    $bandera=0;
    $error="";
    $sqlReplace="REPLACE INTO cit_pac_precios (id_paciente, id_inventario, precio) values(?,?,?)";
    if ($id!=0 || $id!='') {
        $query = "UPDATE cit_pacientes
        set nombre=?,
            apellido=?,
            telefono=?,
            correo=?,
            fecha_nac=?,
            nombre_emergencia=?,
            telefono_emergencia=?,
            sexo=?
        WHERE id=?";
    }else{
        $query="INSERT INTO cit_pacientes (nombre,apellido,telefono,correo,fecha_nac,nombre_emergencia,telefono_emergencia,sexo) VALUES (?,?,?,?,?,?,?,?)";
    }


    try{

        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        $sentencia->bindParam(1, $nombre);
        $sentencia->bindParam(2, $apellido);
        $sentencia->bindParam(3, $telefono);
        $sentencia->bindParam(4, $correo);
        $sentencia->bindParam(5, $fecha_nac);
        $sentencia->bindParam(6, $nombre_emergencia);
        $sentencia->bindParam(7, $telefono_emergencia);
        $sentencia->bindParam(8, $sexo);

        

        if ($id!=0 || $id!='') {
            $sentencia->bindParam(9, $id);
        }


        if($sentencia->execute()){
            if ($id==0) {
                $id = $conexion->lastInsertId();
            }
            $this->Listar("DelPrecios",$id);

            $inventariodat=explode(";",$inventario);

            for ($i = 0; $i < count($inventariodat); $i++){
                $inventario2=explode("|",$inventariodat[$i]);
                //echo $inventario2[1];
                $sentencia2 = $conexion->prepare($sqlReplace);
                $sentencia2->bindParam(1, $id);
                $sentencia2->bindParam(2, $inventario2[0]);
                $sentencia2->bindParam(3, $inventario2[1]);

                if($sentencia2->execute()){

                }else{
                   $bandera++;
                   $error=$sentencia2->errorInfo()[0];
                }

            }
            if($bandera==0){
                return [TRUE,"Se guardo el registro con exito!","Exito"];
            }  else{
                return [FALSE,"Error al guardar el dato error 2:".$error ,$error];
            }



        }else{
            return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[0],$sentencia->errorInfo()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }


}


//------------------------------------------------------------------------------------------------------------------------------//
protected function cancelarCitasAnteriores()
{

 $query="UPDATE citas set
 estado='Cancelado'
 WHERE estado IN ('Reservado', 'Reprogramado') AND fecha_cita<=(CURDATE()- INTERVAL DAY(CURDATE()) DAY)";



 try{

    $conexion = ConexionDB::ConexionLocalPDO();
    $sentencia = $conexion->prepare($query);


    if($sentencia->execute()){

        return [TRUE,"Se cancelaron las citas con exito!","Exito"];


    }else{
        return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
    }
}catch(PDOException $e){
    return [FALSE,"Error al obtener los datos",$e->getMessage()];
}
}

//------------------------------------------------------------------------------------------------------------------------------//
    protected function CitaAtenciones($id_cita, $id_inventario, $cantidad)
    {

        $query="INSERT INTO cita_detalle (id_cita, id_inventario, cantidad) values(?, ?, ?)
     ";

        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $id_cita);
            $sentencia->bindParam(2, $id_inventario);
            $sentencia->bindParam(3, $cantidad);

            if($sentencia->execute()){
                return [TRUE,"Se guardo el registro con exito!","Exito"];
            }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }
    }

//------------------------------------------------------------------------------------------------------------------------------//
protected function agregarAtendido($id, $id_paciente, $procedimiento, $atencionesdat, $agendarCita, $doctorProx="", $motivoProx="", $fechaProx="", $HoraProx="")
{

     $query="UPDATE citas SET
                 procedimiento=?,
                 fecha_cita=date(NOW()),
                 estado='Atendido'
             where id=?
     ";

     try{

        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        $sentencia->bindParam(1, $procedimiento);
        $sentencia->bindParam(2, $id);

         $atenciond=explode(";", $atencionesdat);

        if($sentencia->execute()){

            for ($i = 0; $i < count($atenciond); $i++){
                $atencion_fil=explode("|",$atenciond[$i]);
                //var_dump($atencion_fil);
                $this->CitaAtenciones($id, $atencion_fil[0], $atencion_fil[1]);
            }

            if ($agendarCita=='Si'){
                $result=$this->CrearCita(0, 4, $id_paciente,  $fechaProx,  $HoraProx, $motivoProx,'Reservado');
                if ($result[0]==true){
                    return [TRUE,"Se guardo el registro con exito!","Exito"];
                }else{
                    return [TRUE,"Se guardo el registro con exito, sin embargo no se guardo la cita porque tiene citas pendientes!","Exito"];
                }
            }else{
                return [TRUE,"Se guardo el registro con exito!","Exito"];
            }
        }else{
            return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }
} 




//------------------------------------------------------------------------------------------------------------------------------//
protected function add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado){
    if ($id!=0 || $id!='') {
        if($pass=="Contraseña encriptada"){
            $query = "UPDATE usuarios
                        set nombre=?, 
                            usuario=?, 
                            correo=?,
                            permiso=?,
                            estado=?,
                            pass=pass
                        WHERE ID=?";
        }else{
            $pass=md5("clinica**".$pass);
            $query = "UPDATE usuarios
                        set nombre=?, 
                            usuario=?, 
                            correo=?,
                            permiso=?,
                            estado=?,
                            pass=?
                
                        WHERE ID=?";
        }

    }else{

        $pass=md5("clinica**".$pass);
        $query="INSERT INTO usuarios (nombre, usuario, correo, permiso, estado,pass) VALUES (?,?,?,?,?,?)";
    }


    try{

        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        $sentencia->bindParam(1, $nombre);
        $sentencia->bindParam(2, $usuario);
        $sentencia->bindParam(3, $correo);
        $sentencia->bindParam(4, $permiso);
        $sentencia->bindParam(5, $estado);


        if ($id!=0 || $id!='') {
            if($pass=="Contraseña encriptada") {

                $sentencia->bindParam(6, $id);
            }else{
                $sentencia->bindParam(6, $pass);
                $sentencia->bindParam(7, $id);
            }
        }else{
            $sentencia->bindParam(6, $pass);
        }


        if($sentencia->execute()){


            return [TRUE,"Se guardo el registro con exito!","Exito"];


        }else{
            return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }


}





    //------------------------------------------------------------------------------------------------------------------------------//
protected function CambiarPassword($usuario,$clave){


    $clav2="";
    $query = "UPDATE usuarios set pass=?, estado='y' where usuario=?";
    try{
        if ($clave=='') {
            $clav='';

        }else{
            $clav2=base64_decode($clave);
            $clav=md5("clinica**".$clav2);
        }
        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        $sentencia->bindParam(1, $clav);
        $sentencia->bindParam(2, $usuario);



        if($sentencia->execute()){


            return [TRUE,"Se cambio la contraseña con exito!","Exito"];


        }else{
            return [FALSE,"Error al obtener los datos",$sentencia->errorInfo()];
        }
    }catch(PDOException $e){
        return [FALSE,"Error al obtener los datos",$e->getMessage()];
    }
} 


//===================================================================================================================================================

protected function Ingresar($usuario,$clave){


    $query = "SELECT u.id AS codigo, usuario , nombre,  group_concat(permiso SEPARATOR '|') permiso
                FROM usuarios u
                INNER JOIN permisos_usuarios up ON u.id=up.id_usuario
                INNER JOIN permisos p ON p.id=up.id_permiso
                WHERE usuario=? AND pass=? and estado='y'
                GROUP BY u.id , usuario , nombre ";




    try{
        $conexion = ConexionDB::ConexionLocalPDO();
        $sentencia = $conexion->prepare($query);
        $clav=md5("clinica**".($clave));
        $sentencia->bindParam(1, $usuario);
        $sentencia->bindParam(2,  $clav);



        if($sentencia->execute()){
           $dato=$sentencia->fetchAll(PDO::FETCH_ASSOC);
           //var_dump($dato);
           if (count($dato)>0) {
            $permisos=explode("|", $dato[0]['permiso']);

            $_SESSION['admin']['usuario'] = $dato[0]['usuario'];
            $_SESSION['admin']['id']      = $dato[0]['codigo'];
            $_SESSION['admin']['Nombre']  = $dato[0]['nombre'];
            $_SESSION['admin']['Permisos']= $permisos;


            $token=rand();

            $_SESSION['admin']['token']  =$token;

            $query3="UPDATE usuarios SET token=? WHERE id=?";
            $sentencia3 = $conexion->prepare($query3);
            $sentencia3->bindParam(1, $token);
            $sentencia3->bindParam(2, $dato[0]['codigo']);
            $sentencia3->execute();



            return [TRUE,"Inicio de sesion exitoso!","Acceso Permitido"];


        }else{

            return [FALSE,"Contraseña o correo erroneo, intente nuevamente.","Acceso no permitido"];


        }

    }else{
        return [FALSE,"Error al obtener los datos en la sentencia",$sentencia->errorInfo()];
    }
}catch(PDOException $e){
    return [FALSE,"Error al obtener los datos en la bd",$e->getMessage()];
}
}

//===================================================================================================================================================

}
