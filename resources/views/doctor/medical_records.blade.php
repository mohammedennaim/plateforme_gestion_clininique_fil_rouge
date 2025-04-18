@extends('layouts.doctor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Medical Records</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($medicalRecords->isEmpty())
                        <div class="alert alert-info">
                            No medical records found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>File Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalRecords as $record)
                                        <tr>
                                            <td>
                                                <a href="{{ route('doctor.patient.view', $record->patient_id) }}">
                                                    {{ $record->patient->user->name }}
                                                </a>
                                            </td>
                                            <td>{{ $record->title }}</td>
                                            <td>{{ ucfirst($record->record_type) }}</td>
                                            <td>{{ $record->record_date->format('M d, Y') }}</td>
                                            <td>{{ $record->file_name }}</td>
                                            <td class="d-flex">
                                                <a href="{{ Storage::url($record->file_path) }}" class="btn btn-sm btn-info mr-2" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <a href="{{ Storage::url($record->file_path) }}" class="btn btn-sm btn-primary mr-2" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                                <form action="{{ route('medical-records.delete', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection