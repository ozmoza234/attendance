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
                            <th>Group</th>
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

<!-- Modal Salary -->
<div class="modal fade" id="modal_edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <h2 class="modal-title" id="modal_edit_title"></h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 p-4" style="overflow:auto;">
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
                        <div class="row mt-4">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h4 class="mb-sm-0">Allowance</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3">
                                <label for="ump">UMP: </label>
                                <select class="form-control" name="ump" id="ump">
                                    <option class="form-control text-center" value="0"> -- Select UMP -- </option>
                                    <?php foreach ($listump->result() as $ump) { ?>
                                        <option value="<?= $ump->UmpID ?>"><?= $ump->PeriodeUMP ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="pay">Salary (Rp.): </label>
                                <input type="text" class="form-control" name="pay" id="pay" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="skill">Skills: </label>
                                <input type="text" class="form-control" name="skill" id="skill">
                            </div>
                            <div class="col-lg-3">
                                <label for="service">Service: </label>
                                <input type="text" class="form-control" name="service" id="service">
                            </div>
                            <div class="col-lg-3">
                                <label for="etc1">Etc: </label>
                                <input type="text" class="form-control" name="etc1" id="etc1">
                            </div>
                            <div class="col-lg-9">
                                <label for="etc1">Remarks: </label>
                                <input type="text" class="form-control" name="etc1" id="etc1">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h4 class="mb-sm-0">Deductions</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3">
                                <label for="koperasi">Coperation: </label>
                                <input type="text" class="form-control" name="koperasi" id="koperasi" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="bpjs">BPJS: </label>
                                <input class="form-check-input" type="checkbox" id="bpjs" name="bpjs">
                                <label for="bpjstk">BPJS Tk: </label>
                                <!-- <input type="text" readonly class="form-control" name="bpjstk" id="bpjstk"> -->
                                <input class="form-check-input" type="checkbox" id="bpjstk" name="bpjstk">
                            </div>
                            <div class="col-lg-3">
                                
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
<!-- End Modal Salary -->

<script>
    $(document).ready(function() {
        let tableUser;

        tableUser = $('#tableUser').DataTable({
            autoWidth: false,
            ajax: {
                url: '<?= base_url('Employee/get_op_kandang') ?>',
                type: 'GET',
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
                    'data': 'NIK'
                },
                {
                    targets: 2,
                    'data': 'ename'
                },
                {
                    targets: 3,
                    'data': 'DepartmentDesc'
                },
                {
                    targets: 4,
                    'data': 'PositionDesc'
                },
                {
                    targets: 5,
                    'data': 'TitleDesc'
                },
                {
                    targets: 6,
                    'data': 'GroupDesc'
                },
                {
                    targets: 7,
                    'data': null,
                    render: function(data, type, row) {
                        return `<button class="btn btn-primary btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button><button class="btn btn-info btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button><button class="btn btn-success btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>`
                    }
                },
            ]
        });

        let load_details;

        $('#load_details').DataTable();

        $('#tableUser tbody').on('click', '#btn_d', function() {
            let id = tableUser.row($(this).parents('tr')).data().EmployeeID;
            let nik = tableUser.row($(this).parents('tr')).data().NIK;
            let ename = tableUser.row($(this).parents('tr')).data().ename;
            let position = tableUser.row($(this).parents('tr')).data().PositionDesc;
            let dept = tableUser.row($(this).parents('tr')).data().DepartmentDesc;
            let title = tableUser.row($(this).parents('tr')).data().TitleDesc;
            let salary = tableUser.row($(this).parents('tr')).data().Salary
            let skills = tableUser.row($(this).parents('tr')).data().Allw_Keterampilan;
            let post = tableUser.row($(this).parents('tr')).data().Allw_Jabatan;
            let pay = parseFloat(tableUser.row($(this).parents('tr')).data().Salary).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            let skill = tableUser.row($(this).parents('tr')).data().Allw_Keterampilan;
            let service = tableUser.row($(this).parents('tr')).data().Allw_MasaKerja;
            let etc1 = tableUser.row($(this).parents('tr')).data().Allw_Dll;
            let koperasi = tableUser.row($(this).parents('tr')).data().Pot_Koperasi;
            let bpjs = $('#bpjs');
            if(tableUser.row($(this).parents('tr')).data().Pot_Bpjs == 'F') {
                bpjs.prop('checked', false);
            } else if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs == 'T')
            {
                bpjs.prop('checked', true);
            }
            let bpjstk = $('#bpjstk');
            if(tableUser.row($(this).parents('tr')).data().Pot_Bpjs_TK == 'F') {
                bpjstk.prop('checked', false)
            } else if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs_TK == 'T')
            {
                bpjstk.prop('checked', true)
            }
            let etc2 = tableUser.row($(this).parents('tr')).data().Pot_Dll;
            let ump_id = tableUser.row($(this).parents('tr')).data().UMP;
            console.log(ump_id);
            let select_ump = $(`#ump option[value=${ump_id}]`);
            select_ump.prop('selected',true);
            $('#nik').val(nik);
            $('#title').val(title);
            $('#department').val(dept);
            $('#pos').val(position);
            $('#pay').val(pay);
            $('#skill').val(skill);
            $('#service').val(service);
            $('#etc1').val(etc1);
            $('#koperasi').val(koperasi);
            // $('#bpjs').val(bpjs);
            // $('#bpjstk').val(bpjstk);
            $('#etc2').val(etc2);

            $('#modal_edit_title').text('Details of ' + ename)
            $('#modal_edit').appendTo("body").modal("show");
        });

        $('#ump').on('change',function(){
            if ($(this).val() == "") {
                $('#pay').prop("readonly",false);
            } else if ($(this).val() != "") {
                $('#pay').prop("readonly",true);
                console.log($(this).val())
                // $.ajax({

                // })
            }
        });

        $('#modal_edit').on('hidden.bs.modal', function (e) {
            $('#ump').val('0')
        });

    })
</script>