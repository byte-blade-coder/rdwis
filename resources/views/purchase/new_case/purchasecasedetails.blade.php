@extends('welcome')

@section('content')
<div class="content-wrapper">
    <style>
        /* Modern AdminLTE Enhancements */
        .card {
            border-top: 3px solid #007bff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }

        .card-title {
            font-weight: 600;
            color: #333;
        }

        /* Top Info Grid */
        .top-info-grid {
            display: grid;
            grid-template-columns: 1.5fr 2fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            background: #fdfdfd;
            padding: 15px;
            border: 1px solid #ebedf2;
            border-radius: 8px;
        }

        /* Advanced Attachment Box */
        .attachment-box {
            border: 1px solid #ced4da;
            border-radius: 6px;
            height: 250px; /* Adjusted height */
            overflow-y: auto;
            background: #fff;
        }
        .attachment-item {
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .attachment-info { display: flex; align-items: center; font-size: 13px; }
        .attachment-info i { margin-right: 8px; color: #28a745; display: none; }
        .file-input-wrapper { position: relative; overflow: hidden; display: inline-block; }
        .file-input-wrapper input[type=file] { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; }

        /* Table Styling */
        .table thead th {
            background-color: #f4f6f9;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            vertical-align: middle;
        }
        .table td { vertical-align: middle; }

        /* Section Headers */
        .section-header {
            border-left: 4px solid #007bff;
            padding-left: 10px;
            margin: 30px 0 15px 0;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 0 4px 4px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-header h4 { margin: 0; font-size: 1.1rem; color: #333; }

        /* Bottom Save Bar */
        .form-actions {
            background: #fff;
            padding: 20px;
            border-top: 1px solid #dee2e6;
            text-align: right;
            margin-top: 30px;
            border-radius: 0 0 8px 8px;
        }

        label { font-weight: 600; font-size: 0.9rem; color: #555; }
        
        .badge { font-size: 85%; padding: 0.5em 0.7em; }

        @media (max-width: 1200px) {
            .top-info-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .top-info-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-invoice-dollar mr-2"></i> Purchase Case Details</h3>
            <div class="card-tools">
                <button class="btn btn-secondary btn-sm mr-1">Adv. Payment</button>
                <button class="btn btn-secondary btn-sm mr-1">Minute</button>
                <button class="btn btn-secondary btn-sm mr-1">Market Report</button>
                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-print"></i></button>
            </div>
        </div>

        <div class="card-body">
            
            <!-- Main Title -->
            <div class="form-group mb-4">
                <label><i class="fas fa-tag mr-1"></i> Case Title</label>
                <input type="text" class="form-control form-control-lg" value="{{ $data['title'] ?? 'Procurement of pressure gauges, oxygen sensors and siemens RS 485 mod' }}" style="border-left: 4px solid #007bff; font-weight: 600;">
            </div>

            <!-- Top Info Grid -->
            <div class="top-info-grid">
                
                <!-- Column 1: Core Info -->
                <div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Case ID</label>
                                <input type="text" class="form-control" value="{{ $data['case_id'] ?? '2004' }}" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" value="{{ $data['date'] ?? '2025-12-18' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Firm Name</label>
                        <input type="text" class="form-control" value="AL REHMAN & SYED TRADERS (PVT) LTD">
                    </div>

                    <div class="form-group">
                        <label>Terms & Conditions</label>
                        <textarea class="form-control" rows="3">Complete payment after delivery.</textarea>
                    </div>
                </div>

                <!-- Column 2: Financials & Status (Gray Box) -->
                <div class="date-grid">
                    <div class="form-group">
                        <label>Head</label>
                        <select class="form-control">
                            <option>{{ $data['head'] ?? 'IGS' }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>For</label>
                        <select class="form-control">
                            <option>{{ $data['for'] ?? 'IGS' }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Minute #</label>
                        <input type="text" class="form-control" value="{{ $data['minute'] ?? '13' }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" value="Draft" readonly style="color: #28a745; font-weight: bold;">
                    </div>
                    <div class="form-group">
                        <label>SST Amount</label>
                        <input type="text" class="form-control text-right" value="0.00">
                    </div>
                    <div class="form-group">
                        <label>GST Amount</label>
                        <input type="text" class="form-control text-right" value="89,100.00">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="text-primary">Total Price (PKR)</label>
                        <input type="text" class="form-control form-control-lg text-right" value="584,100.00" style="font-weight: bold; color: #007bff;">
                    </div>
                </div>

                <!-- Column 3: Attachments -->
                <div>
                    <label>Documents & Attachments</label>
                    <div class="attachment-box">
                        <div class="attachment-item">
                            <div class="attachment-info">
                                <i class="fas fa-file-pdf mr-2 text-danger"></i>
                                <span>File_Reference_001.pdf</span>
                            </div>
                            <div class="file-input-wrapper">
                                <button class="btn btn-xs btn-default border"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="attachment-item">
                            <div class="attachment-info">
                                <i class="fas fa-file-image mr-2 text-primary"></i>
                                <span>Quotation_Scan.jpg</span>
                            </div>
                            <div class="file-input-wrapper">
                                <button class="btn btn-xs btn-default border"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <!-- Upload New -->
                        <div class="attachment-item" style="background-color: #f9f9f9;">
                            <div class="attachment-info">
                                <i class="fas fa-check-circle mr-1" id="icon-new"></i>
                                <span class="text-muted">Upload New...</span>
                            </div>
                            <div class="file-input-wrapper">
                                <button class="btn btn-xs btn-outline-primary"><i class="fas fa-plus"></i></button>
                                <input type="file" onchange="markUploaded(this, 'icon-new')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================= ITEMS SECTION ========================= -->
            <div class="section-header">
                <h4><i class="fas fa-list-ul mr-2"></i> Items List</h4>
                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i> Add Item</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 35%;">Description</th>
                            <th style="width: 10%;">Qty</th>
                            <th style="width: 10%;">Unit</th>
                            <th class="text-right" style="width: 15%;">Unit Price</th>
                            <th class="text-right" style="width: 15%;">Total</th>
                            <th style="width: 10%;">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Trafas Capsule type pressure 0-2.5 ba</td>
                            <td>4</td>
                            <td>num</td>
                            <td class="text-right">65,000</td>
                            <td class="text-right font-weight-bold">260,000</td>
                            <td><span class="badge bg-secondary">Permanent</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Smart Oxygen Monitoring Range 0-30</td>
                            <td>1</td>
                            <td>num</td>
                            <td class="text-right">35,000</td>
                            <td class="text-right font-weight-bold">35,000</td>
                            <td><span class="badge bg-secondary">Permanent</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Siemens RS 485 Module cm1241</td>
                            <td>1</td>
                            <td>num</td>
                            <td class="text-right">75,000</td>
                            <td class="text-right font-weight-bold">75,000</td>
                            <td><span class="badge bg-secondary">Permanent</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ========================= QUOTATIONS SECTION ========================= -->
            <div class="section-header d-flex justify-content-between align-items-center">
    
    <!-- Left Side -->
    <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0 m-2">
            <i class="fas fa-file-contract mr-2"></i> Quotations
        </h4>

        <!-- Tax Dropdown -->
        <select class="form-control form-control-sm" style="width: 140px;">
            <option value="with_tax">With Tax</option>
            <option value="without_tax">Without Tax</option>
        </select>
    </div>

    <!-- Right Side -->
    <button class="btn btn-outline-primary btn-sm">
        <i class="fas fa-plus"></i> Add Quote
    </button>

</div>


            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Date</th>
                            <th>Firm</th>
                            <th class="text-right">Total Price</th>
                            <th class="text-center">Tech. Acceptable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="text-muted">088</span></td>
                            <td>05 Dec 25</td>
                            <td>AL REHMAN & SYED TRADERS (PVT) LTD</td>
                            <td class="text-right font-weight-bold">584,100</td>
                            <td class="text-center"><span class="badge bg-success">Yes</span></td>
                        </tr>
                        <tr>
                            <td><span class="text-muted">2589</span></td>
                            <td>08 Dec 25</td>
                            <td>Urban Logistics</td>
                            <td class="text-right font-weight-bold">638,380</td>
                            <td class="text-center"><span class="badge bg-success">Yes</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ========================= QUOTATIONS NOT RECEIVED ========================= -->
            <div class="section-header">
                <h4><i class="fas fa-exclamation-circle mr-2"></i> Quotations Not Received</h4>
                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i> Add Firm</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Firm Name</th>
                            <th>Status / Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Logistic Suppliers</td>
                            <td class="text-muted font-italic">No response received yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Actions -->
            <div class="form-actions">
                <a href="{{ route('createnewcase') }}" class="btn btn-default mr-2">Back</a>
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-check mr-1"></i> Release Case
                </button>
            </div>

        </div> 
    </div>
</div>

<script>
    // Function to show checkmark when file is selected
    function markUploaded(input, iconId) {
        if (input.files && input.files[0]) {
            document.getElementById(iconId).style.display = "inline-block";
            input.previousElementSibling.classList.remove('btn-outline-primary');
            input.previousElementSibling.classList.add('btn-success');
            input.previousElementSibling.innerHTML = '<i class="fas fa-check"></i>';
        }
    }
</script>
@endsection