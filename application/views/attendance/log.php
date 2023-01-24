<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Attendance Log</h4>
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
                <table id="tableLog" class="table activate-select dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Enroll</th>
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
        $('#tableLog').DataTable({
            ajax: {
                url: '<?= base_url('Attendance/get_log') ?>',
                type: 'GET'
            },
            columns: [{
                    'data': null,
                    'className': 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'data': 'NIK'
                },
                {
                    'data': 'Name'
                },
                {
                    'data': 'DeviceDesc'
                },
                {
                    'data': 'Enroll'
                },
            ]
        });
    })
</script>