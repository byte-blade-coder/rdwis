@extends('welcome')

@section('content')
<div class="content-wrapper">
    <style>
        /* Main Theme Colors */
        :root {
            --admin-blue: #007bff;
            --admin-dark: #343a40;
            --light-bg: #f4f6f9;
        }

        .mpr-detail-card {
            background: #fff;
            margin: 15px;
            border-top: 4px solid var(--admin-blue);
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }

        /* Top Header Section */
        .mpr-main-header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mpr-title-text { color: var(--admin-dark); font-weight: 700; margin: 0; }

        /* Summary Boxes Layout */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            padding: 15px;
            background: #fff;
        }

        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            min-height: 100px;
        }

        .summary-box strong { color: var(--admin-blue); display: block; margin-bottom: 5px; border-bottom: 1px solid #eee; }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .data-label { color: #666; font-weight: 500; }

        /* Milestones Table Section */
        .milestone-section { padding: 0 15px; }
        .section-label { 
            background: var(--admin-dark); 
            color: #fff; 
            padding: 5px 15px; 
            font-size: 0.9rem; 
            font-weight: 600;
            display: inline-block;
            border-radius: 4px 4px 0 0;
        }

        .milestone-table { width: 100%; border-collapse: collapse; border: 1px solid #ddd; font-size: 0.85rem; }
        .milestone-table th { background: #e9ecef; padding: 8px; border: 1px solid #ddd; text-align: left; }
        .milestone-table td { padding: 8px; border: 1px solid #ddd; }
        .milestone-table tr:nth-child(even) { background: #f9f9f9; }

        /* Lower Grid (Progress & Notes) */
        .lower-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 250px;
            gap: 15px;
            padding: 15px;
        }

        .content-box {
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 300px;
            display: flex;
            flex-direction: column;
        }

        .box-header {
            background: #f4f6f9;
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
        }

        .box-body { padding: 10px; overflow-y: auto; font-size: 0.88rem; line-height: 1.5; color: #444; flex-grow: 1; }

        /* Buttons Styling */
        .btn-blue-sm { background: var(--admin-blue); color: #fff; border: none; padding: 4px 12px; border-radius: 3px; font-size: 0.8rem; }
        .btn-blue-sm:hover { background: #0056b3; color: #fff; }

        .btn-group-top .btn { margin-left: 5px; font-weight: 600; font-size: 0.8rem; }
    </style>

    <div class="content-wrapper pt-3">
    <section class="content">
        <div class="container-fluid">
            
            {{-- Back Button --}}
            <div class="mb-2">
                <a href="{{ route('projects.show', $mpr->pgh_xprj_id) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Project
                </a>
            </div>

            <div class="card card-widget shadow">
                <div class="card-header bg-light">
                    <div class="user-block">
                        <span class="username ml-0" style="font-size: 1.2rem;">{{ $mpr->project->prj_title }}</span>
                        <span class="description ml-0">Report Date: {{ \Carbon\Carbon::parse($mpr->pgh_dt)->format('d M, Y') }} | ID: #{{ $mpr->pgh_id }}</span>
                    </div>
                    <div class="card-tools">
                        <span class="badge badge-success" style="font-size: 1rem;">{{ $mpr->pgh_percent }}% Complete</span>
                        <button type="button" class="btn btn-tool" onclick="window.print()"><i class="fas fa-print"></i></button>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Title --}}
                    <h4 class="text-primary mb-3">{{ $mpr->pgh_intro }}</h4>
                    
                    {{-- Description --}}
                    <h6 class="font-weight-bold text-muted text-uppercase">Work Description:</h6>
                    <div class="p-3 mb-3" style="background: #f8f9fa; border-radius: 5px; border-left: 4px solid #007bff;">
                        <p class="mb-0" style="white-space: pre-line;">{{ $mpr->pgh_progress }}</p>
                    </div>

                    {{-- Issues --}}
                    @if($mpr->pgh_issues)
                    <h6 class="font-weight-bold text-danger text-uppercase mt-4">Issues / Bottlenecks:</h6>
                    <div class="p-3 mb-3" style="background: #fff5f5; border-radius: 5px; border-left: 4px solid #dc3545;">
                        <p class="mb-0 text-danger">{{ $mpr->pgh_issues }}</p>
                    </div>
                    @endif

                    {{-- Attachments Section (Placeholder logic) --}}
                    <div class="mt-4">
                        <h6 class="font-weight-bold text-muted">Attachments:</h6>
                        <div class="row">
                            <div class="col-sm-2">
                                <a href="#" class="btn btn-outline-secondary btn-block text-truncate">
                                    <i class="fas fa-file-image mr-2"></i> Site_Photo_1.jpg
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <a href="#" class="btn btn-outline-secondary btn-block text-truncate">
                                    <i class="fas fa-file-pdf mr-2"></i> Report.pdf
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <small class="text-muted">Report generated by System on {{ now()->format('d-m-Y H:i') }}</small>
                </div>
            </div>

        </div>
    </section>
</div>
</div>
@endsection