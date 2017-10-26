<?php

class Post extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->site_title = SITE_TITLE;
        $this->view->render('header');
        $this->view->render('post/index');
        $this->view->render('footer');
    }
}
