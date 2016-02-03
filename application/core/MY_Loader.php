<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array())
    {
        $this->view('template/header');
        $this->view('template/menu');
        $this->view($template_name, $vars);
        $this->view('template/footer');
    }
}