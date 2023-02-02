<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employee Attendance Log</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title text-center" style="padding:20px;">
                <h4 class="mb-sm-0">List</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="months">Months: </label>
                        <select name="months" id="months" class="form-control">
                            <option value="">-- Select Month --</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="years">Years: </label>
                        <select name="years" id="years" class="form-control">
                            <option value="">-- Select Year --</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top: 50px; overflow:auto;">
                    <table id="tableUser" class="table activate-select dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Title</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal_edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <h2 class="modal-title" id="modal_edit_title"></h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" style="overflow:auto;">
                        <table class="table table-hover" id="table_edit_header">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Day</th>
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Work Hours Total</th>
                                    <th>Difference</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="dateModal">
                <input type="hidden" id="id_mform">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit -->

<!-- Custom Scripts -->
<script>
    $(document).ready(function() {
        let tableUser;

        tableUser = $('#tableUser').DataTable({
            ajax: {
                url: '<?= base_url('Employee/getData') ?>',
                type: 'GET',
            },
            columnDefs: [{
                    targets: 0,
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    targets: 1,
                    'data': 'NIK'
                },
                {
                    targets: 2,
                    'data': 'ename'
                },
                {
                    targets: 3,
                    'data': 'd'
                },
                {
                    targets: 4,
                    'data': 'p'
                },
                {
                    targets: 5,
                    'data': 't'
                },
                {
                    targets: 6,
                    'data': null,
                    render: function(data, type, row) {
                        return `<button class="btn btn-primary" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>`
                    }
                },
            ]
        });

        $('#tableUser tbody').on('click', '#btn_d', function() {
            $('#table_edit_header').DataTable().destroy();
            let EmployeeID = tableUser.row($(this).parents('tr')).data().EmployeeID;
            let n = tableUser.row($(this).parents('tr')).data().ename;
            let month = $('#months').val();
            let year = $('#years').val();
            if (month == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Month Still Empty',
                    text: 'Please input month from list given'
                })
            } else if (year == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Year Still Empty',
                    text: 'Please input year from list given'
                })
            } else {
                $('#table_edit_header').DataTable({
                    autoWidth: false,
                    paging: false,
                    ajax: {
                        url: '<?= base_url('Attendance/detailss') ?>',
                        data: {
                            EmployeeID: EmployeeID,
                            month: month,
                            year: year,
                        },
                        type: 'GET',
                        dataType: 'json'
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'excel', 'pdf', 'print'
                    ],
                    columnDefs: [{
                            targets: 0,
                            'data': null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            targets: 1,
                            data: 'Name'
                        },
                        {
                            targets: 2,
                            data: 'DAY'
                        },
                        {
                            targets: 3,
                            data: 'date'
                        },
                        {
                            targets: 4,
                            data: 'inTime'
                        },
                        {
                            targets: 5,
                            data: 'outTime'
                        },
                        {
                            targets: 6,
                            data: 'total'
                        },
                        {
                            targets: 7,
                            data: 'difference'
                        },
                        {
                            targets: 8,
                            data: 'WorkHourDesc'
                        }
                    ]
                });
                var date = new Date();
                console.log(date.toDateString())
                var monthh = date.getMonth() + 1;
                date.setDate(1);
                var all_days = [];
                while (date.getMonth() + 1 == monthh) {
                    var d = date.getFullYear() + '-' + date.getMonth().toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                    all_days.push(d);
                    date.setDate(date.getDate() + 1);
                }
                console.log(all_days);
                console.log(monthh);
                console.log(date.toDateString());

                $('#modal_edit_title').text('Details form ' + n);
                $('#modal_edit').prependTo("body").modal("show");
            }
        })
    })
</script>