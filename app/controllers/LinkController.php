<?php

    namespace App\Controllers;

    use Framework\Database;
    use Framework\Validator;

    class LinkController {

        public function index(){
            
            $title = 'Proyectos';
            
            $db = new Database();
            $links = $db->query('SELECT * FROM links ORDER BY id DESC')->get();
                    
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
    
            $validator = new Validator($_POST, [
                'title' => 'required|min:3|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|min:3|max:500'
            ]);

            if($validator->passes()) {
                // Aquí iría la lógica para guardar el enlace o proyecto
                // Por ejemplo, insertar en la base de datos
                $db = new Database();

                $db->query('INSERT INTO links (title, url, description) VALUES (?, ?, ?)', [
                    $_POST['title'],
                    $_POST['url'],
                    $_POST['description']
                ]); 
                // Redirigir a una página de éxito o mostrar un mensaje de éxito
                header('Location: /links');
                exit;
            }
                
            $errors = $validator->errors();

            $title = 'Registrar Proyectos';

            view('links-create', [
                'title' => $title,
                'errors' => $errors,
            ]);
        }


        public function edit(){

            $title = 'Editar Proyecto';

            $id = $_GET['id'] ?? null;

            if (!$id) {
                exit('ID is required');
            }

            $db = new Database();
            $link = $db->query('SELECT * FROM links WHERE id = ?', [$id])->firstOrFail();

            view('links-edit', [
                'title' => $title,
                'link' => $link,
            ]);
        }

        public function update(){

            $validator = new Validator($_POST, [
                'title' => 'required|min:3|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|min:3|max:500'
            ]);

            if($validator->passes()) {
                $db = new Database();

                $db->query('UPDATE links SET title = ?, url = ?, description = ? WHERE id = ?', [
                    $_POST['title'],
                    $_POST['url'],
                    $_POST['description'],
                    $_POST['id']
                ]); 

                header('Location: /links');
                exit;
            }

            $errors = $validator->errors();

            $id = $_POST['id'] ?? null;
            
            if (!$id) {
                exit('ID is required');
            }

            $db = new Database();
            $link = $db->query('SELECT * FROM links WHERE id = ?', [$id])->firstOrFail();
            
            $title = 'Editar Proyecto';

            view('links-edit', [
                'title' => $title,
                'link' => $link,
                'errors' => $errors,
            ]);
        }

        public function destroy(){
            
            $id = $_POST['id'] ?? null;

            if (!$id) {
                exit('ID is required');
            }

            $db = new Database();
            $db->query('DELETE FROM links WHERE id = ?', [$id]);

            header('Location: /links');
            exit;

        }
        
    }
    