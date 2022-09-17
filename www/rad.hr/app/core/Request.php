<?php

class Request
{
    public static function getRuta()
    {
        $ruta='/';
        if(isset($_SERVER['REDIRECT_PATH_IFNO'])){
            $ruta = $_SERVER['REDIRECT_PATH_IFNO'];
        }else if (isset($_SERVER['REQUEST_URI'])){
            $ruta = $_SERVER['REQUEST_URI'];
        }
        return $ruta;
    }
}