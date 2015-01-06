<?php

class afro {

    private $formMethod;
    private $formHTML;
    private $formName;
    private $inputNames = array();
    private $vals = array();

    public function __construct($formName, $formMethod = 'POST') {
        $this->formName = $formName;
        $this->formMethod = $formMethod;
        $this->formHTML = '<form id="' . $formName . '" method="' . $formMethod . '" action="">';
    }

    public function render($return = false) {
        if ($return === true) {
            return $this->formHTML . '</form>';
        } else {
            echo $this->formHTML . '</form>';
        }
    }

    public function add($data, $break = false) {
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
            $this->vals[$data['name'] . '{' . $this->formName . '}'] = $data['validate'];
            unset($data['validate']);
        }

        if (!isset($data['type'])) {
            $data['type'] = 'text';
        }

        $this->formHTML .= '<input';

        foreach ($data as $key => $value) {
            if ($key === 'name') {
                $value .='{' . $this->formName . '}';
                $this->inputNames[] = $value;
            }

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

    public function sanitize($data, $type) {
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

    public function out() {
        if($this->formMethod === 'GET') $data = $_GET;
        else                            $data = $_POST;
       
        if (empty($data)) {
            return;
        }

        $posted = array();
        foreach ($this->inputNames as $iName) {
            $posted[] = $this->sanitize($data[$iName], $this->vals[$iName]);
        }
        return $posted;
    }

}
