<?php

define("SERVERURL", "https://genteayuda.site/");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_name("functionalCookieWeb");

