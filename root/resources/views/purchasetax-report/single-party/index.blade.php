<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Tax Register - Party Report</title>
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
    .report-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #3498db;
    }
    
    .company-info h1 {
      font-size: 24px;
      color: #2c3e50;
      margin-bottom: 5px;
    }
    
    .company-info p {
      color: #7f8c8d;
      font-size: 14px;
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
    }
    
    .party-info {
      background-color: #e8f4fc;
      padding: 10px 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      border-left: 4px solid #3498db;
    }
    
    .party-info strong {
      color: #2c3e50;
    }
    
    /* Table Styles */
    .report-table-container {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      margin-bottom: 20px;
      border: 2px solid #3498db;
    }
    
    .report-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .report-table th {
      background-color: #3498db;
      color: white;
      font-weight: 600;
      padding: 8px 10px;
      text-align: left;
      font-size: 14px;
      border: 1px solid #2980b9;
    }
    
    .report-table td {
      padding: 8px 10px;
      border: 1px solid #e0e0e0;
      font-size: 14px;
    }
    
    .report-table tbody tr:hover {
      background-color: #f5f9fc;
    }
    
    .report-table tbody tr:last-child td {
      border-bottom: 1px solid #e0e0e0;
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
      .powered-by {
        display: none !important;
      }
      
      .report-header {
        border-bottom: 2pt solid #000 !important;
        margin-bottom: 15pt !important;
      }
      
      .report-title {
        background: none !important;
        border: 1pt solid #000 !important;
        margin-bottom: 15pt !important;
      }
      
      .party-info {
        background: none !important;
        border-left: 4pt solid #000 !important;
      }
      
      .report-table-container {
        box-shadow: none !important;
        border: 2pt solid #000 !important;
        page-break-inside: avoid !important;
      }
      
      .report-table th {
        background-color: #ddd !important;
        color: #000 !important;
        border: 1pt solid #000 !important;
        font-weight: bold !important;
      }
      
      .report-table td {
        border: 1pt solid #000 !important;
      }
      
      .summary-row td {
        border-top: 2pt solid #000 !important;
        border-bottom: 2pt solid #000 !important;
      }
      
      .report-table {
        border-collapse: collapse;
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
    @media (max-width: 768px) {
      .report-header {
        flex-direction: column;
        text-align: center;
      }
      
      .company-info {
        margin-bottom: 15px;
      }
      
      .report-table-container {
        overflow-x: auto;
      }
      
      .report-table {
        min-width: 900px;
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
    
    /* Loading overlay */
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
  @include('header.report')
  
  <!-- Report Title -->
  <div class="report-title">
    <h2>PURCHASE TAX REGISTER - PARTY REPORT</h2>
    <p class="date-range">FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}</p>
  </div>
  
  <!-- Party Information -->
  <div class="party-info">
    <strong>Party Name:</strong> {{ $party[0]->party_name }}
  </div>
  
  <!-- Report Table -->
  <div class="report-table-container">
    <table class="report-table" id="dataTable">
      <thead>
        <tr>
          <th>Sr.</th>
          <th>DATE</th>
          <th>VR#</th>
          <th>INV#</th>
          <th>Qty</th>
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
                  <td style="text-align: center;">{{ $sum }}</td>
                  <td style="text-align: center;">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                  <td style="text-align: center;">{{ $sale->invoice_no }}</td>
                  <td style="text-align: center;">{{ $sale->invoice_no1 }}</td>
                  <td style="text-align: right;">{{ number_format($products->quantity, 2) }}</td>
                  <td style="text-align: right;">{{ number_format($products->price, 2) }}</td>
                  <td style="text-align: right;">{{ number_format($products->taxvalue, 2) }}</td>
                  <td style="text-align: right;">{{ number_format($products->extraTaxValue, 2) }}</td>
                  <td style="text-align: right;">{{ number_format($products->total, 2) }}</td>
                  <td style="text-align: left;">
                    @if ($sale->parties != null)
                      {{ $sale->parties->party_name }}
                    @endif
                  </td>
                  <td style="text-align: center;">
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
              <td colspan="4" style="text-align: center;"><b>TOTAL</b></td>
              <td style="text-align: right;"><b>{{ number_format($quantity) }}</b></td>
              <td style="text-align: right;"><b>{{ number_format($ValExcST) }}</b></td>
              <td style="text-align: right;"><b>{{ number_format($STValue) }}</b></td>
              <td style="text-align: right;"><b>{{ number_format($FurtherTax) }}</b></td>
              <td style="text-align: right;"><b>{{ number_format($total) }}</b></td>
              <td style="text-align: center;"></td>
              <td style="text-align: center;"></td>
            </tr>
          @else
            <tr>
              <td colspan="11" class="empty-state">No Sales found</td>
            </tr>
          @endif
        @else
          <tr>
            <td colspan="11" class="empty-state">No Sales data available</td>
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
  <div class="powered-by">
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
        
        // Set column widths
        const wscols = [
          {wch: 5},   // Sr.
          {wch: 12},  // DATE
          {wch: 8},   // VR#
          {wch: 12},  // INV#
          {wch: 10},  // Qty
          {wch: 12},  // Ex.Value
          {wch: 10},  // Tax
          {wch: 10},  // F.Tax
          {wch: 12},  // Inc.Value
          {wch: 30},  // Party Name
          {wch: 15}   // NTN
        ];
        ws['!cols'] = wscols;
        
        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'PurchaseTaxRegister');
        
        // Generate filename with date
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Register_${dateStr}.xlsx`;
        
        // Save the file
        XLSX.writeFile(wb, fileName);
        
        hideLoading();
      } catch (error) {
        console.error('Error generating Excel:', error);
        hideLoading();
        alert('Error generating Excel file. Please try again.');
      }
    }
    
    // Generate Text-based PDF
    function generatePDF() {
      showLoading('Generating PDF...');
      
      try {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('l', 'mm', 'a4');
        
        // Set metadata
        pdf.setProperties({
          title: 'Purchase Tax Register - Party Report',
          subject: 'Tax Report',
          author: 'System',
          keywords: 'tax, purchase, register, party',
          creator: 'System'
        });
        
        // Calculate today's date
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-GB');
        
        // Add header from included header
        let yPos = 15;
        pdf.setFontSize(16);
        pdf.setFont("helvetica", "bold");
        pdf.text('Purchase Tax Register - Party Report', 10, yPos);
        
        yPos += 7;
        pdf.setFontSize(10);
        pdf.setFont("helvetica", "normal");
        pdf.text(`FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}`, 10, yPos);
        
        // Add party information
        yPos += 7;
        pdf.setFont("helvetica", "bold");
        pdf.text('Party Name:', 10, yPos);
        pdf.setFont("helvetica", "normal");
        pdf.text('{{ $party[0]->party_name }}', 35, yPos);
        
        // Add report date on the right
        pdf.setFontSize(10);
        pdf.text(`Report Date: ${formattedDate}`, 270, 15, { align: 'right' });
        
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
                '{{ number_format($products->quantity, 2) }}',
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
            'TOTAL',
            '{{ number_format($tempQuantity, 2) }}',
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
          ['Sr.', 'DATE', 'VR#', 'INV#', 'Qty', 'Ex.Value', 'Tax', 'F.Tax', 'Inc.Value', 'Party Name', 'NTN']
        ];
        
        // Generate the table
        pdf.autoTable({
          head: headers,
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
            2: { cellWidth: 10, halign: 'center' },  // VR#
            3: { cellWidth: 15, halign: 'center' },  // INV#
            4: { cellWidth: 12, halign: 'right' },   // Qty
            5: { cellWidth: 15, halign: 'right' },   // Ex.Value
            6: { cellWidth: 12, halign: 'right' },   // Tax
            7: { cellWidth: 12, halign: 'right' },   // F.Tax
            8: { cellWidth: 15, halign: 'right' },   // Inc.Value
            9: { cellWidth: 30, halign: 'left' },    // Party Name
            10: { cellWidth: 15, halign: 'center' }  // NTN
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
          }
        });
        
        // Generate filename
        const dateStr = new Date().toISOString().split('T')[0];
        const fileName = `Purchase_Tax_Register_${dateStr}.pdf`;
        
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