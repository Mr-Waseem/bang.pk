<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    .summary-container {
        width: 100%;
        max-width: none;
        margin: 6px 0 16px;
        padding: 0;
    }
    .summary-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
        background: #fff;
    }
    .summary-card .card-body {
        padding: 1rem 1.25rem !important;
    }
    .summary-row {
        display: flex;
        flex-wrap: nowrap;
        align-items: stretch;
        gap: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .summary-row .stat-item {
        flex: 1 1 0;
        min-width: 140px;
        padding: 4px 2px;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-end;
    }
    .summary-row .stat-label {
        color: #343a40;
        font-size: 12px !important;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        margin-bottom: 6px;
        text-align: center;
        line-height: 1.25;
        display: block;
    }
    .summary-row .stat-value {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 8px;
        text-align: center;
        font-weight: 700;
        font-size: 18px !important;
        color: #212529;
        padding: 0.5rem 0.35rem;
        width: 100%;
        max-width: none !important;
        min-height: 44px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .st-wrap .st-meta-section {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }
    .st-wrap .st-meta-row {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 8px 12px;
        align-items: end;
        margin-bottom: 10px;
    }
    .st-wrap .st-meta-row:last-child { margin-bottom: 0; }
    .st-wrap .st-meta-field { min-width: 0; }
    .st-wrap .st-meta-field label {
        display: block;
        margin-bottom: 4px;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    .st-wrap .st-meta-row--voucher .st-meta-field--vr { grid-column: span 2; }
    .st-wrap .st-meta-row--voucher .st-meta-field--date { grid-column: span 3; }
    .st-wrap .st-meta-row--voucher .st-meta-field--account { grid-column: span 7; }
    .st-wrap .st-meta-row--voucher-only .st-meta-field--vr { grid-column: span 3; }
    .st-wrap .st-meta-row--voucher-only .st-meta-field--date { grid-column: span 3; }
    .st-wrap .st-meta-field .form-control,
    .st-wrap .st-meta-field .select2-container {
        width: 100% !important;
        max-width: 100%;
    }
    .st-wrap .st-meta-field .form-control {
        height: 38px;
        font-size: 15px;
        border-color: #ced4da;
    }
    .st-wrap .st-meta-field .select2-container .select2-selection--single {
        height: 38px !important;
        border-color: #ced4da;
    }
    .st-wrap .st-meta-field .select2-selection__rendered {
        line-height: 36px !important;
        font-size: 15px;
    }
    .st-wrap .st-meta-field .select2-selection__arrow { height: 36px !important; }
    .st-wrap .st-grid-panel {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 12px;
    }
    .st-wrap .st-grid-scroll { overflow-x: auto; }
    .st-wrap .st-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .st-wrap .st-table th {
        background: #0d6efd;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #0b5ed7;
        white-space: nowrap;
    }
    .st-wrap .st-table td {
        padding: 4px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
        background: #fff;
    }
    .st-wrap .st-table tr.st-entry td { background: #f8f9fa; }
    .st-wrap .st-table tr.st-data-row td { background: #fff; }
    .st-wrap .st-table tr.st-data-row:hover td { background: #f1f3f5; }
    .st-wrap .st-table .form-control {
        height: 36px;
        padding: 4px 6px;
        font-size: 14px;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
    }
    .st-wrap .st-table .btn-sm {
        min-width: 64px;
        height: 36px;
        padding: 4px 10px;
        font-size: 13px;
    }
    .st-wrap .st-num input { text-align: right; }
    .st-wrap .st-table .select2-container { width: 100% !important; }
    .st-wrap .st-table .select2-container .select2-selection--single {
        height: 36px !important;
    }
    .st-wrap .st-table .select2-selection__rendered { line-height: 34px !important; }
    .st-wrap .st-table .select2-selection__arrow { height: 34px !important; }
    .st-wrap .btn-save-voucher {
        min-width: 160px;
    }
</style>
