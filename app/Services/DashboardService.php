<?php

namespace App\Services;

use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\Eloquent\DoctorRepository;
use App\Repositories\Eloquent\PatientRepository;
// use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DashboardService
{
    protected $doctorRepository;
    protected $patientRepository;
    protected $appointmentRepository;

    public function __construct(
        DoctorRepository $doctorRepository,
        PatientRepository $patientRepository,
        AppointmentRepository $appointmentRepository
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->patientRepository = $patientRepository;
        $this->appointmentRepository = $appointmentRepository;

    }

    public function getAllDoctors()
    {
        return $this->doctorRepository->getAll();
    }

    public function getDoctorById($id)
    {
        return $this->doctorRepository->getById($id);
    }

    public function createDoctor(array $data)
    {
        return $this->doctorRepository->create($data);
    }

    public function updateDoctor($id, array $data)
    {
        return $this->doctorRepository->update($id, $data);
    }

    public function deleteDoctor($id)
    {
        return $this->patientRepository->delete($id);
    }

    public function getAllPatients()
    {
        return $this->patientRepository->getAll();
    }

    public function getPatientById($id)
    {
        return $this->patientRepository->getById($id);
    }

    public function updatePatient($id, array $data)
    {
        return $this->patientRepository->update($id, $data);
    }

    public function deletePatient($id)
    {
        return $this->patientRepository->delete($id);
    }

    public function getTotalPatients()
    {
        return $this->patientRepository->getAll()->count();
    }
    public function getTotalDoctors()
    {
        return $this->doctorRepository->getAll()->count();
    }
    public function getTotalAppointments()
    {
        return $this->appointmentRepository->getAll()->count();
    }
    public function getTotalRevenue()
    {
        return $this->appointmentRepository->getAll()->sum('price');
    }
    public function getTodayAppointments()
    {
        return $this->appointmentRepository->getAll();
    }
    public function getPendingRequests()
    {
        return $this->appointmentRepository->getAll()->where('status', 'pending')->count();
    }
    // public function getMonthlyRevenue()
    // {
    //     return $this->appointmentRepository->getAll()->whereMonth('created_at', now()->month)->sum('price');
    // }
    public function getAppointmentsByDate($date)
    {
        return $this->appointmentRepository->getAll()->where('date', $date);
    }

    public function getAllAppointments(){
        return $this->appointmentRepository->getAll();
    }
    public function getAppointmentById($id){
        return $this->appointmentRepository->getById($id);
    }
    public function getAppointmentsByDoctorId($doctorId){
        return $this->appointmentRepository->getByDoctorId($doctorId);
    }
    public function getAppointmentsByPatientId($patientId){
        return $this->appointmentRepository->getByPatientId($patientId);
    }
    public function createAppointment(array $data){
        return $this->appointmentRepository->create($data);
    }
    public function updateAppointment($id, array $data){
        return $this->appointmentRepository->update($id, $data);
    }
    public function deleteAppointment($id){
        return $this->appointmentRepository->delete($id);
    }

}
