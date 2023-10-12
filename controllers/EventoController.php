<?php

namespace Controllers;

use MiladRahimi\PhpRouter\View\View;
use MiladRahimi\PhpRouter\Routing\Route;
use Model\Evento;
use Model\Zona;
use Model\Categoria;
use voku\helper\AntiXSS;
use Classes\Utils;
use Model\Organizacion;
use Model\OrgRequest;

class EventoController
{

  public static function index(View $view)
  {

    $sql = "SELECT e.id, nombre_evento, fecha_evento, direccion_evento, hora_evento, id_cat_ayuda, id_org, e.folder_path, url_img_evento, telefono_org, correo_org, cat_ayuda, icono ";
    $sql .= " FROM eventos e ";
    $sql .= " INNER JOIN categoria_ayuda c ";
    $sql .= " ON e.id_cat_ayuda=c.id ";
    $sql .= " INNER JOIN organizaciones o ";
    $sql .= " ON e.id_org=o.id ";
    $sql .= " ORDER BY e.id ASC LIMIT 6 ";

    $fetch = Evento::objetoSql($sql);

    $color = "rgb(235 235 235 / 40%);";
    $a = "#47454a;";


    $view->make('visita/eventos', [
      'fetch' => $fetch,
      'sql' => $sql,
      'color' =>$color,
      'a' => $a
    ]);
  }

  public static function dataEvent()
  {

    if (isset($_POST["eventoid"]) && !empty($_POST["eventoid"]) && empty($_POST["id"]) && Utils::validateToken()) {

      $xss = new AntiXSS();
       
      $lastID = $xss->xss_clean($_POST['eventoid']);

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

        $sentence1 = " WHERE eve_zona_id = $zona_id AND ";
        $sentence2 = " AND zona = '$zona' ";


        if ($zona === 'todo') {
          $sentence1 = " WHERE ";
          $sentence2 = " ";
        }

        $str = "SELECT COUNT(*) as num_rows FROM eventos $sentence1 id > " . $lastID . " ORDER BY id ASC";

        $rowAll = Evento::objetoSql($str);

        $allNumRows = $rowAll;

        $sql = "SELECT e.id, nombre_evento, fecha_evento, hora_evento, direccion_evento, eve_zona_id, zona, cat_ayuda, e.folder_path, url_img_evento, icono ";
        $sql .= " FROM eventos e ";
        $sql .= " INNER JOIN categoria_ayuda c ";
        $sql .= " ON e.id_cat_ayuda = c.id ";
        $sql .= " INNER JOIN zonas z ";
        $sql .= " ON e.eve_zona_id = z.id ";
        $sql .= " WHERE e.id > " . $lastID . $sentence2 . " ORDER BY e.id ASC LIMIT " . "$showLimit ";
        $result = Evento::objetoSql($sql);



        require_once __DIR__ . '/../views/visita/eventinfo.php';
      } else {


        $queryAll = "SELECT COUNT(*) as num_rows FROM eventos WHERE id > " . $lastID . " ORDER BY id ASC";

        $rowAll = Evento::objetoSql($queryAll);
        $allNumRows = $rowAll;

        //Get rows by limit except already displayed
        $sql = "SELECT e.id, nombre_evento, fecha_evento, hora_evento, direccion_evento, eve_zona_id, cat_ayuda, e.folder_path, url_img_evento, icono ";
        $sql .= " FROM eventos e ";
        $sql .= " INNER JOIN categoria_ayuda c ";
        $sql .= " ON e.id_cat_ayuda = c.id ";
        $sql .= " WHERE e.id > " . $lastID . " ORDER BY e.id ASC LIMIT " . "$showLimit ";


        $result = Evento::objetoSql($sql);

        require_once __DIR__ . '/../views/visita/eventinfo.php';
      }
    }
  }


  public static function eventPage(Route $route, View $view)
  {

    $xss = new AntiXSS();
    $clean = $xss->xss_clean($_GET["e"]);
    $evento_name = $clean;

    $sql = "SELECT e.id, nombre_evento, fecha_evento, hora_evento, direccion_evento, descripcion_evento, id_cat_ayuda, id_org, e.folder_path, url_img_evento, telefono_org, correo_org,
    fb_link, in_link, tw_link, cat_ayuda, nombre_organizacion";
    $sql .= " FROM eventos e ";
    $sql .= " INNER JOIN categoria_ayuda c ";
    $sql .= " ON e.id_cat_ayuda=c.id ";
    $sql .= " INNER JOIN organizaciones o ";
    $sql .= " ON e.id_org=o.id";
    $sql .= " WHERE e.id = '$evento_name' ";

    $color = "rgb(106 237 184 / 40%);";
    $a = "#47454a;";

    $fetch = Evento::objetoSql($sql);

    $view->make('evento/page', [
      "fetch" => $fetch,
      'color' => $color,
      'a' => $a
    ]);
  }

  public static function eventList(View $view)
  {
    $auth = Utils::isAdmin();


    //$csrf = Utils::createToken();
    $csrf = $_SESSION['token'];

    $sql = "SELECT e.id, nombre_evento, fecha_evento, direccion_evento, id_org, e.folder_path as path ,hora_evento, zona, cat_ayuda, creation_date, nombre_organizacion, telefono_org ";
    $sql .= " FROM eventos e ";
    $sql .= " INNER JOIN zonas z ";
    $sql .= " ON e.eve_zona_id=z.id ";
    $sql .= " INNER JOIN categoria_ayuda c ";
    $sql .= " ON e.id_cat_ayuda=c.id ";
    $sql .= " INNER JOIN organizaciones o ";
    $sql .= " ON e.id_org=o.id";


    $event = Evento::objetoSql($sql);


    $view->make('admin/event/eventList', ["event" => $event, "csrf" => $csrf]);
  }


  public static function createEvent(View $view)
  {
    $auth = Utils::isAdmin();

    //$jsc = "<script src='" . SERVERURL . "build/js/va-createdit-eve.js'></script>";

    $eventsave = [
      'result' => false
    ];

    if (!empty($_POST)) {

      $validation = true;

      if (!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,100}$/', $_POST['nombre'])) {
        $validation = false;
      }

      if (!preg_match('/^[\d:-]{1,20}$/', $_POST['fecha'])) {
        $validation = false;
      }

      if (!preg_match('/^[\d:-]{1,20}$/', $_POST['hora'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['org'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['zona'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['ayuda'])) {
        $validation = false;
      }

      if (strlen($_POST['descripcion']) > 10000) {
        $validation = false;
      }

      if (strlen($_POST['address']) > 350) {
        $validation = false;
      }

      if (!$validation) {
        echo json_encode($eventsave);
        exit();
      }
    }


    if ($_SERVER["REQUEST_METHOD"] === 'POST' && Utils::validateToken() && $_POST["nombre"] != "" && $auth && $validation ) {

      $eventsave = ['result' => false];

      $xssCss = new AntiXSS();
      $xssCss->removeEvilAttributes(array('style'));
      $whitCss = $xssCss->xss_clean($_POST['descripcion']);

      $xss = new AntiXSS();
      $clean = $xss->xss_clean($_POST);
      $clean = array_filter($clean);

      $cleanDesc = array_search($clean["descripcion"], $clean);
      $clean[$cleanDesc] = $whitCss;


      $random = Utils::generateRandomString();

      $check = [($_FILES['file']['name'])];

      if (!empty($_FILES['file']['name']) && sizeof($check) == 1 && ($_FILES["file"]["size"] < 4194304)) {

        $image_type = $_FILES["file"]["type"];

        if (($image_type == "image/jpeg") || ($image_type == "image/png") || ($image_type == "image/pjpeg") || ($image_type == "image/jpg")) {
          $image_name = $_FILES["file"]["name"];
          $folder = '/build/img/event/' . $clean["nombre"] . $random . '/';
          $folder = str_replace(" ", "-", $folder);
          if (!is_dir($folder)) {

            mkdir($_SERVER['DOCUMENT_ROOT'] . $folder, 0755, true);
            $name = "";
            $folder = $_SERVER['DOCUMENT_ROOT'] . $folder;
          }
          if (is_dir($folder)) {

            $new_file = md5(rand());
            $test = explode('.', $image_name);
            $name = $new_file . '.' . end($test);
            $_FILES["file"]["name"] = $name;
            $image_temp_name = $_FILES["file"]["tmp_name"];
            $info = getimagesize($image_temp_name);
            $url = $folder . $name;
            if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($image_temp_name);
            elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($image_temp_name);
            elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($image_temp_name);
            if (imagejpeg($image, $url, 60)) {

              $folder_path = 'build/img/event/' . $clean["nombre"] . $random . '/';
              $folder_path = str_replace(" ", "-", $folder_path);
            }
            
          }
        }
      }


      if (isset($folder_path) && !empty($folder_path)) {
        $clean['path'] = $folder_path;
        $clean['img'] = $name;

        $event = new Evento($clean);

        $eventsave = $event->guardar();

        $org = Organizacion::where('id', $clean['org']);

        $form = OrgRequest::where('id', $org->id_registered);

        $admin = $_SESSION['nombre'];
        $ad_id = $_SESSION['id'];

        $sql = "SELECT admin_observation FROM org_form WHERE id = $org->id_registered ";
        $prev = $form->SQL($sql);
        $prev_text = $prev[0]->admin_observation;
        $new_add = "<strong>[Evento asociado ". $clean['nombre']  ." publicado por admin " . $admin . " el ". date('d-m-Y H:i:s') . "]</strong><br>";
        $final_text = $prev_text . $new_add;
        $form->simpleUpdate('admin_observation', $final_text);

      }

      echo json_encode($eventsave);
    } else {

      $evento = Evento::all();
      $zone = Zona::all();
      $cat_ayuda = Categoria::all();
      //$csrf = Utils::createToken();
      $csrf = $_SESSION['token'];
      $org = Organizacion::all();


      $view->make('admin/event/createEvent', ["evento" => $evento, "zone" => $zone, "cat_ayuda" => $cat_ayuda, "csrf" => $csrf, "org" => $org]);
    }
  }

  public static function editEvent(View $view, Route $route)
  {
    $auth = Utils::isAdmin();

    //$jsc = "<script src='" . SERVERURL . "build/js/va-createdit-eve.js'></script>";

    $adsave = [
      'result' => false
    ];

    if (!empty($_POST)) {

      $validation = true;

      if (!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,100}$/', $_POST['nombre_evento'])) {
        $validation = false;
      }

      if (!preg_match('/^[\d:-]{1,20}$/', $_POST['fecha_evento'])) {
        $validation = false;
      }

      if (!preg_match('/^[\d:-]{1,20}$/', $_POST['hora_evento'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['id_org'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['eve_zona_id'])) {
        $validation = false;
      }

      if (!is_numeric($_POST['id_cat_ayuda'])) {
        $validation = false;
      }

      if (strlen($_POST['descripcion_evento']) > 10000) {
        $validation = false;
      }

      if (strlen($_POST['direccion_evento']) > 350) {
        $validation = false;
      }

      if (!$validation) {
        echo json_encode($adsave);
        exit();
      }
    }

    $event_id = $route->getParameters();
    $event_id = (int)$event_id['id'];

    $event = new Evento();

    $user = $event->where('id', $event_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && $auth && $validation) {

      //isAdmin();

      $xssCss = new AntiXSS();
      $xssCss->removeEvilAttributes(array('style'));
      $whitCss = $xssCss->xss_clean($_POST['descripcion_evento']);

      $xss = new AntiXSS();
      $clean = $xss->xss_clean($_POST);
      $clean = array_filter($clean);

      $cleanDesc = array_search($clean["descripcion_evento"], $clean);
      $clean[$cleanDesc] = $whitCss;

     
      if ($_POST = $clean) {

        $clean['nombre'] = $user->nombre_evento;
        $clean['id'] = $user->id;


        $folder = "/" . $user->folder_path;

        $event_id = $user->id;


        if (!empty($_FILES["file"])) {

          $check = [($_FILES['file']['name'])];

          if (is_dir($_SERVER['DOCUMENT_ROOT'] . $folder) && !empty($_FILES['file']['name']) && sizeof($check) == 1 && ($_FILES["file"]["size"] < 4194304)) {
            $image_type = $_FILES["file"]["type"];

            if (($image_type == "image/jpeg") || ($image_type == "image/png") || ($image_type == "image/pjpeg") || ($image_type == "image/jpg")) {
              $image_name = $_FILES["file"]["name"];
              $new_file = md5(rand());
              $test = explode('.', $image_name);
              $name = $new_file . '.' . end($test);
              $_FILES["file"]["name"] = $name;
              $image_temp_name =  $_FILES["file"]["tmp_name"];
              $info = getimagesize($image_temp_name);
              $url = $_SERVER['DOCUMENT_ROOT'] . $folder . $name;
              if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($image_temp_name);
              elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($image_temp_name);
              elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($image_temp_name);
              if (imagejpeg($image, $url, 60)) {
              }
             
              if (unlink($_SERVER['DOCUMENT_ROOT'] . $folder . $user->url_img_evento)) {
                $clean['url_img_evento'] = $name;
              }
              
              $clean["editado"] = date("Y-m-d H:i:s");
              $user->sincronizar($clean);

              $adsave = $user->actualizar();
            }
          }
        }

        
        $clean["editado"] = date("Y-m-d H:i:s");
        $user->sincronizar($clean);

        $adsave = $user->actualizar();


        $org = Organizacion::where('id', $clean['id_org']);

        $form = OrgRequest::where('id', $org->id_registered);

        $admin = $_SESSION['nombre'];
        $ad_id = $_SESSION['id'];

        $sql = "SELECT admin_observation FROM org_form WHERE id = $org->id_registered ";
        $prev = $form->SQL($sql);
        $prev_text = $prev[0]->admin_observation;
        $new_add = "<strong>[Evento asociado ". $clean['nombre_evento']  ."(id: " . $event_id .") editado por admin " . $admin . " el ". date('d-m-Y H:i:s') . "]</strong><br>";
        $final_text = $prev_text . $new_add;
        $form->simpleUpdate('admin_observation', $final_text);
      }

      echo json_encode($adsave);
    } else {

      //$csrf = Utils::createToken();
      $csrf = $_SESSION['token'];
      $zone = Zona::all();
      $ayuda = Categoria::all();
      $org = Organizacion::all();

      $view->make('admin/event/eventEdit', [
        "csrf" => $csrf,
        "zone" => $zone,
        "ayuda" => $ayuda,
        "user" => $user,
        "org" => $org
       
      ]);
    }
  }

  public static function deleteEvent()
  {
    $auth = Utils::isAdmin();


    $json = [
      'result' => false
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && Utils::validateToken() && $auth) {

      $xss = new AntiXSS();

      $clean = $xss->xss_clean($_POST);

      $event = Evento::where('folder_path', $clean['id']);

      $event_name = $event->nombre_evento;
      $event_id = $event->id;

      $delete = $event->eliminar();

      if ($delete) {

        $org = Organizacion::where('id', $event->id_org);

        $form = OrgRequest::where('id', $org->id_registered);

        $admin = $_SESSION['nombre'];
        $ad_id = $_SESSION['id'];

        $sql = "SELECT admin_observation FROM org_form WHERE id = $org->id_registered ";
        $prev = $form->SQL($sql);
        $prev_text = $prev[0]->admin_observation;
        $new_add = "<strong>[Evento asociado ". $event_name  ."(id: ". $event_id .") eliminado por admin " . $admin . " el ". date('d-m-Y H:i:s') . "]</strong><br>";
        $final_text = $prev_text . $new_add;
        $form->simpleUpdate('admin_observation', $final_text);

        $folder = $_SERVER['DOCUMENT_ROOT'] . "/" . $event->folder_path;

        Utils::rrmdir($folder);

        $json = [
          'result' => true,
          'user' => $clean['id'],
        ];
      }

      //Utils::deleteToken();
    }

    echo json_encode($json);
  }
}
