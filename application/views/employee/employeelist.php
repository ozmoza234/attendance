<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employee</h4>
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
                <table id="tableUser" class="table activate-select dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
            ]
        });
    })
</script>