<?php
    require_once('controllers/base_controller.php');
    /**
     *
     */
    class PagesController extends BaseController
    {
        public function __construct()
        {
            $this->folder = 'pages';
        }

        public function index()
        {
            $data = array(
                'name' => 'Sang Beo',
                'age'  => 22
            );
            $this->render('index', $data);
        }

        public function error()
        {
            $this->render('error');
        }
    }
