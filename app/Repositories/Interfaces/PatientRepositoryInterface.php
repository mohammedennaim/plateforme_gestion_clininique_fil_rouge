<?php

namespace App\Repositories\Interfaces;

interface PatientRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function update($id, array $data);
    public function delete($id);
}
