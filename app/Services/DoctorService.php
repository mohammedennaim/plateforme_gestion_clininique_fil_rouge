<?php

namespace App\Services;

use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\Eloquent\DoctorRepository;
use App\Repositories\Eloquent\PatientRepository;
use App\Models\Doctor;

class DoctorService
{
    protected $doctorRepository;

    public function __construct(
        DoctorRepository $doctorRepository,
    ) {
        $this->doctorRepository = $doctorRepository;

    }

    public function getAllDoctors()
    {
        return Doctor::with('user')->get();
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

    public function getTotalDoctors()
    {
        return $this->doctorRepository->getAll();
    }
    
    public function getDoctorDetails($doctorId)
    {
        return $this->doctorRepository->getDoctorDetails($doctorId);
    }
}
