
<?php

require 'afro.php';


$reg = new afro('user');
$reg->add('.username.,placeholder:insert your name here', true);
$reg->add('.password.,placeholder:insert your password', true);
$reg->add('.number.', true);
$reg->add('.submit.');
$reg->render();


print_r($reg->out());





