
<?php
include "ConexionClass.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;



class db extends ConexionDB
{


    protected function ACENTOS(){

       $conexion  = ConexionDB::ConexionLocalPDO();

        $conexion->exec("SET lc_time_names = 'es_ES'");

       return $conexion;
    }

        //---------------------------------------------------------------------------------//
    protected function Listar($tabla, $id = "")
    {


        switch ($tabla) {
    //----------------------------------------------------------------------------------------------//
    //                                                                                              //
    //                                        REGISTRO                                              //
    //                                                                                              //
    //----------------------------------------------------------------------------------------------//
            //------------------------------------------------------------------------------//
            case 'ListarUsuarios':
                $sql="SELECT group_concat(p.permiso SEPARATOR ', ') permiso,u.id, u.nombre, u.usuario, u.correo,  u.estado, u.fecha_ult_log, u.fecha_creacion, u.fecha_modificacion
                        FROM usuarios u 
                        Left JOIN permisos_usuarios pu ON pu.id_usuario=u.id
                        Left JOIN permisos p ON p.id=pu.id_permiso
                        GROUP BY u.id, u.nombre, u.usuario, u.correo, u.pass, u.estado, u.fecha_ult_log, u.fecha_creacion, u.fecha_modificacion";
                break;
            //------------------------------------------------------------------------------//
            case 'listarPermisos':
                $sql="SELECT * from permisos";
                break;

            //------------------------------------------------------------------------------//
            case 'AdminCategoria':
                $sql="SELECT a.id,a.nombre, a.estado, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1,
                                DATE_FORMAT(fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                DATE_FORMAT(fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from categoria a";
                break;

            //------------------------------------------------------------------------------//
            case 'AdminCategoriaActivo':
                $sql="SELECT a.id, a.nombre
                        from categoria a WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getCategoria':
                $sql="SELECT a.*, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from categoria a where id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'AdminSubCategoria':
                $sql="SELECT a.id,a.nombre, a.estado, b.nombre AS categoria, b.estado est_cat,
                                case when a.estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1,
                                DATE_FORMAT(a.fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                DATE_FORMAT(a.fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from subcategoria a 
                            inner join categoria b on a.id_categoria=b.id
                            ";
                break;
            //------------------------------------------------------------------------------//
            case 'AdminSubCategoriaActivo':
                $sql="SELECT a.id, a.id_categoria,b.nombre as categoria, a.nombre
                        from subcategoria a 
                        inner join categoria b on a.id_categoria=b.id
                        WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getSubcategoria':
                $sql="SELECT a.*, a.id_categoria as categoria, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from subcategoria a where id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'getusuario':
                $sql="SELECT pu.id_permiso,u.id, u.nombre, u.usuario, u.correo, u.pass, u.estado, u.fecha_ult_log, u.fecha_creacion, u.fecha_modificacion, GROUP_CONCAT(p.id SEPARATOR ';') permiso
                        FROM usuarios u 
                        Left JOIN permisos_usuarios pu ON pu.id_usuario=u.id
                        Left JOIN permisos p ON p.id=pu.id_permiso
                        where u.id=".$id;
                break;

            //------------------------------------------------------------------------------//
            case 'AdminMarca':
                $sql="SELECT a.id,a.nombre, a.estado, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1,
                                DATE_FORMAT(fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                DATE_FORMAT(fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from marca a";
                break;

            //------------------------------------------------------------------------------//
            case 'AdminMarcaActivo':
                $sql="SELECT a.id, a.nombre
                        from marca a WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getMarca':
                $sql="SELECT a.*, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from marca a where id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'AdminTemporada':
                $sql="SELECT a.id,a.nombre, a.estado, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1,
                                DATE_FORMAT(fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                DATE_FORMAT(fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from temporada a";
                break;

            //------------------------------------------------------------------------------//
            case 'AdminTemporadaActivo':
                $sql="SELECT a.id, a.nombre
                        from temporada a WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getTemporada':
                $sql="SELECT a.*, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from temporada a where id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'AdminProducto':
                $sql="SELECT a.id,a.nombre, a.estado, b.nombre AS marca, b.estado est_marca,
                                case when a.estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1,
                                DATE_FORMAT(a.fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                DATE_FORMAT(a.fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from inventario a 
                            inner join marca b on a.id_marca=b.id
                            ";
                break;
            //------------------------------------------------------------------------------//
            case 'AdminProductoActivo':
                $sql="SELECT a.id, a.id_marca, a.nombre
                        from inventario a WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getProducto':
                $sql="SELECT a.*, a.id_marca as marca, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from inventario a where id=?";
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
                case 'getTemporada':
                case 'getProducto':
                case 'getMarca':
                case 'getCategoria':
                case 'getCliente':
                case 'getSubcategoria':
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
    protected function CrearCategoria($id, $nombre,$estado)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE categoria
            set nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO categoria (nombre,estado) VALUES (?,?)";
        }

        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $estado);

            if ($id!=0 && $id!='') {
                $sentencia->bindParam(3, $id);
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
    protected function CrearSubcategoria($id, $idcategoria, $nombre,$estado)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE subcategoria
            set id_categoria=?,
                nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO subcategoria (id_categoria,nombre,estado) VALUES (?,?,?)";
        }

        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $idcategoria);
            $sentencia->bindParam(2, $nombre);
            $sentencia->bindParam(3, $estado);

            if ($id!=0 && $id!='') {
                $sentencia->bindParam(4, $id);
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
    protected function CrearMarca($id, $nombre,$estado)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE marca
            set nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO marca (nombre,estado) VALUES (?,?)";
        }

        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $estado);

            if ($id!=0 && $id!='') {
                $sentencia->bindParam(3, $id);
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


    //------------------------------------------------------------------------------------------------------------------------------//
    protected function CrearTemporada($id, $nombre,$estado)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE temporada
            set nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO temporada (nombre,estado) VALUES (?,?)";
        }

        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $estado);

            if ($id!=0 && $id!='') {
                $sentencia->bindParam(3, $id);
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
    protected function add_Usuario($id, $nombre,$usuario,$pass,$correo,$permiso,$estado){
            //var_dump($id);
        if ($id!=0 && $id!='' && $id!="") {
            if($pass=="Contraseña encriptada"){
                $query = "UPDATE usuarios
                            set nombre=?, 
                                usuario=?, 
                                correo=?,
                                estado=?,
                                pass=pass
                            WHERE ID=?";
            }else{
                $pass=md5("Tienda**".$pass);
                $query = "UPDATE usuarios
                            set nombre=?, 
                                usuario=?, 
                                correo=?,
                                estado=?,
                                pass=?
                    
                            WHERE ID=?";
            }

        }else{

            $pass=md5("Tienda**".$pass);
            $query="INSERT INTO usuarios (nombre, usuario, correo, estado,pass) VALUES (?,?,?,?,?)";
        }


        try{

            $conexion = ConexionDB::ConexionLocalPDO();

            $sentencia = $conexion->prepare($query);

            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $usuario);
            $sentencia->bindParam(3, $correo);
            $sentencia->bindParam(4, $estado);


            if ($id!=0 && $id!='' && $id!="") {
                if($pass=="Contraseña encriptada") {

                    $sentencia->bindParam(5, $id);
                }else{
                    $sentencia->bindParam(5, $pass);
                    $sentencia->bindParam(6, $id);
                }
            }else{
                $sentencia->bindParam(5, $pass);
            }


            if($sentencia->execute()){

                if ($id==0 || $id=='') {
                    $id = $conexion->lastInsertId();
                }





                 $c=explode(';',$permiso);
                 $querydelete="DELETE FROM permisos_usuarios WHERE id_usuario=?;";
                $queryReplace="INSERT INTO permisos_usuarios (id_usuario, id_permiso) values (?,?)";


                $sentenciaDelete = $conexion->prepare($querydelete);
                $sentenciaDelete->bindParam(1, $id);
                $sentenciaDelete->execute();


                for ($i = 0; $i < count($c) ; $i++) {
                    $sentenciaReplace = $conexion->prepare($queryReplace);
                    $sentenciaReplace->bindParam(1, $id);
                    $sentenciaReplace->bindParam(2, $c[$i]);
                    $sentenciaReplace->execute();
                 }

                return [TRUE,"Se guardo el registro con exito! ".$conexion->lastInsertId(),"Exito"];


            }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[2],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos ".$e->getMessage(),$e->getMessage()];
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


        $query = "SELECT u.id AS codigo, usuario , nombre,  group_concat(up.id_permiso SEPARATOR '|') permiso
                    FROM usuarios u
                    INNER JOIN permisos_usuarios up ON u.id=up.id_usuario
                    INNER JOIN permisos p ON p.id=up.id_permiso
                    WHERE usuario=? AND pass=? and estado='Activo'
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

                $query3="UPDATE usuarios SET token=?, fecha_ult_log=now() WHERE id=?";
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
        return [FALSE,"Error al obtener los datos en la bd ", $e->getMessage()];
    }
    }

//===================================================================================================================================================

}
