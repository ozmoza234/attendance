<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employee's Overtime Approval</h4>
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
<!-- End Main Content -->

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
                    <div class="col-12 mt-3">
                        <table class="table table-hover" id="tableEmployeeNup" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Group</th>
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

<!-- Modal Remarks -->
<div class="modal fade" id="modal_add_remarks" tabindex="-1" aria-labelledby="modal_add_remarks_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_remarks_label">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <label for="app_remarks">Remarks:</label>
                    <input class="form-control" type="text" name="app_remarks" id="app_remarks" placeholder="e.g. Overtime approved with condition">
                    <input class="form-control" type="hidden" name="id_lembur" id="id_lembur">
                    <input class="form-control" type="hidden" name="status_lembur" id="status_lembur">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close-detail-nup" data-bs-dismiss="modal">Close</button>
                <button type="button" id="button_status" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Remarks -->

<?php include APPPATH . 'views/spl/script_app.php' ?>