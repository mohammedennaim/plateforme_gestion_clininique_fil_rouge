@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{ __('Medical Record Details') }}</h3>
                        <div>
                            <a href="{{ route('medical-records.download', $record->id) }}" class="btn btn-success me-2">
                                <i class="fas fa-download"></i> {{ __('Download File') }}
                            </a>
                            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to Records') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">{{ __('Record Information') }}</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 30%">{{ __('Title') }}</th>
                                            <td>{{ $record->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Record Type') }}</th>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ ucfirst(str_replace('_', ' ', $record->record_type)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <td>{{ $record->record_date->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Uploaded On') }}</th>
                                            <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('File') }}</th>
                                            <td>
                                                <i class="fas fa-file me-2"></i>
                                                {{ $record->file_name }}
                                                ({{ number_format($record->file_size / 1024, 2) }} KB)
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">{{ __('Patient & Doctor Information') }}</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 30%">{{ __('Patient') }}</th>
                                            <td>{{ $record->patient->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Patient ID') }}</th>
                                            <td>{{ $record->patient->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Doctor') }}</th>
                                            <td>{{ $record->doctor->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Speciality') }}</th>
                                            <td>{{ $record->doctor->speciality->name ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($record->description)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="fw-bold">{{ __('Description') }}</h5>
                                <div class="p-3 bg-light rounded">
                                    {{ $record->description }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($record->file_extension == 'jpg' || $record->file_extension == 'jpeg' || $record->file_extension == 'png')
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <h5 class="fw-bold mb-3">{{ __('Preview') }}</h5>
                                <img src="{{ route('medical-records.view', $record->id) }}" 
                                     class="img-fluid rounded shadow" 
                                     alt="{{ $record->title }}" 
                                     style="max-height: 400px;">
                            </div>
                        </div>
                    @elseif($record->file_extension == 'pdf')
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <h5 class="fw-bold mb-3">{{ __('Preview') }}</h5>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" 
                                            src="{{ route('medical-records.view', $record->id) }}" 
                                            style="width: 100%; height: 500px;"
                                            allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->isDoctor() && Auth::user()->doctor->id == $record->doctor_id || Auth::user()->isAdmin())
                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <form action="{{ route('medical-records.destroy', $record->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this record? This action cannot be undone.') }}');" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> {{ __('Delete Record') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection