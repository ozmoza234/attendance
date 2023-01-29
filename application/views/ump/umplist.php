<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Minimum Regional Salary</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-title text-center" style="padding:20px;">
                <h4 class="mb-sm-0">List</h4>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <!-- <button class="btn btn-primary btn-sm">+ Add New</button> -->
                </div>
                <div class="col-md-12" style="margin-top: 20px">
                    <table id="table" class="table activate-select dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Period</th>
                                <th>Year</th>
                                <th>Amount (Rp.)</th>
                                <!-- <th>Action</th> -->
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

<!-- Custom Scripts -->
<script>
    $(document).ready(function() {
        let table;

        table = $('#table').DataTable({
            ajax: {
                url: "<?= site_url('Ump/getData') ?>",
                type: 'GET'
            },
            columnDefs: [{
                    targets: 0,
                    'data': null,
                    'className': 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    targets: 1,
                    'data': 'PeriodeUMP'
                },
                {
                    targets: 2,
                    'data': 'YEAR'
                },
                {
                    targets: 3,
                    'data': 'UMP'
                },
                // {
                //     targets: 4,
                //     'data': null,
                //     'className': 'text-center',
                //     render: function(data, type, row) {
                //         return `<label class="btn btn-info" id="btne"><i class="mdi mdi-lead-pencil"></i></label> <label class="btn btn-danger" id="btnd"><i class="mdi mdi-trash-can-outline"></i></label>`
                //     }
                // },

            ]
        });

        $('#table tbody').on('click', '#btne', function() {
            console.log('edit');
        });

        $('#table tbody').on('click', '#btnd', function() {
            // let id = table.row($(this).parents('tr')).data().id;
            // $.ajax({

            // })
        });
    })
</script>
<!-- End of Csutom Scripts -->