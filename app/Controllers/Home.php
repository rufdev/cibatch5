<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $builder = $db->table('authors');

        $query = $builder->get(); // SELECT * FROM authors

        $result = $query->getResult(); // array of objects

        return json_encode($result);



        return view('welcome_message');
    }
}
