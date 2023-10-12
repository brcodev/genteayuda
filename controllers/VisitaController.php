<?php

namespace Controllers;

use Model\Solicitud;
use Model\Visita;
use Model\Categoria;
use Model\Regiones;
use Model\Reclamo;
use Model\Sugerencia;
use Classes\Email;
use Classes\Utils;
use voku\helper\AntiXSS;
use MiladRahimi\PhpRouter\View\View;
use Model\Organizacion;

class VisitaController
{

    public static function index(View $view)
    {
        session_start();

        if (!isset($_SESSION['token'])) {
            $csrf = Utils::createToken();
        } else {
            $csrf = $_SESSION['token'];
        }

        $display = "display: none;";


        $region = new Regiones();
        $regiones = $region->all();
        return $view->make('visita.index', ['csrf' => $csrf, "regiones" => $regiones, 'display' => $display]);
    }


    public static function notFound(View $view)
    {

        return $view->make('layout.notPage');
    }


    public static function save()
    {

        if (!empty($_FILES)) {
   	 exit;
	}

	$save = [
            'result' => false
        ];


         if(!empty($_POST)){

            foreach ($_POST as $key => $value) {
                if (!is_array($value)) {
                    $_POST[$key] = trim($value);
                }
            }


            $validation = true;

            $ayudas = $_POST['ayuda'];
    
            if(count($ayudas) < 5){
    
            foreach ($ayudas as $checkbox) {
                if (!is_numeric($checkbox)) {
                    $validation = false;
                    break;
                }
             }
    
            }else{
                $validation = false;
            }
    
            if (!empty($_POST['nombre'])) {
                if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ][a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{0,49}$/', $_POST['nombre'])) {
                    $validation = false;
                }
            }
            
            if (!empty($_POST['apellido'])) {
                if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ][a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{0,49}$/', $_POST['apellido'])) {
                    $validation = false;
                }
            }
    
            if (!empty($_POST['telefono'])) {
                if (!preg_match('/^\d{9}$/', $_POST['telefono'])) {
                    $validation = false;
                }
            }
    
            if (!empty($_POST['asunto'])) {
                if (strlen($_POST['asunto']) > 525) {
                    $validation = false;
                }
            }
    
            if (!is_numeric($_POST['region']) || $_POST['region'] > 20) {
                $validation = false;
            }
    
            if(strlen($_POST['correo']) > 100){
                $validation = false;
            }

            if(!$validation){
                echo json_encode($save);
                exit();
            }

        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST && Utils::validateToken() && $validation) {

            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);


            if (filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) && !empty($_POST['ayuda']) && $_POST['region'] > 0  && $_POST === $clean) {

                if ($clean["region"] <= 5) {
                    $clean['form_zona'] = 1;
                } else if ($clean["region"] > 8) {
                    $clean['form_zona'] = 3;
                } else {
                    $clean['form_zona'] = 2;
                }

                $usuario = new Visita($clean);
                $usuario->sincronizar($clean);
                $save = $usuario->guardar();

                if ($save) {

                    $helps = [];
                    foreach ($ayudas as $ayuda) {

                        $sync['form_id'] = $save["id"];
                        $sync['ayuda_id'] = (int)$ayuda;
                        $request = new Solicitud($sync);
                        $savrequest = $request->crear();
                        array_push($helps, (int)$ayuda);
                    }

                    if ($savrequest) {

                        if (count($helps) == 1) {
                            array_push($helps, 0);
                            array_push($helps, 0);
                        }

                        if (count($helps) == 2) {
                            array_push($helps, 0);
                        }

                        $reg_form = $clean["region"];

                        $sentence = "SELECT nombre_organizacion, correo_org, telefono_org, ";
                        $sentence .= " id, direccion_org, id_region, id_ayuda_entregada, descripcion_organizacion, ";
                        $sentence .= " url_imagen FROM organizaciones WHERE id_region = $reg_form AND (id_ayuda_entregada = $helps[0] OR id_ayuda_entregada = $helps[1] OR id_ayuda_entregada = $helps[2]) ORDER BY id_ayuda_entregada";
                        $info = new Organizacion();
                        $data = $info->consultarSQL($sentence);
                        $correo = $clean['correo'];
                        $email = new Email($correo);

                        $sent = $email->sentInfo($data, $reg_form, $helps);
                    }
                }

                //Utils::deleteToken();

                echo json_encode($savrequest);
            } else {
                echo json_encode($save);
            }
        } else {
            echo json_encode($save);
        }
    }

    public static function claimSugg()
    {

        if (!empty($_FILES)) {
         exit;
        }

        foreach ($_POST as $key => $value) {
            $_POST[$key] = trim($value);
        }
        
        $validation = true;

        if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ][a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{0,49}$/', $_POST['nombre'])) {
            $validation = false;
        }
        
        if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ][a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{0,49}$/', $_POST['apellido'])) {
            $validation = false;
        }        


        if(strlen($_POST['mail']) > 100){
            $validation = false;
        }

        if($_POST['tipo'] > 3){
            $validation = false;
        }

        if(strlen($_POST['mensaje']) > 525){
            $validation = false;
        }

        $save = [
            'result' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST && Utils::validateToken() && $validation) {

            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);


            if (filter_var($clean['mail'], FILTER_VALIDATE_EMAIL) && $clean['tipo'] > 0  && $_POST === $clean) {


                if ($clean['tipo'] == 1) {
                    $usuario = new Sugerencia($clean);
                    $usuario->sincronizar($clean);
                    $save = $usuario->guardar();
                    $save['type'] = 'sugge';
                } else if ($clean['tipo'] == 2) {
                    $usuario = new Reclamo($clean);
                    $usuario->sincronizar($clean);
                    $save = $usuario->guardar();
                    $save['type'] = 'claim';
                }
            }
        }

        echo json_encode($save);
    }



    public static function nosotros(View $view)
    {

        $color = "#837de1;";

        return $view->make('visita.nosotros', ['color' => $color]);
    }

    public static function contacto(View $view)
    {
        $reg = new Regiones();

        $display = "display: none;";


        if (!isset($_SESSION['token'])) {
            $csrf = Utils::createToken();
        } else {
            $csrf = $_SESSION['token'];
        }


        $regiones = $reg->all();
        return $view->make('visita.contacto', ['regiones' => $regiones, "csrf" => $csrf, 'display' => $display]);
    }

    public static function ayudas(View $view)
    {

        $a = "#2e2a2a;";
        $color = "rgb(245 240 240 / 40%)";


        $categorias = Categoria::all();

        return $view->make('visita.ayudas', ['categorias' => $categorias, 'a' => $a, 'color' => $color]);
    }
}
