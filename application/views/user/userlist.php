<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">User</h4>
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
                            <th>Username</th>
                            <th>Password</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        showDt();
        var tabel;

        function showDt() {
            tabel = $('#tableUser').DataTable({
                autoWidth: false,
                info: true,
                searching: true,
                paging: true,
                scrollX: true,
                stateSave: true,
                destroy: true,
                ajax: {
                    url: '<?= base_url('User/gdu') ?>',
                    type: 'GET'
                },
                columns: [{
                        "data": null,
                        "className": "text-center",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        'data': 'UserName'
                    },
                    {
                        'data': 'Password'
                    },
                    {
                        'data': 'TDate'
                    },
                    {
                        'render': function(data, type, row) {
                            return `<span class='btn btn-info' id='btn-edit'><i class='fas fa-edit'></i></span> <span class='btn btn-danger' id='btn-edit'><i class='fas fa-trash-alt'></i></span>`
                        }
                    }
                ],
            });
        }
    })
</script>