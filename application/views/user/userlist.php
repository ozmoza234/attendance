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
            <div class="card-body">
                <table id="tableUser" class="table activate-select dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Adrian</td>
                            <td>coba123</td>
                            <td>
                                <span class='btn btn-danger' id='btn-del' style='cursor: pointer;'>
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                                <a href="<?= base_url() ?>User/edit">
                                    <span class='btn btn-info' id='btn-edit' style='cursor: pointer;'>
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tableUser').DataTable();
</script>