<div class="print-header-group">
    <div class="report-header">
        <div class="company-name">{{ session()->get('company_name') }}</div>
        <div class="company-details">{{ session()->get('company_address') }}</div>
    </div>

    <div class="report-period text-center">
        FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}
    </div>

    <div class="report-title">{{ $reportTitle }}</div>

    @if (!empty($reportSubtitle))
        <div class="report-subtitle">{!! $reportSubtitle !!}</div>
    @endif

    @if (!empty($reportMetaLeft) || !empty($reportMetaRight))
        <div class="report-meta-row">
            <div>{!! $reportMetaLeft ?? '' !!}</div>
            <div>{!! $reportMetaRight ?? '' !!}</div>
        </div>
    @endif
</div>
