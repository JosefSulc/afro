<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet.css" href="stylesheet?<?php echo date('l jS \of F Y h:i:s A'); ?>>">
        <title>Trying out Afro</title>
    </head>


    <body>
        <?php
        require 'afro.php';


        $reg = new afro(array('method' => 'POST', 'id' => 'reg'));
        $reg->input(array('name' => 'user', 'placeholder' => 'UserName', 'validate' => 'string'));
        $reg->input(array('name' => 'pass', 'type' => 'password', 'placeholder' => 'password', 'validate' => 'string'));
        $reg->input(array('type' => 'submit', 'value' => 'Register'));
        $reg->render();

        print_r(afro::get($_POST));
        ?>
    </body>



</html>