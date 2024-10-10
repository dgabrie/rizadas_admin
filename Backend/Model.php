
<?php
include "ConexionClass.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;



class db extends ConexionDB
{


    protected function CrearPromocion(int $id, $nombre, $descripcion, $tipo_promo, array $tipo, $desc_envio, $desc_prod, $fecha_inicio, $fecha_fin, $estado)
    {
        if ($id != 0 && $id != '') {
            $query = "UPDATE promociones
            set nombre=?,
                descripcion=?,
                tipo_promo=?,
                id_tipo=?,
                desc_envio=?,
                desc_producto=?,
                fecha_inicio=?,
                fecha_fin=?,
                estado=?
            WHERE id=?";
        } else {
            $query = "INSERT INTO promociones (nombre, descripcion, tipo_promo, id_tipo, desc_envio, desc_producto, fecha_inicio, fecha_fin, estado) VALUES (?,?,?,?,?,?,?,?,?)";
        }

        $tipo_p = "";
        for ($i = 0; $i < count($tipo); $i++) {
            if ($i!=0){
                $tipo_p=$tipo_p.",";
            }
            $tipo_p=$tipo_p.$tipo[$i];

        }

        try {
            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $descripcion);
            $sentencia->bindParam(3, $tipo_promo);
            $sentencia->bindParam(4, $tipo_p);
            $sentencia->bindParam(5, $desc_envio);
            $sentencia->bindParam(6, $desc_prod);
            $sentencia->bindParam(7, $fecha_inicio);
            $sentencia->bindParam(8, $fecha_fin);
            $sentencia->bindParam(9, $estado);

            if ($id != 0 && $id != '') {
                $sentencia->bindParam(10, $id);
            }

            if ($sentencia->execute()) {
                return [TRUE, "Se guardo el registro con exito!", "Exito"];
            } else {
                return [FALSE, "Error al guardar el dato error:" . $sentencia->errorInfo()[0], $sentencia->errorInfo()];
            }
        } catch (PDOException $e) {
            return [FALSE, "Error al obtener los datos", $e->getMessage()];
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------//
    protected function AgregarInventario($producto, $cantidad, $precio_compra, $precio_venta, $fec_venc, $lote)
    {
        $query = "INSERT INTO inv_entrada (id_producto, cantidad, precio_compra, precio_venta , fecha_vencimiento, lote) VALUES (?,?,?,?,?,?)";
        try {
            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $producto);
            $sentencia->bindParam(2, $cantidad);
            $sentencia->bindParam(3, $precio_compra);
            $sentencia->bindParam(4, $precio_venta);
            $sentencia->bindParam(5, $fec_venc);
            $sentencia->bindParam(6, $lote);

            if ($sentencia->execute()) {
                return [TRUE, "Se guardo el registro con exito!", "Exito"];
            } else {
                return [FALSE, "Error al guardar el dato error:" . $sentencia->errorInfo()[0], $sentencia->errorInfo()];
            }
        } catch (PDOException $e) {
            return [FALSE, "Error al obtener los datos", $e->getMessage()];
        }
    }

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
            case 'DesactivaProducto':
                $sql="UPDATE inventario SET estado=(case when estado=1 then 0 else 1 end) WHERE id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'EliminarImgProducto':
                $sql="DELETE FROM inv_imagen WHERE id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'EliminarinvProducto':
                $sql="DELETE FROM inv_entrada WHERE id=?";
                break;
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
            case 'AdminEtapa':
                $sql="SELECT a.id,a.nombre,  a.estado, CONCAT('[',GROUP_CONCAT(CONCAT('{ ".'"id"'.":',b.id_etapa,', ".'"id_sig"'.":',b.etapa_next,', ".'"nombre": '.'"'."'".",c.nombre,"."'".'"'.", ". '"texto":'.'"'."'".",b.comentario,"."'".'"'."}') SEPARATOR ','),']') etapa_sig,
                        case when a.estado=1 then 'Activo'
                                                             else 'Inactivo' end as estado1,
                                                        DATE_FORMAT(a.fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                                        DATE_FORMAT(a.fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from etapa a 
                        LEFT JOIN etapa_next b ON a.id=b.id_etapa
                        LEFT JOIN etapa c ON c.id=b.etapa_next
GROUP BY a.id,a.nombre,a.estado

";
              //  var_dump($sql);
                break;

            //------------------------------------------------------------------------------//
            case 'ListarPromociones':
                $sql="SELECT a.*, 
                        (case 
                            when a.tipo_promo='temporada' then (SELECT group_concat(CONCAT('<li>',nombre) SEPARATOR '</li>')  FROM temporada b WHERE FIND_IN_SET(b.id, a.id_tipo) > 0)
                            when a.tipo_promo='subcategoria' then (SELECT group_concat(CONCAT('<li>',nombre) SEPARATOR '</li>')  FROM subcategoria b WHERE FIND_IN_SET(b.id, a.id_tipo) > 0)	
                            when a.tipo_promo='categoria' then (SELECT group_concat(CONCAT('<li>',nombre) SEPARATOR '</li>')  FROM categoria b WHERE FIND_IN_SET(b.id, a.id_tipo) > 0)
                            when a.tipo_promo='marca' then (SELECT group_concat(CONCAT('<li>',nombre) SEPARATOR '</li>')  FROM marca b WHERE FIND_IN_SET(b.id, a.id_tipo) > 0)
                            when a.tipo_promo='producto' then (SELECT group_concat(CONCAT('<li>',nombre) SEPARATOR '</li>')  FROM inventario b WHERE FIND_IN_SET(b.id, a.id_tipo) > 0)
                            end
                        ) productos,
                        case when a.estado=1 then 'Activo'
                             else 'Inactivo' end as estado1,
                        DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                        DATE_FORMAT(a.fecha_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        FROM promociones a
 ";
                //  var_dump($sql);
                break;

            //------------------------------------------------------------------------------//
            case 'getTipoPromocion':
                switch ($id){
                    case 'temporada':
                        $sql="SELECT id,nombre FROM temporada WHERE estado=1";
                        break;
                    case 'subcategoria':
                        $sql="SELECT id,nombre FROM subcategoria WHERE estado=1";
                        break;
                    case 'categoria':
                        $sql="SELECT id,nombre FROM categoria WHERE estado=1";
                        break;
                    case 'marca':
                        $sql="SELECT id,nombre FROM marca WHERE estado=1";
                        break;
                    case 'producto':
                        $sql="SELECT id,nombre FROM inventario WHERE estado=1";
                        break;
                }
                //  var_dump($sql);
                break;

            //------------------------------------------------------------------------------//
            case 'getInvProducto':
                $sql="SELECT b.nombre,a.*
                        FROM inventario b
                        left JOIN inv_entrada a  ON a.id_producto=b.id
                        WHERE b.id=?
                        ORDER BY id desc
								limit 10
                        ";
                //  var_dump($sql);
                break;
            //------------------------------------------------------------------------------//
            case 'AdminCategoriaActivo':
                $sql="SELECT a.id, a.nombre
                        from categoria a WHERE a.estado=1";
                break;
            //------------------------------------------------------------------------------//
            case 'getEtapa':
                $sql="SELECT a.id,a.nombre,b.etapa_next, c.nombre AS etapa_sig, a.estado,
                        case when a.estado=1 then 'Activo'
                                                             else 'Inactivo' end as estado1,
                                                        DATE_FORMAT(a.fec_creacion, '%d/%m/%Y %h:%i %p') fec_creacion,
                                                        DATE_FORMAT(a.fec_modificacion, '%d/%m/%Y %h:%i %p') fec_modificacion
                        from etapa a 
                        LEFT JOIN etapa_next b ON a.id=b.id_etapa
                        LEFT JOIN etapa c ON c.id=b.etapa_next
                        where a.id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'getCategoria':
                $sql="SELECT a.*, 
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from categoria a where id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'getPromocion':
                $sql="SELECT a.*, DATE_FORMAT(a.fecha_inicio, '%Y-%m-%d') fec_inicio,
                                DATE_FORMAT(a.fecha_fin, '%Y-%m-%d') fec_fin,
                                case when estado=1 then 'Activo'
                                     else 'Inactivo' end as estado1
                        from promociones a where id=?";
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
                        where u.id=?";
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
                            else 'Inactivo' end as estado1,
                        GROUP_CONCAT(distinct concat(i.tipo,'|',i.imagen) SEPARATOR '#')	imagen,
                        GROUP_CONCAT(distinct s.id_subcategoria SEPARATOR '#')	subcategoria,
                        GROUP_CONCAT(distinct t.id_temporada SEPARATOR '#')	temporada,
                        GROUP_CONCAT( distinct CONCAT(v.nom_campo,'|',replace(v.valor_campo,'\r\n','<br>')) SEPARATOR '#')	variable
                        
                            
                        from inventario a 
                        left join inv_imagen i ON i.id_producto=a.id
                        left JOIN inv_subcategoria s ON s.id_producto=a.id
                        left JOIN  inv_temporada t ON t.id_producto=a.id
                        left JOIN inv_variable v ON v.id_producto=a.id
                        WHERE a.id=?";
                break;
            //------------------------------------------------------------------------------//
            case 'getImgProducto':
                $sql="SELECT i.*
                        from inv_imagen i 
                        WHERE i.id_producto=?";

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
                case 'DesactivaProducto':
                case 'EliminarImgProducto':
                case 'getImgProducto':
                case 'getEtapa':
                case 'getInvProducto':
                case 'EliminarinvProducto':
                case 'getPromocion':
                case 'getusuario':
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
    protected function CrearEtapa($id, $nombre,$etapa_sig,$estado)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE etapa
            set nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO etapa (nombre,estado) VALUES (?,?)";
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
                if (($id == 0) || ($id == '') || !isset($id)) {
                    $id=$conexion->lastInsertId();
                }
                if($etapa_sig!='' && $etapa_sig!=0){
                    $query_del="DELETE FROM  etapa_next WHERE id_etapa=?";
                    $sentencia_del = $conexion->prepare($query_del);
                    $sentencia_del->bindParam(1, $id);
                    $sentencia_del->execute();
                    if (count($etapa_sig)>0) {
                        for ($i = 0; $i < count($etapa_sig); $i++) {
                            $query2 = "INSERT INTO etapa_next (id_etapa, etapa_next, comentario) VALUES (?,?,' ')";
                            $sentencia2 = $conexion->prepare($query2);
                            $sentencia2->bindParam(1, $id);
                            $sentencia2->bindParam(2, $etapa_sig[$i]);
                            $sentencia2->execute();
                        }
                    }
                }

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
    protected function AdicionalProducto($id, $adicionales)
    {
        $queryDel = "DELETE FROM inv_variable WHERE id_producto=?";

        $queryIns = "INSERT INTO inv_variable (id_producto, nom_campo, valor_campo) values (?,?,?)";
        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($queryDel);
            $sentencia->bindParam(1, $id);

            if($sentencia->execute()){
                for ($i = 0; $i < count($adicionales); $i++) {
                    $adicional=explode("|", $adicionales[$i]);
                    $sentenciaInsert = $conexion->prepare($queryIns);
                    $sentenciaInsert->bindParam(1, $id);
                    $sentenciaInsert->bindParam(2, $adicional[0]);
                    $sentenciaInsert->bindParam(3, $adicional[1]);
                    $sentenciaInsert->execute();
                    //var_dump($adicionales);

                }
                return [TRUE,"Se guardo el registro con exito!","Exito"];

           }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[0],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }

    //------------------------------------------------------------------------------------------------------------------------------//
    protected function SubCategoria_Producto($id, $id_subcategoria)
    {
        $queryDel = "DELETE FROM inv_subcategoria WHERE id_producto=?";

        $queryIns = "INSERT INTO inv_subcategoria (id_producto, id_subcategoria) values (?,?)";
        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($queryDel);
            $sentencia->bindParam(1, $id);

            if($sentencia->execute()){

                $sentenciaInsert = $conexion->prepare($queryIns);

                for ($i = 0; $i <count($id_subcategoria) ; $i++) {
                    $sentenciaInsert->bindParam(1, $id);
                    $sentenciaInsert->bindParam(2, $id_subcategoria[$i]);

                    $sentenciaInsert->execute();
                }

                return [TRUE,"Se guardo el registro con exito!","Exito"];

            }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[0],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }

    //------------------------------------------------------------------------------------------------------------------------------//
    protected function temporada_Producto($id, $temporada)
    {
        $queryDel = "DELETE FROM inv_temporada WHERE id_producto=?";

        $queryIns = "INSERT INTO inv_temporada (id_producto, id_temporada) values (?,?)";
        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($queryDel);
            $sentencia->bindParam(1, $id);

            if($sentencia->execute()){

                $sentenciaInsert = $conexion->prepare($queryIns);

                for ($i = 0; $i <count($temporada) ; $i++) {
                    $sentenciaInsert->bindParam(1, $id);
                    $sentenciaInsert->bindParam(2, $temporada[$i]);

                    $sentenciaInsert->execute();
                }

                return [TRUE,"Se guardo el registro con exito!","Exito"];

            }else{
                return [FALSE,"Error al guardar el dato error:". $sentencia->errorInfo()[0],$sentencia->errorInfo()];
            }
        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }
    //------------------------------------------------------------------------------------------------------------------------------//
    protected function AdicionalImagen($id, $imagen, $tipo)
    {


        $queryIns = "INSERT INTO inv_imagen (id_producto, imagen, tipo) values (?,?, ?)";
        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();

                for ($i = 0; $i <count($imagen) ; $i++) {
                    $img=base64_encode($imagen[$i]);
                    $sentenciaInsert = $conexion->prepare($queryIns);
                    $sentenciaInsert->bindParam(1, $id);
                    $sentenciaInsert->bindParam(2, $img);
                    $sentenciaInsert->bindParam(3, $tipo[$i]);
                    $sentenciaInsert->execute();
                }



                return [TRUE,"Se guardo el registro con exito!","Exito"];


        }catch(PDOException $e){
            return [FALSE,"Error al obtener los datos",$e->getMessage()];
        }


    }

    //------------------------------------------------------------------------------------------------------------------------------//
    protected function CrearProducto($id, $marca,$nombre, $subcategoria,$temporada,$estado, $adicionales, $imagenes, $tipo)
    {
        if ($id!=0 && $id!='') {
            $query = "UPDATE inventario
            set id_marca=?,
                nombre=?,
                estado=?
            WHERE id=?";
        }else{
            $query="INSERT INTO inventario (id_marca, nombre, estado) VALUES (?,?,?)";
        }


        //var_dump($query);
        try{

            $conexion = ConexionDB::ConexionLocalPDO();
            $sentencia = $conexion->prepare($query);
            $sentencia->bindParam(1, $marca);
            $sentencia->bindParam(2, $nombre);
            $sentencia->bindParam(3, $estado);

            if ($id!=0 && $id!='') {
                $sentencia->bindParam(4, $id);
            }


            if($sentencia->execute()){

                if (($id == 0) || ($id == '') || !isset($id)) {
                    $id=$conexion->lastInsertId();

                }

                if (strlen($adicionales)>0){
                    $adicional=explode("#", $adicionales);
                    $this->AdicionalProducto($id, $adicional);
                }

                if (count($imagenes)>0){
                    $this->AdicionalImagen($id, $imagenes, $tipo);
                }

                if (count($subcategoria)>0){
                    $this->SubCategoria_Producto($id, $subcategoria);
                }


                if (count($temporada)>0){
                    $this->temporada_Producto($id, $temporada);
                }

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
            $clav=md5("Tienda**".($clave));
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
