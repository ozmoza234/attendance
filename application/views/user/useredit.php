<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Edit User</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-3 col-md-3 d-flex">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User Picture</h4>
                <div class="text-center">
                    <img id="output1" style="width: 150px; height: 150px;" src="<?= base_url() ?>assets/img/profile_pic/no-foto.png" />
                </div>
                <div class="input-group">
                    <input type="file" class="form-control" id="customFile">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-md-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User Profile</h4>
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Full Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="e.g. Adrian Hadinata" id="example-text-input">
                    </div>
                </div>
                <!-- end row -->
                <div class="row mb-3">
                    <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" placeholder="e.g. adrianhhd@gmail.com" id="example-email-input">
                    </div>
                </div>
                <!-- end row -->
                <div class="row mb-3">
                    <label for="example-tel-input" class="col-sm-2 col-form-label">Telephone</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="tel" placeholder="e.g. 085802520642" id="example-tel-input">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>