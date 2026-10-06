<!DOCTYPE html>
<html>
<head>
    <title>New FBR Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 15px; text-align: center; }
        .content { padding: 20px; }
        .footer { margin-top: 20px; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New FBR Digital Invoicing Registration</h2>
        </div>
        
        <div class="content">
            <p><strong>Business Name:</strong> {{ $formData['business_name'] }}</p>
            <p><strong>NTN Number:</strong> {{ $formData['ntn_number'] }}</p>
            <p><strong>Email:</strong> {{ $formData['email'] }}</p>
            <p><strong>Phone:</strong> {{ $formData['phone'] }}</p>
            
            <p>Registration received at: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from FBR Invoice System. Please do not reply.</p>
        </div>
    </div>
</body>
</html>