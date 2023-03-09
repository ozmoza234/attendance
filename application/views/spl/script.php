<script>
    $(document).ready(function() {
        $('#r_number').mask('000/AAA/AAA-AA/AAA/0000');
        $('#hour').mask('000.000.000', {
            reverse: true
        });

        $('#hour').on('keyup', function() {
            console.log($(this).cleanVal())
        })

        $('#btn_new_rekapitulasi').on('click', function() {
            $('#modal_new_rekapitulasi_title').text('Create New Form');
            $('#modal_new_rekapitulasi').prependTo("body").modal("show");
        });

        $('#vertical-menu-btn').on('click', function() {
            listRekapitulasi.columns.adjust().draw();
        });

        let tableEmployeeNup;
        tableEmployeeNup = $('#tableEmployeeNup').DataTable();

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
                    },
                    {
                        targets: 4,
                        data: null,
                        className: 'text-center',
                        render: function(type, data, row) {
                            return `<label class='btn btn-danger btn-sm' id="btndeleteemp"><i class="fas fa-times"></i></label>`
                        }
                    },
                ]
            });

            setTimeout(function() {
                tableEmployeeNup.columns.adjust().draw();
            }, 500);

            $('#idNup').val(id);
            $('#modal_edit_nup_Label').text('Detail of ' + no);
            $('#modal_edit_nup').prependTo("body").modal("show");
        });

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
                    targets: 8,
                    'data': null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button class="btn btn-primary btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>  <button class="btn btn-danger btn-sm" id="btn_del"><i class="mdi mdi-trash-can-outline"></i></button>`
                    }
                },
            ]
        });

        $('#btn-save-recap').on('click', function() {
            let number = $('#r_number');
            let date_ot = $('#d_start');
            let remarks = $('#d_end');
            let hour = $('#hour');

            let date = new Date();
            let month = date.getMonth() + 1;
            let today = date.getFullYear() + "-" + month + "-" + 0 + date.getDate();
            let now = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            let timeNow = today + " " + now;

            if (number.val() == "") {
                Swal.fire(
                    'Warning!',
                    "Please contact Administrator",
                    "warning"
                )
            } else if (date_ot.val() == "") {
                Swal.fire(
                    'Warning!',
                    "Please input overtime date",
                    "warning"
                )
            } else if (remarks.val() == "") {
                Swal.fire(
                    'Warning!',
                    "Please input remarks",
                    "warning"
                )
            } else if (hour.val() == "") {
                Swal.fire(
                    'Warning!',
                    "Please input hour",
                    "warning"
                )
            } else {
                $.ajax({
                    url: '<?= base_url('Spl/insert_new_overtime') ?>',
                    type: 'POST',
                    data: {
                        number: number.val(),
                        date: date_ot.val(),
                        remarks: remarks.val(),
                        hour: parseFloat(hour.cleanVal()),
                        date_created: timeNow,
                        date_modified: timeNow,
                        status: 0
                    },
                    success: function(data) {
                        Swal.fire('Success!', 'Data Saved', 'success').then(function() {
                            listRekapitulasi.ajax.reload();
                            number.val("");
                            date_ot.val("");
                            remarks.val("");
                            $('#btn-close-new').click();
                        })
                    }
                })
            }
        });

        $("#employee-nup").change(function() {
            let EmployeeID = $(this).val()
            $.ajax({
                url: '<?php echo site_url("Employee/load_op_by_id"); ?>',
                data: {
                    'EmployeeID': EmployeeID
                },
                dataType: 'json',
                type: 'GET',
            }).done(function(data) {
                $('#name-nup-employee').val(data[0].ename);
                $('#group-nup-employee').val(data[0].GroupDesc);
            });
        });

        $('#saveOptNup').on('click', function() {
            let date = new Date();
            let month = date.getMonth() + 1;
            let today = date.getFullYear() + "-" + month + "-" + 0 + date.getDate();
            let now = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            let timeNow = today + " " + now;
            let EmployeeID = $('#employee-nup').val();
            let id = $('#idNup').val();
            $.ajax({
                url: '<?php echo site_url("Spl/save_detail"); ?>',
                data: {
                    'id': id,
                    'EmployeeID': EmployeeID,
                    'date': timeNow
                },
                dataType: 'json',
                type: 'GET',
                success: function(result) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Data Has Been Saved!',
                        icon: 'success'
                    }).then(function() {
                        tableEmployeeNup.ajax.reload();
                        listRekapitulasi.ajax.reload();
                        $('#employee-nup').val("");
                        $('#name-nup-employee').val("");
                        $('#group-nup-employee').val("");
                    })
                }
            });
        });

        $('#tableUser tbody').on('click', '#btn_del', function() {
            id = listRekapitulasi.row($(this).parents('tr')).data().id;
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                html: '<p>' + 'Are you sure?' + '<br>' + "this action can't be undo" + '</p>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'No',
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '<?= base_url('Spl/del') ?>',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire('Success!', 'Data Deleted', 'success').then(function() {
                                listRekapitulasi.ajax.reload()
                            })
                        }
                    })
                }
            })
        });


    })
</script>