<?php

namespace Controllers;

use Model\Solicitud;
use Model\Visita;
use Model\Sugerencia;
use Model\Reclamo;
use Classes\Utils;
use MiladRahimi\PhpRouter\View\View;
use MiladRahimi\PhpRouter\Routing\Route;
use voku\helper\AntiXSS;

class SolicitudController
{

    public static function listRequest(View $view)
    {

        $auth = Utils::isAdmin();

        $formsTable = Visita::all();
        $requestTable = Solicitud::all();
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $view->make('admin/request/list', ["formsTable" => $formsTable, "requestTable" => $requestTable, "csrf" => $csrf]);

    }

    public static function details(View $view, Route $route){
        $auth = Utils::isAdmin();

        $id_form = $route->getParameters();
        $id_form = $id_form['id'];
        $id_form = (int)$id_form;

        $form = new Visita();
        $request = new Solicitud();
        $sql = "SELECT ayuda_id FROM solicitud_ayudas WHERE form_id = $id_form";

        $req = $request->SQL($sql);
        $detail = $form->where('id', $id_form);

        $view->make('admin/request/detail', ["detail" => $detail, "req" => $req]);
    }


    public static function suggestList(View $view)
    {

        $auth = Utils::isAdmin();

        $list = Sugerencia::all();
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $view->make('admin/request/suggList', ["list" => $list, "csrf" => $csrf]);

    }

    public static function suggDetails(View $view, Route $route){
        
        $auth = Utils::isAdmin();

        $id_form = $route->getParameters();
        $id_form = $id_form['id'];
        $id_form = (int)$id_form;

        $form = new Sugerencia();

        $detail = $form->where('id', $id_form);

        $view->make('admin/request/suggDetail', ["detail" => $detail]);
    }


    public static function claimList(View $view)
    {

        $auth = Utils::isAdmin();

        $list = Reclamo::all();
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $options = [1 => 'En análisis', 2 => 'En contacto con el usuario', 3 => 'En proceso de resolución', 4 => 'Problema legal', 5 => 'Solucionado (cerrado)', 6 => 'Sin poder solucionar (cerrado)'];

        $view->make('admin/request/claimList', ["list" => $list, "options" => $options, "csrf" => $csrf]);

    }

    public static function claimDetail(View $view, Route $route)
    {
        $auth = Utils::isAdmin();

        $id_form = $route->getParameters();
        $id_form = $id_form['id'];
        $id_form = (int)$id_form;

        $cod = Utils::sameId($id_form);


        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $options = [1 => 'En análisis', 2 => 'En contacto con el usuario', 3 => 'En proceso de resolución', 4 => 'Problema legal', 5 => 'Solucionado (cerrado)', 6 => 'Sin poder solucionar (cerrado)'];

        //debuguear($options);
        
        $form = new Reclamo();
        $detail = $form->where('id', $id_form);

        $view->make('admin/request/claimDetail', ["detail" => $detail, "csrf" => $csrf, 'options' => $options, 'cod' => $cod ]);
    }

    public static function clUpdateStatus()
    {

        $auth = Utils::isAdmin();

	if(!empty($_FILES)){
            exit;
        }

        $adsave = [
            'result' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && Utils::validateSame() && $auth && is_numeric($_POST['status'])) {

            //isAdmin();

            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);


            if ($_POST = $clean) {

                $form = Reclamo::where('id', $clean['cod']);

                $admin = $_SESSION['id'];

                    $update = $form->simpleUpdate('status', $clean["status"]);
                    if ($update) {
                        if ($clean["status"] == 5 || $clean["status"] == 6) {

                            $id_form = (int)$clean['cod'];

                            $admin = $_SESSION['nombre'];

                            $stat = $clean["status"];

                            $update = $form->simpleUpdate('resolution_date', date('Y-m-d H:i:s'));

                            $sql = "SELECT admin_observation FROM reclamo WHERE id = $id_form";
                            $prev = $form->SQL($sql);
                            $prev_text = $prev[0]->admin_observation;
                           
                            $new_add = "<strong>[Reclamo cerrado por " . $admin . " con status " . $stat  ." el ". date('d-m-Y H:i')."]</strong><br>";
                            $final_text = $prev_text . $new_add;
                            $update = $form->simpleUpdate('admin_observation', $final_text);
                        }else{
                            $id_form = (int)$clean['cod'];

                            $stat = $clean["status"];

                            $admin = $_SESSION['nombre'];;

                            $sql = "SELECT admin_observation FROM reclamo WHERE id = $id_form";
                            $prev = $form->SQL($sql);
                            $prev_text = $prev[0]->admin_observation;
                           
                            $new_add = "[Status actualizado a ". $stat . " por admin: " . $admin . " el ". date('d-m-Y H:i:s'). "]<br>";
                                  $final_text = $prev_text . $new_add;
                            $update = $form->simpleUpdate('admin_observation', $final_text);
                        }
                        $adsave = [
                            'result' => true
                        ];
                      }
                }

            }

            echo json_encode($adsave);
        }


        public static function claimObs()
        {
    
            $auth = Utils::isAdmin();

	    if(!empty($_FILES)){
               exit;
       	    }
    
            $adsave = [
                'result' => false
            ];
    
            ltrim($_POST['obs']);
            $obs = ltrim($_POST['obs']);
    
            if (!empty($obs) && strlen($obs) >= 2 && strlen($obs) < 5000) {
    
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && Utils::validateSame() && $auth) {
    
    
                    $xss = new AntiXSS();
    
                    $clean = $xss->xss_clean($_POST);
    
    
                    if ($_POST === $clean) {
    
                        $id_form = (int)$clean['cod'];
    
                        $form = Reclamo::where('id', $id_form);
    
    
                        $admin = $_SESSION['nombre'];
    
                        $sql = "SELECT admin_observation FROM reclamo WHERE id = $id_form";
                        $prev = $form->SQL($sql);
                        $prev_text = $prev[0]->admin_observation;
                        
                        $new_add = "<p>[" . $clean['obs'] . " - " . $admin . " el " . date('d-m-Y H:i') . "]</p>";
                        
                        $final_text = $prev_text . $new_add;
                        $update = $form->simpleUpdate('admin_observation', $final_text);
    
    
                        if ($update) {
                            $adsave = [
                                'result' => true
                            ];
                        }
    
                    }
                }
            }
    
            echo json_encode($adsave);
        }
    
    
    
    }
    
    

   
