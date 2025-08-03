<?php

    namespace App\Controllers;

    use Framework\Validator;

    class LinkController {

        public function index(){
            
            $title = 'Proyectos';
            
            $links = db()->query('SELECT * FROM links ORDER BY id DESC')->get();
                    
            view('links', [
                'title' => $title,
                'links' => $links
            ]);
        }

        public function create(){

            $title = 'Registrar Proyectos';

            view('links-create', [
                'title' => $title,
            ]);
        }

        public function store(){
    
            Validator::make($_POST, [
                'title' => 'required|min:3|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|min:3|max:500'
            ]);

            db()->query('INSERT INTO links (title, url, description) VALUES (?, ?, ?)', [
                $_POST['title'],
                $_POST['url'],
                $_POST['description']
            ]); 
            
            redirect('/links/create', 'Proyecto registrado correctamente.');
        }


        public function edit(){

            $title = 'Editar Proyecto';

            $id = $_GET['id'] ?? null;

            if (!$id) {
                exit('ID is required');
            }

            $link = db()->query('SELECT * FROM links WHERE id = ?', [$id])->firstOrFail();

            view('links-edit', [
                'title' => $title,
                'link' => $link,
            ]);
        }

        public function update(){

            Validator::make($_POST, [
                'title' => 'required|min:3|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|min:3|max:500'
            ]);

            $link = db()->query('SELECT * FROM links WHERE id = ?', [$_POST['id']])->firstOrFail();

            db()->query('UPDATE links SET title = ?, url = ?, description = ? WHERE id = ?', [
                $_POST['title'],
                $_POST['url'],
                $_POST['description'],
                $_POST['id']
            ]); 

            redirect('/links/edit?id='.$link['id'], 'Proyecto actualizado correctamente.');

        }

        public function destroy(){
            
            $id = $_POST['id'] ?? null;

            if (!$id) {
                exit('ID is required');
            }

            db()->query('DELETE FROM links WHERE id = ?', [$id]);

            redirect('/links');

        }
        
    }
    