@extends('welcome')

@section('content')

<div class="content-wrapper">



<style>
  
        /* --- 2. Card Component --- */
        .card {
            background-color: #ffffff;
            border: 0 solid rgba(0,0,0,.125);
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
        }

        /* Top Border Color: #007BFF */
        .card.card-primary.card-outline {
            border-top: 3px solid #007BFF;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 0.75rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            float: left;
            font-size: 1.1rem;
            font-weight: 400;
            margin: 0;
            color: #1f2d3d;
        }

        .card-tools {
            float: right;
            margin-right: -0.625rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        /* --- 3. Buttons (Color: #007BFF) --- */
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            cursor: pointer;
            transition: all .15s ease-in-out;
        }

        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .btn-default {
            background-color: #f8f9fa;
            border-color: #ddd;
            color: #444;
        }
        .btn-default:hover { background-color: #e2e6ea; border-color: #adadad; }

        /* Primary Button strict #007BFF */
        .btn-primary {
            color: #fff;
            background-color: #007BFF;
            border-color: #007BFF;
            box-shadow: none;
        }
        .btn-primary:hover { 
            background-color: #0069d9; 
            border-color: #0062cc; 
        }

        .btn-tool {
            background-color: transparent;
            color: #adb5bd;
            font-size: 0.875rem;
            margin: -0.75rem 0;
            padding: .25rem .5rem;
        }
        .btn-tool:hover { color: #495057; }

        /* --- 4. Inputs --- */
        .form-group { margin-bottom: 1rem; }
        
        label {
            display: inline-block;
            margin-bottom: .5rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #343a40;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .form-control-sm {
            height: calc(1.8125rem + 2px);
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .form-control:focus {
            border-color: #007BFF;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        /* --- 5. Grid Layout --- */
        .project-grid-top {
            display: grid;
            grid-template-columns: 35% 45% 20%;
            gap: 20px;
        }

        .dates-wrapper {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 4px;
        }
        .dates-row {
            display: flex;
            margin-bottom: 8px;
            align-items: center;
        }
        .dates-row label {
            width: 110px;
            margin-bottom: 0;
            font-weight: 600;
            color: #6c757d;
        }

        .attachment-block {
            border: 1px solid #ced4da;
            background: #fff;
            border-radius: .25rem;
            height: 100%;
            width: 265px;
            display: flex;
            flex-direction: column;
            
            /* padding-left: -20px; */
        }
        .attachment-header {
            background-color: #e9ecef;
            padding: 8px 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 1px solid #ced4da;
        }
        .attachment-content {
            flex: 1;
            overflow-y: auto;
            max-height: 180px;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .attachment-content li {
            padding: 8px 10px;
            border-bottom: 1px solid #f4f4f4;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- 6. Table & Progress --- */
        .table-responsive { width: 100%; overflow-x: auto; }
        
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: .75rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #fff;
            color: #495057;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }

        /* Progress Bar */
        .progress {
            display: flex;
            height: 1rem;
            overflow: hidden;
            line-height: 0;
            font-size: .75rem;
            background-color: #e9ecef;
            border-radius: .25rem;
            box-shadow: inset 0 .1rem .1rem rgba(0,0,0,.1);
        }
        .progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #007BFF;
            transition: width .6s ease;
        }
        .bg-success { background-color: #28a745!important; }
        .bg-primary { background-color: #007BFF!important; }
        
        .progress-text {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 2px;
            display: block;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            border-radius: .25rem;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-primary { background-color: #007BFF; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }

        /* Footer */
        .footer-separator {
            border-top: 2px solid #007BFF;
            margin-top: 20px; 
            padding-top: 20px;
        }

        @media (max-width: 992px) {
            .project-grid-top { grid-template-columns: 1fr; }
            .dates-wrapper, .attachment-block { margin-top: 15px; }
        }
    </style>



  <div class="card card-primary card-outline">
        
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit"></i> Project CDS</h3>
            <div class="card-tools">
                <button class="btn btn-default btn-sm">History</button>
                <button class="btn btn-default btn-sm">Gantt Chart</button>
                <button class="btn btn-default btn-sm"><i class="fas fa-file-alt"></i></button>
                <button class="btn btn-tool"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            
            <div class="project-grid-top">
                <div class="left-details">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="Functional replacement of CDS display of PNS ALAMGIR" style="font-weight: bold;">
                    </div>
                    <div class="form-group">
                        <label>Scope</label>
                        <textarea class="form-control" rows="3">Functional replacement of CRTs of CDS with LED displays</textarea>
                    </div>
                    <div class="row" style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label>Sponsor</label>
                            <input type="text" class="form-control" value="DSMR WE">
                        </div>
                        <div style="flex: 1;">
                            <label>Receipt Date</label>
                            <input type="text" class="form-control" value="31 May 21">
                        </div>
                    </div>
                </div>

                <div class="dates-wrapper">
                    <div class="dates-row"><label>Assign. date</label><input type="text" class="form-control form-control-sm" value="04 Oct 21"></div>
                    <div class="dates-row"><label>Proposal date</label><input type="text" class="form-control form-control-sm" value="09 Aug 21"></div>
                    <div class="dates-row"><label>Proposed cost</label><input type="text" class="form-control form-control-sm" value="10,000,000"></div>
                    <hr style="margin: 10px 0; border-top: 1px solid #e9ecef;">
                    <div class="dates-row"><label>Approval date</label><input type="text" class="form-control form-control-sm" value="04 Oct 21"></div>
                    <div class="dates-row"><label>Start date</label><input type="text" class="form-control form-control-sm" value="20 Oct 21"></div>
                    <div class="dates-row"><label>EDC</label><input type="text" class="form-control form-control-sm" value="20 Jul 22"></div>
                </div>

                <div class="attachment-block">
                    <div class="attachment-header">Attachments</div>
                    <ul class="attachment-content">
                        <li><span>PPF</span><input type="checkbox" checked></li>
                        <li><span>Project Approval</span><input type="checkbox"></li>
                        <li><span>Project Proposal</span><input type="checkbox" checked></li>
                        <li><span>Work Order</span><input type="checkbox" checked></li>
                        <li><span>Tech Specs</span><input type="checkbox"></li>
                    </ul>
                </div>
            </div>

            <br>

            <div class="d-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="font-size: 1.1rem; color: #6c757d; font-weight: 600;">Activities & Milestones</h4><a href="{{route('addmilestonecpr')}}">
                <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>  Add Milestone  </button></a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th style="width: 140px;">Start Date</th> 
                            <th>Target Date</th>
                            <th style="width: 15%;">% Comp</th>
                            <th>Achieved Dt</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Milestone</td>
                            <td>Submission of Global Plan</td>
                            <td><input type="date" class="form-control form-control-sm" value="2021-09-20"></td>
                            <td>20 Nov 21</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                </div>
                                <small class="progress-text">100%</small>
                            </td>
                            <td>18 Oct 21</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Milestone</td>
                            <td>Submission of CDR</td>
                            <td><input type="date" class="form-control form-control-sm" value="2022-01-15"></td>
                            <td>20 Jan 22</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                </div>
                                <small class="progress-text">100%</small>
                            </td>
                            <td>15 May 22</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Milestone</td>
                            <td>Lab trials of Decoder and LEDs</td>
                            <td><input type="date" class="form-control form-control-sm" value="2022-02-01"></td>
                            <td>21 Mar 22</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                </div>
                                <small class="progress-text">100%</small>
                            </td>
                            <td>01 Dec 22</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Milestone</td>
                            <td>Installation and SATs</td>
                            <td><input type="date" class="form-control form-control-sm" value="2022-06-01"></td>
                            <td>20 Jun 22</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-primary" style="width: 45%"></div>
                                </div>
                                <small class="progress-text">45%</small>
                            </td>
                            <td>-</td>
                            <td><span class="badge badge-primary">In progress</span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Milestone</td>
                            <td>Warranty</td>
                            <td><input type="date" class="form-control form-control-sm"></td>
                            <td>21 Jun 23</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-secondary" style="width: 0%"></div>
                                </div>
                                <small class="progress-text">0%</small>
                            </td>
                            <td>-</td>
                            <td><span class="badge badge-secondary">Not started</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer-separator">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <label>Status</label>
                                <select class="form-control">
                                    <option>Work in progress</option>
                                    <option>Completed</option>
                                    <option>Halted</option>
                                </select>
                            </div>
                            <div style="flex: 1;">
                                <label>Completion Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="6" style="background-color: #f4f6f9;">
1. Milestone 1 has been completed and accepted.
2. One of the Radars was made available onboard in April 22...
3. Milestone 2 has been completed and submitted on 15 May.</textarea>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Notes (Private)</label>
                            <textarea class="form-control" rows="9" placeholder="Enter private project notes here..." style="background-color: #fff3cd; color: #856404; border-color: #ffeeba;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div> 
        
        <div class="card-footer" style="background-color: #f7f7f7;">
            <button type="submit" class="btn btn-primary float-right">Save Changes</button>
            <button type="button" class="btn btn-default">Cancel</button>
        </div>

    </div>



</div>
@endsection