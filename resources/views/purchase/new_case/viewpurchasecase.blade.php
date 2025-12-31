@extends('welcome')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <!-- Top Navigation Row -->
            <div class="row mb-4 align-items-center">
                
                <!-- 1. Page Heading -->
                <div class="col-md-4 col-sm-12">
                    <h1 id="page-heading" class="m-0" style="font-weight: 700;">All Purchase Cases</h1>
                </div>

                <!-- 2. Create New Button (Centered) -->
                <div class="col-md-4 col-sm-12 text-center my-2">
                    <a href="{{route('createnewcase')}}" class="btn btn-success shadow-sm" style="border-radius: 20px; padding: 8px 25px;">
                        <i class="fas fa-plus-circle mr-1"></i> Create New Case
                    </a>
                </div>

                <!-- 3. Filter Buttons (Right Aligned) -->
                <div class="col-md-4 col-sm-12 text-right">
                    <div class="btn-group shadow-sm">
                        <button type="button" class="btn btn-outline-primary active" onclick="filterCases('all', 'All Purchase Cases', this)">All</button>
                        <button type="button" class="btn btn-outline-primary" onclick="filterCases('open', 'Open Cases', this)">Open</button>
                        <button type="button" class="btn btn-outline-primary" onclick="filterCases('closed', 'Closed Cases', this)">Closed</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <div class="container-fluid">

            <!-- Case Card 1 (Open) -->
            <div class="card project-card shadow-sm mb-4" data-status="open">
                <div class="card-body">
                    <div class="project-header d-flex justify-content-between align-items-center">
                        <div class="project-title">
                            <h3>PC-2004</h3>
                            <div class="project-desc text-muted">Procurement of pressure gauges and sensors</div>
                            <span class="badge badge-warning px-3 py-2">Draft</span>
                        </div>
                        <a href="{{route('purchasecasedetails')}}" class="btn btn-primary btn-sm px-4">View Case</a>
                    </div>
                    <div class="timeline-wrapper mt-3">
                        <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Initiated</div><div class="meta-date">(18 Dec 25)</div></div> 
                        <div class="timeline-item"><div class="progress-segment bg-warning"></div><div class="meta-text">Approval Pending</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Tender</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Payment</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Delivery</div></div>
                    </div>
                </div>
            </div>

            <!-- Case Card 2 (Closed) -->
            <div class="card project-card shadow-sm mb-4" data-status="closed">
                <div class="card-body">
                    <div class="project-header d-flex justify-content-between align-items-center">
                        <div class="project-title">
                            <h3>PC-1988</h3>
                            <div class="project-desc text-muted">Supply of IT Equipment (Laptops/Servers)</div>
                            <span class="badge badge-success px-3 py-2">Completed</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm px-4">View Case</a>
                    </div>
                    <div class="timeline-wrapper mt-3">
                        <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Initiated</div><div class="meta-date">(10 Nov 25)</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Approved</div><div class="meta-date">(15 Nov 25)</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Delivered</div><div class="meta-date">(01 Dec 25)</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Paid</div><div class="meta-date">(05 Dec 25)</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Closed</div><div class="meta-date">(10 Dec 25)</div></div>
                    </div>
                </div>
            </div>

            <!-- Case Card 3 (Open) -->
            <div class="card project-card shadow-sm mb-4" data-status="open">
                <div class="card-body">
                    <div class="project-header d-flex justify-content-between align-items-center">
                        <div class="project-title">
                            <h3>TA-5501</h3>
                            <div class="project-desc text-muted">TA/DA Claim - Officer Visit to Karachi</div>
                            <span class="badge badge-info px-3 py-2">In Progress</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm px-4">View Case</a>
                    </div>
                    <div class="timeline-wrapper mt-3">
                        <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Submitted</div><div class="meta-date">(20 Dec 25)</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Verification</div><div class="meta-date">Ongoing</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Approval</div></div>
                        <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Payment</div></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function filterCases(status, headingText, btnElement) {
    // 1. Heading Update
    document.getElementById('page-heading').innerText = headingText;

    // 2. Active Button State
    let buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if(btnElement) {
        btnElement.classList.add('active');
    }

    // 3. Filtering Cards
    let cards = document.querySelectorAll('.project-card');
    cards.forEach(card => {
        if (status === 'all') {
            card.style.display = 'block';
        } else {
            card.style.display = (card.getAttribute('data-status') === status) ? 'block' : 'none';
        }
    });
}
</script>

<style>
    /* Spacing and visual polish matching your theme */
    .project-card { 
        transition: transform 0.2s ease, box-shadow 0.2s ease; 
        border: none;
        border-radius: 10px;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    .btn-group .btn.active { 
        background-color: #007bff !important; 
        color: white !important; 
    }
    .badge { font-weight: 500; font-size: 0.85rem; }
    
    /* Timeline specific tweaks for Purchase Cases */
    .timeline-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding-top: 10px;
    }
    .timeline-item {
        text-align: center;
        flex: 1;
        position: relative;
    }
    .progress-segment {
        height: 6px;
        width: 100%;
        border-radius: 3px;
        margin-bottom: 8px;
    }
    .meta-text { font-size: 12px; font-weight: 600; color: #555; }
    .meta-date { font-size: 11px; color: #888; }
</style>
@endsection