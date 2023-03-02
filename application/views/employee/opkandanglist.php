<style>
    table th {
        text-align: center;
    }
</style>
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
            <div class="card-title text-center" style="margin-top:5%;">
                <h4 class="mb-sm-0">List</h4>
            </div>
            <div class="card-body p-4">
                <button class="btn btn-primary btn-sm" id="btn-nup" style="margin-bottom:1%;"><i class="fas fa-list-ol"></i> NUP</button>
                <button class="btn btn-primary btn-sm" id="btn-rekapitulasi" style="margin-bottom:1%;"><i class="fas fa-list-ol"></i> Recapitulation</button>
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
                                <label for="skill">Skills (Rp.): </label>
                                <input type="text" class="form-control" name="skill" id="skill">
                            </div>
                            <div class="col-lg-3">
                                <label for="service">Service (Rp.): </label>
                                <input type="text" class="form-control" name="service" id="service">
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h4 class="mb-sm-0">Deductions</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3">
                                <label for="koperasi">Coperation (Rp.): </label>
                                <input type="text" class="form-control" name="koperasi" id="koperasi">
                            </div>
                            <div class="col-lg-3">
                                <label for="koperasi">PTKP: </label>
                                <select class="form-control" name="ptkp" id="ptkp">
                                    <option class="form-control text-center" value="0"> -- Select PTKP -- </option>
                                    <?php foreach ($listptkp->result() as $ptkp) { ?>
                                        <option value="<?= $ptkp->PTKPID ?>"><?= $ptkp->Description ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <label for="bpjs">BPJS: </label>
                                <input class="form-check-input" type="checkbox" id="bpjs" name="bpjs">
                            </div>
                            <div class="col-lg-2">
                                <label for="bpjstk">BPJS Tk: </label>
                                <input class="form-check-input" type="checkbox" id="bpjstk" name="bpjstk">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Salary -->

<!-- Modal NUP-->
<div class="modal fade" id="modal_nup" tabindex="-1" aria-labelledby="modal_nup" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_nup_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-sm" id="btn_new" style="margin-bottom:1%;"><i class="fas fa-plus"></i> Add New</button>
                    </div>
                    <div class="col-lg-12">
                        <table class="table table-hover" style="width:100%" id="listNup">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NUP Number</th>
                                    <th>Active</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>NUP Number</th>
                                    <th>Active</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-close-modal_nup" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal END NUP-->

<!-- Modal Create NUP-->
<div class="modal fade" id="modal_new_nup" tabindex="-1" aria-labelledby="modal_new_nup" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_new_nup_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input class="form-control" type="text" placeholder="e.g. ___/____" id="no_nup" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-close-new" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btn-save-nup" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal Create NUP-->

<!-- Modal Edit NUP -->
<div class="modal fade" id="modal_edit_nup" tabindex="-1" aria-labelledby="modal_edit_nup_Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_edit_nup_Label">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="status_nup">NUP Status: </label>
                        <select name="status_nup" id="status_nup" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
                        <input type="hidden" id="idNup">
                    </div>
                    <div class="col-6">
                        <label class='btn btn-info' style="margin-top: 30px" id="btn-edit-nup"><i class="fas fa-save"></i> Update</label>
                    </div>
                    <div class="col-12 mt-3">
                        <h3 class="text-center">Operator List</h3>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Save</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="employee-nup" id="employee-nup" class="form-control">
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="name-nup-employee" readonly>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="group-nup-employee" readonly>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" id="saveOptNup"><i class="fas fa-save"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
                        <table class="table table-hover" id="tableEmployeeNup" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close-detail-nup" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Edit NUP -->

<!-- Modal Rekapitulasi-->
<div class="modal fade" id="modal_rekapitulasi" tabindex="-1" aria-labelledby="modal_rekapitulasi" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_rekapitulasi_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-sm" id="btn_new_rekapitulasi" style="margin-bottom:1%;"><i class="fas fa-plus"></i> Add New</button>
                    </div>
                    <div class="col-lg-12">
                        <table class="table table-hover" style="width:100%" id="listRekapitulasi">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Recap Number</th>
                                    <th>Date Begin</th>
                                    <th>Date End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Recap Number</th>
                                    <th>Date Begin</th>
                                    <th>Date End</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-close-modal-rekapitulasi" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal END NUP-->

<!-- Modal Create Rekapitulasi-->
<div class="modal fade" id="modal_new_rekapitulasi" tabindex="-1" aria-labelledby="modal_new_rekapitulasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_new_rekapitulasi_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="r_number">Recapitulation Number:</label>
                        <input class="form-control" type="text" name="r_number" id="r_number" value="<?= $no ?>" readonly required>
                    </div>
                    <div class="col-lg-4">
                        <label for="d_start">Date Start:</label>
                        <input class="form-control" type="date" name="d_start" id="d_start" required>
                    </div>
                    <div class="col-lg-4">
                        <label for="d_end">Date End:</label>
                        <input class="form-control" type="date" name="d_end" id="d_end" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-close-new" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btn-save-recap" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal Create Rekapitulasi-->

<?php include APPPATH . 'views/employee/script.php' ?>