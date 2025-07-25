<?php

    namespace App\Controllers;

    class AboutController {

        public function index(){
            $title = 'Sobre mi';
            view('about', [
                'title' => $title
            ]);
        }
        
    }