<?php


         $vst_id = "";               
         $filename = $_SERVER['DOCUMENT_ROOT']."/build"."/cscript.txt";  
         $timeon = 120;              
         $session_timeout = 1440;   
         $delimiter = ',';          
         $newVst = 0;                
         $online = 0;                
         $today  = 0;               
         $total  = 0;               
 
         
         //set timezone
         date_default_timezone_set('America/Santiago');


    if(!isset($_SESSION['login'])){



         if (!isset($_COOKIE['vst_unique_id'])) {
             $newVst = 1;
             $vst_id = uniqid();
             setcookie('vst_unique_id', $vst_id, [
   		 'expires' => time() + $session_timeout,
   		 'path' => '/',
   		 'samesite' => 'Strict',
   		 'secure' => true,
   		 'httponly' => true
		]);

         } else {
             $vst_id = $_COOKIE['vst_unique_id'];
         }
         
         if (is_readable($filename)) {
         
             $csv = array_map('str_getcsv', file($filename));
             array_walk($csv, function (&$a) use ($csv) {
                 $a = array_combine($csv[0], $a);
             });
             array_shift($csv);
             $lstVstId = array_column($csv, 'visitor_id');
             $lstTimeStamp = array_reverse(array_column($csv, 'timestamp'));
         } else {
             if (is_writable($filename)) {
                 
                 $fp = fopen($filename, 'w');
                 if (fwrite($fp, "timestamp,visitor_id") === FALSE) {
                     echo "Cannot write to file ($filename)";
                 }
                 fclose($fp);
             } else {
                 
                 echo "The file $filename is not writable";
             }
         }
        
         if (in_array($vst_id, $lstVstId)) {
             $newVst = 0;
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
                 $strOut = 'Error: Recording file not exists, or is not writable';
             }
          }

        }

 
         
