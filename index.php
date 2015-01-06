
<?php

require 'afro.php';


$reg = new afro('user');
$reg->add('.use.,placeholder:insert your name here', true);
$reg->add('.pas.,placeholder:insert your password', true);
$reg->add('.num.', true);
$reg->add('.sub.');
$reg->render();


print_r($reg->out());





