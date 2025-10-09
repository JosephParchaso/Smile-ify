<?php 
$mode = $currentMode ?? 'daily'; 
$bid = $branch['branch_id'];
?>
<h2>Highlights</h2>

<div class="kpi-container">
    <div class="kpi-box">Total Services<br>
        <span id="totalServices<?= $bid ?>-<?= $mode ?>">0</span>
    </div>
    <div class="kpi-box">Total Income<br>
        <span id="totalIncome<?= $bid ?>-<?= $mode ?>">₱0</span>
    </div>
    <div class="kpi-box">Top Service<br>
        <span id="topService<?= $bid ?>-<?= $mode ?>">-</span>
    </div>
    <div class="kpi-box">Avg Services per Appointment<br>
        <span id="avgServices<?= $bid ?>-<?= $mode ?>">0</span>
    </div>
    <div class="kpi-box">New Patients<br>
        <span id="newPatients<?= $bid ?>-<?= $mode ?>">0</span>
    </div>
</div>

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

    <div class="chart-box income-trend">
        <h4>Income Trend</h4>
        <canvas id="incomeTrendChart<?= $bid ?>-<?= $mode ?>"></canvas>
    </div>

    

    <?php if ($_SESSION['role'] === 'owner'): ?>
    <div class="chart-box branch-comparison">
        <h4>Branch Comparison</h4>
        <canvas id="branchComparisonChart<?= $bid ?>-<?= $mode ?>"></canvas>
    </div>
    <?php endif; ?>
</div>


<h2>Services Breakdown by Category</h2>
<div class="services-breakdown-grid">
    <div class="chart-box services-category">
        <h4>Services by Category</h4>
        <canvas id="servicesCategoryChart<?= $branch['branch_id'] ?>-<?= $mode ?>"></canvas>
    </div>
</div>



<h2>Staff Performance</h2>
<div class="staff-performance">
    <div class="staff-performance-grid">
        <div class="staff-performance-table">
            
            <table id="staffPerformanceTable<?= $branch['branch_id'] ?>-<?= $mode ?>">
                <thead>
                    <tr>
                        <th>Dentist</th>
                        <th>Branch</th>
                        <th>Services Rendered</th>
                        <th>Total Income (₱)</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="staff-performance-chart">
            <canvas id="staffPerformanceChart<?= $branch['branch_id'] ?>-<?= $mode ?>"></canvas>
        </div>
    </div>
</div>

<h2>Clinic Insights</h2>

<div class="insights-grid">
    <div class="chart-box patient-mix">
        <h4>Patient Mix</h4>
        <canvas id="patientMixChart<?= $branch['branch_id'] ?>-<?= $mode ?>"></canvas>
         <div class="new-patient-count" id="newPatientCount<?= $branch['branch_id'] ?>-<?= $mode ?>">
        New Patient Count: 0
        </div>
    </div>

    <div class="chart-box peak-hours">
        <h4>Peak Hours</h4>
        <canvas id="peakHoursChart<?= $branch['branch_id'] ?>-<?= $mode ?>"></canvas>
    </div>
</div>
