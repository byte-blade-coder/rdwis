<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minute Sheet - Signature Fix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --paper-width: 216mm;
            --paper-height: 356mm;
            --m-top: 25mm;
            --m-bottom: 25mm;
            --m-left: 25mm;
            --m-right: 20mm;
            --font-sz: 12pt;
        }

        body {
            background-color: #525659;
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR (SETTINGS) */
        .settings-sidebar {
            width: 300px;
            background: #252526;
            color: #ccc;
            padding: 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.5);
            z-index: 1001;
            overflow-y: auto;
            flex-shrink: 0;
        }
        .settings-sidebar h3 { color: #fff; font-size: 18px; border-bottom: 1px solid #444; padding-bottom: 10px; margin-top: 0; }
        .setting-group { margin-bottom: 15px; }
        .setting-group label { display: block; font-size: 11px; margin-bottom: 5px; color: #999; text-transform: uppercase; }
        .setting-group input, .setting-group select { 
            width: 100%; background: #3c3c3c; border: 1px solid #555; color: #fff; padding: 8px; border-radius: 4px; font-family: Arial;
        }
        .margin-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        /* WORKSPACE */
        .workspace { 
            flex-grow: 1; 
            overflow-y: auto; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding: 20px 0; 
            background: #525659;
        }

        /* PAPER STYLE */
        .paper-page {
            background: white;
            width: var(--paper-width);
            height: var(--paper-height);
            padding: var(--m-top) var(--m-right) var(--m-bottom) var(--m-left);
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            box-sizing: border-box;
            position: relative;
            color: black;
            margin-bottom: 20px;
            overflow: hidden; 
            flex-shrink: 0;
        }

        /* CONTENT STYLING */
        .header-row { display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 12pt; }
        .header-center { font-weight: bold; text-decoration: underline; font-size: 13pt; }
        .minute-title { text-align: center; font-weight: bold; font-size: 16pt; margin: 25px 0; }
        
        .para-row { display: flex; margin-bottom: 15px; font-size: var(--font-sz); line-height: 1.4; text-align: justify; }
        .para-num { width: 40px; font-weight: bold; flex-shrink: 0; }
        .para-body { flex: 1; }

        .box-table { width: 100%; border-collapse: collapse; margin: 10px 0; border: 1.5px solid black; }
        .box-table th, .box-table td { border: 1px solid black; padding: 5px 8px; font-size: 11pt; text-align: left; }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }

        /* Signature Block Fix - Right side of page, Internal centering */
        .signature-block { 
            margin-top: 60px; 
            float: right; 
            text-align: left; 
            font-weight: bold; 
            font-size: 13pt; 
            line-height: 1.3; 
            min-width: 180px; /* Adjusted width */
        }

        .sig-date-row {
            display: block;
            margin-top: 2px;
            font-size: 12pt;
        }

        /* PRINT LOGIC */
        @media print {
            body { background: none !important; display: block !important; overflow: visible !important; }
            .settings-sidebar { display: none !important; }
            .workspace { display: block !important; overflow: visible !important; padding: 0 !important; margin: 0 !important; }
            
            .paper-page {
                margin: 0 !important; 
                box-shadow: none !important; 
                width: 100% !important; 
                height: 100vh !important; 
                page-break-after: always !important;
                border: none !important;
            }

            .paper-page:last-child {
                page-break-after: avoid !important;
            }

            @page { 
                size: legal portrait; 
                margin: 0; 
            }
        }
    </style>
</head>
<body>

    <!-- SETTINGS SIDEBAR -->
    <div class="settings-sidebar">
        <h3><i class="fas fa-sliders-h mr-2"></i> Page Setup</h3>
        <div class="setting-group">
            <label>Paper Size</label>
            <select id="pageSize" onchange="updateSetup()">
                <option value="legal">Legal (8.5" x 14")</option>
                <option value="a4">A4 (8.27" x 11.69")</option>
            </select>
        </div>
        <div class="setting-group">
            <label>Margins (mm)</label>
            <div class="margin-grid">
                <div><label>Top</label><input type="number" id="mTop" value="25" onchange="updateSetup()"></div>
                <div><label>Bottom</label><input type="number" id="mBottom" value="25" onchange="updateSetup()"></div>
                <div><label>Left</label><input type="number" id="mLeft" value="25" onchange="updateSetup()"></div>
                <div><label>Right</label><input type="number" id="mRight" value="20" onchange="updateSetup()"></div>
            </div>
        </div>
        <div class="setting-group">
            <label>Text Size (pt)</label>
            <input type="number" id="fontSize" value="12" onchange="updateSetup()">
        </div>
        <hr style="border:0; border-top:1px solid #444; margin:20px 0;">
        <button onclick="window.print()" style="width:100%; background:#28a745; border:none; color:white; padding:12px; cursor:pointer; font-weight:bold; border-radius:4px;">
            <i class="fas fa-print mr-2"></i> PRINT REPORT
        </button>
    </div>

    <!-- WORKSPACE -->
    <div class="workspace" id="workspace"></div>

    <!-- HIDDEN SOURCE CONTENT -->
    <div id="content-source" style="display:none;">
        <div class="header-row">
            <div style="width: 30%;">2015<br>Dated: 01 Jan 26</div>
            <div class="header-center">59</div>
            <div style="width: 35%; text-align: right;">From: Director Comm<br>Market Research Report<br>Encl 59 A/D (F/A)</div>
        </div>
        <div class="header-row" style="margin-top: 20px;">
            <div style="width: 30%;">2015<br>Dated: 01 Jan 26</div>
            <div class="header-center">60</div>
            <div style="width: 35%; text-align: right;">From: Director Comm<br>Purchase Case<br>Encl 60 A (F/B)</div>
        </div>
        <div class="minute-title">Minute-61</div>
        
        <!-- Para 1 -->
        <div class="para-row">
            <div class="para-num">1.</div>
            <div class="para-body">
                Purchase case listed below, is required for NDB project
                <table class="box-table">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 60px;">S No</th>
                            <th style="width: 100px;">Case No</th>
                            <th>Title</th>
                            <th style="width: 130px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">a.</td>
                            <td class="text-center">2015</td>
                            <td>Procurement of Ruggedized Computer</td>
                            <td class="text-right">440,600</td>
                        </tr>
                        <tr style="font-weight: bold;"><td colspan="3" class="text-right">Total</td><td class="text-right">440,600</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Para 2 -->
        <div class="para-row">
            <div class="para-num">2.</div>
            <div class="para-body">Details of purchase case mentioned above are placed at Encl 60 A (F/B). Market research report is also placed at Encl 59 A/D (F/A).</div>
        </div>

        <!-- Para 3 -->
        <div class="para-row">
            <div class="para-num">3.</div>
            <div class="para-body">The purchase is to be done from NDB project head. Allocation for the project is Rs. 30,450,000, of which MTSS share is Rs. 8,451,165 and CSRF share is Rs. 304,500. Tabulated below is the breakdown of Project share excluding GST.</div>
        </div>

        <!-- Tables -->
        <div class="para-row" style="margin-left: 40px; display: block;">
            <p><strong>Account Figures:</strong> (Excluding CSRF)</p>
            <table class="box-table" style="width: 480px;">
                <tr><td style="width: 30px;" class="text-center">a.</td><td>Project Share</td><td class="text-right">21,694,335</td></tr>
                <tr><td class="text-center">b.</td><td>Received</td><td class="text-right">15,094,685</td></tr>
                <tr><td class="text-center">c.</td><td>Expenditure</td><td class="text-right">17,880,840</td></tr>
                <tr><td class="text-center">d.</td><td>Commitments</td><td class="text-right">741,875</td></tr>
                <tr><td class="text-center">e.</td><td>In Process (Incl. 440,600 current case)</td><td class="text-right">1,321,362.40</td></tr>
                <tr><td class="text-center">f.</td><td>Available</td><td class="text-right">-4,849,392.40</td></tr>
            </table>
        </div>

        <div class="para-row" style="margin-left: 40px; display: block; margin-top: 20px;">
            <p><strong>Project Figures:</strong></p>
            <table class="box-table text-center">
                <thead>
                    <tr><th>#</th><th style="text-align: left;">Description</th><th>Overall</th><th>Equipment</th><th>HR</th><th>Misc</th></tr>
                </thead>
                <tbody>
                    <tr><td>k.</td><td style="text-align: left;">Max Spending Limit</td><td>21,694,335</td><td>14,579,137</td><td>6,130,222</td><td>984,976</td></tr>
                    <tr><td>l.</td><td style="text-align: left;">Expenditure</td><td>17,880,840</td><td>12,296,234</td><td>4,758,006</td><td>826,600</td></tr>
                    <tr><td>m.</td><td style="text-align: left;">Commitments</td><td>741,875</td><td>729,875</td><td>0.00</td><td>12,000</td></tr>
                    <tr><td>n.</td><td style="text-align: left;">In Process</td><td>1,321,362.40</td><td>972,862.40</td><td>245,000</td><td>103,500</td></tr>
                    <tr><td>p.</td><td style="text-align: left;">Can be Spent</td><td>1,750,257.60</td><td>580,165.60</td><td>1,127,216</td><td>42,876</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Para 4 -->
        <div class="para-row">
            <div class="para-num">4.</div>
            <div class="para-body">Foregoing in view, approval in principle of Rs. 440,600 (Rupees Four Hundred Forty Thousand Six Hundred Only) may please be accorded to process the purchase requirement mentioned at para 1/N above through M/s MTSS.</div>
        </div>

        <!-- SIGNATURE BLOCK -->
        <div class="signature-block">
            Dr Aleem Mushtaq<br>
            Capt PN<br>
            Dir COMM<br>
            <span class="sig-date-row" id="auto-sig-date"></span>
        </div>
    </div>

    <script>
        function updateSetup() {
            const size = document.getElementById('pageSize').value;
            const root = document.documentElement;

            let w = (size === 'a4') ? 210 : 216;
            let h = (size === 'a4') ? 297 : 356;

            root.style.setProperty('--paper-width', w + 'mm');
            root.style.setProperty('--paper-height', h + 'mm');
            root.style.setProperty('--m-top', document.getElementById('mTop').value + 'mm');
            root.style.setProperty('--m-bottom', document.getElementById('mBottom').value + 'mm');
            root.style.setProperty('--m-left', document.getElementById('mLeft').value + 'mm');
            root.style.setProperty('--m-right', document.getElementById('mRight').value + 'mm');
            root.style.setProperty('--font-sz', document.getElementById('fontSize').value + 'pt');

            setSignatureDate();
            setTimeout(paginate, 200);
        }

        function setSignatureDate() {
            const now = new Date();
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const currentMonth = monthNames[now.getMonth()];
            const currentYear = now.getFullYear().toString().substr(-2);
            
            // Reduced space: only 2 non-breaking spaces before the month
            const sigDateSpan = document.querySelector('#content-source #auto-sig-date');
            if (sigDateSpan) {
                sigDateSpan.innerHTML = `&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ${currentMonth} ${currentYear}`;
            }
        }

        function paginate() {
            const workspace = document.getElementById('workspace');
            const source = document.getElementById('content-source');
            workspace.innerHTML = ''; 

            const dummy = document.createElement('div');
            dummy.style.height = 'var(--paper-height)';
            dummy.style.visibility = 'hidden';
            document.body.appendChild(dummy);
            const totalPxHeight = dummy.offsetHeight;
            document.body.removeChild(dummy);

            let pageNum = 1;
            let currentPage = createPageDiv();
            let nodes = Array.from(source.children);

            nodes.forEach(node => {
                let clone = node.cloneNode(true);
                currentPage.appendChild(clone);
                if (currentPage.scrollHeight > totalPxHeight) {
                    currentPage.removeChild(clone);
                    pageNum++;
                    currentPage = createPageDiv();
                    currentPage.appendChild(clone);
                }
            });
        }

        function createPageDiv() {
            const page = document.createElement('div');
            page.className = 'paper-page';
            document.getElementById('workspace').appendChild(page);
            return page;
        }

        window.onload = updateSetup;
    </script>
</body>
</html>