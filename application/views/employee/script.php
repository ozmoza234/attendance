<script>
    $(document).ready(function() {
        let tableUser;

        $('#vertical-menu-btn').on('click', function() {
            tableUser.columns.adjust().draw();
        });

        tableUser = $('#tableUser').DataTable({
            scrollX: true,
            scrollY: 300,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            ajax: {
                url: '<?= base_url('Employee/get_op_kandang') ?>',
                type: 'GET',
            },
            // dom: 'Bfrtip',
            // buttons: [{
            //     className: 'btn btn-success',
            //     extend: 'excelHtml5',
            //     text: '<span class="far fa-file-excel"></span>',
            //     filename: 'Daftar_Operator_Kandang',
            //     customize: function(xlsx) {
            //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
            //         $('c[r=A1] t', sheet).text('Items List');
            //     },
            // }],
            columnDefs: [{
                    targets: 0,
                    className: 'text-center',
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
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button class="btn btn-primary btn-sm" id="btn_d"><i class="mdi mdi-calendar-search"></i></button>`
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
            let pay = tableUser.row($(this).parents('tr')).data().Salary;
            let valMasked = $('#pay').masked(pay);
            let pjk = tableUser.row($(this).parents('tr')).data().PTKPID;
            let skill = tableUser.row($(this).parents('tr')).data().Allw_Keterampilan;
            let service = tableUser.row($(this).parents('tr')).data().Allw_MasaKerja;
            let etc1 = tableUser.row($(this).parents('tr')).data().Allw_Dll;
            let koperasi = tableUser.row($(this).parents('tr')).data().Pot_Koperasi;
            let bpjs = $('#bpjs');
            if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs == 'F') {
                bpjs.prop('checked', false);
            } else if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs == 'T') {
                bpjs.prop('checked', true);
            }
            let bpjstk = $('#bpjstk');
            if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs_TK == 'F') {
                bpjstk.prop('checked', false)
            } else if (tableUser.row($(this).parents('tr')).data().Pot_Bpjs_TK == 'T') {
                bpjstk.prop('checked', true)
            }
            let etc2 = tableUser.row($(this).parents('tr')).data().Pot_Dll;
            let ump_id = tableUser.row($(this).parents('tr')).data().UMP;
            let ptkp_id = tableUser.row($(this).parents('tr')).data().PTKPID;

            let select_ump = $(`#ump option[value=${ump_id}]`);
            let select_ptkp = $(`#ptkp option[value=${ptkp_id}]`);
            select_ump.prop('selected', true);
            select_ptkp.prop('selected', true);
            $('#nik').val(nik);
            $('#title').val(title);
            $('#department').val(dept);
            $('#pos').val(position);
            $('#pay').val(valMasked);
            $('#skill').val(skill);
            $('#service').val(service);
            $('#etc1').val(etc1);
            $('#koperasi').val(koperasi);
            $('#etc2').val(etc2);
            $('#ptkp').val(pjk);

            $('#modal_edit_title').text('Details of ' + ename)
            $('#modal_edit').appendTo("body").modal("show");
        });

        $('#ump').on('change', function() {
            if ($(this).val() == 0) {
                $('#pay').prop("readonly", false);
                $('#pay').val(0);
            } else if ($(this).val() != "") {
                $('#pay').prop("readonly", true);
                let umpid = $(this).val();
                let umpval = $.ajax({
                    url: '<?= base_url('Ump/get_ump_by_id') ?>',
                    data: {
                        umpid: umpid
                    },
                    type: 'GET',
                    dataType: 'json'
                });
                $.when(umpval).done(function(umpvalr) {
                    let valMasked = $('#pay').masked(umpvalr.data[0].UMP);
                    $('#pay').val(valMasked);
                })
            }
        });

        $('#modal_edit').on('hidden.bs.modal', function(e) {
            $('#ump').val('0');
        });

        $('#pay').mask('000.000.000', {
            reverse: true
        });

        $('#skill').mask('000.000.000', {
            reverse: true
        });

        $('#service').mask('000.000.000', {
            reverse: true
        });

        $('#kperasi').mask('000.000.000', {
            reverse: true
        });

        $('#pay').on('keyup', function() {
            console.log($(this).cleanVal())
        });

        let table_listNup;
        table_listNup = $('#listNup').DataTable();

        $('#btn-nup').on('click', function() {
            $('#modal_nup_title').text('NUP');
            $('#modal_nup').prependTo("body").modal("show");
            $('#listNup').DataTable().destroy();

            table_listNup = $('#listNup').DataTable({
                autowidth: false,
                destroy: true,
                // scrollX: true,
                // scrollY: 300,
                // scrollCollapse: true,
                // fixedColumns: {
                //     left: 1,
                //     right: 1
                // },
                ajax: {
                    url: '<?= base_url('Employee/get_nup') ?>',
                    dataType: 'json'
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
                        className: 'text-center',
                        data: 'nup_number'
                    },
                    {
                        targets: 2,
                        className: 'text-center',
                        data: 'is_active',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return 'Active'
                            } else if (data == 0) {
                                return 'Not Active'
                            }
                        }
                    },
                    {
                        targets: 3,
                        className: 'text-center',
                        data: 'date_created'
                    },
                    {
                        targets: 4,
                        className: 'text-center',
                        data: null,
                        render: function(data, rype, row) {
                            return `<label class='btn btn-info btn-sm' id="btneditnup"><i class="fas fa-pencil-alt"></i></label>`
                        }
                    },
                ]
            });

            table_listNup.columns.adjust().draw();
        });

        $('#btn_new').on('click', function() {
            $('#modal_nup').modal("hide");
            $('#modal_new_nup_title').text('Create New NUP');
            $('#modal_new_nup').prependTo("body").modal("show");
        });

        $('#modal_new_nup').on('hidden.bs.modal', function() {
            $('#modal_nup_title').text('NUP List');
            $('#modal_nup').prependTo("body").modal("show");
        });

        $('#no_nup').mask('00A/0000');

        $('#btn-save-nup').on('click', function() {
            let no_nup = $('#no_nup').val();
            if (no_nup == "") {
                'Warning!',
                'NUP Number Still Empty',
                'warning'
            }
            else {
                $.ajax({
                    url: '<?= base_url('Employee/save_nup') ?>',
                    data: {
                        no_nup
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data Has Been Saved!',
                            icon: 'success'
                        });
                        table_listNup.ajax.reload();
                        $('#no_nup').val("");
                        $('#btn-close-new').click();
                    }
                })
            }
        });

        $('#listNup tbody').on('click', '#btneditnup', function() {
            $('#btn-close-modal_nup').click();
            $('#tableEmployeeNup').DataTable().destroy();

            let id = table_listNup.row($(this).parents('tr')).data().id;
            let no = table_listNup.row($(this).parents('tr')).data().nup_number;
            let is_active = table_listNup.row($(this).parents('tr')).data().is_active;

            if (is_active == 0) {
                $('#employee-nup').prop('disabled', true);
            } else {
                $('#employee-nup').prop('disabled', false);
            }

            tableEmployeeNup = $('#tableEmployeeNup').DataTable({
                autowidth: false,
                destroy: true,
                // scrollX: true,
                // scrollY: 300,
                // scrollCollapse: true,
                // fixedColumns: {
                //     left: 1,
                //     right: 1
                // },
                ajax: {
                    url: '<?= base_url('Employee/load_emp_to_nup') ?>',
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
            let default_status = $(`#status_nup option[value=${is_active}]`);
            default_status.prop('selected', true);

            $('#modal_edit_nup_Label').text('Detail of ' + no);
            $('#modal_edit_nup').prependTo("body").modal("show");
        });

        $('#modal_edit_nup').on('hidden.bs.modal', function() {
            $('#modal_nup').prependTo("body").modal("show");
            $('#employee-nup').val('');
            $('#name-nup-employee').val('');
            $('#group-nup-employee').val('');
        });

        $('#btn-edit-nup').on('click', function() {
            let new_status = $('#status_nup').val();
            let id_nup = $('#idNup').val();

            if (new_status == "0") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    html: '<p>' + 'Are you sure?' + '<br>' + "this action also deleted all employee list inside NUP" + '</p>',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then(function(result) {
                    if (result.value) {
                        update_nup(id_nup, new_status);
                    }
                })
            } else {
                update_nup(id_nup, new_status);
            }

            function update_nup(id_nup, new_status) {
                $.ajax({
                    url: '<?= base_url('Employee/update_nup') ?>',
                    data: {
                        id: id_nup,
                        is_active: new_status
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data Has Been Updated!',
                            icon: 'success'
                        });
                        $('#btn-close-detail-nup').click();
                        table_listNup.ajax.reload();
                        tableEmployeeNup.ajax.reload();
                        $('#employee-nup').empty();
                        get_list_opt();
                    }

                })
            }

        });

        $("#employee-nup").change(function() {
            let EmployeeID = $(this).val()
            console.log(EmployeeID);
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
            let EmployeeID = $('#employee-nup').val();
            let id = $('#idNup').val();
            $.ajax({
                url: '<?php echo site_url("Employee/save_emp_for_nup"); ?>',
                data: {
                    'id': id,
                    'EmployeeID': EmployeeID
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
                        $('#employee-nup').val("");
                        $('#name-nup-employee').val("");
                        $('#group-nup-employee').val("");
                        $('#employee-nup').empty();
                        get_list_opt();
                        // $('#employee-nup').children(`option[value="${EmployeeID}"]`).remove();
                    })
                }
            });
        });

        function get_list_opt() {
            let query = $.ajax({
                url: '<?= base_url('Employee/load_opt_kdg') ?>',
                dataType: 'json'
            });
            $('#employee-nup').prepend(`<option value="" class="text-center">-- Select --</option>`);
            $.when(query).done(function(queryAppend) {
                $.each(queryAppend, function(i, item) {
                    $('#employee-nup').append(`<option value="${item.EmployeeID}">${item.NIK}</option>`)
                })
            });
        }

        get_list_opt();

        let tableEmployeeNup;
        tableEmployeeNup = $('#tableEmployeeNup').DataTable();

        $('#tableEmployeeNup tbody').on('click', '#btndeleteemp', function() {
            let id_nup = tableEmployeeNup.row($(this).parents('tr')).data().id_nup;
            let id_employee = tableEmployeeNup.row($(this).parents('tr')).data().id_employee;

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
                        url: '<?= base_url('Employee/del_from_nup') ?>',
                        type: 'POST',
                        data: {
                            id_nup: id_nup,
                            id_employee: id_employee
                        },
                        success: function(data) {
                            Swal.fire('Success!', 'Data Deleted', 'success').then(function() {
                                tableEmployeeNup.ajax.reload();
                                $('#employee-nup').val("");
                                $('#name-nup-employee').val("");
                                $('#group-nup-employee').val("");
                                $('#employee-nup').empty();
                                get_list_opt();
                            })
                        }
                    })
                }
            })
        });

        $('#btn-rekapitulasi').on('click', function() {
            $('#listRekapitulasi').DataTable().destroy();
            listRekapitulasi = $('#listRekapitulasi').DataTable({
                autowidth: false,
                destroy: true,
                // scrollX: true,
                // scrollY: 300,
                // scrollCollapse: true,
                // fixedColumns: {
                //     left: 1,
                //     right: 1
                // },
                ajax: {
                    url: '<?= base_url('Employee/get_data_recap') ?>',
                    dataType: 'json'
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
                        className: 'text-center',
                        data: 'number'
                    },
                    {
                        targets: 2,
                        className: 'text-center',
                        data: 'date_start'
                    },
                    {
                        targets: 3,
                        className: 'text-center',
                        data: 'date_end'
                    },
                    {
                        targets: 4,
                        className: 'text-center',
                        data: null,
                        render: function(data, rype, row) {
                            return `<label class='btn btn-info btn-sm' id="btneditrecap"><i class="fas fa-pencil-alt"></i></label>  <label class="btn btn-info btn-sm sum" id="btn-sum-1"><i class="fas fa-eye"></i></label> <label class='btn btn-sm btn-danger' id="btndelrecap"><i class="fas fa-trash-alt"></i></label>`
                        }
                    },
                ]
            });

            $('#modal_rekapitulasi_title').text('Recapitulation Operator Kandang');
            $('#modal_rekapitulasi').prependTo("body").modal("show");
        });

        $('#listRekapitulasi tbody').on('click', '#btndelrecap', function() {
            let id = listRekapitulasi.row($(this).parents('tr')).data().id;
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
                        url: '<?= base_url('Employee/del_recap') ?>',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire('Success!', 'Data Deleted', 'success').then(function() {
                                listRekapitulasi.ajax.reload();
                            })
                        }
                    })
                }
            })
        });

        let table_rekap_opkdg;
        table_rekap_opkdg = $('#table-rekap_opkdg').DataTable();

        $('#listRekapitulasi tbody').on('click', '#btneditrecap', function() {
            $('#table-rekap_opkdg').DataTable().destroy();

            let id = listRekapitulasi.row($(this).parents('tr')).data().id;
            let number = listRekapitulasi.row($(this).parents('tr')).data().number;
            let date_start = listRekapitulasi.row($(this).parents('tr')).data().date_start;
            let date_end = listRekapitulasi.row($(this).parents('tr')).data().date_end;
            let date_created = listRekapitulasi.row($(this).parents('tr')).data().date_created;
            let date_modified = listRekapitulasi.row($(this).parents('tr')).data().date_modified;

            $('#r_number_view').val(date_created);
            $('#d_start_view').val(date_start);
            $('#d_end_view').val(date_end);
            $('#d_modif_view').val(date_modified);
            $('#modal_rekapitulasi').modal("hide");

            table_rekap_opkdg = $('#table-rekap_opkdg').DataTable({
                scrollX: true,
                scrollY: 300,
                scrollCollapse: true,
                fixedColumns: {
                    left: 1,
                    right: 1
                },
                ajax: {
                    url: '<?= base_url('Employee/load_rekap_op_kdg') ?>',
                    type: 'POST',
                    data: {
                        date_start: date_start,
                        date_end: date_end
                    }
                },
                columnDefs: [{
                        targets: 0,
                        'data': null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: 1,
                        'data': 'nup_number'
                    },
                    {
                        targets: 2,
                        'data': 'NIK'
                    },
                    {
                        targets: 3,
                        'data': 'Name'
                    },
                    {
                        targets: 8,
                        'data': 'Salary',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                        }
                    },
                    {
                        targets: 4,
                        className: 'text-center',
                        'data': 'days_in_month'
                    },
                    {
                        targets: 5,
                        className: 'text-center',
                        'data': 'present'
                    },
                    {
                        targets: 6,
                        className: 'text-center',
                        'data': null,
                        render: function(data, type, row) {
                            return row.days_in_month - row.present
                        }
                    },
                    {
                        targets: 7,
                        'data': null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `<label class="btn btn-info btn-sm sum" id="btn-sum"><i class="fas fa-eye"></i></label>`
                        }
                    },
                    {
                        targets: 9,
                        'data': 'lembur',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data == null) {
                                return `<input type="number" class="form-control" value="0" disabled>`
                            } else {
                                return `<input type="text" class="form-control" value="${parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")}" disabled>`
                            }

                        }
                    },
                    {
                        targets: 10,
                        className: 'text-center',
                        'data': 'pot_jht',
                        render: function(data, type, row) {
                            if (data == 0) {
                                return 0
                            } else {
                                return parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                            }
                        }
                    },
                    {
                        targets: 11,
                        className: 'text-center',
                        'data': 'pot_jp',
                        render: function(data, type, row) {
                            if (data == 0) {
                                return 0
                            } else {
                                return parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                            }
                        }
                    },
                    {
                        targets: 12,
                        className: 'text-center',
                        'data': 'pot_bpjs',
                        render: function(data, type, row) {
                            if (data == 0) {
                                return 0
                            } else {
                                return parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                            }

                        }
                    },
                    {
                        targets: 13,
                        'data': null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return `<input type="text" class="form-control" value="0" id="pot_tidak_masuk${meta.row + meta.settings._iDisplayStart + 1}" placeholder="e.g 10.000">`
                        }
                    },
                    {
                        targets: 14,
                        'data': null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            if (row.Salary > 500000) {
                                if (row.lembur == null) {
                                    return `<input type="text" id="total${meta.row + meta.settings._iDisplayStart + 1}" class="form-control total" value="${parseFloat(row.Salary - row.pot_jht - row.pot_jp - row.pot_bpjs).toFixed(2)}" disabled> <input type="hidden" id="default${meta.row + meta.settings._iDisplayStart + 1}" class="form-control default" value="${parseFloat(row.Salary - row.pot_jht - row.pot_jp - row.pot_bpjs).toFixed(2)}" disabled>`
                                } else {
                                    return `<input type="text" id="total${meta.row + meta.settings._iDisplayStart + 1}" class="form-control total" value="${parseFloat(row.Salary - row.pot_jht - row.pot_jp - row.pot_bpjs + parseInt(row.lembur)).toFixed(2)}" disabled> <input type="hidden" id="default${meta.row + meta.settings._iDisplayStart + 1}" class="form-control default" value="${parseFloat(row.Salary - row.pot_jht - row.pot_jp - row.pot_bpjs + parseInt(row.lembur)).toFixed(2)}" disabled>`
                                }

                            } else {
                                if (row.Salary * row.present == 0) {
                                    return `<input type="text" id="total${meta.row + meta.settings._iDisplayStart + 1}" class="form-control" value="0" disabled> <input type="hidden" id="default${meta.row + meta.settings._iDisplayStart + 1}" class="form-control default" value="0" disabled>`
                                } else {
                                    return `<input type="text" id="total${meta.row + meta.settings._iDisplayStart + 1}" class="form-control total" value="${parseFloat(row.Salary * row.present).toFixed(2)}" disabled> <input type="hidden" id="default${meta.row + meta.settings._iDisplayStart + 1}" class="form-control default" value="${parseFloat(row.Salary * row.present).toFixed(2)}" disabled>`
                                }

                            }

                        }
                    },
                ],
                initComplete: function() {
                    const inputFieldNumber = document.querySelectorAll('input[type=text]');

                    inputFieldNumber.forEach(function(input) {
                        input.addEventListener('keyup', function(e) {
                            if (e.target.value == '') {
                                e.target.value = '0'
                            }
                        })
                    });
                    let data = table_rekap_opkdg.rows().data().toArray();
                    let increment = 0;
                    $.each(data, function(i, item) {
                        increment++
                        let b_total = parseInt($(`#total${increment}`).val());
                        $(`#total${increment}`).val(b_total);
                        let total = $(`#total${increment}`).val()
                        $(`#total${increment}`).mask('000.000.000', {
                            reverse: true
                        });
                        $(`#pot_tidak_masuk${increment}`).mask('000.000.000', {
                            reverse: true
                        });
                        $(`#total${increment}`).masked(total);
                        $(`#pot_tidak_masuk${increment}`).on('keyup', function() {
                            let input = parseInt($(this).cleanVal());
                            let idSelisih = $(this).closest('tr').find('.total').attr('id');
                            $(`#${idSelisih}`).mask('000.000.000', {
                                reverse: true
                            });
                            let idDefault = $(this).closest('tr').find('.default').attr('id');
                            let tgtt = parseInt($(`#${idSelisih}`).val());
                            let tgt = parseInt($(`#${idSelisih}`).cleanVal());
                            const oriTgt = parseInt($(`#${idDefault}`).val());
                            let rumus = oriTgt - input;
                            if (input == 0) {
                                $(`#${idSelisih}`).val(oriTgt);
                                let total1 = $(`#${idSelisih}`).val()
                                let valMask = $(`#${idSelisih}`).masked(total1);
                                let negative = '-' + valMask;
                                if (total1 < 0) {
                                    $(`#${idSelisih}`).val(negative);
                                } else {
                                    $(`#${idSelisih}`).val(valMask);
                                }
                            } else {
                                $(`#${idSelisih}`).val(rumus);
                                let total1 = $(`#${idSelisih}`).val()
                                let valMask = $(`#${idSelisih}`).masked(total1);
                                let negative = '-' + valMask;
                                if (total1 < 0) {
                                    $(`#${idSelisih}`).val(negative);
                                } else {
                                    $(`#${idSelisih}`).val(valMask);
                                }
                            }
                        });
                    });
                    table_rekap_opkdg.columns.adjust().draw();
                },
            });

            $('#modal_view_rekapitulasi_title').text('Detail of ' + number);
            $('#modal_view_rekapitulasi').prependTo("body").modal("show");
        });

        $('#table-rekap_opkdg tbody').on('click', '#btn-sum', function() {
            let EmployeeID = table_rekap_opkdg.row($(this).parents('tr')).data().EmployeeID;
            let date_begin = $('#d_start_view').val();
            let date_end = $('#d_end_view').val();
            console.log(EmployeeID, date_begin, date_end)

            $('#table_edit_header_').DataTable().destroy();
            $('#table_edit_header_').DataTable({
                autoWidth: false,
                paging: false,
                ajax: {
                    url: '<?= base_url('Attendance/detailss') ?>',
                    data: {
                        EmployeeID: EmployeeID,
                        date_begin: date_begin,
                        date_end: date_end,
                    },
                    type: 'GET',
                    dataType: 'json'
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
                        data: 'Name'
                    },
                    {
                        targets: 2,
                        data: 'DAY'
                    },
                    {
                        targets: 3,
                        data: 'date'
                    },
                    {
                        targets: 4,
                        data: 'time_in'
                    },
                    {
                        targets: 5,
                        data: 'time_out'
                    },
                    {
                        targets: 6,
                        data: 'total'
                    },
                    {
                        targets: 7,
                        data: 'difference'
                    },
                    {
                        targets: 8,
                        data: 'WorkHourDesc'
                    }
                ]
            });

            var date = new Date();
            console.log(date.toDateString())
            var monthh = date.getMonth() + 1;
            date.setDate(1);
            var all_days = [];
            while (date.getMonth() + 1 == monthh) {
                var d = date.getFullYear() + '-' + date.getMonth().toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                all_days.push(d);
                date.setDate(date.getDate() + 1);
            }

            $('#modal_edit_title_').text('Details from ' + EmployeeID);
            $('#modal_edit_').appendTo("body").modal("show");

        })

        let listRekapitulasi;
        listRekapitulasi = $('#listRekapitulasi').DataTable();

        $('#btn_new_rekapitulasi').on('click', function() {
            $('#modal_rekapitulasi').modal("hide");
            $('#modal_new_rekapitulasi_title').text('Create New Recapitulation');
            $('#modal_new_rekapitulasi').prependTo("body").modal("show");
        });

        $('#modal_new_rekapitulasi').on('hidden.bs.modal', function() {
            $('#modal_rekapitulasi').prependTo("body").modal("show");
        });

        $('#modal_view_rekapitulasi').on('hidden.bs.modal', function() {
            $('#modal_rekapitulasi').prependTo("body").modal("show");
        });

        $('#btn-save-recap').on('click', function() {
            let number = $('#r_number');
            let date_start = $('#d_start');
            let date_end = $('#d_end');

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
            } else if (date_start.val() == "") {
                Swal.fire(

                    'Warning!',
                    "Please input begin date",
                    "warning"
                )
            } else if (date_end.val() == "") {
                Swal.fire(
                    'Warning!',
                    "Please input end date",
                    "warning"
                )
            } else {
                $.ajax({
                    url: '<?= base_url('Employee/insert_new_recap') ?>',
                    type: 'POST',
                    data: {
                        number: number.val(),
                        date_start: date_start.val(),
                        date_end: date_end.val(),
                        date_created: timeNow,
                        date_modified: timeNow,
                    },
                    success: function(data) {
                        Swal.fire('Success!', 'Data Saved', 'success').then(function() {
                            listRekapitulasi.ajax.reload();
                            number.val("");
                            date_start.val("");
                            date_end.val("");
                            $('#btn-close-new').click();
                        })
                    }
                })
            }
        })
    })
</script>