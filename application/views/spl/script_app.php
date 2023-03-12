<script>
    $(document).ready(function() {
        let listRekapitulasi;
        listRekapitulasi = $('#tableUser').DataTable({
            scrollX: true,
            scrollY: 300,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            ajax: {
                url: '<?= base_url('Spl/list') ?>',
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
                    'data': 'number'
                },
                {
                    targets: 2,
                    'data': 'date'
                },
                {
                    targets: 3,
                    'data': 'hour',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                    }
                },
                {
                    targets: 4,
                    'data': 'date_created'
                },
                {
                    targets: 5,
                    'data': 'remarks'
                },
                {
                    targets: 6,
                    'data': 'approval_1',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data == 0) {
                            return `<button class="btn btn-primary btn-sm">Waiting</button>`
                        } else if (data == 1) {
                            return `<button class="btn btn-success btn-sm">Approved</button>`
                        } else {
                            return `<button class="btn btn-danger btn-sm">Declined</button>`
                        }
                    }
                },
                {
                    targets: 7,
                    'data': 'remarks_app1',
                    className: 'text-center'
                },
                {
                    targets: 8,
                    'data': 'date_app_1',
                    className: 'text-center'
                },
                {
                    targets: 9,
                    'data': 'status',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data == 0) {
                            return `<button class="btn btn-primary btn-sm">Waiting</button>`
                        } else if (data == 1) {
                            return `<button class="btn btn-success btn-sm">Approved</button>`
                        } else {
                            return `<button class="btn btn-danger btn-sm">Declined</button>`
                        }
                    }
                },
                {
                    targets: 10,
                    'data': null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.status == 0) {
                            return `<button class="btn btn-primary btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>  <button class="btn btn-success btn-sm" id="btn_acc"><i class="mdi mdi-check-bold"></i></button>  <button class="btn btn-danger btn-sm" id="btn_dec"><i class="mdi mdi-close"></i></button>`
                        } else {
                            return `<button class="btn btn-primary btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>`
                        }
                    }
                },
            ]
        });

        $('#tableUser tbody').on('click', '#btn_d', function() {
            $('#tableEmployeeNup').DataTable().destroy();

            let id = listRekapitulasi.row($(this).parents('tr')).data().id;
            let no = listRekapitulasi.row($(this).parents('tr')).data().number;
            let status = listRekapitulasi.row($(this).parents('tr')).data().status;

            tableEmployeeNup = $('#tableEmployeeNup').DataTable({
                autowidth: false,
                destroy: true,
                ajax: {
                    url: '<?= base_url('Spl/load_spl_to_emp') ?>',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    type: 'GET'
                },
                columnDefs: [{
                        targets: 0,
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: 1,
                        data: 'NIK'
                    },
                    {
                        targets: 2,
                        data: 'Name'
                    },
                    {
                        targets: 3,
                        data: 'GroupDesc'
                    }
                ]
            });

            setTimeout(function() {
                tableEmployeeNup.columns.adjust().draw();
            }, 500);

            $('#idNup').val(id);
            $('#modal_edit_nup_Label').text('Detail of ' + no);
            $('#modal_edit_nup').prependTo("body").modal("show");
        });

        $('#tableUser tbody').on('click', '#btn_acc', function() {
            let id = listRekapitulasi.row($(this).parents('tr')).data().id;
            let no = listRekapitulasi.row($(this).parents('tr')).data().number;
            $('#id_lembur').val(id);
            $('#status_lembur').val(1);
            $('#modal_add_remarks_label').text('Add Approval Remarks For ' + no);
            $('#modal_add_remarks').prependTo("body").modal("show");
        });

        $('#tableUser tbody').on('click', '#btn_dec', function() {
            let id = listRekapitulasi.row($(this).parents('tr')).data().id;
            let no = listRekapitulasi.row($(this).parents('tr')).data().number;
            $('#id_lembur').val(id);
            $('#status_lembur').val(2);
            $('#modal_add_remarks_label').text('Add Approval Remarks For ' + no);
            $('#modal_add_remarks').prependTo("body").modal("show");
        });

        $('#button_status').on('click', function() {
            let id = $('#id_lembur').val();
            let remarks_app1 = $('#app_remarks').val();
            let status = $('#status_lembur').val();
            let date = new Date();
            let month = date.getMonth() + 1;
            let today = date.getFullYear() + "-" + month + "-" + 0 + date.getDate();
            let now = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            let timeNow = today + " " + now;

            if (remarks_app1 == "") {
                Swal.fire(
                    'Warning!',
                    "Please input remarks",
                    "warning"
                )
            } else {
                if (status == 1) {
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure?',
                        text: "You're about to Accept this form",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!',
                        cancelButtonText: 'No!'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: '<?= base_url('Spl/acc') ?>',
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    id: id,
                                    remarks_app1: remarks_app1,
                                    status: status,
                                    date_app_1: timeNow
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Data has been approved',
                                        icon: 'success'
                                    }).then(function(data) {
                                        listRekapitulasi.ajax.reload();
                                    })
                                }
                            })
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure?',
                        text: "You're about to Decline this form",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!',
                        cancelButtonText: 'No!'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: '<?= base_url('Spl/dec') ?>',
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    id: id,
                                    remarks_app1: remarks_app1,
                                    status: status,
                                    date_app_1: timeNow
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Data has been declined',
                                        icon: 'success'
                                    }).then(function(data) {
                                        listRekapitulasi.ajax.reload();
                                    })
                                }
                            })
                        }
                    })
                }

            }
        });
    });
</script>