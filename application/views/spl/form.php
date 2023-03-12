<style>
    table th {
        text-align: center;
    }
</style>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employee's Overtime</h4>
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
                <button class="btn btn-primary btn-sm" id="btn_new_rekapitulasi" style="margin-bottom:1%;"><i class="fas fa-plus"></i> Overtime</button>
                <table id="tableUser" class="table activate-select dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Number</th>
                            <th>Date</th>
                            <th>Total (Rp.)</th>
                            <th>Date Created</th>
                            <th>Remarks</th>
                            <th>Approval 1</th>
                            <th>Remarks App1</th>
                            <th>Date App1</th>
                            <th>Status</th>
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
                    <div class="col-lg-6">
                        <label for="r_number">Overtime Form Number:</label>
                        <input class="form-control" type="text" name="r_number" id="r_number" value="" placeholder="e.g. 002/LOG/RHB-U5/MAR/2023" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="d_start">Date:</label>
                        <input class="form-control" type="date" name="d_start" id="d_start" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="hour">Total (Rp.):</label>
                        <input class="form-control" type="text" name="hour" id="hour" placeholder="e.g. 10.000" required>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <label for="d_end">Remarks:</label>
                        <input class="form-control" type="text" name="d_end" id="d_end" placeholder="e.g. Very Important" required>
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
                    <div class="col-12 mt-3">
                        <h3 class="text-center">Operator List</h3>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <!-- <th>Name</th> -->
                                    <th>Group</th>
                                    <th>Save</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="employee-nup" id="employee-nup" class="form-control">
                                            <option value="" class="text-center">Select Employee</option>
                                            <?php foreach ($employ->result() as $kry) { ?>
                                                <option value="<?= $kry->EmployeeID ?>"><?= $kry->NIK ?> | <?= $kry->Name ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <!-- <td>
                                        <input class="form-control" type="text" id="name-nup-employee" readonly>
                                    </td> -->
                                    <td>
                                        <input class="form-control" type="text" id="group-nup-employee" readonly>
                                    </td>
                                    <td>
                                        <input type="hidden" id="idNup">
                                        <button class="btn btn-primary text-center" id="saveOptNup"><i class="fas fa-save"></i></button>
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
<?php include APPPATH . 'views/spl/script.php' ?>