
<?php

require 'afro.php';


$reg = new afro('user');
$reg->add('.username.,placeholder:insert your name here', true);
$reg->add('.password.,placeholder:insert your password', true);
$reg->add('.number.', true);
$reg->add('.submit.');
$form = $reg->render();
echo $form;

print_r(afro::get());





