@extends('welcome')

@section('content')
<div class="content-wrapper pt-3">
    <style>
        /* Layout Styles */
        .mpr-wrapper { display: flex; gap: 20px; align-items: flex-start; }
        .mpr-left { flex: 1; }
        .mpr-right { flex: 0 0 400px; max-width: 400px; display: flex; flex-direction: column; gap: 15px; }
        .history-scroll-box { max-height: 550px; overflow-y: auto; padding-right: 5px; }
        
        /* History Card */
        .history-item {
            background: #fff; border-left: 4px solid #17a2b8; border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 10px; padding: 12px; transition: transform 0.2s;
        }
        .history-item:hover { transform: translateX(3px); }
        .history-date { font-size: 0.75rem; color: #6c757d; font-weight: 700; text-transform: uppercase; }
        .history-title { font-weight: 700; color: #343a40; font-size: 0.95rem; margin-bottom: 4px; }
        .history-desc { font-size: 0.85rem; color: #555; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        .milestone-context-box { background: #fff; border-top: 4px solid #ffc107; border-radius: 4px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>

    <section class="content">
        <div class="container-fluid">

            <a href="{{ route('projects.show', $project->prj_id) }}" class="btn btn-sm btn-secondary mb-3 shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Project Details
            </a>

            <div class="mpr-wrapper">
                
                {{-- LEFT SIDE: FORM (Only DB Fields) --}}
                <div class="mpr-left">
                    <div class="card card-success card-outline shadow">
                        <div class="card-header">
                            <h3 class="card-title text-bold"><i class="fas fa-edit mr-2"></i> Prepare Monthly Report</h3>
                        </div>
                        
                        <form action="{{ route('mpr.store', $project->prj_id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                
                                {{-- 1. Date --}}
                                <div class="form-group">
                                    <label>Report Date <span class="text-danger">*</span></label>
                                    <input type="date" name="pgh_dtg" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>

                                {{-- 2. Progress Description --}}
                                <div class="form-group">
                                    <label>Work Description <span class="text-danger">*</span></label>
                                    <textarea name="pgh_progress" class="form-control" rows="10" placeholder="Enter detailed progress update here..." required></textarea>
                                </div>

                                <div class="alert alert-light border mt-3">
                                   <small class="text-muted">
    <i class="fas fa-info-circle mr-1"></i> Author and Level will be auto-recorded as 
    <strong>
        {{ Auth::user()->role->rol_desigshort ?? Auth::user()->acc_username }}
    </strong>.
</small>
                                </div>

                            </div>
                            <div class="card-footer text-right bg-white border-top">
                                <button type="submit" class="btn btn-success px-4 shadow-sm">
                                    <i class="fas fa-paper-plane mr-1"></i> Submit Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- RIGHT SIDE: HISTORY & CONTEXT --}}
                <div class="mpr-right">
                    
                    {{-- Active Milestone --}}
                    <div class="milestone-context-box">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="font-weight-bold m-0 text-dark"><i class="fas fa-crosshairs mr-1 text-warning"></i> Current Target</h6>
                            @if($currentMilestone)
                                <span class="badge badge-warning text-white">{{ $currentMilestone->msn_status }}</span>
                            @else
                                <span class="badge badge-secondary">No Active Target</span>
                            @endif
                        </div>
                        @if($currentMilestone)
                            <p class="mb-2 text-dark font-weight-bold" style="font-size: 1.1rem; line-height: 1.2;">{{ Str::limit($currentMilestone->msn_desc, 60) }}</p>
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="far fa-calendar-alt mr-1"></i> Target:</span>
                                <span class="font-weight-bold text-danger">{{ \Carbon\Carbon::parse($currentMilestone->msn_targetdt)->format('d M, Y') }}</span>
                            </div>
                        @else
                            <p class="text-muted small">No pending milestones found.</p>
                        @endif
                    </div>

                    {{-- History List --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                            <h6 class="font-weight-bold text-secondary m-0">Recent Reports</h6>
                            <span class="badge badge-light border">{{ $mprHistory->count() + 7 }} Records</span>
                        </div>

                        <div class="history-scroll-box">
                            
                            {{-- REAL DATA (Green Border) --}}
                            @foreach($mprHistory as $history)
                            <div class="history-item" style="border-left-color: #28a745;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="history-date">{{ \Carbon\Carbon::parse($history->pgh_dtg)->format('d M, Y') }}</span>
                                 
                                    <span class="badge badge-success" style="font-size: 0.7rem;">Saved</span>
                                </div>
                                <div class="history-title">Progress Report</div>
                                <div class="history-desc">{{ $history->pgh_progress }}</div>
                                <div class="mt-2 text-right"><small class="text-muted font-italic">- {{ $history->pgh_author }}</small></div>
                            </div>
                            @endforeach

                            {{-- DUMMY DATA (Grey Border) --}}
                            @php
                                $dummies = [
                                    ['date' => '2025-12-01', 'desc' => 'Completed plinth beam casting for Block A. Curing in progress.'],
                                    ['date' => '2025-11-01', 'desc' => 'Site clearing and excavation for foundation fully completed.'],
                                    ['date' => '2025-10-01', 'desc' => 'Machinery mobilized to site. Labor camp setup initiated.'],
                                    ['date' => '2025-09-01', 'desc' => 'Official site handover meeting conducted with contractor.'],
                                    ['date' => '2025-08-15', 'desc' => 'Work order issued to M/S Alpha Constructions.'],
                                    ['date' => '2025-07-20', 'desc' => 'Financial bids opened. Evaluation report submitted.'],
                                    ['date' => '2025-06-10', 'desc' => 'Administrative approval received from competent authority.'],
                                ];
                            @endphp

                            @foreach($dummies as $dummy)
                            <div class="history-item" style="border-left-color: #dee2e6;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="history-date">{{ \Carbon\Carbon::parse($dummy['date'])->format('d M, Y') }}</span>
                                    <span class="badge badge-secondary" style="font-size: 0.7rem;">Archived</span>
                                </div>
                                <div class="history-title">Past Update</div>
                                <div class="history-desc">{{ $dummy['desc'] }}</div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </section>
</div>
@endsection