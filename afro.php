<?php

class afro {

    private $formHTML;

    public function __construct($formName) {
        $this->formName = $formName;

        $this->formHTML = '<form id="' . $formName . '" method="POST" action="">';
        if (!isset($_SESSION['vals']))
            $_SESSION['vals'] = array();
        $_SESSION['formNames'][] = $formName;
    }

    public function render() {
        return $this->formHTML . '</form>';
    }

    public function input($data) {
        $data = $this->prepared($data);

        if (isset($data['validate'])) {
            $_SESSION['vals'][$data['name']] = $data['validate'];
            unset($data['validate']);
        }
        $this->formHTML .= '<input';

        foreach ($data as $key => $value) {
            $this->formHTML .= ' ' . $key . '="' . $value . '"';
        }
        $this->formHTML .= ' />';
    }
    
    public function label($data)
    {
        $this->formHTML .= '<label>'.$data.'</label>';
        
    }
    
    public function br()
    {
        $this->formHTML .= '<br>';
    }

    public function prepared($data) {
        switch ($data):
            case('username'):
                $data = array('id' => 'username', 'type' => 'text', 'name' => 'username', 'placeholder' => 'username', 'validate' => 'string');
                return $data;
            case('password'):
                $data = array('id' => 'password', 'name' => 'password', 'type' => 'password', 'placeholder' => 'password', 'validate' => 'string');
                return $data;
            case('email'):
                $data = array('id' => 'email', 'name' => 'email', 'type' => 'text', 'placeholder' => 'email', 'validate' => 'email');
                return $data;
            case('message'):
                $data = array('id' => 'message', 'name' => 'message', 'type' => 'text', 'placeholder' => 'message', 'validate' => 'string');
                return $data;
            case('number'):
                $data = array('id' => 'number', 'name' => 'number', 'type' => 'number', 'validate' => 'integer');
                return $data;
            case('submit'):
                $data = array('id' => 'submit', 'type' => 'submit', 'value' => 'submit');
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

    public static function sanitize($data = false) {

        if ($data != false)
            return afro::filter_inputs($data);
    }

}
