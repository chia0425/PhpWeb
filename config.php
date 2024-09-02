<?php

ini_set('session.use_only_cookies' , 1); //This setting ensures that the session ID is only passed through cookies and not through URLs
ini_set('session.use_strict_mode' , 1); //strict session ID usage, preventing the session from being initialized with an invalid session ID

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => "/", //cookie is valid for all paths on the domain
    'secure' => true, // only allow https no http.
    'httponly' => true //restrict script access from client
]);

session_start();

if(!isset($_SESSION['Last_generated'])){ //on initialization no last_generated variable
    session_regenerate_id(true);
    $_SESSION['Last_generated'] = time();

}
else{
    $interval = 60 * 30;

    if(time() - $_SESSION['Last_generated'] >= $interval){ //regenerated id if time elapsed 30minutes.
        session_regenerate_id(true);
        $_SESSION['Last_generated'] = time();
    }
}
