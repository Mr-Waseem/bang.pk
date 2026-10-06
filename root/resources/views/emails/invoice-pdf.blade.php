<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNo }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <p>Dear Customer,</p>
    <p>Please find attached Invoice <strong>#{{ $invoiceNo }}</strong>@if(!empty($companyName)) from <strong>{{ $companyName }}</strong>@endif.</p>
    <p>This is an automated email. Please do not reply.</p>
</body>
</html>
