<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #000;
        margin: 0;
        padding: 15px;
    }

    .report-header {
        text-align: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .company-name {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .company-details {
        font-size: 13px;
        margin: 3px 0;
        color: #000;
    }

    .report-period {
        font-weight: bold;
        margin: 10px 0;
        font-size: 14px;
    }

    .report-title {
        font-size: 17px;
        font-weight: bold;
        margin: 15px 0;
        text-align: center;
    }

    .report-subtitle {
        font-size: 13px;
        margin: 0 0 12px;
        text-align: center;
        font-weight: bold;
        line-height: 1.5;
    }

    .report-meta-row {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 13px;
        margin: 0 0 12px;
        font-weight: bold;
        line-height: 1.5;
    }

    .report-table-wrap {
        overflow-x: auto;
        margin: 10px 0;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 13px;
        table-layout: fixed;
    }

    .report-table th {
        background-color: #f5f5f5;
        border: 1px solid #000;
        padding: 10px 8px;
        text-align: center;
        font-weight: bold;
        font-size: 13px;
        vertical-align: middle;
    }

    .report-table td {
        border: 1px solid #000;
        padding: 9px 8px;
        font-size: 13px;
        vertical-align: middle;
    }

    .report-table .col-sr { width: 4%; }
    .report-table .col-date { width: 8%; }
    .report-table .col-inv { width: 6%; }
    .report-table .col-fbr { width: 14%; font-size: 11px; word-break: break-all; line-height: 1.35; }
    .report-table .col-product { width: 22%; word-wrap: break-word; line-height: 1.4; }
    .report-table .col-party { width: 16%; word-wrap: break-word; line-height: 1.4; }
    .report-table .col-code { width: 8%; word-break: break-all; }
    .report-table .col-ntn { width: 9%; }
    .report-table .col-num { width: 7%; }
    .report-table .col-hs { width: 10%; }

    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .total-row {
        font-weight: bold;
        background-color: #f9f9f9;
        font-size: 14px;
    }

    .print-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 10px 0;
        cursor: pointer;
        border-radius: 4px;
    }

    .date-stamp {
        float: right;
        margin-top: -40px;
        font-size: 13px;
    }

    .print-header-group {
        margin-bottom: 0;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        @page landscape {
            size: A4 landscape;
            margin: 8mm;
        }

        body.report-wide-print {
            page: landscape;
        }

        body {
            font-size: 11pt;
            padding: 0;
            margin: 0;
            background: white;
        }

        .print-button,
        .date-stamp {
            display: none;
        }

        .print-header-group {
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .report-table-wrap {
            overflow: visible;
        }

        .report-table {
            page-break-inside: auto;
            font-size: 11pt;
        }

        .report-table .col-fbr {
            font-size: 9pt;
        }

        .report-table th,
        .report-table td {
            padding: 7px 5px;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    }
</style>
