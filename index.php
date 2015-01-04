
        <?php
        require 'afro.php';


        $reg = new afro('user');
        $reg->add('name:username,type:text,placeholder:insert your name here,validation:string,br');
        $reg->add('.password.,placeholder:insert your password,br');
        $reg->add('.number.,br');
        $reg->add('.submit.');
        $form = $reg->render();
        echo $form;
        
        print_r(afro::sanitize($_POST));
        
        
        ?>


        

