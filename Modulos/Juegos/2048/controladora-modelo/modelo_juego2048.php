<?php
/**
 * Created by PhpStorm.
 * User: Ernesto
 * Date: 31/03/15
 * Time: 21:56
 */

class juego2048
{
    public function conexionBD()
    {
        $conexApolo = @mysql_connect('localhost', 'adminemproy2', 'emproy2');
        if($conexApolo != false)
        {
           $conexApolo= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
        return $conexApolo;
    }

    public function datosRecor()
    {
        $resp = false;
        $conexion = $this->conexionBD();
        if($conexion != false)
        {
            $sql = "SELECT * FROM `persona` inner join `juego` on ci_jugador = C_IDENTIDA WHERE nombre_juego = '2048'"."";
            $consulta = $conexion->query($sql);
            $obj=$consulta->fetch_object();
            if(!empty($obj->C_IDENTIDA))
            {
                $resp = $obj;
            }
        }
        $conexion->close();
        return $resp;
    }

    public function cambiarRecor($newRecor,$ci)
    {
        $resp = false;
        $conexion = $this->conexionBD();
        if($conexion != false)
        {
            $sql = "Update juego Set recor = '".$newRecor."', ci_jugador = '".$ci."' Where nombre_juego = '2048'";
            $conexion->query($sql);
            if($conexion->affected_rows > 0)
            {
                $resp = true;
            }
        }
        $conexion->close();
        return $resp;
    }
} 