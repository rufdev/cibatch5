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

        $data['barchartdata'] = $officeModel->select("offices.name AS office_name, COUNT(tickets.id) as ticket_count")
        ->join("tickets", "tickets.office_id = offices.id")
        ->groupBy("offices.id")
        ->findAll();

        $data['barchart2data'] = $ticketModel->select("DISTINCT(severity) AS severity, COUNT(id) AS ticket_count")
        ->groupBy("severity")
        ->findAll();

        return view('pages/dashboard',$data);
    }
}
