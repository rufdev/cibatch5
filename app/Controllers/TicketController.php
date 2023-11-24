<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Response;

class TicketController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $officeModel = new \App\Models\Office();
        $data['offices'] = $officeModel->findAll();

        return view('pages/tickets', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $ticketModel = new \App\Models\Ticket();
        $data = $ticketModel->find($id);
        if (!$data) {
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($data);
    }

    public function list()
    {
        $ticketModel = new \App\Models\Ticket();
        $postData = $this->request->getPost();

        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $searchValue = $postData['search']['value'];
        $sortby = $postData['order'][0]['column'];
        $sortdir = $postData['order'][0]['dir'];
        $sortcolumn = $postData['columns'][$sortby]['data'];

        // Total number of records
        $totalRecords = $ticketModel->select('id')->countAllResults();

        // Total number of records with filtering
        $totalRecordwithFilter = $ticketModel->select('tickets.id')
            ->join('offices', 'offices.id = tickets.office_id')
            ->like('tickets.first_name', $searchValue)
            ->orLike('tickets.last_name', $searchValue)
            ->orLike('offices.code', $searchValue)
            ->orLike('offices.name', $searchValue)
            ->orLike('tickets.description', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->countAllResults();

        // Fetch records
        $records = $ticketModel->select('tickets.*, CONCAT(tickets.first_name, " ", tickets.last_name) as full_name, offices.name as office_name')
            ->join('offices', 'offices.id = tickets.office_id')
            ->like('tickets.first_name', $searchValue)
            ->orLike('tickets.last_name', $searchValue)
            ->orLike('offices.code', $searchValue)
            ->orLike('offices.name', $searchValue)
            ->orLike('tickets.description', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->findAll($rowperpage, $start);

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                'id' => $record['id'],
                'state' => $record['state'],
                'severity' => $record['severity'],
                'full_name' => $record['full_name'],
                'office_name' => $record['office_name'],
                'description' => $record['description'],
                'created_at' => $record['created_at'],
            );
        }

        // Response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordwithFilter,
            "data" => $data
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }



    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $ticketModel = new \App\Models\Ticket();
        $data = $this->request->getJSON();
        $data->state = 'PENDING';
        if (!$ticketModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $ticketModel->errors()
            );

            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
        }


        $ticketModel->insert($data);
        $response = array(
            'status' => 'success',
            'message' => "Ticket created successfully"
        );

        return $this->response->setStatusCode(Response::HTTP_CREATED)->setJSON($response);
    }


    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $ticketModel = new \App\Models\Ticket();
        $data = $this->request->getJSON();

        if (!$ticketModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $ticketModel->errors()
            );

            return $this->response->setStatusCode(Response::HTTP_NOT_MODIFIED)->setJSON($response);
        }


        $ticketModel->update($id, $data);
        $response = array(
            'status' => 'success',
            'message' => "Ticket updated successfully"
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $ticketModel = new \App\Models\Ticket();
        $data = $ticketModel->find($id);
        if ($data) {
            $ticketModel->delete($id);
            $response = array(
                'status' => 'success',
                'message' => "Ticket deleted successfully"
            );

            return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
        }



        $response = array(
            'status' => 'error',
            'message' => "Record not found"
        );

        return $this->response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->setJSON($response);
    }
}
