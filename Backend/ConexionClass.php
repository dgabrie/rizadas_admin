<?php
/**
 * Clase Conexion que devuelve un objeto de conexion a la base de datos local
 */
class ConexionDB
{
	//----------------------------------------------------------------------------------------------------//
	
	//----------------------------------------------------------------------------------------------------//
	//Metodo de conexion a la base lodal
	protected function ConexionLocalPDO(): PDO
    {
		$server='localhost';
		$user='tienda';
		$password='*123';
		$db = 'tienda_online';

        return new PDO("mysql:host=".$server.";dbname=".$db.";charset=utf8",$user,$password);
	}
	//----------------------------------------------------------------------------------------------------//

	//----------------------------------------------------------------------------------------------------//



   
}
