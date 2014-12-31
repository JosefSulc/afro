<?php


class afro {

    private $formHTML;

    public function __construct($data) {
        if (!isset($data['method']))
            $data['method'] = 'POST';
        $this->formHTML = '<form';
        foreach ($data as $key => $value) {
            $this->formHTML .= ' ' . $key . '="' . $value . '"';
        }
        $this->formHTML .= ' action="">';
        $_SESSION['vals'] = array();
    }

    public function render() {
        echo $this->formHTML . '</form>';
    }

    public function input($data) {
        if (isset($data['label-l']))
            $this->formHTML .= '<label>' . $data['label-l'] . '</label>';
        if (isset($data['validate']))
            $_SESSION['vals'][$data['name']] = $data['validate'];

        $this->formHTML .= '<input';
        foreach ($data as $key => $value) {
            $this->formHTML .= ' ' . $key . '="' . $value . '"';
        }

        if (isset($data['label-r']))
            $this->formHTML .= ' /><label>' . $data['label-r'] . '</label><br>';
        else
            $this->formHTML .= ' /><br>';
    }

    public static function validate($data) {
        $val_types = $_SESSION['vals'];
        echo '<br>';
        
        foreach($data as $key => $post) {
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

    public static function get($data = false) {

        if($data != false) return afro::validate($data);
        
    }

}


