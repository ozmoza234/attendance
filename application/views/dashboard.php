<?php $user = $this->session->userdata('username'); ?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between" id="top_bar">
            <h4 class="mb-sm-0">Dashboard</h4>
        </div>
    </div>
</div>
<input type="hidden" value="<?= $user ?>" id="usr">
<!-- end page title -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                        <h4 class="mb-2"><?= $data['total_act'] ?></h4>
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
                <h4 class="card-title mb-4">Employee Gender Ratio</h4>
                <canvas id="pieGen" height="150"></canvas>
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
<script src="<?= base_url() ?>assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url() ?>assets/js/pages/chartjs.init.js"></script>

<script>
    $(document).ready(function() {
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novermber", "December"];
        let date = new Date();
        let num = date.getDate();
        let today = date.getDay();
        let thisMonth = date.getMonth();
        let thisYear = date.getFullYear();
        let disp = days[today] + ', ' + num + ' ' + months[thisMonth] + ' ' + thisYear;
        $('#top_bar').append(`<h4 id="date_now" class="mb-sm-0">${disp}<span id="time_now"></span></h4>`);
        let span = document.getElementById('time_now');

        function timeNow() {
            let dt = new Date();
            let hour = dt.getHours();
            let minute = dt.getMinutes();
            let second = dt.getSeconds();

            let time = ` ${hour}:${minute}:${second}`;
            span.textContent = time;

        }
        setInterval(timeNow, 1000);

        let getDataGen = $.ajax({
            url: '<?= site_url("Auth/get_data_graph"); ?>',
            type: 'POST',
            dataType: 'json'
        });

        $.when(getDataGen).done(function(getDataGenCtx) {
            let labelMf = ['Males', 'Females'];
            let dataMf = [];

            $.each(getDataGenCtx, function(i, item) {
                dataMf.push(item.m);
                dataMf.push(item.f);
            });

            let ctxPieGen = document.getElementById("pieGen");
            let myChartPieGen = new Chart(ctxPieGen, {
                type: 'pie',
                data: {
                    labels: labelMf,
                    datasets: [{
                        // label: 'Attendance Log Today',
                        data: dataMf,
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