@extends('welcome')

@section('content')
<div class="content-wrapper bg-white">
    <style>
        /* --- IMAGE THEME STYLING --- */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 10px;
        }
        .page-title {
            color: #007bff;
            font-weight: 700;
            font-size: 26px;
            display: flex;
            align-items: center;
        }
        .page-title i { margin-right: 12px; }

        .btn-new-project {
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }

        /* Filter Bar Container */
        .filter-container {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px 20px;
            background-color: #fff;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .filter-item label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #888;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .form-control, .form-select {
            height: 40px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Status Toggle Button Group (Segmented Control) */
        .status-toggle {
            display: flex;
            border: 1px solid #007bff;
            border-radius: 6px;
            overflow: hidden;
        }
        .status-toggle .btn {
            flex: 1;
            border: none;
            border-radius: 0;
            padding: 8px 15px;
            font-size: 13px;
            font-weight: 600;
            background: #fff;
            color: #007bff;
        }
        .status-toggle .btn.active {
            background-color: #007bff;
            color: #fff;
        }
        .status-toggle .btn:not(:last-child) {
            border-right: 1px solid #007bff;
        }

        /* --- EXISTING CARD STYLING --- */
        .project-card {
            border: 1px solid #eee;
            border-radius: 12px;
            transition: 0.3s;
            background: #fdfdfd;
        }
        .project-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .timeline-wrapper { display: flex; justify-content: space-between; }
        .timeline-item { flex: 1; text-align: center; padding: 0 5px; }
        .progress-segment { height: 7px; border-radius: 10px; margin-bottom: 8px; }
        .meta-text { font-size: 11px; font-weight: 600; color: #777; }
    </style>

    <div class="content">
        <div class="container-fluid">
            
            <!-- HEADER -->
            <div class="page-header">
                <div class="page-title">
                    <i class="fas fa-folder-open"></i> All Purchase Cases
                </div>
                <a href="{{ route('createnewcase') }}" class="btn btn-new-project">
                    <i class="fas fa-plus-circle mr-1"></i> New Case
                </a>
            </div>

            <!-- THEMED FILTER BAR -->
            <div class="filter-container">
                <div class="row align-items-end">
                    <div class="col-md-3 filter-item">
                        <label>Case Code</label>
                        <input type="text" class="form-control" placeholder="Select Codes">
                    </div>
                    <div class="col-md-2 filter-item">
                        <label>From Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-2 filter-item">
                        <label>To Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-2 filter-item">
                        <label>Project Stage</label>
                        <select class="form-control">
                            <option value="">All Stages</option>
                            <option value="initiated">Initiated</option>
                            <option value="finance">D Finance</option>
                            <option value="approved">Approved</option>
                            <option value="pi">P.I</option>
                            <option value="po">P.O</option>
                            <option value="received">Received</option>
                            <option value="payment">Payment</option>
                        </select>
                    </div>
                    <div class="col-md-3 filter-item">
                        <label>Main Status</label>
                        <div class="status-toggle">
                            <button class="btn active" onclick="filterCases('all','All Purchase Cases',this)">All</button>
                            <button class="btn" onclick="filterCases('open','Open Cases',this)">Open</button>
                            <button class="btn" onclick="filterCases('closed','Closed Cases',this)">Closed</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXISTING CARDS DATA -->
            <div id="cards-container">
                
                <!-- Card 1 -->
                <div class="card project-card shadow-sm mb-4" data-status="open">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="font-weight-bold mb-1">PC-2004</h4>
                                <div class="text-muted mb-2">Procurement of pressure gauges and sensors</div>
                                <span class="badge badge-warning">Draft</span>
                            </div>
                            <a href="{{ route('purchasecasedetails') }}" class="btn btn-outline-primary btn-sm px-3">View Case</a>
                        </div>
                        <div class="timeline-wrapper mt-4">
                            <div class="timeline-item"><div class="progress-segment bg-primary"></div><div class="meta-text">Initiated</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-warning"></div><div class="meta-text">D Finance</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Approved</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">P.I</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">P.O</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Received</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-secondary"></div><div class="meta-text">Payment</div></div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="card project-card shadow-sm mb-4" data-status="closed">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="font-weight-bold mb-1">PC-1988</h4>
                                <div class="text-muted mb-2">Supply of IT Equipment (Laptops / Servers)</div>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm px-3">View Case</a>
                        </div>
                        <div class="timeline-wrapper mt-4">
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Initiated</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">D Finance</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Approved</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">P.I</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">P.O</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Received</div></div>
                            <div class="timeline-item"><div class="progress-segment bg-success"></div><div class="meta-text">Payment</div></div>
                        </div>
                    </div>
                </div>

            </div> 

        </div>
    </div>
</div>

<script>
function filterCases(status, heading, btn){
    // Update active button style
    const buttons = btn.parentElement.querySelectorAll('.btn');
    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Filter cards
    document.querySelectorAll('.project-card').forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection