<?php

namespace Classes;

class Utils
{

    public static function deleteAllSession()
    {
        session_start();
        if (isset($_SESSION)) {

            $_SESSION = [];
            $_SESSION = null;
            unset($_SESSION);
            session_destroy();

            return true;
        }
    }


    public static function deleteSession($name)
    {
        session_start();
        if (isset($_SESSION[$name])) {

            $_SESSION[$name] = [];
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    public static function isAdmin()
    {
        session_start();
        if (!isset($_SESSION['login']) && !isset($_SESSION['admin'])) {
            header("Location: " . SERVERURL . "not-found");
            die();
        } else {
            return true;
        }
    }
 
    private static function createKey()
    {
        session_start();
        if (empty($_SESSION['key'])) {
            $_SESSION['key'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['key'];
    }

    
    public static function createToken()
    {
      
        $key = self::createKey();
        if (isset($_SESSION['key']) && !empty($_SESSION['key'])) {
            $csrf = hash_hmac('sha256', session_id() . time(), $key);
            $_SESSION['token'] = $csrf;
        }
        return $_SESSION['token'];
    }

    public static function validateToken()
    {
        $result = false;
        session_start();
        if (hash_equals($_SESSION['token'], $_POST['csrf'])) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public static function deleteToken()
    {
        $_SESSION['token'] = '';
        unset($_SESSION['token']);
    }


    public static function sameId($number)
    {


        $_SESSION['equal'] = $number;

        return $_SESSION['equal'];
    }


    public static function validateSame()
    {
        $result = false;
        session_start();
        if (($_SESSION['equal'] == $_POST['cod'])) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public static function deleteSame()
    {
        $_SESSION['equal'] = '';
        unset($_SESSION['equal']);
    }

    public static function countV()
    {

        $vst_id = "";               
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/build" . "/cscript.txt";  
        $timeon = 120;              
        $delimiter = ',';           
        $newVst = 0;                
        $online = 0;                
        $today  = 0;               
        $total  = 0;               
       
        if (is_readable($filename)) {
            //read the file and map to array
            $csv = array_map('str_getcsv', file($filename));
            array_walk($csv, function (&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
            $lstVstId = array_column($csv, 'visitor_id');
            $lstTimeStamp = array_reverse(array_column($csv, 'timestamp'));
        } else {
            echo "error";
        }

       
        foreach ($lstTimeStamp as $value) {
            if ((time() - intval($value)) < $timeon) {
                $online++;
                $today++;
            } else {
               
                if (date('m/d/Y', time()) == date('m/d/Y', intval($value))) {
                    $today++;
                } else {
                    break;
                }
            }
        }
        $online = $online + $newVst; 
        if ($online == 0) {
            $online = 1;
        }
        $today = $today + $newVst; 
        if ($today == 0) {
            $today = 1;
        }
        $total = count($lstVstId) + $newVst;  
        if ($total == 0) {
            $total = 1;
        }
        if ($newVst > 0) {
            
            $strNewLine = time() . $delimiter . $vst_id;
          
            if (!file_put_contents($filename, $strNewLine . PHP_EOL, FILE_APPEND | LOCK_EX)) {
                $out = 'Error: Recording file not exists, or is not writable';
            }
        }

        $out = ["online" => $online, "today" => $today, "total" => $total];

        return $out; 
    
       
    }


    public static function compressImage($source, $destination, $quality)
    {
        
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

       
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

    
    public static function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object)) {
                        
                        self::rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                    } else
                        
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }

    public static function regiones($region)
    {

        $reg = "ew";
        switch ($region) {
            case 1:
                $reg = "Arica y Parinacota";
                break;
            case 2:
                $reg = "Tarapacá";
                break;
            case 3:
                $reg = "Antofagasta";
                break;
            case 4:
                $reg = "Atacama";
                break;
            case 5:
                $reg = "Coquimbo";
                break;
            case 6:
                $reg = "Valparaíso";
                break;
            case 7:
                $reg = "Metropolitana de Santiago";
                break;
            case 8:
                $reg = "Libertador B. O'Higgins";
                break;
            case 9:
                $reg = "Maule";
                break;
            case 10:
                $reg = "Biobío";
                break;
            case 11:
                $reg = "Ñuble";
                break;
            case 12:
                $reg = "La Araucanía";
                break;
            case 13:
                $reg = "Los Ríos";
                break;
            case 14:
                $reg = "Los Lagos";
                break;
            case 15:
                $reg = "Aysén";
                break;
            case 16:
                $reg = "Magallanes";
                break;
        }

        return $reg;
    }

    public static function regionesPre($region)
    {

        $reg = "ew";
        switch ($region) {
            case 1:
                $reg = "de Arica y Parinacota";
                break;
            case 2:
                $reg = "de Tarapacá";
                break;
            case 3:
                $reg = "de Antofagasta";
                break;
            case 4:
                $reg = "de Atacama";
                break;
            case 5:
                $reg = "de Coquimbo";
                break;
            case 6:
                $reg = "de Valparaíso";
                break;
            case 7:
                $reg = "Metropolitana de Santiago";
                break;
            case 8:
                $reg = "del Libertador B. O'Higgins";
                break;
            case 9:
                $reg = "del Maule";
                break;
            case 10:
                $reg = "del Biobío";
                break;
            case 11:
                $reg = "del Ñuble";
                break;
            case 12:
                $reg = "de La Araucanía";
                break;
            case 13:
                $reg = "de Los Ríos";
                break;
            case 14:
                $reg = "de Los Lagos";
                break;
            case 15:
                $reg = "de Aysén";
                break;
            case 16:
                $reg = "de Magallanes";
                break;
        }

        return $reg;
    }

    public static function typeToString($type_id)
    {

        switch ($type_id) {
            case 1:
                $ayuda = "Alimentaria";
                break;
            case 2:
                $ayuda = "Psicológica";
                break;
            case 3:
                $ayuda = "Vestuario";
                break;
        }

        return $ayuda;
    }

    public static function typeToStringPre($type_id)
    {

        switch ($type_id) {
            case 1:
                $ayuda = "alimentaria";
                break;
            case 2:
                $ayuda = "psicológica";
                break;
            case 3:
                $ayuda = "de vestuario";
                break;
        }

        return $ayuda;
    }

    public static function zona($zone)
    {

        switch ($zone) {
            case 1:
                $zona = "Norte";
                break;
            case 2:
                $zona = "Centro";
                break;
            case 3:
                $zona = "Sur";
                break;
        }

        return $zona;
    }

    public static function statusOrg($status)
    {

        switch ($status) {
            case 1:
                $stat = "Solicitud Recibida, contactar via mail para pedir mas info de la org";
                break;
            case 2:
                $stat = "Mail solicitando mas info enviado, esperando respuesta";
                break;
            case 3:
                $stat = "Info recibida, en proceso de verificación";
                break;
            case 4:
                $stat = "Solicitud aprobada, org inscrita";
                break;
            case 5:
                $stat = "Solicitud rechazada";
                break;
            case 6:
                $stat = "Org incrita pero en revisión por reclamo u otros";
                break;
            case 7:
                $stat = "Org incrita en revisión y suspendida temporalmente por reclamo u otros";
                break;
            case 8:
                $stat = "Org dada de baja - eliminada";
                break;
            case 9:
                $stat = "Organización inscrita y publicada";
                break;
        }

        return $stat;
    }

    public static function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    public static function getAgent()
    {
        $os_br = "Client details: " . $_SERVER['HTTP_USER_AGENT'];

        return $os_br;
    }

    public static function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "Unknown Browser";

        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

    public static function iconSvg($idAyuda)
    {
     switch ($idAyuda) {
            case 1:
                $svg = '<img src="https://cdn3.iconfinder.com/data/icons/font-awesome-solid/576/heart-pulse-512.png" style="height: 8rem; margin-top: -2.5rem;">';
                break;
            case 2:
                $svg = '<img src="https://cdn0.iconfinder.com/data/icons/font-awesome-solid-vol-2/640/hands-helping-512.png" style="height: 8rem; margin-top: -2.5rem;"';
                break;
            case 3:
                $svg = '<img src="https://cdn3.iconfinder.com/data/icons/font-awesome-solid/640/shirt-512.png" style="height: 8rem; margin-top: -2.5rem;"';
                break;
        }

        return $svg;
    }
}
