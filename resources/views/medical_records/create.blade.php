@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{ __('Upload Medical Record') }}</h3>
                        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Records') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('medical-records.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="patient_id" class="col-md-3 col-form-label text-md-end">{{ __('Patient') }} <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" name="patient_id" required>
                                    <option value="">{{ __('Select Patient') }}</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->user->name }} (ID: {{ $patient->id }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('patient_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="title" class="col-md-3 col-form-label text-md-end">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="record_type" class="col-md-3 col-form-label text-md-end">{{ __('Record Type') }} <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select id="record_type" class="form-select @error('record_type') is-invalid @enderror" name="record_type" required>
                                    <option value="">{{ __('Select Type') }}</option>
                                    <option value="consultation" {{ old('record_type') == 'consultation' ? 'selected' : '' }}>{{ __('Consultation') }}</option>
                                    <option value="lab_result" {{ old('record_type') == 'lab_result' ? 'selected' : '' }}>{{ __('Lab Result') }}</option>
                                    <option value="prescription" {{ old('record_type') == 'prescription' ? 'selected' : '' }}>{{ __('Prescription') }}</option>
                                    <option value="imaging" {{ old('record_type') == 'imaging' ? 'selected' : '' }}>{{ __('Imaging (X-ray, MRI, etc.)') }}</option>
                                    <option value="surgery" {{ old('record_type') == 'surgery' ? 'selected' : '' }}>{{ __('Surgery') }}</option>
                                    <option value="medical_certificate" {{ old('record_type') == 'medical_certificate' ? 'selected' : '' }}>{{ __('Medical Certificate') }}</option>
                                    <option value="other" {{ old('record_type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>

                                @error('record_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="record_date" class="col-md-3 col-form-label text-md-end">{{ __('Record Date') }} <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="record_date" type="date" class="form-control @error('record_date') is-invalid @enderror" name="record_date" value="{{ old('record_date', date('Y-m-d')) }}" required>

                                @error('record_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-7">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="file" class="col-md-3 col-form-label text-md-end">{{ __('File') }} <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required>
                                <small class="form-text text-muted">
                                    {{ __('Accepted formats: PDF, JPG, PNG, DOCX. Max size: 5MB') }}
                                </small>

                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> {{ __('Upload Record') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection