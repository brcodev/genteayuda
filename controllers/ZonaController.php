<?php

namespace Controllers;

use Classes\Utils;
use Model\Zona;
use voku\helper\AntiXSS;

class ZonaController
{

  public static function dataZona()
  {

    $xss = new AntiXSS();

    if (isset($_POST["zona"]) && !empty($_POST["zona"]) && empty($_POST["event"]) && isset($_POST['cat']) && Utils::validateToken()) {

      
      $zona = $xss->xss_clean($_POST["zona"]);
      $categoria = $xss->xss_clean($_POST['cat']);
      $sentence =  " AND zona = '$zona' ";

      if ($zona === 'todo') {
        $sentence = " ";
      }

      $sql = "SELECT o.id, nombre_organizacion, correo_org, telefono_org, direccion_org, zona, cat_ayuda, folder_path, url_imagen, icono ";
      $sql .= " FROM organizaciones o ";
      $sql .= " INNER JOIN categoria_ayuda c ";
      $sql .= " ON o.id_ayuda_entregada=c.id ";
      $sql .= " INNER JOIN zonas z ";
      $sql .= " ON o.org_zona_id = z.id ";
      $sql .= " WHERE cat_ayuda = '$categoria ' $sentence ";
      $sql .= " ORDER BY o.id ASC LIMIT 6 ";
      $resultado = Zona::objetoSql($sql);

      if(empty($resultado)){
        if($categoria == "Vestuario"){
          $categoria = "en vestuario";
        }
        
        if($zona == 'todo'){
          $zona = "norte, centro y sur";
        }
          echo '<h1 class="region-h1 error-zone-none" style="text-align: center; margin-bottom: 5rem; visibility:hidden" > No se encotraron Organizaciones que entreguen ayuda ' .$categoria. ' en la zona ' . $zona . '.</h1>';
          echo '<h1 class="region-h1 error-zone" style="text-align: center; margin-bottom: 5rem" > No se encotraron Organizaciones que entreguen ayuda ' .$categoria. ' en la zona ' . $zona . '.</h1>';
      
        }

      require_once __DIR__."/../views/visita/zona.php";

    }else if (isset($_POST["zona"]) && !empty($_POST["zona"]) && !empty($_POST["event"]) && Utils::validateToken()){

      $zona = $xss->xss_clean($_POST["zona"]);
      $sentence =  " WHERE zona = '$zona' ";

      if ($zona === 'todo') {
        $sentence = " ";
      }

      $sql = "SELECT e.id, nombre_evento, fecha_evento, hora_evento, direccion_evento, eve_zona_id, zona, cat_ayuda, folder_path , url_img_evento, icono ";
      $sql .= " FROM eventos e ";
      $sql .= " INNER JOIN categoria_ayuda c ";
      $sql .= " ON e.id_cat_ayuda = c.id ";
      $sql .= " INNER JOIN zonas z ";
      $sql .= " ON e.eve_zona_id = z.id ";
      $sql .= " $sentence ";
      $sql .= " ORDER BY e.id ASC LIMIT 6 ";
      $result = Zona::objetoSql($sql);
      
      require_once __DIR__."/../views/visita/zona.php";

      if(empty($result)){
       
        if($zona == 'todo'){
          $zona = "norte, centro y sur";
        }
          echo '<h1 class="region-h1 error-zone-none" style="text-align: center; margin-bottom: 5rem; visibility:hidden" > No se encotraron eventos sociales en la zona ' . $zona . '.</h1>';
          echo '<h1 class="region-h1 error-zone" style="text-align: center; margin-bottom: 5rem" >No se encotraron eventos sociales en la zona ' . $zona . '.</h1>';
      
        }


    }
  }
}
