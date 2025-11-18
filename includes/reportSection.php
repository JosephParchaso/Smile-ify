<?php 
$mode = $currentMode ?? 'daily'; 
$bid = isset($branch['branch_id']) ? $branch['branch_id'] : ($branchId ?? 'all');
$role = $_SESSION['role'] ?? '';
?>

<?php if ($role === 'admin'): ?>
    <h2>Highlights</h2>
    <div class="kpi-container">
        <div class="kpi-box">Total Services<br><span id="totalServices<?= $bid ?>-<?= $mode ?>">0</span></div>
        <div class="kpi-box">Top Service<br><span id="topService<?= $bid ?>-<?= $mode ?>">-</span></div>
        <div class="kpi-box">Avg Services per Appointment<br><span id="avgServices<?= $bid ?>-<?= $mode ?>">0</span></div>
        <div class="kpi-box">New Patients<br><span id="newPatients<?= $bid ?>-<?= $mode ?>">0</span></div>
    </div>
<?php endif; ?>

<h2>Summary</h2>
<div class="chart-grid">
    <div class="chart-box appointments-summary">
        <h4>Appointments Summary</h4>
        <canvas id="appointmentsChart<?= $bid ?>-<?= $mode ?>"></canvas>
    </div>
    <div class="chart-box services-trend">
        <h4>Services Trend</h4>
        <canvas id="servicesTrendChart<?= $bid ?>-<?= $mode ?>"></canvas>
    </div>
</div>

<h2>Clinic Insights</h2>
<div class="insights-grid">
    <div class="chart-box patient-mix">
        <h4>Patient Mix</h4>
        <canvas id="patientMixChart<?= $bid ?>-<?= $mode ?>"></canvas>
        <div class="new-patient-count" id="newPatientCount<?= $bid ?>-<?= $mode ?>">New Patient Count: 0</div>
    </div>
    <div class="chart-box peak-hours">
        <h4>Peak Hours</h4>
        <canvas id="peakHoursChart<?= $bid ?>-<?= $mode ?>"></canvas>
    </div>
</div>

<?php if ($role === 'admin'): ?>
    <h2>Services Breakdown</h2>
    <div class="staff-performance">
        <div class="staff-performance-grid">
            <div class="staff-performance-table">
                <table id="servicesBreakdownTable<?= $bid ?>-<?= $mode ?>">
                    <thead>
                        <tr><th>Service</th><th>Count</th><th>%Total of Service</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="services-breakdown-chart">
                <canvas id="servicesBreakdownChart<?= $bid ?>-<?= $mode ?>"></canvas>
            </div>
        </div>
    </div>

    <h2>Promos Availed</h2>
    <div class="staff-performance">
        <div class="staff-performance-grid">
            <div class="staff-performance-table">
                <table id="promosTable<?= $bid ?>-<?= $mode ?>">
                    <thead>
                        <tr><th>Promo Name</th><th>Count</th><th>%Total of Promos</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <p id="totalPromos<?= $bid ?>-<?= $mode ?>" style="margin-top:1rem;font-weight:bold;"></p>
            </div>
            <div class="chart-wrapper">
                <canvas id="promosChart<?= $bid ?>-<?= $mode ?>"></canvas>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($role === 'owner'): ?>
    <h2>Branch Comparison</h2>
    <div class="staff-performance">
        <div class="staff-performance-grid">
            <div class="staff-performance-table">
                <h4>Service Prices</h4>
                <table id="servicePricesTable<?= $bid ?>-<?= $mode ?>">
                    <thead><tr><th>Service</th><th>Price (PHP)</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="chart-wrapper">
                <canvas id="branchComparisonChart<?= $bid ?>-<?= $mode ?>"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-box income-trend">
        <h4>Income Trend</h4>
        <div class="chart-wrapper-income-trend">
            <canvas id="incomeTrendChart<?= $bid ?>-<?= $mode ?>"></canvas>
        </div>
    </div>

    <div class="profitability-analysis">
        <h2>Profitability Analysis</h2>
        <div class="profitability-grid">
            <div class="chart-box">
                <h4>Growth Trend</h4>
                <canvas id="growthTrendChart<?= $bid ?>-<?= $mode ?>"></canvas>
            </div>
        </div>
    </div>

    <h2>Staff Performance</h2>
    <div class="staff-performance">
        <div class="staff-performance-grid">
            <div class="staff-performance-table">
                <table id="staffPerformanceTable<?= $bid ?>-<?= $mode ?>">
                    <thead><tr><th>Dentist</th><th>Branch</th><th>Services Rendered</th><th>Total Income (₱)</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="staff-performance-chart">
                <canvas id="staffPerformanceChart<?= $bid ?>-<?= $mode ?>"></canvas>
            </div>
        </div>
    </div>
<?php endif; ?>
