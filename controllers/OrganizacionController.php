<?php

namespace Controllers;

use Classes\Utils;
use Classes\Email;
use MiladRahimi\PhpRouter\Routing\Route;
use MiladRahimi\PhpRouter\View\View;
use Model\ActiveRecord;
use Model\Categoria;
use Model\Organizacion;
use Model\Regiones;
use Model\Zona;
use Model\OrgRequest;
use Model\Status;
use URLify;
use voku\helper\AntiXSS;
use Exception;
use Laminas\Diactoros\Request;

class OrganizacionController
{

    public static function index(View $view, Route $route)
    {

        $xss = new AntiXSS();

        $categoria = $route->getParameters();

        $categoria = $xss->xss_clean($categoria['cat']);

        $categoria = urldecode($categoria);

        $query = "SELECT o.id, nombre_organizacion, correo_org, telefono_org, direccion_org, o.id_ayuda_entregada, cat_ayuda, folder_path, url_imagen, icono ";
        $query .= " FROM organizaciones o ";
        $query .= " INNER JOIN categoria_ayuda c ";
        $query .= " ON o.id_ayuda_entregada=c.id ";
        $query .= " WHERE cat_ayuda = '$categoria' ";
        $query .= " ORDER BY o.id ASC LIMIT 6 ";


        $org = Organizacion::objetoSql($query);
        $regiones = Regiones::all();

        $color = "#0097a7;";
        $a = "#fff;";


        $view->make(
            'visita.ayuda',
            [
                'org' => $org,
                'regiones' => $regiones,
                'categoria' => $categoria,
                'color' => $color,
                'a' => $a
            ]
        );
    }

    public static function region(View $view, Route $route)
    {

        $xss = new AntiXSS();

        $region = $route->getParameters();

        $region = $xss->xss_clean($region["region"]);

        $region = (int)$region;


        $categoria = $route->getParameters();

        $categoria = $xss->xss_clean($categoria['cat']);

        $categoria = urldecode($categoria);

       /* if ($categoria == "Alimentaria" || $categoria == "Psicológica" || $categoria == "Psicologica" || $categoria == "Vestuario") {
            $categoria = "error";
        } */

        $slider_off = true;

        $query = "SELECT o.id, nombre_organizacion, correo_org, telefono_org, direccion_org, o.id_ayuda_entregada, cat_ayuda, id_region, folder_path, url_imagen, icono ";
        $query .= " FROM organizaciones o ";
        $query .= " INNER JOIN categoria_ayuda c ";
        $query .= " ON o.id_ayuda_entregada=c.id ";
        $query .= " INNER JOIN regiones r ";
        $query .= " ON o.id_region=r.id ";
        $query .= " WHERE cat_ayuda = '$categoria' AND id_region = '$region' ";
        $query .= " ORDER BY o.id ASC";


        $org = Organizacion::objetoSql($query);
        $regiones = Regiones::all();
        $consultado = Regiones::where('id', $region);
        $region = $consultado->region;
        $region_id = $consultado->id;

        $color = "#0097a7;";
        $a = "#fff;";



        $view->make(
            'visita.region',
            [
                'org' => $org,
                'regiones' => $regiones,
                'categoria' => $categoria,
                'slider_off' => $slider_off,
                'region' => $region,
                'region_id' => $region_id,
                'color' => $color,
                'a' => $a
            ]
        );
    }

