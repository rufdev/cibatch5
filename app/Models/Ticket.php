<?php

namespace App\Models;

use CodeIgniter\Model;

class Ticket extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'email',
        'office_id',
        'state',
        'severity',
        'description',
        'remarks'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'first_name' => 'required|min_length[3]|max_length[200]',
        'last_name' => 'required|min_length[3]|max_length[200]',
        'email' => 'required|valid_email',
        'office_id' => 'required|numeric',
        'state' => 'required',
        'severity' => 'required',
        'description' => 'required|min_length[3]',
        'remarks' => 'min_length[3]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $returnTypeRelations = 'array';
    protected $belongsTo = [
        'office' => [
            'model' => 'App\Models\Office',
            'foreign_key' => 'office_id'
        ]
    ]
}
