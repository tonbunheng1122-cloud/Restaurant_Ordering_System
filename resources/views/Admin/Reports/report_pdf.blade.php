<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FastBite Report</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; padding: 30px; }
    .header { text-align: center; border-bottom: 3px solid #EE6D3C; padding-bottom: 16px; margin-bottom: 24px; }
    .header h1 { font-size: 24px; font-weight: 900; letter-spacing: 2px; color: #1a1a1a; }
    .header h1 span { color: #EE6D3C; }
    .header p { color: #666; font-size: 11px; margin-top: 4px; }
    .section { margin-bottom: 28px; page-break-inside: avoid; }
    .section-title { font-size: 14px; font-weight: 700; color: #EE6D3C; text-transform: uppercase;
        letter-spacing: 1px; border-left: 4px solid #EE6D3C; padding-left: 10px; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    thead { background-color: #1a1a1a; color: #fff; }
    thead th { padding: 8px 10px; text-align: left; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; font-size: 10px; }
    tbody tr { border-bottom: 1px solid #e5e5e5; }
    tbody tr:nth-child(even) { background-color: #fafafa; }
    tbody td { padding: 7px 10px; color: #333; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; }
    .badge-orange { background: #fff3ee; color: #c05621; }
    .badge-green  { background: #f0fff4; color: #276749; }
    .badge-yellow { background: #fffff0; color: #975a16; }
    .badge-blue   { background: #ebf8ff; color: #2c5282; }
    .badge-red    { background: #fff5f5; color: #9b2c2c; }
    .footer { text-align: center; margin-top: 32px; padding-top: 12px;
        border-top: 1px solid #e5e5e5; font-size: 10px; color: #999; }
    @media print {
        body { padding: 15px; }
        .section { page-break-inside: avoid; }
    }
</style>
</head>
<body>

<div class="header">
    <h1><span>Fast</span>Bite — Report</h1>
    <p>Generated: {{ $generatedAt }} &nbsp;|&nbsp; Type: {{ ucfirst($type) }}</p>
</div>

<!-- RESERVATIONS -->
@if($reservations->count())
<div class="section">
    <div class="section-title">Reservations ({{ $reservations->count() }})</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Date & Time</th>
                <th>Table</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $r)
            <tr>
                <td>#{{ $r->id }}</td>
                <td>{{ $r->full_name }}</td>
                <td>{{ $r->phone_number }}</td>
                <td>{{ $r->date }} {{ $r->time }}</td>
                <td><span class="badge badge-orange">Table {{ $r->table_id }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- ORDERS -->
@if($orders->count())
<div class="section">
    <div class="section-title">Orders ({{ $orders->count() }})</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
            @php
                $badgeClass = match(strtolower($o->status)) {
                    'completed' => 'badge-green',
                    'pending'   => 'badge-yellow',
                    'confirmed' => 'badge-blue',
                    'cancelled' => 'badge-red',
                    default     => 'badge-orange',
                };
            @endphp
            <tr>
                <td>#{{ $o->id }}</td>
                <td><span class="badge {{ $badgeClass }}">{{ ucfirst($o->status) }}</span></td>
                <td>${{ number_format($o->total_amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d M Y, h:i A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- PRODUCTS -->
@if($products->count())
<div class="section">
    <div class="section-title">Products ({{ $products->count() }})</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>#{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td><span class="badge badge-orange">{{ $p->category?->name ?? 'N/A' }}</span></td>
                <td>${{ number_format($p->price, 2) }}</td>
                <td>{{ $p->qty ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- CATEGORIES -->
@if($categories->count())
<div class="section">
    <div class="section-title">Categories ({{ $categories->count() }})</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Products</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
            <tr>
                <td>#{{ $c->id }}</td>
                <td>{{ $c->name }}</td>
                <td><span class="badge badge-green">{{ $c->products_count }} items</span></td>
                <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="footer">© {{ date('Y') }} FastBite Restaurant Ordering System &nbsp;|&nbsp; Confidential</div>

</body>
</html>