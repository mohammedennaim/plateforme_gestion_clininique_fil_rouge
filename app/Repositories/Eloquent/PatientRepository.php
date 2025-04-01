<?php

namespace App\Repositories\Eloquent;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface
{
    public function getAll()
    {
        return Patient::all();
    }

    public function getById($id)
    {
        return Patient::findOrFail($id);
    }

    public function create($data)
    {
        return Patient::create($data);
    }

    public function update($id, $data)
    {
        $doctor = Patient::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete($id)
    {
        return Patient::destroy($id);
    }
}