    public static function dataOrg()
    {

        if (isset($_POST["id"]) && !empty($_POST["id"]) && empty($_POST["eventoid"]) && Utils::validateToken()) {

            $xss = new AntiXSS();

            $lastID = $xss->xss_clean($_POST['id']);
            $categoria = $xss->xss_clean($_POST['cat']);
            $cat = $categoria;

            if ($categoria === 'Alimentaria') {
                $categoria = 1;
            } else if ($categoria === 'Psicológica') {
                $categoria = 2;
            } else if ($categoria === 'Vestimenta') {
                $categoria = 3;
            }


            $showLimit = 6;

            if (isset($_POST["zona"]) && !empty($_POST["zona"])) {
                $zona = $xss->xss_clean($_POST["zona"]);


                $zona_id = $zona;
                if ($zona_id === 'Norte') {
                    $zona_id = 1;
                } else if ($zona_id === 'Centro') {
                    $zona_id = 2;
                } else if ($zona_id === 'Sur') {
                    $zona_id = 3;
                }

                $sentence1 = " AND org_zona_id = $zona_id ";
                $sentence2 = " AND zona = '$zona' ";



                if ($zona === 'todo') {
                    $sentence1 = " ";
                    $sentence2 = " ";
                }

                $str = "SELECT COUNT(*) as num_rows FROM organizaciones WHERE id_ayuda_entregada = $categoria $sentence1 AND id > " . $lastID . " ORDER BY id ASC";

                $rowAll = Organizacion::objetoSql($str);

                $allNumRows = $rowAll;



                $sql = "SELECT o.id, nombre_organizacion, correo_org, telefono_org, direccion_org, zona, cat_ayuda, folder_path ,url_imagen, icono ";
                $sql .= " FROM organizaciones o ";
                $sql .= " INNER JOIN categoria_ayuda c ";
                $sql .= " ON o.id_ayuda_entregada=c.id ";
                $sql .= " INNER JOIN zonas z ";
                $sql .= " ON o.org_zona_id=z.id ";
                $sql .= " WHERE o.id > " . $lastID . " AND cat_ayuda = '$cat' $sentence2  ORDER BY o.id ASC LIMIT " . "$showLimit ";
                $resultado = Organizacion::objetoSql($sql);



                require_once __DIR__ . '/../views/visita/orginfo.php';
            } else {


                $queryAll = "SELECT COUNT(*) as num_rows FROM organizaciones WHERE id_ayuda_entregada = $categoria AND id > " . $lastID . " ORDER BY id ASC";

                $rowAll = Organizacion::objetoSql($queryAll);
                $allNumRows = $rowAll;

                //Get rows by limit except already displayed
                $sql = "SELECT o.id, nombre_organizacion, correo_org, telefono_org, direccion_org, cat_ayuda, folder_path ,url_imagen, icono ";
                $sql .= " FROM organizaciones o ";
                $sql .= " INNER JOIN categoria_ayuda c ";
                $sql .= " ON o.id_ayuda_entregada=c.id ";
                $sql .= " WHERE o.id > " . $lastID . " AND cat_ayuda = '$cat' ORDER BY o.id ASC LIMIT " . "$showLimit ";


                $resultado = Organizacion::objetoSql($sql);

                require_once __DIR__ . '/../views/visita/orginfo.php';
            }
        }
    }


    public static function orgPage(View $view, Route $route)
    {

        $xss = new AntiXSS();
        $clean = $xss->xss_clean($_GET["e"]);
        $id_org = $clean;

        $organizacion = new Organizacion();
        $org = $organizacion->where('id', $id_org);


        $color = "rgb(11 191 176 / 40%);";
        $a = "#fff;";

        $view->make('organizacion/page', [
            "org" => $org,
            'color' => $color,
            'a' => $a,

        ]);
    }

    public static function saveOrg()
    {
       if (!empty($_FILES)) {
         exit;
        }

        foreach ($_POST as $key => $value) {
            $_POST[$key] = trim($value);
        }

        $validation = true;

        if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{1,50}$/', $_POST['nombres'])) {
            $validation = false;
        }
        
