<?php

class Contacto extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->site_title = SITE_TITLE;
        $this->view->render('header');
        $this->view->render('contacto/index');
        $this->view->render('footer');
    }

}
