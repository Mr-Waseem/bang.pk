@php
    $headerStrn = trim((string) (session()->get('company_strn') ?? ''));
    $headerNtn = trim((string) (session()->get('company_ntn') ?? ''));
    $headerAddress = trim((string) (session()->get('company_address') ?? ''));
    $headerLogo = trim((string) ($company->company_logo ?? ''));
    $hasLogo = $headerLogo !== '';
@endphp
@if($hasLogo)
<table class="company-header company-header--logo">
    <tr>
        <td class="ch-info">
            <div class="ch-name">{{ session()->get('company_name') }}</div>
            @if(filled($headerStrn) || filled($headerNtn))
            <div class="ch-meta">
                @if(filled($headerStrn))STRN: {{ $headerStrn }}@endif
                @if(filled($headerStrn) && filled($headerNtn)) &emsp; @endif
                @if(filled($headerNtn))NTN: {{ $headerNtn }}@endif
            </div>
            @endif
            @if(filled($headerAddress))
            <div class="ch-address">{{ $headerAddress }}</div>
            @endif
        </td>
        <td class="ch-logo">
            <img src="{{ asset($headerLogo) }}" alt="" onerror="this.style.display='none'">
        </td>
    </tr>
</table>
@else
<table class="company-header company-header--plain">
    <tr>
        <td class="ch-info">
            <div class="ch-name">{{ session()->get('company_name') }}</div>
            @if(filled($headerStrn) || filled($headerNtn))
            <div class="ch-meta">
                @if(filled($headerStrn))STRN: {{ $headerStrn }}@endif
                @if(filled($headerStrn) && filled($headerNtn)) &emsp; @endif
                @if(filled($headerNtn))NTN: {{ $headerNtn }}@endif
            </div>
            @endif
            @if(filled($headerAddress))
            <address class="ch-address">{{ $headerAddress }}</address>
            @endif
        </td>
    </tr>
</table>
@endif
