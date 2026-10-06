@extends('app')
@section('content')
<div class="container">
    <h3>Edit SRB draft {{ $sale->invoice_no }}</h3>
    <p>Amounts are recalculated on save. Use a single tax rate for all lines. Saving does not submit to SRB.</p>
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @foreach($errors->all() as $error)<div class="alert alert-danger">{{ $error }}</div>@endforeach
    <form method="POST" action="{{ url('pos-salestax/' . $sale->id) }}">
        @csrf @method('PUT')
        <table class="table"><thead><tr><th>Item</th><th>Quantity</th><th>Rate</th><th>Tax %</th><th>Line discount</th></tr></thead><tbody>
        @foreach($sale->saletax_details as $index => $line)
            <tr><td>{{ $line->products->product_name ?? 'Item' }}<input type="hidden" name="lines[{{ $index }}][id]" value="{{ $line->id }}"></td>
            @foreach(['quantity', 'rate', 'stvalue', 'discount_value'] as $field)
                <td><input class="form-control" type="number" min="0" step="any" required name="lines[{{ $index }}][{{ $field }}]" value="{{ old('lines.'.$index.'.'.$field, $line->$field) }}"></td>
            @endforeach</tr>
        @endforeach
        </tbody></table>
        <label>Invoice discount (PKR)</label><input class="form-control" type="number" min="0" step="0.01" required name="discount_amount" value="{{ old('discount_amount', $sale->discount_amount) }}">
        <p class="help-block">SRB payment mode is Cash for all invoices.</p>
        <button class="btn btn-primary">Save SRB draft</button>
    </form>
</div>
@endsection
