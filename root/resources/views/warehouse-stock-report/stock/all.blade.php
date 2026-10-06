<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Report - All Items</title>
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
    
    .item-name {
      font-weight: 600;
      color: #2c3e50;
      margin-top: 5px;
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
      padding: 3px 6px;
      text-align: left;
      font-size: 14px;
      border: 1px solid #2980b9;
    }
    
    .report-table td {
      padding: 3px 6px;
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
    }
    
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: background-color 0.3s;
      margin: 5px;
    }
    
    .btn:hover {
      background-color: #2980b9;
    }
    
    .btn-print {
      background-color: #2ecc71;
    }
    
    .btn-print:hover {
      background-color: #27ae60;
    }
    
    .btn-preview {
      background-color: #9b59b6;
    }
    
    .btn-preview:hover {
      background-color: #8e44ad;
    }
    
    /* Print Preview Modal */
    .print-preview-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      overflow: auto;
    }
    
    .print-preview-content {
      background-color: white;
      margin: 2% auto;
      width: 80%;
      max-width: 900px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      position: relative;
    }
    
    .preview-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #e0e0e0;
      background-color: #f8f9fa;
      border-radius: 8px 8px 0 0;
    }
    
    .preview-header h3 {
      color: #2c3e50;
    }
    
    .close-btn {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #7f8c8d;
    }
    
    .preview-body {
      padding: 20px;
    }
    
    /* Print-specific styles */
    @media print {
      body {
        padding: 0;
        background: white;
        font-size: 12pt;
      }
      
      .action-buttons, 
      .print-preview-modal {
        display: none !important;
      }
      
      .report-header {
        border-bottom: 2pt solid #000;
        margin-bottom: 15pt;
      }
      
      .report-title {
        background: none;
        border: 1pt solid #000;
        margin-bottom: 15pt;
      }
      
      .report-table-container {
        box-shadow: none;
        border: 2pt solid #000;
        page-break-inside: avoid;
      }
      
      .report-table th {
        background-color: #ddd !important;
        color: #000 !important;
        border: 1pt solid #000 !important;
        font-weight: bold;
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
        min-width: 700px;
      }
      
      .print-preview-content {
        width: 95%;
        margin: 5% auto;
      }
    }
  </style>
</head>
<body>
  <!-- Company Header -->
  @include("/header.report")
  
  <!-- Report Title -->
  <div class="report-title">
    <h2>STOCK REPORT - ALL ITEMS</h2>
    <p class="date-range">Period: {{date("d/m/Y", Strtotime($fromDate))}} to {{date("d/m/Y", Strtotime($toDate))}}</p>
  </div>
  
  <!-- Report Table -->
  <div class="report-table-container">
    <table class="report-table">
      <thead>
        <tr>
          <th>SR#</th>
          <th>Product Code</th>
          <th>Product Name</th>
          <th>Opening Stock</th>
          <th>Period IN</th>
          <th>Period OUT</th>
          <th>Closing Stock</th>
          <th>Rate</th>
          <th>Stock Value</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sum = 1; 
          $totalOpening = 0;
          $totalPeriodIn = 0;
          $totalPeriodOut = 0;
          $totalStockValue = 0; 
          $totalClosing = 0; 
        ?>
        
        @if(count($RawMaterial) > 0)
          @foreach($RawMaterial as $items)
            <tr>
              <td>{{$sum}}</td>
              <td>{{$items->product_code}}</td>
              <td>{{$items->product_name}}</td>
              @php 
                $opening = (float) ($items->opening_stock ?? 0);
                $periodIn = (float) ($items->stockin ?? 0);
                $periodOut = (float) ($items->stockout ?? 0);
                $closing = (float) ($items->current_stock ?? 0);
                $rate = (float)($items->avg_rate ?? 0);
                $stockValue = $closing * $rate;
              @endphp
              <td>{{number_format($opening, 2)}}</td>
              <td>{{number_format($periodIn, 2)}}</td>
              <td>{{number_format($periodOut, 2)}}</td>
              <td>{{number_format($closing, 2)}}</td>
              <td>{{number_format($rate, 2)}}</td>
              <td>{{number_format($stockValue, 2)}}</td>
            </tr>
            @php 
              $sum = $sum + 1;
              $totalOpening = $totalOpening + $opening;
              $totalPeriodIn = $totalPeriodIn + $periodIn;
              $totalPeriodOut = $totalPeriodOut + $periodOut;
              $totalClosing = $totalClosing + $closing;
              $totalStockValue = $totalStockValue + $stockValue;
            @endphp
          @endforeach
          
          <!-- Summary Row -->
          <tr class="summary-row">
            <td colspan="3" style="text-align: right;">TOTAL:</td>
            <td>{{number_format($totalOpening, 2)}}</td>
            <td>{{number_format($totalPeriodIn, 2)}}</td>
            <td>{{number_format($totalPeriodOut, 2)}}</td>
            <td>{{number_format($totalClosing, 2)}}</td>
            <td></td>
            <td>{{number_format($totalStockValue, 2)}}</td>
          </tr>
        @else
          <tr>
            <td colspan="9" class="empty-state">No records found for the selected period</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  
  <!-- Action Buttons -->
  <div class="action-buttons">
    <button class="btn" onclick="goBack()">Go Back</button>
    <!-- <button class="btn btn-preview" onclick="openPrintPreview()">Print Preview</button> -->
    <button class="btn btn-print" onclick="window.print()">Print Report</button>
  </div>

  <!-- Print Preview Modal -->
 

  <script>
    function goBack() {
      window.history.back();
    }
    
    // function openPrintPreview() {
    //   document.getElementById('printPreview').style.display = 'block';
    // }
    
    // function closePrintPreview() {
    //   document.getElementById('printPreview').style.display = 'none';
    // }
    
    // Close modal when clicking outside the content
    // window.onclick = function(event) {
    //   const modal = document.getElementById('printPreview');
    //   if (event.target === modal) {
    //     closePrintPreview();
    //   }
    // }
  </script>
</body>
</html>
