<?php
namespace App\Services;

use App\Models\Appointment;
use App\Repositories\Eloquent\AppointmentRepository;



class AppointmentService{

    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function getAll()
    {
        return $this->appointmentRepository->getAll();
    }

    public function getById($id)
    {
        return $this->appointmentRepository->getById($id);
    }

    public function create($data)
    {
        return $this->appointmentRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->appointmentRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->appointmentRepository->delete($id);
    }

    public function getTodayAppointments($doctorId = null)
    {
        if ($doctorId) {
            return Appointment::with('patient')
                ->where('doctor_id', $doctorId)
                ->where('status', '=', 'pending')
                ->whereDate('date', now()->format('Y-m-d'))
                ->get();
        }
        return $this->appointmentRepository->getTodayAppointments();
    }

    public function getPendingRequests()
    {
        return $this->appointmentRepository->getPendingRequests();
    }
    public function getTotalAppointments()
    {
        return $this->appointmentRepository->getTotalAppointments();
    }
    public function getTotalRevenue($doctorId = null)
    {
        if ($doctorId) {
            return Appointment::where('doctor_id', $doctorId)->sum('price');
        }
        return $this->appointmentRepository->getTotalRevenue();
    }
    public function getByDoctorId($doctorId)
    {
        return $this->appointmentRepository->getAppointmentsByDoctorId($doctorId);
    }
    public function getByPatientId($patientId)
    {
        return $this->appointmentRepository->getByPatientId($patientId);
    }
    public function getCountByDoctorId($doctorId)
    {
        return $this->appointmentRepository->getCountByDoctorId($doctorId);
    }
    public function getCountByPatientsByDoctorId($doctorId)
    {
        return $this->appointmentRepository->getCountByPatientsByDoctorId($doctorId);
    }
    public function getCountStatistique()
    {
        return $this->appointmentRepository->getCountStats();
    }

    public function searchPatients($query)
    {
        return $this->appointmentRepository->searchPatients($query);
    }

    public function updateAppointment($id, $data)
    {
        return $this->appointmentRepository->update($id, $data);
    }

    public function deleteAppointment($id)
    {
        return $this->appointmentRepository->delete($id);
    }
}