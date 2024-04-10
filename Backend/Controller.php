<?php
include 'Model.php';
class Controller extends db
{
    //----------------------------------------------------------------------------------------------------//
    //funcion para cambiar contraseña del usuario
    public function CambiarPassword($usuario,$clave)
    {
        
        $Data = db::CambiarPassword($usuario,$clave);
        return $Data;
    }
    //----------------------------------------------------------------------
    
    public function mantenimiento($tabla, $id = "")
    {
        $Data = db::Listar($tabla, $id);
        //var_dump($Data);
        return $Data;
    }

     //funcion para Ingresar al modulo 
    public function Ingresar($usuario,$clave)
    {
        
        $Data = db::Ingresar($usuario,$clave);
        return $Data;
    }


    //----------------------------------------------------------------------------------------
    public function CrearCita($id,$doctor,$paciente,$fecha,$Hora,$motivo,$estado,$nombre="",$telefono="",$correo="")
    {
        $Data = db::CrearCita($id,$doctor,$paciente,$fecha,$Hora,$motivo,$estado,$nombre,$telefono,$correo);
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado)
    {
        $Data = db::add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado)   ;
        return $Data;
    }



      //----------------------------------------------------------------------------------------
    public function CrearPaciente($id,$nombre,$apellido,$telefono,$correo,$fecha_nac,$nombre_emergencia,$telefono_emergencia,$sexo, $inventario)
    {
        $Data = db::CrearPaciente($id,$nombre,$apellido,$telefono,$correo,$fecha_nac,$nombre_emergencia,$telefono_emergencia,$sexo,$inventario);
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function CrearInventario($id,$nombre,$descripcion,$tipo, $estado)
    {
        $Data = db::CrearInventario($id,$nombre,$descripcion,$tipo, $estado);
        return $Data;
    }

      //----------------------------------------------------------------------------------------
    public function agregarAtendido($id, $id_paciente, $procedimiento,$atencionesdat,$agendar_cita, $doctor="", $motivo="", $fecha="", $Hora="")
    {
        $Data = db::agregarAtendido($id, $id_paciente, $procedimiento,$atencionesdat, $agendar_cita,  $doctor, $motivo, $fecha, $Hora);
        return $Data;
    }

      //----------------------------------------------------------------------------------------
    public function cancelarCitasAnteriores()
    {
        $Data = db::cancelarCitasAnteriores();
        return $Data;
    }
     //---------------------------------------------------------------------------------------

    public function ReporteCita($fechaI, $fechaF, $id_doc){
        $Data = db::ReporteCita($fechaI, $fechaF, $id_doc);
        return $Data;
    }

    //---------------------------------------------------------------------------------------

    public function ReporteFinanciero($fechaI, $fechaF, $id_doc){
        $Data = db::ReporteFinanciero($fechaI, $fechaF, $id_doc);
        return $Data;
    }
    //---------------------------------------------------------------------------------------

    public function ReporteHorarioSR($fechaI, $id_doc){
        $Data = db::ReporteHorarioSR($fechaI, $id_doc);
        return $Data;
    }
  

}


//======================================================================================================================================
if (isset($_POST['request'])) {
     header('Content-Type: application/json; charset=utf-8');
    $response = array(
        "status"  => "Error",
        "message" => "No hay una peticion valida",
        "data"    => null,
    );

    $Controller = new Controller();
    extract($_POST);

   

//-------------------------------------------------------------------------
     switch ($request) {
         
        case 'Listar':
           
            if (!isset($id)) {
                $id = '';
            }

            $Request = $Controller->mantenimiento($tabla, $id);

            if ($Request[0] == true) {
               
                $response['status']  = 'success';
                $response['message'] = $Request[1];
                $response['data']    = $Request[2];
                $response['tabla']    = $tabla;
                $response['id']=$id;
                //var_dump($Request[2]);
            } else {
                $response['status']  = 'error';
                $response['message'] = $Request[1];
                $response['data']    = $Request;
                $response['id']=$id;
            }

            echo json_encode($response);

            break;

        
          

        case 'CambiarContra':
            
            $Data = $Controller->CambiarPassword($usuario,$clave);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            
            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Su contraseña fue creada con exito","success"];
               
            }else{
                 $response['data'] =["Error",'al cambiar la contraseña, contacte a soporte',"error"];
            }
            echo json_encode($response);
            break;

         


 //------------------------------------------------------------------------------------------



case 'agregarAtendido':
            
            if(!isset($doctor)){ $doctor=""; }
            if(!isset($motivo)){ $motivo=""; }
            if(!isset($fecha)){  $fecha="";  }
            if(!isset($Hora)){   $Hora="";   }


            $Data = $Controller->agregarAtendido($id, $id_paciente, $procedimiento,$atencionesdat, $agendar_cita,  $doctor, $motivo, $fecha, $Hora);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            
            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el servicio exitosamente","success"];
               
            }else{
                 $response['data'] =["Error",'al guardar el servicio, contacte a soporte',"error"];
            }
            echo json_encode($response);
            break;

         //------------------------------------------------------------------------------------------



         case 'add_Usuario':

             if(!isset($pass)){ $pass="Contraseña encriptada"; }
             if(!isset($id)){ $motivo=0; }



             $Data = $Controller->add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado)   ;
             if ($Data[0] == true) {
                 $response['status'] = "success";
             } else {
                 $response['status'] = "Error";
             }
             $response['message'] = $Data[1];

             if ($Data[2]=='Exito') {
                 $response['data'] =["Exito","Se guardo el servicio exitosamente","success"];

             }else{
                 $response['data'] =["Error",'al guardar el servicio, contacte a soporte',"error"];
             }
             echo json_encode($response);
             break;

