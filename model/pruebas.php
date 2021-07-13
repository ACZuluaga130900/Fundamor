<?php

class AdminTest
{
    public function sumar($n1, $n2)
    {
        return $n1 + $n2;
    }

    public function consulta($host, $req)
    {
        $url = $host . $req;
        // Crear opciones de la petición HTTP
        $opciones = array(
            "http" => array(
                "header" => "Content-type: application/json",
                "method" => "Get",
            ),
        );
        # Preparar petición
        $contexto = stream_context_create($opciones);
        # Hacerla
        $resultado = file_get_contents($url, false, $contexto);
        #resultado 
        if ($resultado === false) {
            return false;
        } else {
            return true;
        }
    }

    public function consultaData($host, $req, $data)
    {
        $url = $host . $req;
        // Crear opciones de la petición HTTP
        $opciones = array(
            "http" => array(
                "header" => "Content-type: application/json",
                "method" => "Get",
                "content" => http_build_query($data),
            ),
        );
        # Preparar petición
        $contexto = stream_context_create($opciones);
        # Hacerla
        $resultado = file_get_contents($url, false, $contexto);
        #resultado 
        if ($resultado === false) {
            return false;
        } else {
            return true;
        }
    }
}
