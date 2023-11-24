<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Response;

class OfficeController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return view('pages/offices');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $officeModel = new \App\Models\Office();
        $data = $officeModel->find($id);
        if (!$data) {
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($data);
    }

    public function list()
    {
        $officeModel = new \App\Models\Office();
        $postData = $this->request->getPost();

        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $searchValue = $postData['search']['value'];
        $sortby = $postData['order'][0]['column'];
        $sortdir = $postData['order'][0]['dir'];
        $sortcolumn = $postData['columns'][$sortby]['data'];

        // Total number of records
        $totalRecords = $officeModel->select('id')->countAllResults();

        // Total number of records with filtering
        $totalRecordwithFilter = $officeModel->select('id')
        ->like('code', $searchValue)
        ->orLike('name', $searchValue)
        ->orderBy($sortcolumn, $sortdir)
        ->countAllResults();

        // Fetch records
        $records = $officeModel->select('*')
        ->like('code', $searchValue)
        ->orLike('name', $searchValue)
        ->orderBy($sortcolumn, $sortdir)
        ->findAll($rowperpage, $start);

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                'id'=>$record['id'],
                'code'=>$record['code'],
                'name'=>$record['name'],
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
        $officeModel = new \App\Models\Office();
        $data = $this->request->getPost();

        if (!$officeModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $officeModel->errors()
            );

            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
        }


        $officeModel->insert($data);
        $response = array(
            'status' => 'success',
            'message' => "Office created successfully"
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
        $officeModel = new \App\Models\Office();
        $data = $this->request->getJSON();

        if (!$officeModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $officeModel->errors()
            );

            return $this->response->setStatusCode(Response::HTTP_NOT_MODIFIED)->setJSON($response);
        }


        $officeModel->update($id, $data);
        $response = array(
            'status' => 'success',
            'message' => "Office updated successfully"
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
        $officeModel = new \App\Models\Office();
        $data = $officeModel->find($id);
        if ($data) {
            $officeModel->delete($id);
            $response = array(
                'status' => 'success',
                'message' => "Office deleted successfully"
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
