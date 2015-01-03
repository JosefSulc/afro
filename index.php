
        <?php
        require 'afro.php';


        $reg = new afro('user');
        $reg->input('username');
        $reg->br();
        $reg->input('password');
        $reg->br();
        $reg->input(array('name' => 'remember', 'type' => 'checkbox', 'value' => 'remember', 'label-r' => 'Remember me'));
        $reg->label('Remember me');
        $reg->br();
        $reg->input('submit');
        $reg->render();
        
        print_r(afro::sanitize($_POST));
        
        
        

