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
    public function getTodayAppointments()
    {
        return $this->model->where('doctor_id', auth()->user()->id)->where('date', now()->format('Y-m-d'))->get();
    }
    public function getPending()
    {
        return $this->model->where('status', 'pending')->get()->count();
    }
    public function getCanceled()
    {
        return $this->model->where('status', 'canceled')->get()->count();
    }
    public function getTermine()
    {
        return $this->model->where('status', 'completed')->get()->count();
    }
    public function getconfirmed()
    {
        return $this->model->where('status', 'confirmed')->get()->count();
    }
    public function getTotalAppointments()
    {
        return $this->model->count();
    }
    public function getTotalRevenue()
    {
        return $this->model->where('doctor_id', auth()->user()->id)->sum('price');
    }
    public function getAppointmentsByDoctorId($doctorId)
    {
        return $this->model->where('doctor_id', $doctorId)->get()->unique('patient_id');
    }
    public function getByPatientId($patientId)
    {
        return $this->model->where('patient_id', $patientId)->where('doctor_id', auth()->user()->id)->get();
    }
    public function getCountByDoctorId($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)->count();
    }
    public function getCountByPatientsByDoctorId($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)->count();
    }

    public function searchPatients($query)
    {
        // Search in joined patient table
        return $this->model->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->where('doctor_id', auth()->user()->id)
            ->where(function($q) use ($query) {
                $q->where('patients.name', 'like', "%{$query}%")
                  ->orWhere('patients.email', 'like', "%{$query}%")
                  ->orWhere('patients.phone', 'like', "%{$query}%");
            })
            ->select('appointments.*', 'patients.name as patient_name')
            ->get()
            ->unique('patient_id');
    }
}