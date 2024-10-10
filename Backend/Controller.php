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
    public function add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado)
    {
        $Data = db::add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado)   ;
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function AdicionalImagen($id, $imagenes, $tipo)
    {
        $Data = db::AdicionalImagen($id, $imagenes, $tipo);
        return $Data;
    }



    //----------------------------------------------------------------------------------------
    public function CrearProducto($id, $marca,$nombre, $subcategoria,$temporada,$estado, $adicionales, $imagenes, $tipo)
    {
        $Data = db::CrearProducto($id, $marca,$nombre, $subcategoria,$temporada,$estado, $adicionales, $imagenes, $tipo)   ;
        return $Data;
    }
    //----------------------------------------------------------------------------------------
    public function CrearCategoria($id, $nombre,$estado)
    {
        $Data = db::CrearCategoria($id, $nombre,$estado)   ;
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function CrearSubcategoria($id, $idcategoria, $nombre,$estado)
    {
        $Data = db::CrearSubcategoria($id, $idcategoria, $nombre,$estado);
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function CrearMarca($id, $nombre,$estado)
    {
        $Data = db::CrearMarca($id, $nombre,$estado)   ;
        return $Data;
    }

    //----------------------------------------------------------------------------------------
    public function CrearEtapa($id, $nombre,$etapa_sig,$estado)
    {
        $Data = db::CrearEtapa($id, $nombre,$etapa_sig,$estado)   ;
        return $Data;
    }
    //----------------------------------------------------------------------------------------
    public function AgregarInventario($producto, $cantidad,$precio_compra,$precio_venta, $fec_venc, $lote)
    {
        $Data = db::AgregarInventario($producto, $cantidad,$precio_compra,$precio_venta, $fec_venc, $lote);
        return $Data;
    }
    //----------------------------------------------------------------------------------------
    public function CrearTemporada($id, $nombre,$estado)
    {
        $Data = db::CrearTemporada($id, $nombre,$estado)   ;
        return $Data;
    }

    public function CrearPromocion(int $id, $nombre, $descripcion, $tipo_promo, array $tipo, $desc_envio, $desc_prod, $fecha_inicio, $fecha_fin, $estado)
    {
        $Data = db::CrearPromocion($id, $nombre, $descripcion, $tipo_promo, $tipo, $desc_envio, $desc_prod, $fecha_inicio, $fecha_fin, $estado);
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



         case 'add_Usuario':

             if(!isset($pass)){ $pass="Contraseña encriptada"; }
             if(!isset($id)){ $id=0; }
             if($id==""){ $id=0; }



             $Data = $Controller->add_Usuario($id, $nombre,$usuario,$pass,$correo,$permisos,$estado)   ;
             if ($Data[0] == true) {
                 $response['status'] = "success";
             } else {
                 $response['status'] = "Error";
             }
             $response['message'] = $Data[1];

             if ($Data[2]=='Exito') {
                 $response['data'] =["Exito","Se guardo el servicio exitosamente","success"];

             }else{
                 $response['data'] =["Error","al guardar el servicio, contacte a soporte ","error"];
             }
             echo json_encode($response);
             break;

//------------------------------------------------------------------------------------------
        case 'AgregarImagenProducto':



            if (isset($_FILES["imagenes_add"]["name"])) {
                $img=$_FILES["imagenes_add"]["name"];
            }else{
                $img=[];
                $imagenes=[];
                $tipo=[];
            }


            for ($i = 0; $i < count($img); $i++) {
                $imagenes[$i]=file_get_contents($_FILES["imagenes_add"]["tmp_name"][$i]);
                $tipo[$i]=$_FILES["imagenes_add"]['type'][$i];
            }



            $Data = $Controller->  AdicionalImagen($id, $imagenes, $tipo);

            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;

//------------------------------------------------------------------------------------------
         case 'CrearProducto':


             if(!isset($id)){ $id=0; }
             if($id==""){ $id=0; }
             if(!isset($temporada)){ $temporada=[]; }
             if($temporada==null){ $temporada=[]; }

             if (isset($_FILES["imagenes"]["name"])) {
                 $img=$_FILES["imagenes"]["name"];
             }else{
                    $img=[];
                    $imagenes=[];
                    $tipo=[];
            }


             for ($i = 0; $i < count($img); $i++) {
                 $imagenes[$i]=file_get_contents($_FILES["imagenes"]["tmp_name"][$i]);
                 $tipo[$i]=$_FILES["imagenes"]['type'][$i];
             }



             $Data = $Controller->  CrearProducto($id, $marca, $nombre, $subcategoria,$temporada,$estado, $adicionales, $imagenes, $tipo)  ;


             if ($Data[0] == true) {
                 $response['status'] = "success";
             } else {
                 $response['status'] = "Error";
             }
             $response['message'] = $Data[2];

             if ($Data[2]=='Exito') {
                 $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

             }else{
                 $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
             }
             echo json_encode($response);
             break;


        //------------------------------------------------------------------------------------------
        case 'CrearPromocion':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }

            if(!isset($tipo)){ $tipo=[]; }


            $Data = $Controller->CrearPromocion($id, $nombre, $descripcion, $tipo_promo, $tipo, $desc_env, $desc_prod, $fec_inicio, $fec_fin, $estado);
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;

             //------------------------------------------------------------------------------------------
         case 'CrearCategoria':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }

            $Data = $Controller->CrearCategoria($id, $nombre,$estado)   ;
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;

        //------------------------------------------------------------------------------------------
        case 'CrearSubcategoria':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }

            $Data = $Controller->CrearSubcategoria($id, $categoria, $nombre,$estado) ;
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;
        //------------------------------------------------------------------------------------------
        case 'CrearMarca':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }

            $Data = $Controller->CrearMarca($id, $nombre,$estado) ;
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;


        //------------------------------------------------------------------------------------------
        case 'CrearEtapa':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }
            if (!isset($etapa_sig)) {
                $etapa_sig=0;
            }
            $Data = $Controller->CrearEtapa($id, $nombre,$etapa_sig,$estado)  ;
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;


        //------------------------------------------------------------------------------------------
        case 'AgregarInventario':



            if (!isset($fec_venc)) { $fec_venc=null; }
            if (!isset($lote)) { $lote=null; }

            $Data = $Controller->AgregarInventario( $producto,$cantidad,$precio_compra,$precio_venta,$fec_venc,$lote)  ;

            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
            }
            echo json_encode($response);
            break;
        //------------------------------------------------------------------------------------------
        case 'CrearTemporada':


            if(!isset($id)){ $id=0; }
            if($id==""){ $id=0; }

            $Data = $Controller->CrearTemporada($id, $nombre,$estado) ;
            if ($Data[0] == true) {
                $response['status'] = "success";
            } else {
                $response['status'] = "Error";
            }
            $response['message'] = $Data[2];

            if ($Data[2]=='Exito') {
                $response['data'] =["Exito","Se guardo el valor exitosamente","success"];

            }else{
                $response['data'] =["Error","al guardar el valor, contacte a soporte ","error"];
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
                 $response['data'] =["Error",$Data[1],"error", $Data[2]];
            }
            echo json_encode($response);
            break;
        
        
            
             //-------------------------------------------------------------------------
        





        default:
            echo json_encode($response);
            break;
    }

}
