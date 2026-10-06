<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Tax Report - All Parties (Detail)</title>
  <style>
    /* Reset and Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f8f9fa;
      color: #333;
      line-height: 1.6;
      padding: 20px;
    }
    
    /* Header Styles */
    .company-header {
      text-align: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #3498db;
    }
    
    .company-header h3 {
      font-size: 24px;
      color: #2c3e50;
      margin-bottom: 5px;
    }
    
    .company-header p {
      color: #7f8c8d;
      font-size: 14px;
      margin-top: 2px;
    }
    
    .report-title {
      text-align: center;
      margin-bottom: 20px;
      padding: 15px;
      background-color: #f1f8ff;
      border-radius: 6px;
      border: 1px solid #cce5ff;
    }
    
    .report-title h2 {
      color: #3498db;
      font-size: 20px;
      margin-bottom: 5px;
    }
    
    .report-title .date-range {
      color: #7f8c8d;
      font-size: 14px;
      margin-top: 5px;
    }
    
    .report-date {
      text-align: right;
      margin-bottom: 10px;
      color: #7f8c8d;
      font-size: 14px;
    }
    
    /* Table Styles */
    .report-table-container {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      overflow: auto;
      margin-bottom: 20px;
      border: 2px solid #3498db;
    }
    
    .report-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }
    
    .report-table th {
      background-color: #3498db;
      color: white;
      font-weight: 600;
      padding: 6px 8px;
      text-align: left;
      border: 1px solid #2980b9;
      white-space: nowrap;
    }
    
    .report-table td {
      padding: 6px 8px;
      border: 1px solid #e0e0e0;
      white-space: nowrap;
    }
    
    .report-table tbody tr:hover {
      background-color: #f5f9fc;
    }
    
    .tabledataright {
      text-align: right;
    }
    
    .tabledataleft {
      text-align: left;
    }
    
    .tabledatacenter {
      text-align: center;
    }
    
    /* Summary Row */
    .summary-row {
      background-color: #f8f9fa !important;
      font-weight: 600;
    }
    
    .summary-row td {
      border-top: 2px solid #2c3e50;
      border-bottom: 2px solid #2c3e50;
    }
    
    /* Button Styles */
    .action-buttons {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 10px 20px;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s;
      text-decoration: none;
      min-width: 140px;
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .btn i {
      margin-right: 8px;
    }
    
    .btn-print {
      background-color: #2ecc71;
    }
    
    .btn-print:hover {
      background-color: #27ae60;
    }
    
    .btn-excel {
      background-color: #217346;
    }
    
    .btn-excel:hover {
      background-color: #1a5c38;
    }
    
    .btn-pdf {
      background-color: #e74c3c;
    }
    
    .btn-pdf:hover {
      background-color: #c0392b;
    }
    
    .btn-back {
      background-color: #95a5a6;
    }
    
    .btn-back:hover {
      background-color: #7f8c8d;
    }
    
    /* Print-specific styles */
    @media print {
      @page {
        size: A4 landscape;
        /* margin: 0.5cm; */
        margin: 0.5cm;
      }
      
      body {
        padding: 0 !important;
        margin: 0 !important;
        background: white !important;
        font-size: 10pt !important;
        width: 100% !important;
        overflow: visible !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      
      .action-buttons,
      .powered-by {
        display: none !important;
      }
      
      .company-header {
        border-bottom: 2pt solid #000 !important;
        margin-bottom: 10pt !important;
        padding-bottom: 10pt !important;
        page-break-after: avoid !important;
      }
      
      .company-header h3 {
        font-size: 16pt !important;
        margin-bottom: 3pt !important;
      }
      
      .company-header p {
        font-size: 10pt !important;
        margin-top: 1pt !important;
        line-height: 1.2 !important;
      }
      
      .report-date {
        font-size: 10pt !important;
        margin-bottom: 5pt !important;
      }
      
      .report-title {
        background: none !important;
        border: 1pt solid #000 !important;
        margin-bottom: 10pt !important;
        padding: 10pt !important;
        page-break-after: avoid !important;
      }
      
      .report-title h2 {
        font-size: 14pt !important;
        margin-bottom: 3pt !important;
      }
      
      .report-title .date-range {
        font-size: 10pt !important;
      }
      
      .report-table-container {
        box-shadow: none !important;
        border: 2pt solid #000 !important;
        page-break-inside: avoid !important;
        overflow: visible !important;
        width: 100% !important;
        margin: 0 !important;
        display: block !important;
      }
      
      .report-table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 9pt !important;
        table-layout: fixed !important;
        word-wrap: break-word !important;
      }
      
      .report-table th {
        background-color: #ddd !important;
        color: #000 !important;
        border: 1pt solid #000 !important;
        font-weight: bold !important;
        padding: 4pt 5pt !important;
        font-size: 9pt !important;
        page-break-inside: avoid !important;
      }
      
      .report-table td {
        border: 1pt solid #000 !important;
        padding: 4pt 5pt !important;
        font-size: 9pt !important;
        page-break-inside: avoid !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
      }
      
      .summary-row td {
        border-top: 2pt solid #000 !important;
        border-bottom: 2pt solid #000 !important;
        background-color: #f0f0f0 !important;
      }
      
      /* Force table to fit on page */
      .report-table th:nth-child(1),
      .report-table td:nth-child(1) { width: 4% !important; }
      .report-table th:nth-child(2),
      .report-table td:nth-child(2) { width: 7% !important; }
      .report-table th:nth-child(3),
      .report-table td:nth-child(3) { width: 6% !important; }
      .report-table th:nth-child(4),
      .report-table td:nth-child(4) { width: 7% !important; }
      .report-table th:nth-child(5),
      .report-table td:nth-child(5) { width: 15% !important; }
      .report-table th:nth-child(6),
      .report-table td:nth-child(6) { width: 5% !important; }
      .report-table th:nth-child(7),
      .report-table td:nth-child(7) { width: 5% !important; }
      .report-table th:nth-child(8),
      .report-table td:nth-child(8) { width: 7% !important; }
      .report-table th:nth-child(9),
      .report-table td:nth-child(9) { width: 5% !important; }
      .report-table th:nth-child(10),
      .report-table td:nth-child(10) { width: 5% !important; }
      .report-table th:nth-child(11),
      .report-table td:nth-child(11) { width: 7% !important; }
      .report-table th:nth-child(12),
      .report-table td:nth-child(12) { width: 18% !important; }
      .report-table th:nth-child(13),
      .report-table td:nth-child(13) { width: 9% !important; }
      
      tr {
        page-break-inside: avoid !important;
        page-break-after: auto !important;
      }
      
      .tabledataright,
      .tabledataleft,
      .tabledatacenter {
        font-size: 9pt !important;
      }
      
      .empty-state {
        text-align: center;
        padding: 20pt;
        color: #000 !important;
        font-weight: bold;
      }
    }
    
    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 30px;
      color: #e74c3c;
      font-weight: 500;
    }
    
    /* Responsive Design */
    @media screen and (max-width: 768px) {
      .report-table-container {
        overflow-x: auto;
      }
      
      .report-table {
        min-width: 1200px;
      }
      
      .action-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .btn {
        width: 90%;
        max-width: 300px;
      }
    }
    
    /* Powerd By Section */
    .powered-by {
      text-align: center;
      margin-top: 30px;
      color: #7f8c8d;
      font-size: 12px;
      padding-top: 10px;
      border-top: 1px solid #eee;
    }
    
    /* Loading overlay for PDF/Excel generation */
    .loading-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 9999;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 18px;
      flex-direction: column;
    }
    
    .loading-spinner {
      border: 5px solid #f3f3f3;
      border-top: 5px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-bottom: 15px;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- SheetJS for Excel export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <!-- jsPDF for PDF export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <!-- jsPDF AutoTable plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
  <!-- Loading Overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div id="loadingText">Generating Document...</div>
  </div>

  <!-- Company Header -->
  <div class="company-header">
    <h3><u><b id="systemTitle">{{ session()->get('company_name') }}</b></u></h3>
    <p id="systemTitle">{{ session()->get('company_address') }}</p>
    <!-- <p id="systemTitle">PH: {{ session()->get('company_phone') }}</p>
    <p id="systemTitle">Email: {{ session()->get('company_email') }}</p> -->
  </div>
  
  <!-- Report Date -->
  <div class="report-date" id="systemDetail">
    @php
      $t = time();
      echo date('d/m/Y', $t);
    @endphp
  </div>
  
  <!-- Report Title -->
  <div class="report-title">
    <h2>ALL PARTIES PURCHASE TAX REPORT (DETAIL)</h2>
    <p class="date-range">FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}</p>
  </div>
  
  <!-- Report Table -->
  <div class="report-table-container" id="reportTable">
    <table class="report-table" id="dataTable">
      <thead>
        <tr>
          <th>Sr.</th>
          <th>DATE</th>
          <th>VR#</th>
          <th>INV#</th>
          <th>Product Description</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>Ex.Value</th>
          <th>Tax</th>
          <th>F.Tax</th>
          <th>Inc.Value</th>
          <th>Party Name</th>
          <th>NTN</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sum = 1; 
        $rate = 0;
        $quantity = 0;
        $ValExcST = 0;
        $FurtherTax = 0;
        $STValue = 0;
        $total = 0; 
        ?>
        
        @if (isset($sales))
          @if (count($sales) > 0)
            @foreach ($sales as $sale)
              @foreach ($sale->purchasetax_details as $products)
                <tr>
                  <td class="tabledatacenter">{{ $sum }}</td>
                  <td class="tabledatacenter">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                  <td class="tabledatacenter">{{ $sale->invoice_no }}</td>
                  <td class="tabledatacenter">{{ $sale->invoice_no1 }}</td>
                  <td class="tabledataleft">{{ $products->products->product_name }}</td>
                  <td class="tabledataright">{{ number_format($products->quantity, 2) }}</td>
                  <td class="tabledataright">{{ number_format($products->rate, 2) }}</td>
                  <td class="tabledataright">{{ number_format($products->price, 2) }}</td>
                  <td class="tabledataright">{{ number_format($products->taxvalue, 2) }}</td>
                  <td class="tabledataright">{{ number_format($products->extraTaxValue, 2) }}</td>
                  <td class="tabledataright">{{ number_format($products->total, 2) }}</td>
                  <td class="tabledataleft">
                    @if ($sale->parties != null)
                      {{ $sale->parties->party_name }}
                    @endif
                  </td>
                  <td class="tabledatacenter">
                    @if ($sale->parties != null)
                      {{ $sale->parties->ntn }}
                    @endif
                  </td>
                  
                  <?php
                  $rate = $rate + $products->rate;
                  $quantity = $quantity + $products->quantity;
                  $ValExcST = $ValExcST + $products->price;
                  $FurtherTax += $products->extraTaxValue;
                  $STValue += $products->taxvalue;
                  $total = $total + $products->total;
                  $sum += 1;
                  ?>
                </tr>
              @endforeach
            @endforeach
            
            <!-- Summary Row -->
            <tr class="summary-row">
              <td colspan="5" style="text-align: center;"><b>TOTAL</b></td>
              <td class="tabledataright"><b>{{ number_format($quantity, 2) }}</b></td>
              <td class="tabledataright"></td>
              <td class="tabledataright"><b>{{ number_format($ValExcST, 2) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($STValue, 2) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($FurtherTax, 2) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($total, 2) }}</b></td>
              <td class="tabledatacenter"></td>
              <td class="tabledatacenter"></td>
            </tr>
          @else
            <tr>
              <td colspan="13" class="empty-state">No Sales found</td>
            </tr>
          @endif
        @else
          <tr>
            <td colspan="13" class="empty-state">No Sales data available</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  
  <!-- Action Buttons -->
  <div class="action-buttons">
    <button class="btn btn-back" onclick="goBack()">
      <i class="fa fa-arrow-left"></i> Go Back
    </button>
    <button class="btn btn-excel" onclick="exportToExcel()">
      <i class="fa fa-file-excel-o"></i> Download Excel
    </button>
    <!-- <button class="btn btn-pdf" onclick="generatePDF()">
      <i class="fa fa-file-pdf-o"></i> Download PDF
    </button> -->
    <button class="btn btn-print" onclick="printReport()">
      <i class="fa fa-print"></i> Print Report
    </button>
  </div>
  
  <!-- Powered By Section -->
  <div class="powered-by" id="poweredBySection">
    @include('include.powerdby3')
  </div>

  <script>
    // Go Back Function
    function goBack() {
      window.history.back();
    }
    
    // Print Function
    function printReport() {
      window.print();
    }
    
    // Show loading overlay
    function showLoading(message = 'Generating Document...') {
      document.getElementById('loadingText').textContent = message;
      document.getElementById('loadingOverlay').style.display = 'flex';
    }
    
    // Hide loading overlay
    function hideLoading() {
      document.getElementById('loadingOverlay').style.display = 'none';
    }
    
    // Export to Excel Function
    function exportToExcel() {
      showLoading('Generating Excel File...');
      
      try {
        // Get table element
        const table = document.getElementById('dataTable');
        
        // Clone the table to avoid modifying the original
        const tableClone = table.cloneNode(true);
        
        // Remove the empty state rows if they exist
        const emptyRows = tableClone.querySelectorAll('.empty-state');
        emptyRows.forEach(row => {
          const parent = row.parentNode;
          if (parent && parent.parentNode) {
            parent.parentNode.removeChild(parent);
          }
        });
        
        // Create a workbook
        const wb = XLSX.utils.book_new();
        
        // Convert table to worksheet
        const ws = XLSX.utils.table_to_sheet(tableClone);
        
        // Set column widths
        const wscols = [
          {wch: 5},   // Sr.
          {wch: 12},  // DATE
          {wch: 10},  // VR#
          {wch: 12},  // INV#
          {wch: 30},  // Product Description
          {wch: 10},  // Qty
          {wch: 10},  // Rate
          {wch: 12},  // Ex.Value
          {wch: 10},  // Tax
          {wch: 10},  // F.Tax
          {wch: 12},  // Inc.Value
          {wch: 30},  // Party Name
          {wch: 15}   // NTN
        ];
        ws['!cols'] = wscols;
        
        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'PurchaseTaxReport');
        
        // Generate filename with date
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Report_${dateStr}.xlsx`;
        
        // Save the file
        XLSX.writeFile(wb, fileName);
        
        hideLoading();
      } catch (error) {
        console.error('Error generating Excel:', error);
        hideLoading();
        alert('Error generating Excel file. Please try again.');
      }
    }
    
    // Generate Text-based PDF with selectable text
    function generatePDF() {
      showLoading('Generating PDF...');
      
      try {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('l', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth(); // 297mm for A4 landscape
        // Set metadata
        pdf.setProperties({
          title: 'Purchase Tax Report - All Parties (Detail)',
          subject: 'Tax Report',
          author: '{{ session()->get("company_name") }}',
          keywords: 'tax, purchase, report, detail',
          creator: 'System'
        });
        
        // Calculate today's date
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-GB');
        
        // Add header
        let yPos = 15;
        pdf.setFontSize(16);
        pdf.setFont("helvetica", "bold");
        pdf.text('{{ session()->get("company_name") }}', 10, yPos);
        
        yPos += 7;
        pdf.setFontSize(10);
        pdf.setFont("helvetica", "normal");
        pdf.text('{{ session()->get("company_address") }}', 10, yPos);
        
        // Add report date on the right
        pdf.setFontSize(10);
        pdf.text(`Report Date: ${formattedDate}`, 270, 15, { align: 'right' });
        
        // Add report title
        yPos += 10;
        pdf.setFontSize(14);
        pdf.setFont("helvetica", "bold");
        pdf.text('ALL PARTIES PURCHASE TAX REPORT (DETAIL)', 10, yPos);
        
        yPos += 7;
        pdf.setFontSize(10);
        pdf.setFont("helvetica", "normal");
        pdf.text(`FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}`, 10, yPos);
        
        // Prepare table data
        const tableData = [];
        
        <?php
        $tempSum = 1;
        $tempRate = 0;
        $tempQuantity = 0;
        $tempValExcST = 0;
        $tempFurtherTax = 0;
        $tempSTValue = 0;
        $tempTotal = 0;
        ?>
        
        @if (isset($sales) && count($sales) > 0)
          @foreach ($sales as $sale)
            @foreach ($sale->purchasetax_details as $products)
              tableData.push([
                '{{ $tempSum }}',
                '{{ date("d/m/Y", strtotime($sale->date)) }}',
                '{{ $sale->invoice_no }}',
                '{{ $sale->invoice_no1 }}',
                '{{ $products->products->product_name }}',
                '{{ number_format($products->quantity, 2) }}',
                '{{ number_format($products->rate, 2) }}',
                '{{ number_format($products->price, 2) }}',
                '{{ number_format($products->taxvalue, 2) }}',
                '{{ number_format($products->extraTaxValue, 2) }}',
                '{{ number_format($products->total, 2) }}',
                '{{ $sale->parties != null ? $sale->parties->party_name : "" }}',
                '{{ $sale->parties != null ? $sale->parties->ntn : "" }}'
              ]);
              
              <?php
              $tempRate = $tempRate + $products->rate;
              $tempQuantity = $tempQuantity + $products->quantity;
              $tempValExcST = $tempValExcST + $products->price;
              $tempFurtherTax += $products->extraTaxValue;
              $tempSTValue += $products->taxvalue;
              $tempTotal = $tempTotal + $products->total;
              $tempSum += 1;
              ?>
            @endforeach
          @endforeach
          
          // Add total row
          tableData.push([
            '',
            '',
            '',
            '',
            'TOTAL',
            '{{ number_format($tempQuantity, 2) }}',
            '',
            '{{ number_format($tempValExcST, 2) }}',
            '{{ number_format($tempSTValue, 2) }}',
            '{{ number_format($tempFurtherTax, 2) }}',
            '{{ number_format($tempTotal, 2) }}',
            '',
            ''
          ]);
        @endif
        
        // Define table headers
        const headers = [
          ['Sr.', 'DATE', 'VR#', 'INV#', 'Product Description', 'Qty', 'Rate', 'Ex.Value', 'Tax', 'F.Tax', 'Inc.Value', 'Party Name', 'NTN']
        ];
        
        // Generate the table
        pdf.autoTable({
          head: headers,
          tableWidth: '15000px !important',
          body: tableData,
          startY: yPos + 5,
          theme: 'grid',
          headStyles: {
            fillColor: [52, 152, 219],
            textColor: 255,
            fontStyle: 'bold',
            fontSize: 8
          },
          bodyStyles: {
            fontSize: 7,
            cellPadding: 2
          },
          columnStyles: {
            0: { cellWidth: 8, halign: 'center' },   // Sr.
            1: { cellWidth: 15, halign: 'center' },  // DATE
            2: { cellWidth: 12, halign: 'center' },  // VR#
            3: { cellWidth: 15, halign: 'center' },  // INV#
            4: { cellWidth: 30, halign: 'left' },    // Product Description
            5: { cellWidth: 12, halign: 'right' },   // Qty
            6: { cellWidth: 12, halign: 'right' },   // Rate
            7: { cellWidth: 15, halign: 'right' },   // Ex.Value
            8: { cellWidth: 12, halign: 'right' },   // Tax
            9: { cellWidth: 12, halign: 'right' },   // F.Tax
            10: { cellWidth: 15, halign: 'right' },  // Inc.Value
            11: { cellWidth: 30, halign: 'left' },   // Party Name
            12: { cellWidth: 15, halign: 'center' }  // NTN
          },
          margin: { left: 10, right: 10 },
          styles: {
            overflow: 'linebreak',
            
            cellWidth: 'wrap'
          },
          didDrawPage: function(data) {
            // Add page number
            const pageCount = pdf.internal.getNumberOfPages();
            pdf.setFontSize(8);
            pdf.setTextColor(128, 128, 128);
            pdf.text(
              `Page ${data.pageNumber} of ${pageCount}`,
              data.settings.margin.left,
              pdf.internal.pageSize.height - 10
            );
            
            // Add generated date
            pdf.text(
              `Generated: ${formattedDate}`,
              pdf.internal.pageSize.width - data.settings.margin.right,
              pdf.internal.pageSize.height - 10,
              { align: 'right' }
            );
          }
        });
        
        // Add footer note
        const finalY = pdf.lastAutoTable.finalY || yPos + 20;
        pdf.setFontSize(8);
        pdf.setTextColor(100, 100, 100);
        pdf.text('This is a computer generated report.', 10, finalY + 10);
        
        // Generate filename
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Report_Detail_${dateStr}.pdf`;
        
        // Save the PDF
        pdf.save(fileName);
        
        hideLoading();
      } catch (error) {
        console.error('Error generating PDF:', error);
        hideLoading();
        alert('Error generating PDF. Please try again or use the Print function.');
      }
    }
    
    // Print optimization
    document.addEventListener('DOMContentLoaded', function() {
      window.addEventListener('beforeprint', function() {
        document.body.style.overflow = 'visible';
        document.querySelector('.report-table-container').style.overflow = 'visible';
      });
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      // Ctrl+P for print
      if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printReport();
      }
      // Ctrl+E for Excel
      if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
      }
      // Ctrl+D for PDF
      if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        generatePDF();
      }
      // Escape to go back
      if (e.key === 'Escape') {
        goBack();
      }
    });
  </script>
</body>
</html>