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

        /* 4-Column Grid Layout: Attachments (0.5fr) | Items (1.5fr) */
        .top-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 0.5fr 1.5fr; 
            gap: 15px;
            margin-bottom: 15px;
            align-items: stretch;
        }

        /* 2-Column Grid Layout for Quotation Row */
        .quotation-info-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr; 
            gap: 15px;
            margin-bottom: 25px;
            align-items: stretch;
        }

        /* Container Styling */
        .date-grid {
            display: flex;
            flex-direction: column;
            background: #fdfdfd;
            padding: 15px;
            border: 1px solid #ebedf2;
            border-radius: 8px;
            height: 100%;
            overflow: hidden; /* Prevent content spill */
        }

        /* Section Header Style */
        .section-header {
            border-left: 4px solid #007bff;
            padding: 8px 12px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 0 4px 4px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-header h4 { margin: 0; font-size: 1rem; font-weight: 600; color: #333; }

        /* Readability for Tables */
        .readable-table { font-size: 0.85rem; width: 100%; border-collapse: collapse; white-space: nowrap; }
        .readable-table th { background: #f4f6f9; padding: 10px; text-transform: uppercase; border-bottom: 2px solid #dee2e6; text-align: left; font-size: 0.75rem; color: #666; }
        .readable-table td { padding: 8px 10px; vertical-align: middle; border-bottom: 1px solid #eee; color: #333; }

        /* Attachment styling */
        .attachment-box {
            border: 1px solid #ced4da;
            border-radius: 6px;
            height: 200px; 
            overflow-y: auto;
            background: #fff;
        }
        .attachment-item {
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        label { font-weight: 600; font-size: 0.9rem; color: #555; }
        .badge { font-size: 85%; padding: 0.4em 0.6em; }

        .form-actions {
            background: #fff;
            padding: 20px;
            border-top: 1px solid #dee2e6;
            text-align: right;
            margin-top: 20px;
        }
/* Firm list scrollable box */
.firm-scroll-box {
    height: 300px; /* Fixed height for scrolling */
    overflow-y: auto; 
    border: 1px solid #ced4da;
    background: #fff;
    border-radius: 4px;
}

/* Custom Scrollbar for professional look */
.firm-scroll-box::-webkit-scrollbar {
    width: 6px;
}
.firm-scroll-box::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}
.firm-scroll-box::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.list-group-item-action {
    cursor: pointer;
    transition: 0.2s;
}

.list-group-item-action:hover {
    background-color: #f1f7ff;
    color: #007bff;
}

        @media (max-width: 1400px) { 
            .top-info-grid { grid-template-columns: 1fr 1fr; } 
        }
    </style>

    <div class="card">
        <div class="card-header text-right">
            <h3 class="card-title float-left"><i class="fas fa-file-invoice-dollar mr-2"></i> Purchase Case Details</h3>
            <button class="btn btn-secondary btn-sm">Adv. Payment</button>
<a href="{{ route('minutesheet') }}" class="btn btn-secondary btn-sm text-white text-decoration-none">
    Minute
</a>
            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-print"></i></button>
        </div>

        <div class="card-body">
            
            <!-- Case Title Row -->
            <div class="form-group mb-4">
                <label><i class="fas fa-tag mr-1"></i> Case Title</label>
                <input type="text" class="form-control form-control-lg" value="Procurement of pressure gauges, oxygen sensors and siemens RS 485 mod" style="border-left: 4px solid #007bff; font-weight: 600;">
            </div>

            <!-- Top Grid Row -->
            <div class="top-info-grid">
                
                <!-- Core Details & Financials (Merged) -->
                <div class="date-grid" style="grid-column: span 2;">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <div class="row">
                                <div class="col-6"><label>Case ID</label><input type="text" class="form-control" value="2004" readonly></div>
                                <div class="col-6"><label>Date</label><input type="date" class="form-control" value="2025-12-18"></div>
                            </div>
                            <div class="form-group mt-2">
                                <label>Firm Name</label>
                                <input type="text" class="form-control" value="AL REHMAN & SYED TRADERS (PVT) LTD">
                            </div>
                            <label>Terms & Conditions</label>
                            <textarea class="form-control" rows="3">Complete payment after delivery.</textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6 mb-2"><label>Head</label><select class="form-control"><option>IGS</option></select></div>
                                <div class="col-6 mb-2"><label>Status</label><input type="text" class="form-control font-weight-bold" value="Draft" readonly style="color: #28a745;"></div>
                                <div class="col-6"><label>SST Amount</label><input type="text" class="form-control text-right" value="0.00"></div>
                                <div class="col-6"><label>GST Amount</label><input type="text" class="form-control text-right" value="89,100"></div>
                            </div>
                            <div class="mt-auto pt-3">
                                <label class="text-primary">Total Price (PKR)</label>
                                <input type="text" class="form-control form-control-lg text-right font-weight-bold text-primary" value="584,100.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Box (Half Width) -->
                <div class="date-grid">
                    <label>Attachments</label>
                    <div class="attachment-box">
                        <div class="attachment-item">
                            <span><i class="fas fa-file-pdf text-danger"></i> Ref_001.pdf</span>
                            <button class="btn btn-xs btn-link p-0"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="attachment-item bg-light mt-auto text-center justify-content-center">
                            <button class="btn btn-xs btn-outline-primary"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Items Summary (Large Width with all columns from image) -->
                <div class="date-grid">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="mb-0">Items Summary</label>
                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addItemModal"><i class="fas fa-plus"></i></button>
                    </div>
                    <div style="overflow-x: auto; flex-grow: 1;">
                        <table class="readable-table">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th>Price</th>
                                    <th>Balance</th>
                                    <th>Type</th>
                                    <th>Subtype</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Trafas Capsule type pressure 0-2.5 ba</td>
                                    <td>4</td>
                                    <td>num</td>
                                    <td>65,000.00</td>
                                    <td>260,000.00</td>
                                    <td>4</td>
                                    <td>Permanent</td>
                                    <td>Parts</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Smart Oxygen Monitoring Range 0-30</td>
                                    <td>1</td>
                                    <td>num</td>
                                    <td>35,000.00</td>
                                    <td>35,000.00</td>
                                    <td>1</td>
                                    <td>Permanent</td>
                                    <td>Parts</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Siemens RS 485 Module cm1241</td>
                                    <td>1</td>
                                    <td>num</td>
                                    <td>75,000.00</td>
                                    <td>75,000.00</td>
                                    <td>1</td>
                                    <td>Permanent</td>
                                    <td>Parts</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Cargo Tank pressure gauge 300mbr</td>
                                    <td>10</td>
                                    <td>num</td>
                                    <td>12,500.00</td>
                                    <td>125,000.00</td>
                                    <td>10</td>
                                    <td>Permanent</td>
                                    <td>Parts</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quotation Grid Row -->
            <div class="quotation-info-grid">
                <!-- Received Quotations -->
                <div class="date-grid">
                    <div class="section-header">
                        <div class="d-flex align-items-center">
                            <h4 class="mr-3"><i class="fas fa-file-contract mr-2"></i> Received Quotations</h4>
                            <select class="form-control form-control-sm" style="width: 120px;">
                                <option>With Tax</option>
                                <option>Without Tax</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#compStatementModal"><i class="fas fa-balance-scale"></i> Comparative</button>
<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addQuoteModal">
    <i class="fas fa-plus"></i> Add Quote
</button>                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="readable-table">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Firm Name</th>
                                    <th class="text-right">Total Price</th>
                                    <th class="text-center">Tech.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>088</td>
                                    <td class="font-weight-bold">AL REHMAN & SYED TRADERS (PVT) LTD</td>
                                    <td class="text-right font-weight-bold">584,100</td>
                                    <td class="text-center"><span class="badge bg-success">Yes</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Not Received Section -->
<div class="date-grid">
    <div class="section-header">
        <h4><i class="fas fa-exclamation-circle mr-2"></i> Not Received</h4>
        <!-- Updated Trigger -->
        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addNotReceivedModal">
            <i class="fas fa-plus"></i> Add Firm
        </button>
    </div>
    <div class="table-responsive">
        <table class="readable-table">
            <thead>
                <tr>
                    <th>Firm Name</th>
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
</div>
            </div>

            <!-- Modal: Item Details Creation -->
            <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="itemDetailsLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="border-radius: 8px; border-top: 5px solid #6c757d;">
                        <div class="modal-header" style="background-color: #f4f6f9;">
                            <h5 class="modal-title" id="itemDetailsLabel" style="font-weight: bold; color: #444;">
                                <i class="fas fa-list mr-2"></i> Item Details
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="itemForm">
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label>S No</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-md-10">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" id="qty">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Price</label>
                                        <input type="text" class="form-control" id="price">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Type</label>
                                        <select class="form-control">
                                            <option value="">Select Type</option>
                                            <option>Permanent</option>
                                            <option>Consumable</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Inv/Asst</label>
                                        <select class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Den.</label>
                                        <select class="form-control">
                                            <option value="num">num</option>
                                            <option value="kg">kg</option>
                                            <option value="mtr">mtr</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Total Price</label>
                                        <input type="text" class="form-control" readonly style="background-color: #f8f9fa;">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Subtype</label>
                                        <select class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Subhead</label>
                                        <select class="form-control">
                                            <option value="Equipment">Equipment</option>
                                            <option value="Furniture">Furniture</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer" style="background-color: #f4f6f9;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary shadow-sm"><i class="fas fa-save mr-1"></i> Add to List</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal: Comparative Statement View -->
            <div class="modal fade" id="compStatementModal" tabindex="-1" role="dialog" aria-labelledby="compLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="border-radius: 8px; border-top: 5px solid #007bff;">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="compLabel" style="font-weight: bold; color: #333;">
                                <i class="fas fa-file-contract mr-2 text-primary"></i> Comparative Statement (CS)
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-primary py-2" style="background-color: #e7f1ff; border-color: #b3d7ff; color: #004085;">
                                <i class="fas fa-info-circle mr-1"></i> Lowest quoted price is highlighted in green (L1).
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover shadow-sm">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th style="width: 100px;">Rank</th>
                                            <th>Number</th>
                                            <th>Date</th>
                                            <th>Firm / Vendor Name</th>
                                            <th class="text-right">Total Price (PKR)</th>
                                            <th class="text-center">Tech. Acceptable</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: #f0fff4;">
                                            <td class="text-center"><span class="badge badge-success">L1 (Lowest)</span></td>
                                            <td class="text-center">088</td>
                                            <td class="text-center">05 Dec 25</td>
                                            <td class="font-weight-bold text-primary">AL REHMAN & SYED TRADERS (PVT) LTD</td>
                                            <td class="text-right font-weight-bold">584,100</td>
                                            <td class="text-center"><span class="badge badge-success px-3">Yes</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><span class="badge badge-secondary">L2</span></td>
                                            <td class="text-center">2589</td>
                                            <td class="text-center">08 Dec 25</td>
                                            <td>Urban Logistics</td>
                                            <td class="text-right font-weight-bold">638,380</td>
                                            <td class="text-center"><span class="badge badge-success px-3">Yes</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary shadow-sm"><i class="fas fa-print mr-1"></i> Print Statement</button>
                        </div>
                    </div>
                </div>
            </div>


<!-- ========================= MODALS ========================= -->

<!-- 1. Modal: Quote Entry (Large) -->
<div class="modal fade" id="addQuoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="border-radius: 8px; border-top: 5px solid #007bff;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold">Quote Entry</h5>
                <div class="ml-auto">
                    <button type="button" class="btn btn-sm btn-danger mr-2">Delete Quote</button>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            
<div class="modal-body p-0">
    <div class="row no-gutters">
        <!-- Left Sidebar: Firm Selection -->
        <div class="col-md-3 border-right p-3 bg-light">
            <label class="text-primary font-weight-bold">Select Firm</label>
            <div class="firm-scroll-box mb-2 shadow-sm">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">2D Tech Pvt Ltd</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">AL REHMAN & SYED TRADERS</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Urban Logistics</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">A A Communication</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">A T Engineering</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">A&K Construction Company</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Adams Advanced Materials</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">AFM Traders</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Ahmer Masood Ansari Ltd</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">AIK Traders</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Al Hasan Enterprises</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Al Raziq Enterprises</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Al Rehman Traders</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Al Umar Enterprises</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Blue Star Suppliers</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Global Tech Solutions</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Indus Valley Corp</li>
                    <li class="list-group-item list-group-item-action py-1 px-2 border-bottom">Matrix Trading Co.</li>
                </ul>
            </div>
            <button class="btn btn-xs btn-outline-secondary btn-block mb-3" data-toggle="modal" data-target="#newFirmModal">
                <i class="fas fa-plus"></i> New Firm
            </button>
            
            <div class="form-group"><label class="small">Number</label><input type="text" class="form-control form-control-sm" value="<Add Ref>"></div>
            <div class="form-group"><label class="small">Date</label><input type="text" class="form-control form-control-sm" value="31 Dec 25"></div>
            <div class="form-group"><label class="small">Acceptable</label><select class="form-control form-control-sm"><option>Yes</option><option>No</option></select></div>
        </div>

        <!-- Right Side: Items Table & Totals -->
        <div class="col-md-9 p-3 d-flex flex-column" style="min-height: 550px;">
            <div class="table-responsive flex-grow-1">
                <table class="table table-sm table-bordered">
                    <thead class="bg-light small">
                        <tr>
                            <th style="width: 50px;">Serial</th>
                            <th>Description</th>
                            <th style="width: 70px;">Qty</th>
                            <th style="width: 70px;">Unit</th>
                            <th style="width: 120px;">Unit Price</th>
                            <th style="width: 120px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Petrol for BTC-541 Hire Corolla Car for Month of June 2024</td>
                            <td>126</td>
                            <td>ltr</td>
                            <td><input type="text" class="form-control form-control-sm text-right border-0 bg-transparent" value="0.00"></td>
                            <td class="text-right">0.00</td>
                        </tr>
                        <!-- Empty rows for spacing -->
                        <tr><td class="py-3"></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td class="py-3"></td><td></td><td></td><td></td><td></td><td></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Prices -->
            <div class="mt-auto">
                <div class="d-flex flex-column align-items-end mb-3">
                    <div class="border-bottom py-1" style="width: 200px; display: flex; justify-content: space-between;">
                        <span class="small font-weight-bold">Total:</span>
                        <span class="font-weight-bold">0.00</span>
                    </div>
                    <div class="border-bottom py-1" style="width: 200px; display: flex; justify-content: space-between;">
                        <span class="small font-weight-bold">S.S.T:</span>
                        <span class="font-weight-bold">0.00</span>
                    </div>
                    <div class="border-bottom py-1" style="width: 200px; display: flex; justify-content: space-between;">
                        <span class="small font-weight-bold">G.S.T:</span>
                        <span class="font-weight-bold">0.00</span>
                    </div>
                    <div class="py-1" style="width: 200px; display: flex; justify-content: space-between;">
                        <span class="small font-weight-bold">Final Price:</span>
                        <span class="font-weight-bold text-primary h5 mb-0">0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary px-4">Save Quote</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal: Add New Firm (STAY OUTSIDE FOR FIX) -->
<div class="modal fade" id="newFirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content shadow-lg" style="border-top: 4px solid #6c757d;">
            <div class="modal-header bg-light py-2">
                <h6 class="modal-title font-weight-bold">Add New Firm</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold">Firm Name</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Enter name...">
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary">Save Firm</button>
            </div>
        </div>
    </div>
</div>
                        <!-- Footer Prices -->
                        <div class="d-flex flex-column align-items-end mt-4">
                            <div class="d-flex w-25 justify-content-between border-bottom py-1">
                                <span class="small font-weight-bold">Total:</span>
                                <span class="font-weight-bold">0.00</span>
                            </div>
                            <div class="d-flex w-25 justify-content-between py-2">
                                <span class="small font-weight-bold">Final Price:</span>
                                <span class="h5 mb-0 font-weight-bold text-primary">0.00</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary px-4"><i class="fas fa-save mr-1"></i> Save Quote</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Firm (Not Received) -->
<div class="modal fade" id="addNotReceivedModal" tabindex="-1" role="dialog" aria-labelledby="notReceivedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 8px; border-top: 5px solid #007bff;">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title font-weight-bold" id="notReceivedLabel">
                    <i class="fas fa-building mr-2 text-primary"></i> Add Firm (Not Received)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="notReceivedForm">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1">Firm Name</label>
                        <input type="text" class="form-control" placeholder="Enter firm name (e.g. Logistic Suppliers)">
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="font-weight-bold mb-1">Status / Reason</label>
                        <textarea class="form-control" rows="3" placeholder="Reason for not receiving (e.g. No response, Declined, etc.)">No response received yet</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm px-4 shadow-sm">
                    <i class="fas fa-save mr-1"></i> Add to List
                </button>
            </div>
        </div>
    </div>
</div>

            <!-- Footer Action Buttons -->
            <div class="form-actions">
                <button class="btn btn-default mr-2">Back</button>
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-check mr-1"></i> Release Case
                </button>
            </div>

        </div> 
    </div>
</div>

<script>
    /* Display checkmark after file selection */
    function markUploaded(input, iconId) {
        if (input.files && input.files[0]) {
            input.previousElementSibling.classList.remove('btn-outline-primary');
            input.previousElementSibling.classList.add('btn-success');
            input.previousElementSibling.innerHTML = '<i class="fas fa-check"></i>';
        }
    }
</script>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Auto Date for signature
        const now = new Date();
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $('#sig-date-display').html(`&nbsp;&nbsp; ${months[now.getMonth()]} ${now.getFullYear().toString().substr(-2)}`);

        // Nested Modal Fix
        $('#newFirmModal').on('hidden.bs.modal', function () {
            if ($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
            }
        });
    });
</script>

@endsection