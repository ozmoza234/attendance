<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employee's Salary</h4>
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
            <div class="card-body" style="overflow:auto;">
                <table id="tableUser" class="table activate-select dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Title</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <h2 class="modal-title" id="modal_edit_title"></h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" style="overflow:auto;">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="nik">NIK: </label>
                                <input type="text" class="form-control" placeholder="" name="nik" id="nik" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="department">Department: </label>
                                <input type="text" class="form-control" name="department" id="department" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="pos">Position: </label>
                                <input type="text" readonly class="form-control" name="pos" id="pos">
                            </div>
                            <div class="col-lg-3">
                                <label for="title">Title: </label>
                                <input type="text" readonly class="form-control" name="title" id="title">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit -->

<script>
    $(document).ready(function() {
        let tableUser;

        tableUser = $('#tableUser').DataTable({
            autoWidth: false,
            ajax: {
                url: '<?= base_url('Employee/getDatas') ?>',
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

        let load_details;

        $('#load_details').DataTable();

        $('#tableUser tbody').on('click', '#btn_d', function() {
            $('#load_details').DataTable().destroy();
            let id = tableUser.row($(this).parents('tr')).data().EmployeeID;
            let nik = tableUser.row($(this).parents('tr')).data().NIK;
            let ename = tableUser.row($(this).parents('tr')).data().ename;
            let position = tableUser.row($(this).parents('tr')).data().p;
            let dept = tableUser.row($(this).parents('tr')).data().d;
            let title = tableUser.row($(this).parents('tr')).data().t;
            let salary = tableUser.row($(this).parents('tr')).data().Salary;
            let skills = tableUser.row($(this).parents('tr')).data().Allw_Keterampilan;
            let post = tableUser.row($(this).parents('tr')).data().Allw_Jabatan;
            let services = tableUser.row($(this).parents('tr')).data().Allw_MasaKerja;

            $('#nik').val(nik);
            $('#title').val(title);
            $('#department').val(dept);
            $('#pos').val(position);

            $('#modal_edit_title').text('Details of ' + ename)
            $('#modal_edit').appendTo("body").modal("show");
        })

    })
</script>