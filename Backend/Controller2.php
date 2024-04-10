<?php

include '../Backend/Model.php';


function imagetoBLOB($i){
    if (count($_FILES['imagenes']['tmp_name']) > 0) {
        if (is_uploaded_file($_FILES['imagenes']['tmp_name'])) {




            $imgData = (file_get_contents($_FILES['imagenes']['tmp_name']));
            
            
           return base64_encode($imgData);
        }
    }
    return null;
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

        default:
            echo json_encode($response);
            break;
    }

}
