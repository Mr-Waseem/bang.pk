<div style="display: flex; justify-content: space-between; align-items: center; margin: 10px 0;">
    <span style="font-weight: bold; font-size: 14px;">Party Name: {{ $party[0]->party_name }}</span>
    <span style="font-weight: bold; font-size: 14px;">
        @if ($party[0]->code != null)
            Party Code: {{ $party[0]->code }}
        @endif
    </span>
</div>