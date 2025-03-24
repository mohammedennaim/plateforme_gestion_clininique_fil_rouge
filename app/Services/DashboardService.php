<?php

namespace App\Services;

use App\Repositories\Eloquent\DoctorRepository;
use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DashboardService
{
    protected $doctorRepository;
    protected $patientRepository;
    protected $appointmentRepository;

    public function __construct(
        DoctorRepository $doctorRepository
    ) {
        $this->doctorRepository = $doctorRepository;
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
        return $this->doctorRepository->delete($id);
    }

}
