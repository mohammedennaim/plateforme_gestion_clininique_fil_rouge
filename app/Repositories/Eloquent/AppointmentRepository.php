<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    protected $model;

    public function __construct(Appointment $appointment)
    {
        $this->model = $appointment;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $appointment = $this->getById($id);
        if ($appointment) {
            $appointment->update($data);
            return $appointment;
        }
        return null;
    }

    public function delete($id)
    {
        $appointment = $this->getById($id);
        if ($appointment) {
            return $appointment->delete();
        }
        return false;
    }
}