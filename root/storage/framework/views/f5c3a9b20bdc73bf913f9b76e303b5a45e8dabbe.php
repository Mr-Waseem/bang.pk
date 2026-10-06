<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tax Invoice</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f0f0;
            color: #000;
            font-size: 12px;
            line-height: 1.45;
        }

        .page-wrapper {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 28px 36px 24px 36px;
            box-shadow: 0 0 12px rgba(0,0,0,0.12);
        }

        .print-controls {
            margin-bottom: 12px;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .print-controls button {
            background: #333; color: #fff; border: none;
            padding: 6px 14px; cursor: pointer; font-size: 12px;
            border-radius: 3px;
        }
        .print-controls button:hover { background: #555; }
        .print-controls a {
            background: #c0392b; color: #fff;
            padding: 6px 14px; font-size: 12px;
            border-radius: 3px; text-decoration: none;
        }
        .print-controls a:hover { background: #a93226; color: #fff; }

        /* Top-right seller block */
        .seller-block {
            text-align: right;
            margin-bottom: 18px;
        }
        .seller-block .seller-name {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 4px;
        }
        .seller-block .seller-address {
            font-size: 12px;
            line-height: 1.4;
            max-width: 420px;
            margin-left: auto;
        }
        .seller-block .seller-ntn {
            font-size: 12px;
            margin-top: 2px;
        }

        /* Center FBR + QR */
        .digital-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 8px 0 22px 0;
        }
        .digital-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        .fbr-logo {
            height: 72px;
            width: auto;
            object-fit: contain;
        }
        .qr-box {
            width: 78px;
            height: 78px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qr-box img {
            width: 78px;
            height: 78px;
        }
        .digital-invoice-no {
            margin-top: 8px;
            font-size: 12px;
            text-align: center;
            letter-spacing: 0.2px;
        }

        /* Buyer left / meta right */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            margin-bottom: 18px;
        }
        .buyer-col {
            flex: 1 1 60%;
            min-width: 0;
        }
        .buyer-col .inv-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .buyer-col .buyer-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .buyer-col .buyer-address,
        .buyer-col .buyer-ntn {
            font-size: 12px;
            line-height: 1.45;
        }
        .meta-col {
            flex: 0 0 34%;
            text-align: left;
            font-size: 12px;
            line-height: 1.7;
            padding-top: 2px;
        }
        .meta-col .meta-line {
            white-space: nowrap;
        }
        .meta-col .meta-label {
            display: inline-block;
            min-width: 88px;
        }

        /* Items table */
        .items-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 8px;
        }
        .items-table thead tr th {
            border: 1px solid #000;
            background: #e8e8e8;
            padding: 3px 2px;
            text-align: center;
            font-weight: 700;
            font-size: 10px;
            vertical-align: middle;
            line-height: 1.2;
            word-wrap: break-word;
        }
        .items-table tbody tr td {
            border: 1px solid #000;
            padding: 3px 2px;
            vertical-align: middle;
            font-size: 10px;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }
        .td-center { text-align: center; }
        .td-right { text-align: right; white-space: nowrap; }
        .td-left { text-align: left; }

        /* Totals */
        .totals-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            margin-bottom: 40px;
        }
        .totals-block {
            width: 260px;
            font-size: 12px;
        }
        .totals-block .tot-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            line-height: 1.5;
        }
        .totals-block .tot-row .tot-label {
            text-align: left;
        }
        .totals-block .tot-row .tot-value {
            text-align: right;
            min-width: 110px;
        }
        .totals-block .tot-grand {
            margin-top: 4px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 5px 0;
            font-weight: 700;
            font-size: 13px;
        }

        .footer-note {
            text-align: center;
            font-size: 11px;
            color: #333;
            margin-top: 28px;
        }

        @media  print {
            @page  { size: A4; margin: 10mm; }
            body { background: white; }
            .page-wrapper {
                margin: 0;
                padding: 8px 10px;
                box-shadow: none;
                max-width: none;
            }
            .print-controls { display: none !important; }
        }

        /* DomPDF-friendly layout when generating PDF/email */
        body.is-pdf {
            background: #fff;
        }
        body.is-pdf .page-wrapper {
            margin: 0;
            padding: 8px 10px;
            box-shadow: none;
            max-width: none;
        }
        body.is-pdf .print-controls { display: none !important; }
        body.is-pdf .digital-row {
            display: block;
            text-align: center;
        }
        body.is-pdf .digital-row .fbr-logo,
        body.is-pdf .digital-row .qr-box {
            display: inline-block;
            vertical-align: middle;
            margin: 0 6px;
        }
        body.is-pdf .info-row {
            display: table;
            width: 100%;
        }
        body.is-pdf .buyer-col,
        body.is-pdf .meta-col {
            display: table-cell;
            vertical-align: top;
        }
        body.is-pdf .buyer-col { width: 60%; }
        body.is-pdf .meta-col { width: 40%; }
        body.is-pdf .totals-wrap {
            display: block;
            text-align: right;
        }
        body.is-pdf .totals-block {
            display: inline-block;
            text-align: left;
        }
    </style>
</head>
<body class="<?php echo e(!empty($isPdf) ? 'is-pdf' : ''); ?>">
<?php
    $sale = $newsale_detail[0];
    $party = $sale->parties ?? null;
    $invoiceDate = !empty($sale->date) ? date('d/m/Y', strtotime($sale->date)) : '';
    $fbrNo = $sale->fbr_invoice_no ?? null;
    $fbrLogoSrc = !empty($isPdf)
        ? \App\Services\InvoicePdfMailer::fileSrc('root/upload/logo/fbrlogo.jpg')
        : asset('root/upload/logo/fbrlogo.jpg');
