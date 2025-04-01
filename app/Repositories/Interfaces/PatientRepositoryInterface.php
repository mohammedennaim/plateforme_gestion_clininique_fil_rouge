<?php

namespace App\Repositories\Interfaces;

interface PatientRepositoryInterface
{
    public function getAll();
    public function create($data);
    public function getById($id);
    public function update($id, $data);
    public function delete($id);
}
