<?php

    namespace App\Controllers;

    class HomeController {

        public function index(){     
            $posts = db()->query('SELECT * FROM posts ORDER BY id DESC')->get();
        
            view('home', [
                'posts' => $posts
            ]);
        }
        
    }
    