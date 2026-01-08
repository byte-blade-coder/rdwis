@extends('welcome')

@section('content')
<div class="content-wrapper pt-3">
    <style>
        /* --- GLOBAL STYLES --- */
        .card-primary.card-outline { border-top: 3px solid #007bff; }
        .bg-light-blue { background-color: #f4f7fa; }
        
        /* --- HEADER & BADGES --- */
        .header-controls { display: flex; align-items: center; gap: 8px; }
        .milestone-box-compact {
            background: #ffffff; 
            border: 1px solid #e9ecef; 
            border-radius: 30px; 
            padding: 5px 15px;
            display: inline-flex; align-items: center; justify-content: space-between;
            min-width: 300px; height: 45px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }

        /* --- INFO PANEL (TOP SECTION) --- */
        .info-panel {
            background: #fff;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            display: flex; /* Flex container for Row */
            overflow: hidden;
        }
        .info-left-content { flex: 1; padding: 15px; display: flex; align-items: center; } /* 70% Width */
        .info-right-team { width: 350px; background: #fff; border-left: 1px solid #e9ecef; padding: 10px 15px; display: flex; flex-direction: column; justify-content: center; } /* 30% Width */

        .info-label { font-size: 0.7rem; text-transform: uppercase; color: #8898aa; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
        .info-value { font-size: 0.9rem; color: #32325d; font-weight: 600; line-height: 1.4; }
        .cost-tag { background: #e0fdf4; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-weight: 700; border: 1px solid #b7eb8f; display: inline-block; }

        /* --- TEAM SECTION (RIGHT ALIGNED) --- */
        .team-section-container {
            display: flex; 
            align-items: center; 
            justify-content: flex-end; /* TOUCH RIGHT BORDER */
            flex-wrap: wrap; 
            gap: -8px; /* Overlap effect */
            padding-right: 5px;
        }
        .team-avatar-wrapper { 
            position: relative; cursor: pointer; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            margin-left: -10px; /* Overlap */
            z-index: 1;
        }
        .team-avatar-wrapper:hover { transform: scale(1.2); z-index: 100; margin: 0 5px; }
        .team-avatar-wrapper img { width: 42px; height: 42px; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 4px 6px rgba(50,50,93,0.11), 0 1px 3px rgba(0,0,0,0.08); object-fit: cover; }
        .more-staff-btn { width: 42px; height: 42px; border-radius: 50%; background: #fff; color: #525f7f; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; margin-left: 5px; z-index: 0; }

        /* --- DOCUMENTS (LEFT VERTICAL LIST) --- */
        .doc-scroll-container { max-height: 500px; overflow-y: auto; padding-right: 5px; }
        .doc-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-left: 3px solid #007bff;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
            display: flex; align-items: center; justify-content: space-between;
            transition: all 0.2s;
        }
        .doc-card:hover { transform: translateX(3px); box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .doc-content { display: flex; align-items: center; overflow: hidden; margin-right: 10px; }
        .doc-icon { 
            width: 30px; height: 30px; background: #f4f6f9; color: #007bff; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 0.8rem; flex-shrink: 0; 
        }
        .doc-title { font-size: 0.8rem; font-weight: 600; color: #444; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        /* FORCE HIDE FILE INPUT */
        .file-input-hidden { display: none !important; }

        /* --- MILESTONES (RIGHT MAIN) --- */
        .milestone-table-wrapper { background: #fff; border-radius: 8px; border: 1px solid #e9ecef; overflow: hidden; }
        .table-custom thead th { background: #f6f9fc; color: #8898aa; text-transform: uppercase; font-size: 0.75rem; border-bottom: 1px solid #e9ecef; padding: 12px 15px; }
        .table-custom tbody td { padding: 12px 15px; vertical-align: middle; color: #525f7f; font-size: 0.9rem; border-bottom: 1px solid #f0f0f0; }
        .table-custom tr:hover { background-color: #fcfcfc; }

        /* --- TIMELINE --- */
        .timeline-steps { display: flex; justify-content: space-around; position: relative; padding: 20px 0; background: #fff; border-radius: 8px; border: 1px solid #ebedf2; margin-top: 15px; }
        .timeline-steps::before { content: ''; position: absolute; top: 40%; left: 5%; right: 5%; height: 2px; background: #e9ecef; z-index: 1; }
        .t-step { position: relative; z-index: 2; text-align: center; background: #fff; padding: 0 10px; }
        .t-icon { width: 30px; height: 30px; background: #fff; border: 2px solid #007bff; border-radius: 50%; line-height: 26px; margin: 0 auto 5px; color: #007bff; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .t-step.active .t-icon { background: #007bff; color: #fff; border-color: #007bff; }
        .t-step.edc .t-icon { border-color: #dc3545; color: #dc3545; }
        .t-label { font-size: 10px; font-weight: 700; color: #525f7f; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
        .t-date { font-size: 10px; color: #8898aa; margin-top: 2px; display: block; font-weight: 600; }

        /* --- MODALS --- */
        .emp-modal-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #f4f6f9; margin-bottom: 15px; }
        .emp-detail-row { border-bottom: 1px solid #eee; padding: 10px 0; display: flex; justify-content: space-between; }
    </style>

    @php
        $nextMilestone = $project->milestones->where('msn_status', '!=', 'Completed')->sortBy('msn_targetdt')->first();
        $daysDiff = 0; $isOverdue = false; $statusMsg = "All Done"; $badgeClass = "badge-secondary";
        if ($nextMilestone && $nextMilestone->msn_targetdt) {
            $target = \Carbon\Carbon::parse($nextMilestone->msn_targetdt)->startOfDay();
            $today = \Carbon\Carbon::now()->startOfDay();
            $diff = $today->diffInDays($target, false);
            if ($diff < 0) { $isOverdue = true; $daysDiff = abs($diff); $statusMsg = $daysDiff . " Days Late"; $badgeClass = "badge-danger"; }
            else { $daysDiff = $diff; $statusMsg = $daysDiff . " Days Left"; $badgeClass = "badge-success"; }
        }
        $team = [
            ['id'=>1, 'name'=>'Ali Khan', 'role'=>'Project Manager', 'img'=>'https://ui-avatars.com/api/?name=Ali+Khan&background=007bff&color=fff', 'email'=>'ali@rdwis.com', 'phone'=>'0300-1234567'],
            ['id'=>2, 'name'=>'Sara Ahmed', 'role'=>'Senior Architect', 'img'=>'https://ui-avatars.com/api/?name=Sara+Ahmed&background=e83e8c&color=fff', 'email'=>'sara@rdwis.com', 'phone'=>'0300-7654321'],
            ['id'=>3, 'name'=>'Bilal Hameed', 'role'=>'Site Engineer', 'img'=>'https://ui-avatars.com/api/?name=Bilal+Hameed&background=28a745&color=fff', 'email'=>'bilal@rdwis.com', 'phone'=>'0333-1122334'],
            ['id'=>4, 'name'=>'Usman Qureshi', 'role'=>'Surveyor', 'img'=>'https://ui-avatars.com/api/?name=Usman+Q&background=ffc107&color=fff', 'email'=>'usman@rdwis.com', 'phone'=>'0321-9988776'],
        ];
        $displayLimit = 6; $remaining = count($team) - $displayLimit;
    @endphp

    <div class="container-fluid">
        <form action="#" method="POST" enctype="multipart/form-data"> @csrf
        
        <div class="card card-primary card-outline shadow-sm border-0">
            
            {{-- HEADER: Code, Title, Center Milestone, Action Buttons --}}
            <div class="card-header p-3 bg-white border-bottom">
                <div class="row align-items-center">
                    
                    {{-- LEFT: Project ID & Title --}}
                    <div class="col-md-4">
                        <div style="line-height: 1.3;">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge badge-light border mr-2">CODE: {{ $project->prj_code ?? 'N/A' }}</span>
                            </div>
                            <h4 class="text-dark font-weight-bold m-0 text-truncate" title="{{ $project->prj_title }}">
                                {{ $project->prj_title }}
                            </h4>
                        </div>
                    </div>

                    {{-- CENTER: Active Milestone Status --}}
                    <div class="col-md-4 text-center">
                        @if($nextMilestone)
                            <div class="milestone-box-compact">
                                <div class="d-flex align-items-center pr-3 border-right mr-3">
                                    <span class="badge {{ $badgeClass }} px-3 py-2" style="font-size: 0.85rem;">
                                        <i class="fas {{ $isOverdue ? 'fa-exclamation-triangle' : 'fa-clock' }} mr-1"></i> {{ $statusMsg }}
                                    </span>
                                </div>
                                <div class="text-left" style="line-height: 1.1;">
                                    <div class="font-weight-bold text-dark text-truncate" style="max-width: 150px;">{{ $nextMilestone->msn_desc }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Target: <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($nextMilestone->msn_targetdt)->format('d M, Y') }}</span></small>
                                </div>
                            </div>
                        @else
                            <span class="badge badge-secondary p-2 px-3 rounded-pill">No Pending Milestones</span>
                        @endif
                    </div>

                    {{-- RIGHT: Buttons (Spendings LEFT of History) --}}
                    <div class="col-md-4 text-right">
                        <div class="header-controls justify-content-end">
                            <button type="button" class="btn btn-warning btn-sm shadow-sm font-weight-bold text-white" onclick="alert('Module under development')">
                                <i class="fas fa-coins mr-1"></i> Spendings
                            </button>
                            <a href="{{ route('projecthistory') }}" class="btn btn-outline-secondary btn-sm shadow-sm font-weight-bold">
                                <i class="fas fa-history mr-1"></i> History
                            </a>
                            <a href="{{ route('mpr.view', $project->prj_id) }}" class="btn btn-primary btn-sm shadow-sm font-weight-bold px-3">
                                <i class="fas fa-file-invoice mr-1"></i> Create MPR
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light-blue">
                
                {{-- NEW TOP INFO ROW: Info Left, Team Right --}}
                <div class="info-panel">
                    
                    {{-- LEFT: Info Block (Scope, Sponsor, Cost) --}}
                    <div class="info-left-content">
                        <div class="row w-100 m-0">
                            {{-- Scope --}}
                            <div class="col-md-6 border-right">
                                <span class="info-label"><i class="fas fa-align-left mr-1"></i> Scope of Work</span>
                                <div class="info-value text-muted" style="font-size: 0.9rem;">
                                    {{ Str::limit($project->prj_scope, 150) ?? 'No scope defined.' }}
                                </div>
                            </div>
                            
                            {{-- Sponsor --}}
                            <div class="col-md-3 border-right text-center">
                                <span class="info-label"><i class="fas fa-handshake mr-1"></i> Sponsor</span>
                                <div class="info-value mt-2">{{ $project->prj_sponsor ?? 'Self' }}</div>
                            </div>

                            {{-- Cost --}}
                            <div class="col-md-3 text-center">
                                <span class="info-label"><i class="fas fa-tag mr-1"></i> Proposed Cost</span>
                                <div class="mt-2">
                                    <span class="cost-tag">Rs. {{ number_format($project->prj_propcost ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Team Block (Border Touch) --}}
                    <div class="info-right-team">
                        <div class="d-flex justify-content-end mb-2">
                            <span class="info-label text-right" style="color: #007bff;">Project Team ({{ count($team) }})</span>
                        </div>
                        <div class="team-section-container">
                            @foreach($team as $index => $member)
                                @if($index < $displayLimit)
                                    <div class="team-avatar-wrapper" onclick="openEmployeeModal('{{ $member['name'] }}', '{{ $member['role'] }}', '{{ $member['img'] }}', '{{ $member['email'] }}', '{{ $member['phone'] }}')">
                                        <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}" title="{{ $member['name'] }} - {{ $member['role'] }}">
                                    </div>
                                @endif
                            @endforeach
                            
                            @if($remaining > 0)
                                <a href="#" class="more-staff-btn" onclick="openAllStaffModal()">+{{ $remaining }}</a>
                            @endif
                            <button type="button" class="more-staff-btn bg-white text-primary" style="border-color: #007bff;" title="Add Member">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="row">
                    
                    {{-- LEFT COLUMN: Required Documents (Compact Scroll) --}}
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold m-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-folder-open text-primary mr-1"></i> Documents
                            </h6>
                            <span class="badge badge-light border">Required: 8</span>
                        </div>
                        
                        <div class="doc-scroll-container">
                            @php $docs = ['PPF', 'Project Approval', 'Project Proposal', 'Work Order', 'Tech Specs', 'Drawing/Plan', 'Site Images', 'BOQ']; @endphp
                            @foreach($docs as $index => $doc)
                            <div class="doc-card shadow-sm">
                                {{-- Left: Icon & Name --}}
                                <div class="doc-content">
                                    <div class="doc-icon"><i class="fas fa-file-alt"></i></div>
                                    <div class="doc-title" title="{{ $doc }}">{{ $doc }}</div>
                                </div>
                                {{-- Right: Button --}}
                                <div style="width: 28px; height: 28px; flex-shrink: 0;">
                                    <label for="file-{{$index}}" class="btn btn-sm btn-outline-secondary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; cursor: pointer;" id="btn-{{$index}}">
                                        <i class="fas fa-upload" style="font-size: 0.75rem;"></i>
                                    </label>
                                    <input type="file" id="file-{{$index}}" name="docs[{{ $doc }}]" class="file-input-hidden" onchange="updateUploadUI(this, 'btn-{{$index}}')">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Milestones & Timeline (Wide View) --}}
                    <div class="col-lg-9">
                        
                        {{-- 1. MILESTONES (Prominent Table) --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="font-weight-bold m-0 text-dark"><i class="fas fa-tasks text-primary mr-1"></i> Project Milestones</h6>
                            <a href="{{ route('projects.add-milestone', $project->prj_id) }}" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
                                <i class="fas fa-plus mr-1"></i> Add Milestone
                            </a>
                        </div>

                        <div class="milestone-table-wrapper shadow-sm mb-4">
                            <table class="table table-custom w-100 m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Type</th>
                                        <th style="width: 45%;">Description</th>
                                        <th style="width: 15%;">Target Date</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 15%; text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($project->milestones ?? [] as $milestone)
                                    <tr>
                                        <td><span class="badge badge-light border">{{ $milestone->msn_type }}</span></td>
                                        <td class="font-weight-bold text-dark">{{ Str::limit($milestone->msn_desc, 60) }}</td>
                                        <td><span class="text-muted"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($milestone->msn_targetdt)->format('d M, Y') }}</span></td>
                                        <td>
                                            @if(Str::lower($milestone->msn_status) == 'completed')
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Completed</span>
                                            @else
                                                <span class="badge badge-warning px-2 py-1 text-white"><i class="fas fa-spinner mr-1"></i> {{ $milestone->msn_status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('milestone.edit', $milestone->msn_id) }}" class="btn btn-xs btn-outline-warning mr-1" title="Edit"><i class="fas fa-pen"></i></a>
                                            <a href="{{ route('milestone.delete', $milestone->msn_id) }}" class="btn btn-xs btn-outline-danger" title="Delete" onclick="return confirm('Delete?');"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted">No milestones added yet. Click 'Add Milestone' to begin.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- 2. TIMELINE (Updated with Year) --}}
                        <h6 class="font-weight-bold m-0 text-dark mb-2"><i class="fas fa-stream text-primary mr-1"></i> Execution Timeline</h6>
                        <div class="timeline-steps shadow-sm">
                            
                            {{-- Step 1: Proposal --}}
                            <div class="t-step {{ $project->prj_propdt ? 'active' : '' }}">
                                <div class="t-icon"><i class="fas fa-file-invoice"></i></div>
                                <span class="t-label">Proposal</span>
                                <span class="t-date">
                                    {{ $project->prj_propdt ? \Carbon\Carbon::parse($project->prj_propdt)->format('d M, Y') : '--' }}
                                </span>
                            </div>

                            {{-- Step 2: Assigned --}}
                            <div class="t-step {{ $project->prj_assigndt ? 'active' : '' }}">
                                <div class="t-icon"><i class="fas fa-user-check"></i></div>
                                <span class="t-label">Assigned</span>
                                <span class="t-date">
                                    {{ $project->prj_assigndt ? \Carbon\Carbon::parse($project->prj_assigndt)->format('d M, Y') : '--' }}
                                </span>
                            </div>

                            {{-- Step 3: Approved --}}
                            <div class="t-step {{ $project->prj_aprvdt ? 'active' : '' }}">
                                <div class="t-icon"><i class="fas fa-check-double"></i></div>
                                <span class="t-label">Approved</span>
                                <span class="t-date">
                                    {{ $project->prj_aprvdt ? \Carbon\Carbon::parse($project->prj_aprvdt)->format('d M, Y') : '--' }}
                                </span>
                            </div>

                            {{-- Step 4: Started --}}
                            <div class="t-step {{ $project->prj_startdt ? 'active' : '' }}">
                                <div class="t-icon"><i class="fas fa-play"></i></div>
                                <span class="t-label">Started</span>
                                <span class="t-date">
                                    {{ $project->prj_startdt ? \Carbon\Carbon::parse($project->prj_startdt)->format('d M, Y') : '--' }}
                                </span>
                            </div>

                            {{-- Step 5: Target (Est End Date) --}}
                            <div class="t-step edc">
                                <div class="t-icon"><i class="fas fa-flag-checkered"></i></div>
                                <span class="t-label text-danger">Target</span>
                                <span class="t-date text-danger font-weight-bold">
                                    {{ $project->prj_estenddt ? \Carbon\Carbon::parse($project->prj_estenddt)->format('d M, Y') : '--' }}
                                </span>
                            </div>

                        </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

{{-- MODALS --}}
<div class="modal fade" id="employeeDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <img src="" id="empModalImg" class="emp-modal-img shadow-sm">
                <h4 id="empModalName" class="font-weight-bold mb-1"></h4>
                <p id="empModalRole" class="text-primary mb-4"></p>
                <div class="text-left mt-3">
                    <div class="emp-detail-row"><span class="emp-label"><i class="fas fa-id-card mr-2"></i>ID</span><span class="text-dark font-weight-bold">EMP-00X</span></div>
                    <div class="emp-detail-row"><span class="emp-label"><i class="fas fa-envelope mr-2"></i>Email</span><span id="empModalEmail" class="text-dark"></span></div>
                    <div class="emp-detail-row"><span class="emp-label"><i class="fas fa-phone mr-2"></i>Phone</span><span id="empModalPhone" class="text-dark"></span></div>
                </div>
                <button type="button" class="btn btn-secondary btn-block mt-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="allStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold">Project Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-striped table-hover m-0">
                    <thead class="bg-primary text-white"><tr><th>Image</th><th>Name</th><th>Role</th><th>Contact</th></tr></thead>
                    <tbody>
                        @foreach($team as $member)
                        <tr>
                            <td><img src="{{ $member['img'] }}" class="rounded-circle" width="35" height="35"></td>
                            <td class="font-weight-bold">{{ $member['name'] }}</td>
                            <td>{{ $member['role'] }}</td>
                            <td>{{ $member['phone'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

<script>
    function openEmployeeModal(name, role, img, email, phone) {
        document.getElementById('empModalName').innerText = name;
        document.getElementById('empModalRole').innerText = role;
        document.getElementById('empModalImg').src = img;
        document.getElementById('empModalEmail').innerText = email;
        document.getElementById('empModalPhone').innerText = phone;
        $('#employeeDetailModal').modal('show');
    }
    function openAllStaffModal() { $('#allStaffModal').modal('show'); }
    
    function updateUploadUI(input, btnId) {
        if (input.files && input.files[0]) {
            const labelBtn = document.getElementById(btnId);
            const parent = labelBtn.closest('.doc-card');
            
            // Change Button Style (Target the Label behaving as button)
            labelBtn.classList.remove('btn-outline-secondary');
            labelBtn.classList.add('btn-success');
            labelBtn.innerHTML = '<i class="fas fa-check"></i>';
            
            // Change Card Style
            parent.style.borderColor = '#28a745';
            parent.style.backgroundColor = '#f0fff4';
            parent.querySelector('.doc-icon').style.color = '#28a745';
            parent.querySelector('.doc-icon').style.backgroundColor = '#e0fdf4';
        }
    }
</script>
@endsection