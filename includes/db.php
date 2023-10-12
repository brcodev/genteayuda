<?php

	$db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);       

        try {
		 $db->query("SET NAMES 'utf8'");
       
	 } catch (Exception $e) {

                $e->getMessage();
       	 }
