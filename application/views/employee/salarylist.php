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
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h4 class="mb-sm-0">Allowance</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="pay">Salary: </label>
                                <input type="text" class="form-control" name="pay" id="pay" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="skill">Skills: </label>
                                <input type="text" readonly class="form-control" name="skill" id="skill">
                            </div>
                            <div class="col-lg-3">
                                <label for="service">Service: </label>
                                <input type="text" readonly class="form-control" name="service" id="service">
                            </div>
                            <div class="col-lg-3">
                                <label for="etc1">Etc: </label>
                                <input type="text" readonly class="form-control" name="etc1" id="etc1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h4 class="mb-sm-0">Deductions</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="koperasi">Coperation: </label>
                                <input type="text" class="form-control" name="koperasi" id="koperasi" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="bpjs">BPJS: </label>
                                <input type="text" readonly class="form-control" name="bpjs" id="bpjs">
                            </div>
                            <div class="col-lg-3">
                                <label for="bpjstk">BPJS Tk: </label>
                                <input type="text" readonly class="form-control" name="bpjstk" id="bpjstk">
                            </div>
                            <div class="col-lg-3">
                                <label for="etc2">Etc: </label>
                                <input type="text" readonly class="form-control" name="etc2" id="etc2">
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
            let pay = tableUser.row($(this).parents('tr')).data().Salary;
            let skill = tableUser.row($(this).parents('tr')).data().Allw_Keterampilan;
            let service = tableUser.row($(this).parents('tr')).data().Allw_MasaKerja;
            let etc1 = tableUser.row($(this).parents('tr')).data().Allw_Dll;
            let koperasi = tableUser.row($(this).parents('tr')).data().Pot_Koperasi;
            let bpjs = tableUser.row($(this).parents('tr')).data().Pot_Bpjs;
            let bpjstk = tableUser.row($(this).parents('tr')).data().Pot_Bpjs_TK;
            let etc2 = tableUser.row($(this).parents('tr')).data().Pot_Dll;

            $('#nik').val(nik);
            $('#title').val(title);
            $('#department').val(dept);
            $('#pos').val(position);
            $('#pay').val(pay);
            $('#skill').val(skill);
            $('#service').val(service);
            $('#etc1').val(etc1);
            $('#koperasi').val(koperasi);
            $('#bpjs').val(bpjs);
            $('#bpjstk').val(bpjstk);
            $('#etc2').val(etc2);

            $('#modal_edit_title').text('Details of ' + ename)
            $('#modal_edit').appendTo("body").modal("show");
        })

    })
</script>