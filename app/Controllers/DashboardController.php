<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {   
        $officeModel = new \App\Models\Office();
        $ticketModel = new \App\Models\Ticket();

        $data['totaloffices'] = $officeModel->countAllResults();
        $data['totaltickets'] = $ticketModel->countAllResults();

        return view('pages/dashboard',$data);
    }
}
