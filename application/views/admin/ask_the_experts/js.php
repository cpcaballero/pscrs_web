<script>
    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var expert_table = $('#expert_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    var users_table = $('#users_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    get_expert();
    get_users();



    function get_expert() {
        $.ajax({
            type: "get",
            url: base_url + "api/user/Users",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    experts = res.success.data;
                    var counter = 1;
                    expert_table.clear().draw();

                    experts.forEach(element => {
                        if (element.is_expert == 1 && element.id != active_user) {
                            expert_table.row.add([
                                element.fullname,
                                element.field_study,
                                element.contact_number,
                                element.email_address,
                                element.last_login,
                                '<a href="' + base_url + 'Admin_FE/ask_the_experts_view/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                                '<a href="' + base_url + 'Admin_FE/member_settings_update/' + element.id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;'
                            ]).draw(false);
                        }
                    });
                } else {
                    expert_table.clear().draw();
                }

            }
        });
    }

    function get_users() {
        $.ajax({
            type: "get",
            url: base_url + "api/user/Users",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    users = res.success.data;
                    var counter = 1;
                    users_table.clear().draw();
                    var thumbnail;
                    users.forEach(element => {
                        if (element.profile_thumb) {
                            thumbnail = '<img src ="' + element.profile_thumb + '">';
                        } else {
                            thumbnail = '<img width="80px" src ="<?= base_url() . 'assets/images/avatar.png' ?>">';
                        }

                        var blk_id = "expert_status('" + element.id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small blue darken-2 col s12 l6">EXPERT</button>&nbsp';

                        var alw_id = "expert_status('" + element.id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2 col s12 l6">REGULAR</button>&nbsp';
                        var status;

                        if (element.is_expert == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }
                        users_table.row.add([
                            thumbnail,
                            element.fullname,
                            element.username,
                            element.contact_number,
                            element.email_address,
                            status,
                            element.fullname
                        ]).draw(false);
                    });
                } else {
                    users_table.clear().draw();
                }

            }
        });
    }

    function expert_status(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to make this an expert?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/ExpertStatus",
                    type: "POST",
                    data: {
                        id: id,
                        active_user: active_user
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: res.success.message,
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_users();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_users();
                            })
                        }
                    }
                });
            }
        })
    }

    // export surgical report CSV
    $("#report_csv_download").on("click", function (e ){
        e.preventDefault();
        export_csv();
    });
    function export_csv() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/ExpertReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'csv',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => { 
                        let csvContent = atob(res.success.data);
                        var blob = new Blob([csvContent], {type: "data:application/octet-stream;base64"});
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(blob);
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export surgical report CSV

    // export surgical report PDF
    $("#report_pdf_download").on("click", function (e ){
        e.preventDefault();
        export_pdf();
    });
    function export_pdf() {
        console.log('pdf')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/ExpertReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'pdf',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => {
                        var a = document.createElement('a');
                        var url = "data:application/pdf;base64," + res.success.data.trim();
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export surgical report PDF

</script>
<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>