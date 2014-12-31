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


        $reg = new afro(array('id' => 'reg'));
        $reg->input('username');
        $reg->input('password');
        $reg->input(array('name'=>'remember','type'=>'checkbox','value'=>'remember','label-r'=>'Remember me'));
        $reg->render();

        print_r(afro::get($_POST));
        ?>
    </body>



</html>