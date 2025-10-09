let charts = {};

document.addEventListener("DOMContentLoaded", function () {
  
    document.querySelectorAll(".tab-content").forEach(tab => {
        const branch_id = tab.id.replace("branch", "");
        switchSubTab(branch_id, "daily");
    });
});


function switchTab(branch_id) {
    document.querySelectorAll(".tab, .tab-content").forEach(el => el.classList.remove("active"));
    document.querySelector(`.tab[onclick="switchTab('${branch_id}')"]`).classList.add("active");
    document.getElementById(branch_id).classList.add("active");
}


function switchSubTab(branch_id, mode) {
    console.log(`Switching to mode: ${mode} for branch ${branch_id}`);

    const container = document.getElementById(`branch${branch_id}`);
    if (!container) return;

    container.querySelectorAll(".sub-tab, .sub-tab-content").forEach(el => el.classList.remove("active"));

    const activeSubTab = container.querySelector(`.sub-tab[onclick*="${mode}"]`);
    const activeContent = container.querySelector(`#branch${branch_id}-${mode}`);

    if (activeSubTab) activeSubTab.classList.add("active");
    if (activeContent) activeContent.classList.add("active");

    loadReports(branch_id, mode);
}


function loadReports(branch_id, mode) {
    fetch(`/Smile-ify/processes/fetch_Reports.php?branch_id=${branch_id}&mode=${mode}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

         
            updateKPI(branch_id, mode, data.kpi);

           
            destroyChart(`appointments${branch_id}-${mode}`);
            destroyChart(`servicesTrend${branch_id}-${mode}`);
            destroyChart(`incomeTrend${branch_id}-${mode}`);
            destroyChart(`branchComparison${branch_id}-${mode}`);

           
            renderAppointmentsChart(branch_id, mode, data.appointments);
            renderServicesTrendChart(branch_id, mode, data.trend);
            renderIncomeTrendChart(branch_id, mode, data.trend);
            renderBranchComparisonChart(branch_id, mode, data.branchComparison);
            renderStaffPerformanceTable(branch_id, mode, data.staffPerformance);
            renderStaffPerformanceChart(branch_id, mode, data.staffPerformance);
            renderPatientMixChart(branch_id, mode, data.patientMix);
            renderPeakHoursChart(branch_id, mode, data.peakHours);

        })
        .catch(err => console.error("Fetch error:", err));
}


function updateKPI(branch_id, mode, kpi) {
    if (!kpi) return;
    const safeSet = (id, value) => {
        const el = document.getElementById(`${id}${branch_id}-${mode}`);
        if (el) el.textContent = value;
    };

    safeSet("totalServices", kpi.totalServices ?? 0);
    safeSet("totalIncome", "₱" + Number(kpi.totalIncome ?? 0).toLocaleString());
    safeSet("topService", kpi.topService ?? "-");
    safeSet("newPatients", kpi.newPatients ?? 0);
    safeSet("avgServices", kpi.avgServices ?? 0);

    const newCountEl = document.getElementById(`newPatientCount${branch_id}-${mode}`);
    if (newCountEl) newCountEl.textContent = "New Patient Count: " + (kpi.newPatients ?? 0);
}




function renderAppointmentsChart(branch_id, mode, appointments) {
    const ctx = document.getElementById(`appointmentsChart${branch_id}-${mode}`);
    if (!ctx || !appointments) return;

    charts[`appointments${branch_id}-${mode}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Booked", "Completed", "Cancelled"],
            datasets: [{
                data: [
                    appointments.booked || 0,
                    appointments.completed || 0,
                    appointments.cancelled || 0
                ],
                backgroundColor: ["#3498db", "#2ecc71", "#e74c3c"],
                borderColor: [
                    'rgba(52, 152, 219, 1)',
                    'rgba(46, 204, 113, 1)',
                    'rgba(231, 76, 60, 1)'
                ],
                borderWidth: 2,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: -6,
                    color: '#000',
                    font: {
                        size: 24,         
                        weight: 'bold',
                        family: 'Poppins, sans-serif'
                    },
                    formatter: (value) => value > 0 ? value : ''
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%',  
                    ticks: {
                        color: '#333',
                        font: { size: 13 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#333',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}



function renderServicesTrendChart(branch_id, mode, trend) {
    const ctx = document.getElementById(`servicesTrendChart${branch_id}-${mode}`);
    if (!ctx || !trend) return;

    charts[`servicesTrend${branch_id}-${mode}`] = new Chart(ctx, {
        type: "line",
        data: {
            labels: trend.labels,
            datasets: [{
                label: "Services",
                data: trend.services,
                borderColor: "#1d445dff",
                borderWidth: 3,
                tension: 0.3,
                fill: false,
                pointBackgroundColor: "#1d445dff",
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: 8,
                    color: '#000',
                    font: {
                        size: 24,
                        weight: 'bold',
                        family: 'Poppins, sans-serif'
                    },
                    formatter: (value) => value > 0 ? value : ''
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%',
                    ticks: {
                        color: '#333',
                        font: { size: 13 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#333',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}



function renderIncomeTrendChart(branch_id, mode, trend) {
    const ctx = document.getElementById(`incomeTrendChart${branch_id}-${mode}`);
    if (!ctx || !trend) return;

    charts[`incomeTrend${branch_id}-${mode}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: trend.labels,
            datasets: [{
                label: "Income (₱)",
                data: trend.income,
                backgroundColor: "#2ecc71",
                borderColor: "rgba(46, 204, 113, 1)",
                borderWidth: 2,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: 6,
                    color: '#000',
                    font: {
                        size: 18,
                        weight: 'bold',
                        family: 'Poppins, sans-serif'
                    },
                    formatter: (value) => "₱" + Number(value).toLocaleString()
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%',
                    ticks: {
                        color: '#333',
                        font: { size: 13 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#333',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}



function renderBranchComparisonChart(branch_id, mode, branchComparison) {
    const ctx = document.getElementById(`branchComparisonChart${branch_id}-${mode}`);
    if (!ctx || !branchComparison) return;

    charts[`branchComparison${branch_id}-${mode}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: Object.keys(branchComparison),
            datasets: [{
                label: "Income (₱)",
                data: Object.values(branchComparison),
                backgroundColor: ["#8e44ad", "#2980b9", "#f39c12", "#16a085"],
                borderColor: [
                    "rgba(142, 68, 173, 1)",
                    "rgba(41, 128, 185, 1)",
                    "rgba(243, 156, 18, 1)",
                    "rgba(22, 160, 133, 1)"
                ],
                borderWidth: 2,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: 6,
                    color: '#000',
                    font: {
                        size: 18,
                        weight: 'bold',
                        family: 'Poppins, sans-serif'
                    },
                    formatter: (value) => "₱" + Number(value).toLocaleString()
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%',
                    ticks: {
                        color: '#333',
                        font: { size: 13 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#333',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

function renderStaffPerformanceTable(branch_id, mode, staffData) {
    const tbody = document.querySelector(`#staffPerformanceTable${branch_id}-${mode} tbody`);
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!staffData || staffData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" style="text-align:center;">No data available</td></tr>`;
        return;
    }

    staffData.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.dentist_name}</td>
            <td>${row.branch_name}</td>
            <td>${row.services_rendered}</td>
            <td>₱${Number(row.total_income).toLocaleString()}</td>
        `;
        tbody.appendChild(tr);
    });
}


function renderStaffPerformanceChart(branch_id, mode, staffData) {
    const ctx = document.getElementById(`staffPerformanceChart${branch_id}-${mode}`);
    if (!ctx || !staffData || staffData.length === 0) return;

    const topDentists = staffData.slice(0, 10); 

    const labels = topDentists.map(d => d.dentist_name);
    const incomes = topDentists.map(d => d.total_income);

    charts[`staffPerformance${branch_id}-${mode}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels,
            datasets: [{
                label: "Total Income (₱)",
                data: incomes,
                backgroundColor: "#3498db",
                borderColor: "#2980b9",
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: 6,
                    color: '#000',
                    font: {
                        size: 18,
                        weight: 'bold',
                        family: 'Poppins, sans-serif'
                    },
                    formatter: (value) => "₱" + Number(value).toLocaleString()
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%',
                    ticks: {
                        color: '#333',
                        font: { size: 13 }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: {
                        color: '#333',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: { display: false }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}


function renderPatientMixChart(branch_id, mode, mix) {
    const ctx = document.getElementById(`patientMixChart${branch_id}-${mode}`);
    if (!ctx || !mix) return;

    charts[`patientMix${branch_id}-${mode}`] = new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["New Patients", "Returning Patients"],
            datasets: [{
                data: [mix.new || 0, mix.returning || 0],
                backgroundColor: ["#3498db", "#2ecc71"],
                borderColor: ["#2980b9", "#27ae60"],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "right",
                    labels: { font: { size: 20, family: "Poppins, sans-serif" } }
                },
                datalabels: {
                    color: "#fff",
                    font: { weight: "bold", size: 16 },
                    formatter: (value, ctx) => {
                        const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        return total ? ((value / total) * 100).toFixed(1) + "%" : "0%";
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}


function renderPeakHoursChart(branch_id, mode, hoursData) {
    const ctx = document.getElementById(`peakHoursChart${branch_id}-${mode}`);
    if (!ctx || !hoursData) return;

    const labels = Object.keys(hoursData);
    const values = Object.values(hoursData);

    charts[`peakHours${branch_id}-${mode}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Appointments",
                data: values,
                backgroundColor: "#1d445dff",
                borderColor: "#16384b",
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: "end",
                    align: "end",
                    offset: -4,
                    color: "#000",
                    font: { size: 14, weight: "bold", family: "Poppins, sans-serif" },
                    formatter: (value) => value > 0 ? value : ""
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: "#333", font: { size: 13 } },
                    grid: { color: "rgba(0,0,0,0.05)" }
                },
                x: {
                    ticks: { color: "#333", font: { size: 13, weight: "bold" } },
                    grid: { display: false }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}






function destroyChart(key) {
    if (charts[key]) {
        charts[key].destroy();
        delete charts[key];
    }
}
