@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{ __('Medical Records') }}</h3>
                        @if(Auth::user()->isDoctor())
                            <a href="{{ route('medical-records.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add New Medical Record') }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(count($records) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Record Type') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        @if(Auth::user()->isDoctor() || Auth::user()->isAdmin())
                                            <th>{{ __('Patient') }}</th>
                                        @endif
                                        @if(Auth::user()->isPatient() || Auth::user()->isAdmin())
                                            <th>{{ __('Doctor') }}</th>
                                        @endif
                                        <th>{{ __('File') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{ $record->title }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ ucfirst(str_replace('_', ' ', $record->record_type)) }}
                                                </span>
                                            </td>
                                            <td>{{ $record->record_date->format('d/m/Y') }}</td>
                                            @if(Auth::user()->isDoctor() || Auth::user()->isAdmin())
                                                <td>{{ $record->patient->user->name }}</td>
                                            @endif
                                            @if(Auth::user()->isPatient() || Auth::user()->isAdmin())
                                                <td>{{ $record->doctor->user->name }}</td>
                                            @endif
                                            <td>
                                                <span class="text-muted">
                                                    <i class="fas fa-file"></i> {{ $record->file_name }}
                                                    ({{ number_format($record->file_size / 1024, 2) }} KB)
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('medical-records.show', $record->id) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('medical-records.download', $record->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @if(Auth::user()->isDoctor() && Auth::user()->doctor->id == $record->doctor_id || Auth::user()->isAdmin())
                                                        <form action="{{ route('medical-records.destroy', $record->id) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('{{ __('Are you sure you want to delete this record?') }}');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('No medical records found.') }}
                            @if(Auth::user()->isDoctor())
                                <a href="{{ route('medical-records.create') }}">{{ __('Add a new one') }}</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection