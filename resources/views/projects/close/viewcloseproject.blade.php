@extends('welcome')

@section('content')

<div class="content-wrapper">

<div class="content-header">
        <h1>Closed Projects</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="project-header">
                <div class="project-title">
                    <h3>CDS</h3>
                    <div class="project-desc">Demo CDS Project for PNS Vessel</div>
                    <span class="badge-custom">Demo Comm</span>
                </div>
                <a href="{{route('closeprojectdetails')}}" class="btn-view">View Project</a>
            </div>
            <div class="timeline-wrapper">
                <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Approval</div><div class="meta-date">(04 Oct 21)</div></div> 
                <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Start</div><div class="meta-date">(20 Oct 21)</div></div>
                <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Work in Progress</div></div>
                <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Warranty</div></div>
                <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">EDC</div><div class="meta-date">(20 Jul 22)</div></div>
            </div>
        </div>
    </div>

    
</div>
@endsection