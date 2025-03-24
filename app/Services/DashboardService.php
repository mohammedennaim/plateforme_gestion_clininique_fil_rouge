<?php

namespace App\Services;

use App\Repositories\Eloquent\DoctorRepository;
use App\Repositories\Eloquent\PatientRepository;
use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DashboardService
{
    protected $doctorRepository;
    protected $patientRepository;
    protected $appointmentRepository;

    public function __construct(
        DoctorRepository $doctorRepository,
        PatientRepository $patientRepository
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->patientRepository = $patientRepository;

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


}
