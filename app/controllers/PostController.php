<?php

    namespace App\Controllers;

    class PostController {

        public function index(){
            
            $title = 'Posts';
            
            $post = db()->query('SELECT * FROM posts WHERE id = :id', 
                [
                    'id' => $_GET['id'] ?? null
                ]
            )->firstOrFail();
        
            view('post', [
                'title' => $title,
                'post' => $post
            ]);
        }
        
    }
    