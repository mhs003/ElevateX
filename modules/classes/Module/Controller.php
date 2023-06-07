<?php
namespace Module;

class Controller
{
    public static function parseController($com, $req, $res)
    {
        $expCom = explode("@", $com);
        if (count($expCom) == 2) {
            $controllerFile = __DIR__ . "/../../../app/Controllers/" . $expCom[0] . ".php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                return call_user_func(array(new $expCom[0], $expCom[1]), $req, $res);
            } else {
                \Route::addError(500, "Internal server error. Controller file not found.");
            }
        } else {
            \Route::addError(500, "Internal server error. Controller definition error.");
        }
    }
}