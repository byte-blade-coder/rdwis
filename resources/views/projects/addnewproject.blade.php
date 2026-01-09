@extends('welcome')

@section('content')
<div class="content-wrapper pt-3">
    {{-- CSS Styles wese hi rahein --}}
    <style>
        /* ... aapki purani styling ... */
        .card-add-project { border-top: 3px solid #28a745; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); }
    </style>
        
        {{-- ERROR DISPLAY BLOCK (Isay Add Karein) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 1500px; margin: 0 auto 15px auto;">
                <strong><i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following errors:</strong>
                <ul class="mb-0 mt-1 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-success card-outline card-add-project">
            <div class="card-header">
                <h3 class="card-title text-bold"><i class="fas fa-plus-circle mr-2"></i> Initiate New Project</h3>
            </div>

            {{-- FORM START --}}
            <form action="{{ route('save-project') }}" method="POST">
                @csrf 
                <div class="card-body">
                    
                    {{-- Row 1: Code & Title --}}
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Project Code <span class="text-danger">*</span></label>
                            {{-- old('prj_code') lagaya taaki error par data na urr jaye --}}
                            <input type="text" name="prj_code" class="form-control" placeholder="e.g. P-2025-001" value="{{ old('prj_code') }}" required>
                            <small class="text-muted">Unique ID for this project.</small>
                        </div>

                        <div class="col-md-9 form-group">
                            <label>Project Title <span class="text-danger">*</span></label>
                            <input type="text" name="prj_title" class="form-control" placeholder="Enter Full Project Name" value="{{ old('prj_title') }}" required>
                        </div>
                    </div>

                    {{-- Row 2: Sponsor & Cost --}}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Sponsor / Funding Agency</label>
                            <input type="text" name="prj_sponsor" class="form-control" placeholder="e.g. World Bank, Govt of Punjab" value="{{ old('prj_sponsor') }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Proposed Cost (Rs.)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="number" name="prj_propcost" class="form-control" placeholder="0.00" value="{{ old('prj_propcost') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Scope --}}
                    <div class="form-group">
                        <label>Scope of Work</label>
                        <textarea name="prj_scope" class="form-control" rows="4" placeholder="Brief description of project scope...">{{ old('prj_scope') }}</textarea>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-right">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-arrow-right mr-1"></i> Save & Continue
                    </button>
                </div>
            </form>
            {{-- FORM END --}}
</div>
@endsection