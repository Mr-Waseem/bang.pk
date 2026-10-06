<style>
    .print-report-toolbar {
        margin: 12px 0;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .print-report-toolbar .toolbar-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.2;
        text-decoration: none;
        cursor: pointer;
        border: none;
        font-family: Arial, sans-serif;
    }

    .print-report-toolbar .toolbar-btn-print {
        background: #17a2b8;
        color: #fff;
    }

    .print-report-toolbar .toolbar-btn-print:hover {
        background: #138496;
        color: #fff;
    }

    .print-report-toolbar .toolbar-btn-back {
        background: #6c757d;
        color: #fff;
    }

    .print-report-toolbar .toolbar-btn-back:hover {
        background: #5a6268;
        color: #fff;
        text-decoration: none;
    }

    @media print {
        .print-report-toolbar {
            display: none !important;
        }
    }
</style>

<div class="print-report-toolbar">
    <button type="button" class="toolbar-btn toolbar-btn-print" onclick="{{ $printOnclick ?? 'window.print()' }}">
        @if (!empty($printLabel))
            {!! $printLabel !!}
        @else
            Print
        @endif
    </button>
    <a href="{{ url('print-reports/create') }}" class="toolbar-btn toolbar-btn-back">Back</a>
</div>