?>

<div class="page-wrapper">
    <?php if(empty($isPdf)): ?>
    <div class="print-controls">
        <button type="button" onclick="window.print()">Print Invoice</button>
        <?php if(isset($id)): ?>
            <a href="<?php echo e(asset('salestax/' . $id . '/pdf')); ?>">Download PDF</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <div class="seller-block">
        <div class="seller-name"><?php echo e($sellerCompany->CompanyName); ?></div>
        <div class="seller-address"><?php echo e($sellerCompany->address ?? ''); ?></div>
        <div class="seller-ntn">NTN : <?php echo e($sellerCompany->ntn ?? ''); ?></div>
    </div>

    
    <?php if(!empty($fbrNo)): ?>
    <div class="digital-block">
        <div class="digital-row">
            <img class="fbr-logo" src="<?php echo e($fbrLogoSrc); ?>" alt="FBR Digital Invoicing System">
            <div class="qr-box">
                <?php if(!empty($sale->qr_code)): ?>
                    <img src="<?php echo e($sale->qr_code); ?>" alt="QR">
                <?php else: ?>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo e(urlencode($fbrNo)); ?>&amp;size=78x78" alt="QR">
                <?php endif; ?>
            </div>
        </div>
        <div class="digital-invoice-no">Digital Invoice #: <?php echo e($fbrNo); ?></div>
    </div>
    <?php endif; ?>

    
    <div class="info-row">
        <div class="buyer-col">
            <div class="inv-title">Sales Tax Invoice</div>
            <div class="buyer-name"><?php echo e($party->party_name ?? ''); ?></div>
            <div class="buyer-address"><?php echo e($party->address ?? ''); ?></div>
            <div class="buyer-ntn">NTN <?php echo e($party->ntn ?? ''); ?></div>
        </div>
        <div class="meta-col">
            <div class="meta-line"><span class="meta-label">Date:</span> <?php echo e($invoiceDate); ?></div>
            <div class="meta-line"><span class="meta-label">Due Date:</span> <?php echo e($invoiceDate); ?></div>
            <div class="meta-line"><span class="meta-label">Invoice No:</span> <?php echo e($sale->invoice_no); ?></div>
            <div class="meta-line"><span class="meta-label">Account No:</span> <?php echo e($party->code ?? ''); ?></div>
        </div>
    </div>

    
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:4%;">SrNo</th>
                <th style="width:9%;">HSCode</th>
                <th style="width:22%;">Product Name</th>
                <th style="width:7%;">Item ID</th>
                <th style="width:8%;">PO No</th>
                <th style="width:8%; white-space:nowrap;">UM Unit</th>
                <th style="width:8%; white-space:nowrap;">UM Qty</th>
                <th style="width:8%; white-space:nowrap;">UM Rate</th>
                <th style="width:13%;">Amount</th>
                <th style="width:13%;">Sales Tax</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sr = 1;
                $subTotal = 0;
                $gstTotal = 0;
            ?>
            <?php $__currentLoopData = $sale->saletax_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $subTotal += floatval($details->price);
                    $gstTotal += floatval($details->taxvalue);
                    $uom = $details->fbr_uom_desc
                        ?? (optional($details->unit)->uom_desc ?? optional($details->unit)->uom ?? '');
                ?>
                <tr>
                    <td class="td-center"><?php echo e($sr++); ?></td>
                    <td class="td-center"><?php echo e(optional($details->products)->product_code); ?></td>
                    <td class="td-left"><?php echo e(optional($details->products)->product_name); ?></td>
                    <td class="td-center"><?php echo e(optional($details->products)->id); ?></td>
                    <td class="td-center"><?php echo e($sale->p_order); ?></td>
                    <td class="td-center"><?php echo e($uom); ?></td>
                    <td class="td-center"><?php echo e(rtrim(rtrim(number_format($details->quantity, 4, '.', ''), '0'), '.')); ?></td>
                    <td class="td-right"><?php echo e(rtrim(rtrim(number_format($details->rate, 4, '.', ''), '0'), '.')); ?></td>
                    <td class="td-right"><?php echo e(number_format($details->price, 2)); ?></td>
                    <td class="td-right"><?php echo e(number_format($details->taxvalue, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php
        $incomeTax = floatval($sale->total_income_tax ?? 0);
        $grandTotal = $subTotal + $gstTotal + $incomeTax;
    ?>

    <div class="totals-wrap">
        <div class="totals-block">
            <div class="tot-row">
                <span class="tot-label">Sub Total:</span>
                <span class="tot-value"><?php echo e(number_format($subTotal, 2)); ?></span>
            </div>
            <div class="tot-row">
                <span class="tot-label">GST:</span>
                <span class="tot-value"><?php echo e(number_format($gstTotal, 2)); ?></span>
            </div>
            <div class="tot-row">
                <span class="tot-label">Advance I.tax 236H:</span>
                <span class="tot-value"><?php echo e(number_format($incomeTax, 2)); ?></span>
            </div>
            <div class="tot-row tot-grand">
                <span class="tot-label">Total:</span>
                <span class="tot-value">Rs. <?php echo e(number_format($grandTotal, 2)); ?></span>
            </div>
        </div>
    </div>

    <div class="footer-note">This is a system generated invoice and does not require any signatures.</div>
</div>
</body>
</html>
<?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/salestax/ashoes-template.blade.php ENDPATH**/ ?>