        if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{1,50}$/', $_POST['apellidos'])) {
            $validation = false;
        }

        

        if (!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,100}$/', $_POST['nombre_org'])) {
            $validation = false;
        }
    
        
        if (!preg_match('/^\d{9}$/', $_POST['telefono'])) {
            $validation = false;
        }


        if(!is_numeric($_POST['region'])){
            $validation = false;
        }


        if(!is_numeric($_POST['ayuda'])){
            $validation = false;
        }

        if (strlen($_POST['asunto']) > 525){
            $validation = false;
        }

        if(strlen($_POST['correo']) > 100){
            $validation = false;
        }


        $save = [
            'result' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST && Utils::validateToken() && $validation) {

               
            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);

            if (
                filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) && !empty($_POST['ayuda']) && !empty($_POST['region'])
                && !empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['nombre_org'])
                && !empty($_POST['asunto']) && $_POST == $clean
            ) {

                if ($clean["region"] <= 5) {
                    $clean['zona_form'] = 1;
                } else if ($clean["region"] > 8) {
                    $clean['zona_form'] = 3;
                } else {
                    $clean['zona_form'] = 2;
                }

                $usuario = new orgRequest($clean);
                $usuario->sincronizar($clean);
                $save = $usuario->guardar();

                if ($save) {

                    $correo = $clean['correo'];
                    $email = new Email($correo);
                    $sent = $email->orgRequest($clean);
                    $save = ['result' => true, 'type' => 'org'];
                }

                //Utils::deleteToken();

                echo json_encode($save);
            } else {
                echo json_encode($save);
            }
        } else {
            echo json_encode($save);
        }
    }

    public static function orgListRequest(View $view)
    {

        $auth = Utils::isAdmin();

        $formsTable = OrgRequest::all();
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $view->make('admin/org/inscriptionList', ["formsTable" => $formsTable, "csrf" => $csrf]);
    }

    public static function orgRequestDetail(View $view, Route $route)
    {
        $auth = Utils::isAdmin();

        $id_form = $route->getParameters();
        $id_form = $id_form['id'];
        $id_form = (int)$id_form;

        $cod = Utils::sameId($id_form);

        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $stat = new Status();
        $options = $stat->all();

        $form = new OrgRequest();
        $detail = $form->where('id', $id_form);
        $sql = "SELECT f.id, u.nombre, u.apellido, status_by FROM org_form f ";
        $sql .= "INNER JOIN admins u ";
        $sql .= "ON f.status_by = u.id ";
        $sql .= "WHERE f.status_by = $detail->status_by";

        if (!empty($detail->status_by)) {
            $user = $form->objetoSql($sql);
        }

        $view->make('admin/org/inscriptionDetail', ["detail" => $detail, "csrf" => $csrf, 'user' => $user, 'options' => $options, 'cod' => $cod]);
    }

    public static function statusUpdate()
    {

        $auth = Utils::isAdmin();

	if(!empty($_FILES)){
            exit;
        }

        $adsave = [
            'result' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && Utils::validateSame() && $auth && is_numeric($_POST['stat'])) {


            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);


            if ($_POST = $clean) {

                $form = OrgRequest::where('id', $clean['cod']);

                $admin = $_SESSION['id'];

                $by = $form->simpleUpdate('status_by', $admin);

                if ($by) {
                    $update = $form->simpleUpdate('status', $clean["stat"]);
                    if ($update) {
                        if ($clean["stat"] == 4) {

                            $id_form = (int)$clean['cod'];

                            $admin = $_SESSION['nombre'];

                            $update = $form->simpleUpdate('date_approved', date('Y-m-d H:i:s'));

                            $sql = "SELECT admin_observation FROM org_form WHERE id = $id_form";
                            $prev = $form->SQL($sql);
                            $prev_text = $prev[0]->admin_observation;

                            $new_add = "<strong>[Organización aprobada por admin " . $admin . " el " . date('d-m-Y H:i') . "]</strong><br>";
                            $final_text = $prev_text . $new_add;
                            $update = $form->simpleUpdate('admin_observation', $final_text);
                        } else {
                            $id_form = (int)$clean['cod'];

                            $stat = $clean["stat"];

                            $admin = $_SESSION['nombre'];;

                            $sql = "SELECT admin_observation FROM org_form WHERE id = $id_form";
                            $prev = $form->SQL($sql);
                            $prev_text = $prev[0]->admin_observation;

                            $new_add = "[Status actualizado a " . $stat . " por admin: " . $admin . " el " . date('d-m-Y H:i:s') . "]<br>";
                            $final_text = $prev_text . $new_add;
                            $update = $form->simpleUpdate('admin_observation', $final_text);
                        }
                        $adsave = [
                            'result' => true
                        ];
                    }
                }
            }
        }

     echo json_encode($adsave);

    }

    public static function obsUpdate()
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

        if (!empty($obs) && strlen($obs) >= 2 && strlen($obs) < 5000 ) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && Utils::validateSame() && $auth) {


                $xss = new AntiXSS();

                $clean = $xss->xss_clean($_POST);


                if ($_POST === $clean) {

                    $id_form = (int)$clean['cod'];

                    $form = OrgRequest::where('id', $id_form);


                    $admin = $_SESSION['nombre'];

                    $sql = "SELECT admin_observation FROM org_form WHERE id = $id_form";
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

    public static function registeredList(View $view)
    {

        $auth = Utils::isAdmin();

        $sql = "SELECT * FROM org_form WHERE status = 4 OR status = 9";
        $formsTable = OrgRequest::consultarSQL($sql);
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];

        $view->make('admin/org/registeredList', ["formsTable" => $formsTable, "csrf" => $csrf]);
    }


    public static function createOrg(View $view)
    {
        $auth = Utils::isAdmin();

	 $orgsave = [
            'result' => false
        ];

        if (!empty($_POST)) {

            $validation = true;

            if (!is_numeric($_POST['registered'])) {
                $validation = false;
            }

            if (!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,100}$/', $_POST['nombre'])) {
                $validation = false;
            }

            if (!empty($_POST['telefono'])) {

                if (!preg_match('/^\d{9}$/', $_POST['telefono'])) {
                    $validation = false;
                }
            }


            if (!is_numeric($_POST['region'])) {
                $validation = false;
            }


            if (!is_numeric($_POST['ayuda'])) {
                $validation = false;
            }

            if (strlen($_POST['descripcion']) > 10000) {
                $validation = false;
            }

            if (strlen($_POST['correo']) > 100) {
                $validation = false;
            }

            if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
                $validation = false;
            }

            if (strlen($_POST['direccion']) > 350) {
                $validation = false;
            }

            if (strlen($_POST['in_link']) > 200) {
                $validation = false;
            }
            if (strlen($_POST['fb_link']) > 200) {
                $validation = false;
            }
            if (strlen($_POST['tw_link']) > 200) {
                $validation = false;
            }

            if(!$validation){
                echo json_encode($orgsave);
                exit();
            }
        }



        //$jsc = "<script src='" . SERVERURL . "build/js/va-createdit-org.js'></script>";

        if ($_SERVER["REQUEST_METHOD"] === 'POST' && Utils::validateToken() && $_POST["nombre"] != "" && !empty($_POST['registered']) && $auth && $validation ) {

            $xssCss =  new AntiXSS();
            $xssCss->removeEvilAttributes(array('style'));
            $whitCss = $xssCss->xss_clean($_POST['descripcion']);

            $xss = new AntiXSS();
            $clean = $xss->xss_clean($_POST);
            $clean = array_filter($clean);

            $approved = $clean['registered'];


            if ($clean["region"] <= 5) {
                $clean['zona'] = 1;
            } else if ($clean["region"] > 8) {
                $clean['zona'] = 3;
            } else {
                $clean['zona'] = 2;
            }

            if (!preg_match('/^[1-9][0-9]{8}+$/', $clean['telefono'])) {
                $clean["telefono"] = null;
            }

            $cleanDesc = array_search($clean["descripcion"], $clean);
            $clean[$cleanDesc] = $whitCss;


            $random = Utils::generateRandomString();
            $folder = '/build/img/org/' . $clean["nombre"] . $random . '/';
            $folder = str_replace(" ", "-", $folder);

            if (!is_dir($folder)) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . $folder, 0755, true);
            }

            $folder_path = 'build/img/org/' . $clean["nombre"] . $random . '/';
            $folder_path = str_replace(" ", "-", $folder_path);

            if ($clean) {
                $clean['path'] = $folder_path;

                $organizacion = new Organizacion($clean);

                $orgsave = $organizacion->guardar();

                if ($orgsave) {
                    $published = OrgRequest::where('id', $approved);

                    $published->simpleUpdate('published', date('Y-m-d H:i:s'));
                    $published->simpleUpdate('status', 9);

                    $admin = $_SESSION['nombre'];
                    $ad_id = $_SESSION['id'];

                    $sql = "SELECT admin_observation FROM org_form WHERE id = $approved ";
                    $prev = $published->SQL($sql);
                    $prev_text = $prev[0]->admin_observation;
                    $new_add = "<strong>[Organización (" . $clean['nombre'] . ") publicada por admin " . $admin . " el " . date('d-m-Y H:i:s') . "]</strong><br>";
                    $final_text = $prev_text . $new_add;
                    $published->simpleUpdate('admin_observation', $final_text);
                    $published->simpleUpdate('status_by', $ad_id);
                }
            }

            echo json_encode($orgsave);
        } else {

            $formsTable = OrgRequest::allWhere('status', 4);
            $org = Organizacion::all();
            $zone = Zona::all();
            $cat_ayuda = Categoria::all();
            $regiones = Regiones::all();
            //$csrf = Utils::createToken();
            $csrf = $_SESSION['token'];


            $view->make('admin/org/createOrg', ["org" => $org, "zone" => $zone, "cat_ayuda" => $cat_ayuda, "regiones" => $regiones, "csrf" => $csrf, 'formsTable' => $formsTable]);
        }
    }

    public static function uploadImgOrg(View $view)
    {
        $auth = Utils::isAdmin();

        if ($_SERVER["REQUEST_METHOD"] === 'POST' && Utils::validateToken() && $auth) {

            $xss = new AntiXSS();

            $org_name = $xss->xss_clean($_POST['nameOrg']);


            if (!empty($_POST["profile"]) && $_POST["profile"] === "update") {
                $select_image = $xss->xss_clean($_POST["selectImage"]);
                $path = Organizacion::where('nombre_organizacion', $org_name);
                $path->simpleUpdate('url_imagen', $select_image);
                echo json_encode(['update' => true, 'data' => $select_image]);
                die();
            }


            if (count($_FILES['upload_files']['error']) <= 15) {


                $clean = $xss->xss_clean($_POST);

                $pic_name = $clean['profilePic'];

                $filter_name = array_values(array_filter($_FILES['upload_files']['name']));
                $filter_size = array_values(array_filter($_FILES['upload_files']['size']));
                $filter_type = array_values(array_filter($_FILES['upload_files']['type']));
                $filter_tmp = array_values(array_filter($_FILES['upload_files']['tmp_name']));


                if ($_POST['nameOrg'] != '' && count($filter_name) <= 15 && $_POST = $clean) {

                    $path = Organizacion::where('nombre_organizacion', $org_name);

                    $dir_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $path->folder_path;

                    if (is_dir($dir_path) && !empty($path)) {

                        $files = array_diff(scandir($dir_path), array('..', '.'));
                        $files_dir = count($files);


                        if (($files_dir + count($filter_name)) <= 15) {

                            $dts = $_POST['dts'];
                            $ttt = explode(',', $dts);
                            $others_image_last = '';
                            $image_link = $_SERVER['DOCUMENT_ROOT'] . "/" . $path->folder_path;

                            for ($i = 0; $i <= 5; $i++) {

                                if (in_array($i + 1, $ttt)) {
                                } else {

                                    if ($filter_size[$i] < 4194304) {

                                        $image_type = $filter_type[$i];

                                        $image_temp_name = $filter_tmp[$i];

                                        if (($image_type == "image/jpeg") || ($image_type == "image/png") || ($image_type == "image/pjpeg") || ($image_type == "image/jpg")) {

                                            $new_file = md5(rand());
                                            $image_name = $filter_name[$i];

                                            $test = explode('.', $image_name);
                                            $name = $new_file . '.' . end($test);
                                            $name_profile_pic = $image_name . $name;
                                            $check_name = substr($name_profile_pic, 0, -36);

                                            if ($check_name == $pic_name) {
                                                $check_true = substr($name_profile_pic, -36);
                                            } else {
                                                $not_profile = $name;
                                            }
                                            $url = $image_link . $name;

                                            $info = getimagesize($image_temp_name);
                                            if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($image_temp_name);
                                            elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($image_temp_name);
                                            elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($image_temp_name);
                                            imagejpeg($image, $url, 60);
                                        }
                                    }
                                }
                            }
                        }

                        if (isset($check_true) && !empty($check_true) && $check_true != '') {
                            $path->simpleUpdate('url_imagen', $check_true);
                        } else {
                            $path->simpleUpdate('url_imagen', $not_profile);
                        }
                    }

                    //Utils::deleteToken();
                }
            }
        } else {
            //$csrf = Utils::createToken();
            $csrf = $_SESSION['token'];

            $view->make('admin/org/images_upload', ["csrf" => $csrf]);
        }
    }



    public static function orgPreview(View $view)
    {
        $auth = Utils::isAdmin();
        $view->make('admin/org/preview');
    }


    public static function orgList(View $view)
    {

        $auth = Utils::isAdmin();
        $query = "SELECT o.id, nombre_organizacion, correo_org, id_registered, telefono_org, direccion_org, id_ayuda_entregada, org_zona_id, fecha_creacion_org, r.region, org_name ";
        $query .= " FROM organizaciones o INNER JOIN regiones r ON o.id_region = r.id ";
        $query .= " INNER JOIN org_form f ON o.id_registered = f.id ";
        //$csrf = Utils::createToken();
        $csrf = $_SESSION['token'];
        $org = Organizacion::objetoSql($query);




        $view->make('admin/org/orgList', ["org" => $org, "csrf" => $csrf]);
    }


    public static function deleteOng()
    {
        $auth = Utils::isAdmin();

        $json = [
            'result' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && $auth) {

            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);

            $admin = Organizacion::where('nombre_organizacion', $clean['id']);

            try {


                $delete = $admin->eliminar();
            } catch (Exception $e) {

                $e->getMessage();
            }


            if ($delete) {

                $del = OrgRequest::where('id', $admin->id_registered);

                $del->simpleUpdate('status', 8);

                $ad_name = $_SESSION['nombre'];

                $org_form = $admin->id_registered;
                $org_name = $admin->nombre_organizacion;
                $ad_id = $_SESSION['id'];



                $sql = "SELECT admin_observation FROM org_form WHERE id = $org_form";
                $prev = $del->SQL($sql);
                $prev_text = $prev[0]->admin_observation;
                $new_add = "<strong>[Organización publicada (" . $org_name . "  - id : " . $admin->id . " ) dada de baja - eliminada por admin " . $ad_name . " el " . date('d-m-Y H:i:s') . "]</strong><br>";
                $final_text = $prev_text . $new_add;
                $del->simpleUpdate('admin_observation', $final_text);
                $del->simpleUpdate('status_by', $ad_id);


                $folder = $_SERVER['DOCUMENT_ROOT'] . "/" . $admin->folder_path;


                Utils::rrmdir($folder);

                $json = [
                    'result' => true,
                    'user' => $clean['id']
                ];
            }

            //Utils::deleteToken();
        }

        echo json_encode($json);
    }

    public static function deleteImg()
    {
        $auth = Utils::isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && $auth) {


            $json = [
                'result' => false
            ];

            $xss = new AntiXSS();

            $clean = $xss->xss_clean($_POST);

            $org = Organizacion::where('nombre_organizacion', $clean['id']);

            $name = $clean['nameImg'];
            $path_image = $_SERVER['DOCUMENT_ROOT'] . "/" . $org->folder_path . $name;


            if (file_exists($path_image)) {

                unlink($path_image);

                if ($name == $org->url_imagen) {

                    $org->simpleUpdate('url_imagen', null);
                }

                $del = OrgRequest::where('id', $org->id_registered);

                $ad_name = $_SESSION['nombre'];

                $org_form = $org->id_registered;
                $org_name = $org->nombre_organizacion;
                $ad_id = $_SESSION['id'];


                $sql = "SELECT admin_observation FROM org_form WHERE id = $org_form";
                $prev = $del->SQL($sql);
                $prev_text = $prev[0]->admin_observation;
                $new_add = "<strong>[Se ha eliminado una imagen de la organización publicada (" . $org_name . "  - id : " . $org->id . " ) por admin " . $ad_name . " el " . date('d-m-Y H:i:s') . "]</strong><br>";
                $final_text = $prev_text . $new_add;
                $del->simpleUpdate('admin_observation', $final_text);
                $del->simpleUpdate('status_by', $ad_id);


                $json = [
                    'result' => true,
                    'image' => $name
                ];
            }

            echo json_encode($json);
        }
    }



    public static function editOrg(View $view, Route $route)
    {
        $auth = Utils::isAdmin();

        //$jsc = "<script src='" . SERVERURL . "build/js/va-createdit-org.js'></script>";

        $adsave = [
            'result' => false
        ];


	 if (!empty($_POST)) {

            $validation = true;


            if (!empty($_POST['telefono_org'])) {

                if (!preg_match('/^\d{9}$/', $_POST['telefono_org'])) {
                    $validation = false;
                }

            }else{
                $_POST['telefono_org'] = 'Sin teléfono registrado.';
            }



            if (!is_numeric($_POST['id_region'])) {
                $validation = false;
            }


            if (!is_numeric($_POST['id_ayuda_entregada'])) {
                $validation = false;
            }

            if (strlen($_POST['descripcion_organizacion']) > 10000) {
                $validation = false;
            }

            if (strlen($_POST['correo_org']) > 100) {
                $validation = false;
            }

            if (!filter_var($_POST['correo_org'], FILTER_VALIDATE_EMAIL)) {
                $validation = false;
            }

            if(!empty($_POST['direccion_org'])){

                if (strlen($_POST['direccion_org']) > 350) {
                    $validation = false;
                }

            }else{
                $_POST['direccion_org'] = 'Sin dirección registrada.';
            }

            if (strlen($_POST['in_link']) > 200) {
                $validation = false;
            }
            if (strlen($_POST['fb_link']) > 200) {
                $validation = false;
            }
            if (strlen($_POST['tw_link']) > 200) {
                $validation = false;
            }

            if(!$validation){
                echo json_encode($adsave);
                exit();
            }
        }



        $id = $route->getParameters();
        $id = (int)$id['id'];

        $org = new Organizacion();

        $user = $org->where('id', $id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && $auth) {


            $xssCss = new AntiXSS();
            $xssCss->removeEvilAttributes(array('style'));
            $whitCss = $xssCss->xss_clean($_POST['descripcion_organizacion']);

            $xss = new AntiXSS();
            $clean = $xss->xss_clean($_POST);
            $clean = array_filter($clean);

            $cleanDesc = array_search($clean["descripcion_organizacion"], $clean);
            $clean[$cleanDesc] = $whitCss;

            if ($clean["id_region"] <= 5) {
                $clean['org_zona_id'] = 1;
            } else if ($clean["id_region"] > 8) {
                $clean['org_zona_id'] = 3;
            } else {
                $clean['org_zona_id'] = 2;
            }

            if (!isset($clean["direccion_org"])) {
                $clean["direccion_org"] = null;
            }

            if (!isset($clean["in_link"])) {
                $clean["in_link"] = null;
            }

            if (!isset($clean["fb_link"])) {
                $clean["fb_link"] = null;
            }

            if (!isset($clean["tw_link"])) {
                $clean["tw_link"] = null;
            }


           /* if (!isset($clean['telefono_org']) || !preg_match('/^[1-9][0-9]{8}+$/', $clean['telefono_org'])) {
                $clean["telefono_org"] = null;
                $invalid = true;
            } */


            /*if (!preg_match('/^[0-9]{9}+$/', $clean["telefono"]) || $clean["telefono"] = "") {
                $clean['telefono'] = '0';
            }*/


            $mail = $clean['correo_org'];

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                $clean['nombre_organizacion'] = $user->nombre_organizacion;
                //$clean['id'] = $user->id;
                $clean["org_editado"] = date("Y-m-d H:i:s");




                unset($clean["csrf"]);

                foreach ($clean as $key => $value) {
                    $update = $user->simpleUpdate("{$key}", "{$value}");
                    if ($update['result'] === true) {
                        if ($key === array_key_last($clean)) {
                            $adsave =  $user->simpleUpdate($key, $value);
                        }
                    } else {
                        break;
                    }
                }

                $edit = OrgRequest::where('id', $user->id_registered);

                $admin = $_SESSION['nombre'];

                $org_form = $user->id_registered;
                $org_name = $user->nombre_organizacion;

                $sql = "SELECT admin_observation FROM org_form WHERE id = $org_form ";
                $prev = $edit->SQL($sql);
                $prev_text = $prev[0]->admin_observation;
                $new_add = "<strong>[Organización( " . $org_name . "  - id : " . $user->id . " ) editada por admin " . $admin . " el " . date('d-m-Y H:i:s') . "]</strong><br>";
                $final_text = $prev_text . $new_add;
                $edit->simpleUpdate('admin_observation', $final_text);
            }

            echo json_encode($adsave);
        } else {


            //$csrf = Utils::createToken();
            $ins_org = OrgRequest::where('id', $user->id_registered);
            $csrf = $_SESSION['token'];
            $zone = Zona::all();
            $regiones = Regiones::all();
            $cat_ayuda = Categoria::all();

            $view->make('admin/org/orgEdit', [
                "csrf" => $csrf,
                "regiones" => $regiones,
                "zone" => $zone,
                "cat_ayuda" => $cat_ayuda,
                "user" => $user,
                "ins_org" => $ins_org

            ]);
        }
    }
}
