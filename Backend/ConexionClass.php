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
		$server='82.180.172.87';
		$user='u855477434_cdgabrie';
		$password='Clinica..2022';
		$db = 'u855477434_odontologia';
        return new PDO("mysql:host=".$server.";dbname=".$db.";charset=utf8",$user,$password);
	}
	//----------------------------------------------------------------------------------------------------//
	
	//----------------------------------------------------------------------------------------------------//
	


   
}
