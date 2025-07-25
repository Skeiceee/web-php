<?php

    namespace App\Controllers;

    use Framework\Database;

    class HomeController {

        public function index(){
            $db = new Database();

            $posts = $db->query('SELECT * FROM posts ORDER BY id DESC')->get();
        
            view('home', [
                'posts' => $posts
            ]);
        }
        
    }
    