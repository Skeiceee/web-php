<?php

    class HomeController {

        public function index(){
            $db = new Database();

            $posts = $db->query('SELECT * FROM posts ORDER BY id DESC')->get();
        
            require __DIR__ . '/../../resources/home.template.php';
        }
        
    }
    