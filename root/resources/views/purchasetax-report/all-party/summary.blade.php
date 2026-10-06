<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Tax Report - All Parties (Summary)</title>
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
      padding: 8px 10px;
      text-align: left;
      border: 1px solid #2980b9;
      white-space: nowrap;
    }
    
    .report-table td {
      padding: 8px 10px;
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
      .powered-by,
      .loading-overlay {
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
        padding: 5pt 6pt !important;
        font-size: 9pt !important;
        page-break-inside: avoid !important;
      }
      
      .report-table td {
        border: 1pt solid #000 !important;
        padding: 5pt 6pt !important;
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
      
      /* Column widths for summary report */
      .report-table th:nth-child(1),
      .report-table td:nth-child(1) { width: 8% !important; }
      .report-table th:nth-child(2),
      .report-table td:nth-child(2) { width: 6% !important; }
      .report-table th:nth-child(3),
      .report-table td:nth-child(3) { width: 8% !important; }
      .report-table th:nth-child(4),
      .report-table td:nth-child(4) { width: 8% !important; }
      .report-table th:nth-child(5),
      .report-table td:nth-child(5) { width: 10% !important; }
      .report-table th:nth-child(6),
      .report-table td:nth-child(6) { width: 10% !important; }
      .report-table th:nth-child(7),
      .report-table td:nth-child(7) { width: 10% !important; }
      .report-table th:nth-child(8),
      .report-table td:nth-child(8) { width: 10% !important; }
      .report-table th:nth-child(9),
      .report-table td:nth-child(9) { width: 20% !important; }
      .report-table th:nth-child(10),
      .report-table td:nth-child(10) { width: 10% !important; }
      
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
        min-width: 1000px;
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
    
    /* Powered By Section */
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
    
    /* PDF Generation Styles */
    .pdf-template {
      width: 100%;
      background: white;
      padding: 20px;
    }
  </style>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- SheetJS for Excel export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <!-- jsPDF for PDF export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
    @if(session()->get('company_phone'))
    <p id="systemTitle">PH: {{ session()->get('company_phone') }}</p>
    @endif
    @if(session()->get('company_email'))
    <p id="systemTitle">Email: {{ session()->get('company_email') }}</p>
    @endif
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
    <h2>ALL PARTIES PURCHASE TAX REPORT (SUMMARY)</h2>
    <p class="date-range">FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}</p>
  </div>
  
  <!-- Report Table -->
  <div class="report-table-container" id="reportTable">
    <table class="report-table" id="dataTable">
      <thead>
        <tr>
          <th>Date</th>
          <th>Vr#</th>
          <th>Ivn#</th>
          <th>QTY</th>
          <th>Tax Value</th>
          <th>F.Tax</th>
          <th>Ex.Value</th>
          <th>En.Value</th>
          <th>Party Name</th>
          <th>NTN</th>
        </tr>
      </thead>
      <tbody>
        <?php $grand = 0;
        $grandValExcST = 0;
        $grandFurtherTax = 0;
        $grandSTValue = 0;
        $GrandWeight = 0; ?>
        
        @if (isset($sales))
          @if (count($sales) > 0)
            @foreach ($sales as $sale)
              <?php 
              $ValExcST = 0; 
              $FurtherTax = 0;
              $STValue = 0;
              $total = 0;
              $TotalWeight = 0; 
              ?>
              
              <tr>
                <td class="tabledatacenter">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                <td class="tabledatacenter">{{ $sale->invoice_no }}</td>
                <td class="tabledatacenter">{{ $sale->invoice_no1 }}</td>
                
                @foreach ($sale->purchasetax_details as $products)
                  <?php
                  $TotalWeight = $TotalWeight + $products->quantity;
                  $ValExcST = $ValExcST + $products->taxvalue;
                  $FurtherTax = $FurtherTax + $products->extraTaxValue;
                  $STValue = $STValue + $products->price;
                  $total = $total + $products->total;
                  ?>
                @endforeach
                
                <td class="tabledataright">{{ number_format($TotalWeight, 2) }}</td>
                <td class="tabledataright">{{ number_format($STValue, 2) }}</td>
                <td class="tabledataright">{{ number_format($FurtherTax, 2) }}</td>
                <td class="tabledataright">{{ number_format($ValExcST, 2) }}</td>
                <td class="tabledataright">{{ number_format($total, 2) }}</td>
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
                $GrandWeight = $GrandWeight + $TotalWeight;
                $grandValExcST = $grandValExcST + $ValExcST;
                $grandFurtherTax = $grandFurtherTax + $FurtherTax;
                $grandSTValue = $grandSTValue + $STValue;
                $grand = $grand + $total;
                ?>
              </tr>
            @endforeach
            
            <!-- Summary Row -->
            <tr class="summary-row">
              <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
              <td class="tabledataright"><b>{{ number_format($GrandWeight) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($grandSTValue) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($grandFurtherTax) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($grandValExcST) }}</b></td>
              <td class="tabledataright"><b>{{ number_format($grand) }}</b></td>
              <td class="tabledatacenter"></td>
              <td class="tabledatacenter"></td>
            </tr>
          @else
            <tr>
              <td colspan="10" class="empty-state">No Sales found</td>
            </tr>
          @endif
        @else
          <tr>
            <td colspan="10" class="empty-state">No Sales data available</td>
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
    @include('include.powerdby2')
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
        
        // Set column widths for summary report
        const wscols = [
          {wch: 12},  // Date
          {wch: 8},   // Vr#
          {wch: 10},  // Ivn#
          {wch: 10},  // QTY
          {wch: 12},  // Tax Value
          {wch: 10},  // F.Tax
          {wch: 12},  // Ex.Value
          {wch: 12},  // En.Value
          {wch: 30},  // Party Name
          {wch: 15}   // NTN
        ];
        ws['!cols'] = wscols;
        
        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'PurchaseTaxSummary');
        
        // Generate filename with date
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Summary_${dateStr}.xlsx`;
        
        // Save the file
        XLSX.writeFile(wb, fileName);
        
        hideLoading();
      } catch (error) {
        console.error('Error generating Excel:', error);
        hideLoading();
        alert('Error generating Excel file. Please try again.');
      }
    }
    
    // Export to PDF Function with multi-page support
    function generatePDF() {
      showLoading('Generating PDF...');
      
      // Create a custom PDF template that will capture all data
      const pdfTemplate = document.createElement('div');
      pdfTemplate.className = 'pdf-template';
      pdfTemplate.style.width = '1000px'; // Wider for landscape
      pdfTemplate.style.backgroundColor = 'white';
      pdfTemplate.style.padding = '20px';
      pdfTemplate.style.position = 'absolute';
      pdfTemplate.style.left = '-9999px';
      
      // Get all necessary elements
      const companyHeader = document.querySelector('.company-header');
      const reportDate = document.querySelector('.report-date');
      const reportTitle = document.querySelector('.report-title');
      const reportTable = document.querySelector('.report-table-container');
      
      // Clone elements
      const headerClone = companyHeader.cloneNode(true);
      const dateClone = reportDate.cloneNode(true);
      const titleClone = reportTitle.cloneNode(true);
      const tableClone = reportTable.cloneNode(true);
      
      // Add to template
      pdfTemplate.appendChild(headerClone);
      pdfTemplate.appendChild(dateClone);
      pdfTemplate.appendChild(titleClone);
      pdfTemplate.appendChild(tableClone);
      
      // Add to body temporarily
      document.body.appendChild(pdfTemplate);
      
      // Use html2canvas with better settings
      html2canvas(pdfTemplate, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff',
        windowWidth: 1000,
        onclone: function(clonedDoc) {
          // Ensure all content is visible in the clone
          const table = clonedDoc.querySelector('.report-table-container');
          if (table) {
            table.style.overflow = 'visible';
            table.style.height = 'auto';
          }
        }
      }).then(canvas => {
        // Remove template
        document.body.removeChild(pdfTemplate);
        
        // Calculate PDF dimensions
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('l', 'mm', 'a4');
        
        // PDF page dimensions
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        
        // Image dimensions
        const imgWidth = pageWidth - 20; // 10mm margins on each side
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        // Check if content fits on one page
        if (imgHeight <= pageHeight - 20) {
          // Single page
          pdf.addImage(canvas, 'PNG', 10, 10, imgWidth, imgHeight);
        } else {
          // Multi-page
          let heightLeft = imgHeight;
          let position = 10; // Start position
          let pageNumber = 1;
          
          // Add first page
          pdf.addImage(canvas, 'PNG', 10, position, imgWidth, imgHeight);
          heightLeft -= (pageHeight - 20);
          
          // Add additional pages if needed
          while (heightLeft > 0) {
            position = -((pageHeight - 20) * pageNumber) + 10;
            pdf.addPage();
            pdf.addImage(canvas, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= (pageHeight - 20);
            pageNumber++;
          }
        }
        
        // Add footer with page numbers
        const totalPages = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
          pdf.setPage(i);
          pdf.setFontSize(10);
          pdf.setTextColor(128, 128, 128);
          pdf.text(
            `Page ${i} of ${totalPages}`,
            pageWidth / 2,
            pageHeight - 10,
            { align: 'center' }
          );
          pdf.text(
            'Generated on: ' + new Date().toLocaleDateString(),
            pageWidth - 10,
            pageHeight - 10,
            { align: 'right' }
          );
        }
        
        // Generate filename
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Summary_${dateStr}.pdf`;
        
        // Save PDF
        pdf.save(fileName);
        
        hideLoading();
      }).catch(error => {
        console.error('Error generating PDF:', error);
        document.body.removeChild(pdfTemplate);
        hideLoading();
        
        // Fallback: Try simpler method
        tryFallbackPDF();
      });
    }
    
    // Fallback PDF method for very large reports
    function tryFallbackPDF() {
      showLoading('Generating PDF (alternative method)...');
      
      // Create PDF from scratch using jsPDF's table plugin
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('l', 'mm', 'a4');
      
      // Set font
      pdf.setFont("helvetica");
      
      // Add header
      pdf.setFontSize(16);
      pdf.setFont("helvetica", "bold");
      pdf.text("{{ session()->get('company_name') }}", 10, 15);
      
      pdf.setFontSize(10);
      pdf.setFont("helvetica", "normal");
      pdf.text("{{ session()->get('company_address') }}", 10, 22);
      
      if ("{{ session()->get('company_phone') }}") {
        pdf.text("PH: {{ session()->get('company_phone') }}", 10, 29);
      }
      
      if ("{{ session()->get('company_email') }}") {
        pdf.text("Email: {{ session()->get('company_email') }}", 10, 36);
      }
      
      // Report title
      pdf.setFontSize(14);
      pdf.setFont("helvetica", "bold");
      pdf.text("ALL PARTIES PURCHASE TAX REPORT (SUMMARY)", 10, 45);
      
      pdf.setFontSize(10);
      pdf.setFont("helvetica", "normal");
      pdf.text("FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}", 10, 52);
      pdf.text("Generated on: " + new Date().toLocaleDateString(), 270, 15, { align: 'right' });
      
      // Create table data
      const tableData = [];
      const tableHeaders = ['Date', 'Vr#', 'Ivn#', 'QTY', 'Tax Value', 'F.Tax', 'Ex.Value', 'En.Value', 'Party Name', 'NTN'];
      
      <?php if (isset($sales) && count($sales) > 0): ?>
        <?php foreach ($sales as $sale): ?>
          <?php 
          $ValExcST = 0; 
          $FurtherTax = 0;
          $STValue = 0;
          $total = 0;
          $TotalWeight = 0; 
          
          foreach ($sale->purchasetax_details as $products) {
            $TotalWeight = $TotalWeight + $products->quantity;
            $ValExcST = $ValExcST + $products->taxvalue;
            $FurtherTax = $FurtherTax + $products->extraTaxValue;
            $STValue = $STValue + $products->price;
            $total = $total + $products->total;
          }
          ?>
          
          tableData.push([
            "{{ date('d/m/Y', strtotime($sale->date)) }}",
            "{{ $sale->invoice_no }}",
            "{{ $sale->invoice_no1 }}",
            "{{ number_format($TotalWeight, 2) }}",
            "{{ number_format($STValue, 2) }}",
            "{{ number_format($FurtherTax, 2) }}",
            "{{ number_format($ValExcST, 2) }}",
            "{{ number_format($total, 2) }}",
            "{{ $sale->parties != null ? $sale->parties->party_name : '' }}",
            "{{ $sale->parties != null ? $sale->parties->ntn : '' }}"
          ]);
        <?php endforeach; ?>
        
        // Add total row
        tableData.push([
          'TOTAL',
          '',
          '',
          "{{ number_format($GrandWeight, 2) }}",
          "{{ number_format($grandSTValue, 2) }}",
          "{{ number_format($grandFurtherTax, 2) }}",
          "{{ number_format($grandValExcST, 2) }}",
          "{{ number_format($grand, 2) }}",
          '',
          ''
        ]);
      <?php endif; ?>
      
      // Generate table
      pdf.autoTable({
        head: [tableHeaders],
        body: tableData,
        startY: 60,
        theme: 'grid',
        headStyles: { fillColor: [52, 152, 219], textColor: 255, fontStyle: 'bold' },
        columnStyles: {
          0: { cellWidth: 20 },
          1: { cellWidth: 15 },
          2: { cellWidth: 18 },
          3: { cellWidth: 15, halign: 'right' },
          4: { cellWidth: 20, halign: 'right' },
          5: { cellWidth: 15, halign: 'right' },
          6: { cellWidth: 20, halign: 'right' },
          7: { cellWidth: 20, halign: 'right' },
          8: { cellWidth: 40 },
          9: { cellWidth: 25 }
        },
        margin: { top: 60 }
      });
      
      // Save PDF
      const dateStr = new Date().toISOString().split('T')[0];
      const fileName = `Purchase_Tax_Summary_${dateStr}.pdf`;
      pdf.save(fileName);
      
      hideLoading();
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