//------------------------------------------------------------------------------------------

case 'CrearCita':
            if (!isset($nombre)) { $nombre=""; }
            if (!isset($telefono)) { $telefono=""; }
            if (!isset($correo)) { $correo=""; }

            $Data = $Controller->CrearCita($id,$doctor,$paciente,$fecha,$Hora,$motivo,$estado,$nombre,$telefono,$correo);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            
            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo la cita exitosamente","success"];
               
            }else{
                 $response['data'] =["Error",$Data[0][1],"error"];
            }
            echo json_encode($response);
            break;
//------------------------------------------------------------------------------------------

        case 'cancelarCitasAnteriores':
            
            $Data = $Controller->cancelarCitasAnteriores();
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            
            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se cancelaron las citas exitosamente","success"];
               
            }else{
                 $response['data'] =["Error",'al cancelar las citas, contacte a soporte',"error"];
            }
            echo json_encode($response);
            break;


//------------------------------------------------------------------------------------------

case 'CrearPaciente':
            
            $Data = $Controller->CrearPaciente($id,$nombre,$apellido,$telefono,$correo,$fecha_nac,$nombre_emergencia,$telefono_emergencia,$sexo,$inventariodata);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            
            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el servicio exitosamente","success"];

            }else{
                 $response['data'] =["Error",'al guardar el servicio, contacte a soporte',"error",$Data];
            }
            echo json_encode($response);
            break;

//------------------------------------------------------------------------------------------

        case 'CrearInventario':

            $Data = $Controller->CrearInventario($id,$nombre,$descripcion,$tipo, $estado);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el servicio exitosamente","success"];

            }else{
                $response['data'] =["Error",'al guardar el servicio, contacte a soporte',"error",$Data];
            }
            echo json_encode($response);
            break;



 //------------------------------------------------------------------------------------------ 
        case 'inicio':
            
            $Data = '';

            $citas=$Controller->mantenimiento('citas2dias','');
            $citasmes=$Controller->mantenimiento('citasmes','');
            $citasgrafico=$Controller->mantenimiento('citas1anio','');
            $medioscitas=$Controller->mantenimiento('medioscitas','');
            
            
            


            if ($citas[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
                $response['message'] = $citas[1];
            
             if ($citas[0] == true) {
               
                $response['status']  = 'success';
                $response['message'] = $citas[1];
                $response['data']    = $citasmes[2];
                $response['citas']    = $citas[2];
                $response['citasgrafico']=$citasgrafico[2];
                $response['medioscitas']=$medioscitas[2];
                
                
                
                //var_dump($Request[2]);
            } else {
                $response['status']  = 'error';
                $response['message'] = $citas[1];
                $response['data']    = $citas;
            }

            echo json_encode($response);
            break;

        case 'Ingresar':
            $Data = $Controller->Ingresar($usuario,$clave);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[1];
            if ($Data[2]=='Acceso Permitido') {
                $response['data'] =["Exito","Bienvenido ".$_SESSION['admin']['Nombre'],"success"];
               
            }else{
                 $response['data'] =["Error",$Data[1],"error"];
            }
            echo json_encode($response);
            break;
        
        
            
             //-------------------------------------------------------------------------
        





        default:
            echo json_encode($response);
            break;
    }

}
