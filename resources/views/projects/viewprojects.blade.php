@extends('welcome')

@section('content')
<div class="content-wrapper">

    {{-- HEADER --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">

                <div class="col-md-4 col-sm-12">
                    <h1 id="page-heading" class="m-0 font-weight-bold">All Projects</h1>
                </div>

                <div class="col-md-4 col-sm-12 text-center my-2">
                    <a href="{{ route('addnewproject') }}"
                       class="btn btn-success shadow-sm px-4"
                       style="border-radius:20px;">
                        <i class="fas fa-plus-circle mr-1"></i> Create New Project
                    </a>
                </div>

                <div class="col-md-4 col-sm-12 text-right">
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-outline-primary active"
                                onclick="filterProjects('all','All Projects',this)">All</button>
                        <button class="btn btn-outline-primary"
                                onclick="filterProjects('open','Open Projects',this)">Open</button>
                        <button class="btn btn-outline-primary"
                                onclick="filterProjects('closed','Closed Projects',this)">Closed</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <div class="container-fluid">

            @forelse($projects as $project)

            <div class="card project-card shadow-sm mb-4"
                 data-status="{{ Str::lower($project->prj_status) }}">

                <div class="card-body">

                    {{-- PROJECT HEADER --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $project->prj_code }}</h3>
                            <div class="text-muted">{{ $project->prj_title }}</div>

                            @php
                                $badge = match(Str::lower($project->prj_status)){
                                    'open'   => 'badge-primary',
                                    'closed' => 'badge-success',
                                    'hold'   => 'badge-warning',
                                    default  => 'badge-secondary'
                                };
                            @endphp

                            <span class="badge {{ $badge }} px-3 py-2 mt-2">
                                {{ strtoupper($project->prj_status) }}
                            </span>
                        </div>

                        <a href="{{ route('projects.show',$project->prj_id) }}"
                           class="btn btn-primary btn-sm px-4">
                            View Project
                        </a>
                    </div>

                    {{-- TIMELINE --}}
                    <div class="timeline-wrapper mt-4">

                        <div class="timeline-item">
                            <div class="progress-segment bg-primary"></div>
                            <div class="meta-text">Approval</div>
                            <div class="meta-date">
                                {{ optional($project->created_at)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="progress-segment bg-primary"></div>
                            <div class="meta-text">Start</div>
                            <div class="meta-date">
                                {{ \Carbon\Carbon::parse($project->prj_startdt)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="progress-segment
                                {{ Str::lower($project->prj_status)=='open' ? 'bg-success':'bg-secondary' }}">
                            </div>
                            <div class="meta-text">Work In Progress</div>
                        </div>

                        <div class="timeline-item">
                            <div class="progress-segment bg-secondary"></div>
                            <div class="meta-text">Warranty</div>
                        </div>

                        <div class="timeline-item">
                            <div class="progress-segment bg-secondary"></div>
                            <div class="meta-text">EDC</div>
                            <div class="meta-date">
                                {{ $project->prj_enddt ? \Carbon\Carbon::parse($project->prj_enddt)->format('d M Y') : 'TBD' }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            @empty
                <div class="alert alert-info">No projects found.</div>
            @endforelse

        </div>
    </div>
</div>

{{-- FILTER SCRIPT --}}
<script>
function filterProjects(status, heading, btn){
    document.getElementById('page-heading').innerText = heading;

    document.querySelectorAll('.btn-group .btn')
        .forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.project-card').forEach(card=>{
        card.style.display =
            (status==='all' || card.dataset.status===status)
            ? 'block' : 'none';
    });
}
</script>

{{-- STYLES --}}
<style>
.project-card{
    border:none;
    border-radius:10px;
    transition:.2s ease;
}
.project-card:hover{
    transform:translateY(-5px);
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}
.timeline-wrapper{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
}
.timeline-item{
    text-align:center;
    flex:1;
}
.progress-segment{
    height:6px;
    border-radius:4px;
    margin-bottom:6px;
}
.meta-text{
    font-weight:600;
}
.meta-date{
    font-size:12px;
    color:#6c757d;
}
.btn-group .btn.active{
    background:#007bff;
    color:#fff;
}
</style>
@endsection
