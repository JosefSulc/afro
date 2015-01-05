<?php

class afro {

    private $formHTML;

    public function __construct($formName) {
       
        $this->formHTML = '<form id="' . $formName . '" method="POST" action="">';
        if (!isset($_SESSION['vals']))
            $_SESSION['vals'] = array();
        $_SESSION['formNames'][] = $formName;
    }

    public function render() {
        return $this->formHTML . '</form>';
    }

    public function add($data,$break = false) {
       if (preg_match('~[.](.+?)[.]~', $data, $prep)) {
           $data = $this->prepared($prep[0]) . ',' . $data;
        }
        $data = explode(',', $data);
        foreach ($data as $key => $val) {
            unset($data[$key]);
            
            $val = explode(':', $val);
            if (!isset($val[1])) {
                unset($data[$key]);
                continue;
            }

            $data[$val[0]] = $val[1];
        }

        $this->input($data, $break);
    }

    private function input($data, $break) {


        if (isset($data['validate'])) {
            $_SESSION['vals'][$data['name']] = $data['validate'];
            unset($data['validate']);
        } 
        
        if (!isset($data['type'])) {
            $data['type'] = 'text';
        }
        
        $this->formHTML .= '<input';

        foreach ($data as $key => $value) {
            $this->formHTML .= ' ' . $key . '="' . $value . '"';
        }
        $this->formHTML .= ' />';

        if ($break === true)
            $this->formHTML .= '<br>';
    }

    public function label($data) {
        $this->formHTML .= '<label>' . $data . '</label>';
    }

    public function prepared($data) {
        switch ($data):
            case '.username.':
                $data = 'id:username,type:text,name:username,placeholder:username,validate:string';
                return $data;
            case '.password.':
                $data = 'id:password,name:password,type:password,placeholder:password,validate:string';
                return $data;
            case '.email.':
                $data = 'id:email,name:email,type:text,placeholder:email,validate:email';
                return $data;
            case '.message.':
                $data = 'id:message,name:message,type:text,placeholder:message,validate:string';
                return $data;
            case '.number.':
                $data = 'id:number,name:number,type:number,validate:integer';
                return $data;
            case '.submit.':
                $data = 'id:submit,type:submit,value:submit';
                return $data;
            default:
                return $data;
        endswitch;
    }

    public static function filter_inputs($data) {
        $val_types = $_SESSION['vals'];

        foreach ($data as $key => $post) {
            $data[$key] = afro::filter($post, $val_types[$key]);
        }

        return $data;
    }

    public static function filter($data, $type) {


        switch ($type) {
            case('string'):
                $data = filter_var($data, FILTER_SANITIZE_STRING);
                break;
            case('integer'):
                $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
                break;
            case('email'):
                $data = filter_var($data, FILTER_SANITIZE_EMAIL);
                break;
            case('url'):
                $data = filter_var($data, FILTER_SANITIZE_URL);
                break;
            default:
                $data = htmlspecialchars($data);
                break;
        }

        return $data;
    }

    public static function get() {
        
       
         if (isset($_POST))
            return afro::filter_inputs($_POST);
    }

}
