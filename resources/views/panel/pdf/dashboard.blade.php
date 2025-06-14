<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; background: #f7f7f7; color: #222; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2a4d8f; margin-bottom: 5px; }
        .header .date { color: #888; font-size: 14px; }
        .section-title { background: #2a4d8f; color: #fff; padding: 8px 16px; border-radius: 6px; margin-bottom: 10px; font-size: 18px; }
        .stats-grid { display: flex; gap: 16px; margin-bottom: 24px; }
        .stat-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 18px 20px;
            flex: 1;
            text-align: center;
        }
        .stat-label { color: #888; font-size: 13px; margin-bottom: 4px; }
        .stat-value { font-size: 28px; font-weight: bold; color: #2a4d8f; }
        .stat-change { font-size: 13px; color: #388e3c; }
        .table-section { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d0d0d0; padding: 8px 10px; }
        th { background: #e3eafc; color: #2a4d8f; }
        tr:nth-child(even) { background: #f5f8fd; }
        ul { margin: 0 0 0 18px; }
        .summary-list li { margin-bottom: 4px; }
        .footer { text-align: center; color: #aaa; font-size: 13px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Summary</h1>
        <div class="date">{{ \Carbon\Carbon::now()->format('d F Y, H:i') }}</div>
    </div>

    <div class="section-title">Statistics</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $productCount }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Labels Created</div>
            <div class="stat-value">{{ $translatedProductCount }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Product Change</div>
            <div class="stat-value">{{ $productPercentageChange }}%</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Translation Change</div>
            <div class="stat-value">{{ $translatedProductPercentageChange }}%</div>
        </div>
    </div>

    <div class="section-title">Most Printed Products</div>
    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Label Count</th>
                </tr>
            </thead>
            <tbody>
            @foreach($topCategories as $cat)
                <tr>
                    <td>{{ $cat['name'] }}</td>
                    <td>{{ $cat['count'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-title">Monthly Summary</div>
    <ul class="summary-list">
        <li><b>Labels Created:</b> {{ $monthlySummary['labelsCreated'] }}</li>
        <li><b>Translations:</b> {{ $monthlySummary['translations'] }}</li>
        <li><b>Print Jobs:</b> {{ $monthlySummary['printJobs'] }}</li>
        <li><b>Templates:</b> {{ $monthlySummary['templates'] }}</li>
    </ul>

    <div class="footer">
        &copy; {{ date('Y') }} labeltranslate Dashboard &mdash; Generated on {{ \Carbon\Carbon::now()->format('d F Y, H:i') }}
    </div>
</body>
</html>