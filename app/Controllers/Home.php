<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $builder = $db->table('authors');

        // $query = $builder->get(); // SELECT * FROM authors

        $query = $builder->getWhere(['id' => 1]); // SELECT * FROM authors WHERE id = 1


        $result = $query->getResult(); // array of objects

        return json_encode($result);



        return view('welcome_message');
    }
}
