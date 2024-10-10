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


// Obtener el host (dominio completo)
        $host = $_SERVER['HTTP_HOST'];

// Separar el subdominio del dominio principal
        $parts = explode('.', $host);

// Dependiendo de cómo esté estructurado el dominio, puedes identificar el subdominio
// Por ejemplo, si tienes un dominio como: subdominio.dominio.com
        if (count($parts) > 2) {
            // Esto toma el primer segmento como el subdominio
            $subdominio = $parts[0];
        } else {
            // Si no hay subdominio (ej: dominio.com)
            $subdominio = null;
        }

// Ejecutar código según el subdominio
        if ($subdominio == 'adm') {
            $server='localhost';
            $user='u196509350_adm';
            $password='*Rizadas2024';
            $db = 'u196509350_rizadas';
        } elseif ($subdominio == 'dev') {
            $server='localhost';
            $user='u196509350_dev';
            $password='*Rizadas2024';
            $db = 'u196509350_rizadas';
        } else {
            $server='88.223.84.151';
            $user='u196509350_adm';
            $password='*Rizadas2024';
            $db = 'u196509350_rizadas';
        }




        return new PDO("mysql:host=".$server.";dbname=".$db.";charset=utf8",$user,$password);
	}
	//----------------------------------------------------------------------------------------------------//

	//----------------------------------------------------------------------------------------------------//



   
}
