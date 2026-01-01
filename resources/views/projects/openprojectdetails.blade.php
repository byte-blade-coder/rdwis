@extends('welcome')

@section('content')
<div class="content-wrapper">
    <style>
        /* Modern UI Enhancements */
        .card-primary.card-outline { border-top: 3px solid #007bff; }
        .section-header { 
            border-left: 4px solid #007bff; 
            background: #f4f6f9; 
            padding: 8px 15px; 
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* 2-Column Document Grid */
        .attachment-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            background: #fff;
        }
        .attachment-item { 
            padding: 8px 12px; 
            border: 1px solid #dee2e6; 
            border-radius: 4px;
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            transition: all 0.3s ease;
        }
        
        /* Icon Button Styling */
        .btn-upload-icon {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        /* Team Avatar Styling (New) */
        .team-section-container {
            background: #ffffff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: 6px 12px;
            height: calc(2.875rem + 2px); /* Matches lg input height */
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        .avatar-stack { display: flex; align-items: center; padding-left: 10px; }
        .avatar-stack img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #fff;
            margin-left: -12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
            background: #eee;
        }
        .avatar-stack img:hover { transform: translateY(-3px); z-index: 10; }
        .add-team-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px dashed #007bff;
            color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            font-size: 12px;
            margin-left: 5px;
        }
        
        /* Professional Timeline */
        .timeline-steps { 
            display: flex; 
            justify-content: space-around; 
            position: relative; 
            padding: 20px 0; 
            background: #ffffff; 
            border-radius: 8px; 
            border: 1px solid #ebedf2;
        }
        .timeline-steps::before { 
            content: ''; 
            position: absolute; 
            top: 50%; 
            left: 10%; 
            right: 10%; 
            height: 2px; 
            background: #e9ecef; 
            z-index: 1; 
        }
        .t-step { position: relative; z-index: 2; text-align: center; }
        .t-icon { 
            width: 35px; height: 35px; 
            background: #fff; 
            border: 2px solid #007bff; 
            border-radius: 50%; 
            line-height: 31px; 
            margin: 0 auto 8px; 
            color: #007bff; 
            transition: all 0.3s;
        }
        .t-step.active .t-icon { background: #007bff; color: #fff; }
        .t-step.edc .t-icon { border-color: #dc3545; color: #dc3545; }
        .t-label { font-size: 11px; font-weight: 700; color: #495057; display: block; }
        .t-date { font-size: 10px; color: #868e96; }

        .milestone-scroll { max-height: 320px; overflow-y: auto; border: 1px solid #dee2e6; }
        .file-input-hidden { position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .status-select { border: 1px solid #007bff; font-weight: 600; }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Project Management</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('projecthistory')}}" class="btn btn-secondary btn-sm shadow-sm"><i class="fas fa-history"></i> View History</a>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="card card-primary card-outline shadow">
            <div class="card-header">
                <h3 class="card-title text-bold"><i class="fas fa-edit mr-2 text-primary"></i> Project ID: #{{ $project->id ?? 'NEW' }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="window.print()"><i class="fas fa-print"></i></button>
                </div>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    
                    {{-- Title and Hired Team Row --}}
                    <div class="row mb-4 align-items-end">
                        {{-- Project Title (Reduced Width) --}}
                        <div class="col-md-7">
                            <label class="text-muted mb-1 small font-weight-bold">PROJECT TITLE</label>
                            <input type="text" class="form-control form-control-lg border-primary shadow-sm" 
                                   value="{{ $project->prj_title ?? '' }}" placeholder="Enter Project Title" 
                                   style="font-weight: 700; border-left: 5px solid #007bff;">
                        </div>

                        {{-- Hired Personnel (Right Side) --}}
                        <div class="col-md-5">
                            <label class="text-muted mb-1 small font-weight-bold">HIRED PERSONNEL / TEAM</label>
                            <div class="team-section-container">
                                <div class="avatar-stack">
                                    <img src="https://ui-avatars.com/api/?name=Engineer&background=007bff&color=fff" title="Lead Engineer">
                                    <img src="https://ui-avatars.com/api/?name=Manager&background=28a745&color=fff" title="Project Manager">
                                    <img src="https://ui-avatars.com/api/?name=Supervisor&background=ffc107&color=fff" title="Supervisor">
                                    <img src="https://ui-avatars.com/api/?name=Technician&background=17a2b8&color=fff" title="Technician">
                                    <button type="button" class="add-team-btn" title="Assign Member">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-pill badge-light border text-primary">4 Members Hired</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Left Column: Project Details --}}
                        <div class="col-lg-5 col-md-5">
                            <div class="section-header"><span><i class="fas fa-info-circle mr-1"></i> Basic Information</span></div>
                            
                            <div class="form-group">
                                <label><small class="font-weight-bold">Scope of Work</small></label>
                                <textarea class="form-control" rows="2" style="font-size: 0.9rem;">{{ $project->prj_scope ?? '' }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-4 form-group">
                                    <label><small class="font-weight-bold">Sponsor</small></label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $project->prj_sponsor ?? '' }}">
                                </div>
                                <div class="col-4 form-group">
                                    <label><small class="font-weight-bold">Receipt Date</small></label>
                                    <input type="date" class="form-control form-control-sm" value="{{ $project->prj_rcptdt ?? '' }}">
                                </div>
                                <div class="col-4 form-group">
                                    <label><small class="font-weight-bold">Proposed Cost</small></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">Rs.</span></div>
                                        <input type="text" class="form-control font-weight-bold" value="{{ number_format($project->prj_propcost ?? 0) }}">
                                    </div>
                                </div>
                            </div>

                            <label class="mt-2"><small class="font-weight-bold text-dark">REQUIRED DOCUMENTS</small></label>
                            <div class="attachment-grid">
                                @php $docs = ['PPF', 'Project Approval', 'Project Proposal', 'Work Order', 'Tech Specs', 'Drawing/Plan']; @endphp
                                @foreach($docs as $index => $doc)
                                <div class="attachment-item shadow-sm">
                                    <span style="font-size: 0.75rem; font-weight: 600;"><i class="fas fa-file-alt text-muted mr-1"></i> {{ $doc }}</span>
                                    <div style="position: relative;">
                                        <button type="button" class="btn btn-upload-icon btn-outline-primary shadow-sm" id="btn-{{$index}}">
                                            <i class="fas fa-upload" style="font-size: 0.8rem;"></i>
                                        </button>
                                        <input type="file" name="docs[{{ $doc }}]" class="file-input-hidden" onchange="updateUploadUI(this, 'btn-{{$index}}')">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Right Column: Timeline & Milestones --}}
                        <div class="col-lg-7 col-md-7">
                            <div class="section-header"><span><i class="fas fa-stream mr-1"></i> Execution Timeline</span></div>
                            
                            <div class="timeline-steps mb-4 shadow-sm">
                                <div class="t-step active">
                                    <div class="t-icon"><i class="fas fa-file-invoice"></i></div>
                                    <span class="t-label">Proposal</span>
                                    <span class="t-date">{{ $project->prj_propdt ?? 'N/A' }}</span>
                                </div>
                                <div class="t-step"><div class="t-icon"><i class="fas fa-user-check"></i></div><span class="t-label">Assigned</span></div>
                                <div class="t-step"><div class="t-icon"><i class="fas fa-check-double"></i></div><span class="t-label">Approved</span></div>
                                <div class="t-step"><div class="t-icon"><i class="fas fa-play"></i></div><span class="t-label">Started</span></div>
                                <div class="t-step edc">
                                    <div class="t-icon"><i class="fas fa-flag-checkered"></i></div>
                                    <span class="t-label text-danger">EDC Target</span>
                                    <span class="t-date text-danger font-weight-bold">{{ $project->prj_estenddt ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="section-header">
                                <span><i class="fas fa-tasks mr-1"></i> Activities & Milestones</span>
                                <a href="{{route('addmilestonepr')}}" class="btn btn-primary btn-xs"><i class="fas fa-plus-circle"></i> New Milestone</a>
                            </div>

                            <div class="milestone-scroll">
                                <table class="table table-sm table-head-fixed table-hover m-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($project->milestones ?? [] as $milestone)
                                        <tr>
                                            <td><span class="badge badge-info">{{ $milestone->msn_type }}</span></td>
                                            <td>{{ Str::limit($milestone->msn_desc, 50) }}</td>
                                            <td><small>{{ $milestone->msn_targetdt }}</small></td>
                                            <td><span class="badge {{ Str::lower($milestone->msn_status) == 'completed' ? 'badge-success' : 'badge-warning' }}">{{ $milestone->msn_status }}</span></td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-4 text-muted">No activities recorded yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-header"><span><i class="fas fa-chart-line mr-1"></i> Status & Remarks</span></div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Current Status</label>
                                    <select class="form-control status-select">
                                        <option>Open</option>
                                        <option>Work in progress</option>
                                        <option>Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Final Completion Date</label>
                                    <input type="date" class="form-control border-primary" value="{{ $project->prj_enddt ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Progress Remarks</label>
                                <textarea class="form-control" rows="3" style="background-color: #f9f9f9; border-left: 3px solid #28a745;">{{ $project->prj_rem ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="section-header"><span><i class="fas fa-lock mr-1"></i> Internal Notes</span></div>
                            <div class="form-group">
                                <label>Team Reference Notes</label>
                                <textarea class="form-control" rows="6" style="background-color: #fffdf5; border: 1px dashed #ffc107;">{{ $project->prj_notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-default mr-2 px-4">Cancel</button>
                        <button type="submit" class="btn btn-primary px-5 shadow">
                            <i class="fas fa-save mr-2"></i> SAVE PROJECT DATA
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateUploadUI(input, btnId) {
        if (input.files && input.files[0]) {
            const btn = document.getElementById(btnId);
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');
            btn.innerHTML = '<i class="fas fa-check" style="font-size: 0.8rem;"></i>';
            btn.closest('.attachment-item').style.borderColor = '#28a745';
            btn.closest('.attachment-item').style.backgroundColor = '#f0fff4';
        }
    }
</script>
@endsection