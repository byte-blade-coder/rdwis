@extends('welcome')

@section('content')
<div class="content-wrapper">
  <section class="content">
        <div class="container-fluid">
            
            {{-- Header Info --}}
            <div class="callout callout-info shadow-sm">
                <h5><i class="fas fa-hard-hat mr-2"></i> Prepare MPR: {{ $project->prj_title }}</h5>
                <p>
                    <strong>Project Code:</strong> {{ $project->prj_code ?? 'N/A' }} | 
                    <strong>Sponsor:</strong> {{ $project->prj_sponsor ?? 'Self' }} |
                    <strong>Current Physical Status:</strong> 
                    <span class="badge badge-warning">{{ $lastMpr->pgh_percent ?? 0 }}% Completed</span>
                </p>
            </div>

            <div class="card card-primary card-outline shadow">
                <div class="card-header">
                    <h3 class="card-title">New Progress Report Form</h3>
                </div>

                <form action="{{ route('projects.store-mpr', $project->prj_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        
                        {{-- Row 1: Date and Percentage --}}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Report Month/Date <span class="text-danger">*</span></label>
                                <input type="date" name="pgh_dt" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Physical Progress (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="pgh_percent" class="form-control" min="0" max="100" placeholder="e.g. 45" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Last recorded: {{ $lastMpr->pgh_percent ?? 0 }}%</small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Report Title / Headline <span class="text-danger">*</span></label>
                                <input type="text" name="pgh_intro" class="form-control" placeholder="e.g. Slab casting completed" required>
                            </div>
                        </div>

                        {{-- Row 2: Detailed Progress --}}
                        <div class="form-group">
                            <label>Work Done Description <span class="text-danger">*</span></label>
                            <textarea name="pgh_progress" class="form-control" rows="5" placeholder="Detail the activities performed this month..." required></textarea>
                        </div>

                        {{-- Row 3: Issues & Financial --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Issues / Bottlenecks (If any)</label>
                                <textarea name="pgh_issues" class="form-control" rows="3" placeholder="Delays, fund issues, site problems..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Site Photos / Documents</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="mprFiles" multiple>
                                    <label class="custom-file-label" for="mprFiles">Choose files</label>
                                </div>
                                <small class="text-muted d-block mt-2">Upload site images for evidence.</small>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-right bg-white border-top">
                        <a href="{{ route('projects.show', $project->prj_id) }}" class="btn btn-default mr-2">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-paper-plane mr-1"></i> Submit Report
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection