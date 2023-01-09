<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                        <h4 class="mb-2">234</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="mdi mdi-account-group-outline font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Users</p>
                        <h4 class="mb-2">240</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-account-key font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Present Employees</p>
                        <h4 class="mb-2">220</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="ri-user-3-line font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Absent Employees</p>
                        <h4 class="mb-2">14</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-danger rounded-3">
                            <i class="ri-user-3-line font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Monthly Attendance Log</h4>
                <canvas id="bar" height="150"></canvas>
            </div>
        </div><!-- end card -->
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Today Attendance Log</h4>
                <canvas id="pie" height="150"></canvas>
            </div>
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<!-- Chart JS -->
<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<script>
    $(document).ready(function() {
        let ctxBar = document.getElementById("bar");
        let myChartBar = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['August 2022', 'September 2022', 'October 2022', 'November 2022', 'December 2022', 'January 2023'],
                datasets: [{
                    label: 'Present Employees',
                    data: [211, 199, 220, 116, 119, 126],
                    borderWidth: 1,
                    // borderColor: '#36A2EB',
                    // backgroundColor: 'rgba(255, 0, 255, 0.5)'
                    backgroundColor: 'rgba(0, 0, 255, 0.5)',
                    // datalabels: {
                    //     anchor: 'end',
                    //     align: 'top',
                    //     offset: 1,
                    //     font: {
                    //         weight: 'bold'
                    //     }
                    // }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            },
            // plugins: [ChartDataLabels],
        });

        let ctxPie = document.getElementById("pie");
        let myChartPie = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Present Employees', 'Absent Employees'],
                datasets: [{
                    label: 'Attendance Log Today',
                    data: [220, 14],
                    borderWidth: 1,
                    borderColor: ['#36A2EB', '#FF6384'],
                    backgroundColor: ['rgba(0, 0, 255, 0.5)', 'rgba(255, 0, 255, 0.5)'],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            },
        });
    })
</script>