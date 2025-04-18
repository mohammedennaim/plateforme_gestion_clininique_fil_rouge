<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedicalRecordService
{
    /**
     * Upload a medical record file and save record data
     * 
     * @param array $data
     * @param UploadedFile $file
     * @param int $doctorId
     * @return MedicalRecord
     */
    public function uploadMedicalRecord(array $data, UploadedFile $file, int $doctorId): MedicalRecord
    {
        // Generate a unique filename
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        
        // Store the file in the appropriate directory
        $path = $file->storeAs(
            'medical_records/' . $data['patient_id'],
            $filename,
            'public'
        );
        
        // Create a new medical record entry
        return MedicalRecord::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $doctorId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'record_date' => $data['record_date'] ?? now(),
            'record_type' => $data['record_type'] ?? 'other',
        ]);
    }
    
    /**
     * Get all medical records for a specific patient
     * 
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPatientMedicalRecords(int $patientId)
    {
        return MedicalRecord::where('patient_id', $patientId)
            ->orderBy('record_date', 'desc')
            ->get();
    }
    
    /**
     * Get all medical records uploaded by a specific doctor
     * 
     * @param int $doctorId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDoctorMedicalRecords(int $doctorId)
    {
        return MedicalRecord::where('doctor_id', $doctorId)
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Delete a medical record and its associated file
     * 
     * @param int $recordId
     * @return bool
     */
    public function deleteMedicalRecord(int $recordId): bool
    {
        $record = MedicalRecord::findOrFail($recordId);
        
        // Delete the file from storage
        if (Storage::disk('public')->exists($record->file_path)) {
            Storage::disk('public')->delete($record->file_path);
        }
        
        // Delete the record from database
        return $record->delete();
    }
}