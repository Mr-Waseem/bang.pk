<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            padding: 20px;
            color: #343a40;
        }
        
        .header-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            /*border-radius: 12px;*/
            padding: 5px;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            /*border: 1px solid #e9ecef;*/
            position: relative;
        }
        
        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 20px;
        }
        
        .company-info {
            width: 100%;
            text-align: center;
        }
        
        .company-info h3 {
            color: #2c3e50;
            margin: 0 0 12px 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .company-info p {
            color: #495057;
            margin: 6px 0;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .company-actions {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .print-button {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(78, 84, 200, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(78, 84, 200, 0.4);
        }
        
        .print-button:active {
            transform: translateY(0);
            box-shadow: 0 3px 6px rgba(78, 84, 200, 0.3);
        }
        
        .icon {
            width: 20px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .header-content {
                padding-top: 40px;
            }
            
            .company-actions {
                position: relative;
                top: 0;
                right: 0;
                margin-top: 15px;
            }
            
            .company-info h3 {
                font-size: 1.5rem;
            }
        }
        
        @media print {
            .print-button {
                display: none !important;
            }
            
            .header-container {
                box-shadow: none;
                /*border: 1px solid #ddd;*/
                /*border-radius: 0;*/
            }
        }
        
        .demo-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .demo-content h2 {
            color: #4e54c8;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .demo-content p {
            line-height: 1.6;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="header-content">
            <div class="company-info">
                <h3>{{ session()->get('company_name') }}</h3>
                <p><span class="icon"><i class="fas fa-map-marker-alt"></i></span>Address: {{ session()->get('company_address') }}</p>
            </div>
            
            <div class="company-actions">
                <button class="print-button" onclick="printInvoice()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!--<div class="demo-content">-->
    <!--    <h2>Sample Document Content</h2>-->
    <!--    <p>This is a demonstration of the professional header with centered company information. The company name and address are now centered in the header with the print button positioned in the top right corner.</p>-->
    <!--    <p>On mobile devices, the layout adjusts to maintain good readability with the print button moving below the company information.</p>-->
    <!--    <p>Try printing this document to see how the header appears without the print button in the printed version.</p>-->
    <!--</div>-->

    <script>
        function printInvoice() {
            const button = document.querySelector('.print-button');
            
            // Add smooth fade-out animation
            button.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            button.style.opacity = '0';
            button.style.transform = 'scale(0.9)';
            
            // Wait for animation to complete before printing
            setTimeout(() => {
                button.style.display = 'none';
                window.print();
                
                // Restore button after printing is done (or cancelled)
                setTimeout(() => {
                    button.style.display = 'flex';
                    button.style.opacity = '1';
                    button.style.transform = 'scale(1)';
                }, 300);
            }, 300);
        }
        
        // Listen for afterprint event to show button again
        window.addEventListener('afterprint', function() {
            const button = document.querySelector('.print-button');
            button.style.display = 'flex';
            setTimeout(() => {
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
            }, 10);
        });
    </script>
</body>
</html>