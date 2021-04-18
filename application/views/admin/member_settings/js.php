<script>
    if ($('#faqs').length == 1) {
        var faqs_editor = CKEDITOR.replace('faqs');
    }
    if ($('#terms_conditions').length == 1) {
        var terms_editor = CKEDITOR.replace('terms_conditions');
    }
    if ($('#data_privacy').length == 1) {
        var privacy_editor = CKEDITOR.replace('data_privacy');
    }
    if ($('#event').length == 1) {
        var event_editor = CKEDITOR.replace('event');
    }
    if ($('#field_study').length == 1) {
        var field_study_editor = CKEDITOR.replace('field_study');
    }

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";


    var users_table = $('#users_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });
    var events_table = $('#events_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    get_users();
    get_events();

    if ($("#is_expert option:selected").val() == 1) {
        $("#field_of_study").show();
    } else {
        $("#field_of_study").hide();
    }

    $("#is_expert").change(function() {
        if ($("#is_expert option:selected").val() == 1) {
            $("#field_of_study").show();
        } else {
            $("#field_of_study").hide();
        }
    })


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
                            thumbnail = '<img width="40px" src ="<?= base_url() . 'assets/images/avatar.png' ?>">';
                        }

                        var expert_blk_id = "expert_status('" + element.id + "')";
                        var expert_blk = '<button onclick="' + expert_blk_id + '" class="btn btn-small blue darken-2">EXPERT</button>&nbsp';

                        var expert_alw_id = "expert_status('" + element.id + "')";
                        var expert_alw = '<button onclick="' + expert_alw_id + '" class="btn btn-small green darken-2">REGULAR</button>&nbsp';
                        var expert_status;

                        if (element.is_expert == 1) {
                            expert_status = expert_blk;
                        } else {
                            expert_status = expert_alw;
                        }

                        var del_id = "delete_user('" + element.id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "block_user('" + element.id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "allow_user('" + element.id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }

                        if (element.id != active_user && element.role != 'admin') {
                            users_table.row.add([
                                thumbnail,
                                element.fullname,
                                element.contact_number,
                                element.email_address,
                                element.role,
                                expert_status,
                                // element.status,
                                '<a href="' + base_url + 'Admin_FE/member_settings_view/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                                '<a href="' + base_url + 'Admin_FE/member_settings_update/' + element.id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                                status
                                // status,
                                // element.fullname
                            ]).draw(false);
                        }

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
            confirmButtonText: 'Yes'
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

    function delete_user(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/Users/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Account deleted',
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

    $('#create_member_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/user/Users",
            data: {
                'id': $('#id').val(),
                'active_user': active_user,
                'fname': $('#fname').val(),
                'mname': $('#mname').val(),
                'lname': $('#lname').val(),
                'contact_number': $('#contact_number').val(),
                'email_address': $('#email_address').val(),
                'pass': $('#password').val(),
                'role': 'member',
                'is_expert': $("#is_expert option:selected").val(),
                'field_study': field_study_editor.getData()
            },
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
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
                            window.location.replace(base_url + "Admin_FE/member_settings_create");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $('#update_member_submit').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update this account?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Update'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: base_url + "api/user/Update",
                    data: {
                        'id': $('#id').val(),
                        'active_user': active_user,
                        'fname': $('#fname').val(),
                        'mname': $('#mname').val(),
                        'lname': $('#lname').val(),
                        'contact_number': $('#contact_number').val(),
                        'email_address': $('#email_address').val(),
                        'password': $('#passoword').val(),
                        'is_expert': $("#is_expert option:selected").val(),
                        'field_study': field_study_editor.getData()
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res) {
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
                                    window.location.replace(base_url + "Admin_FE/member_settings_update/" + $('#id').val());
                                })

                            } else {
                                Swal.fire({
                                    title: 'Warning',
                                    html: res.error.message,
                                    icon: 'warning',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Okay'
                                })
                            }
                        }
                    }
                });
            }
        })
    });

    function block_user(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to block this account?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/Block/",
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

    function allow_user(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to unblock this account?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/Allow",
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

    // fetch member_settings
    $.ajax({
        type: "get",
        url: base_url + "api/member/Faqs",
        headers: {
            "Authorization": "Bearer " + token
        },
        dataType: "json",
        success: function(res) {
            if (res.success) {
                $('#faqs_data').html(res.success.data[0].faq);
                $('#terms_data').html(res.success.data[0].terms_conditions);
                $('#privacy_data').html(res.success.data[0].data_privacy);
            }
        }
    });

    $('#create_faq_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/member/Faqs",
            data: {
                'faqs': faqs_editor.getData(),
                'active_user': active_user,
            },
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
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
                            window.location.replace(base_url + "Admin_FE/member_settings");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $('#create_terms_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/member/Terms",
            data: {
                'terms_conditions': terms_editor.getData(),
                'active_user': active_user,
            },
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
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
                            window.location.replace(base_url + "Admin_FE/member_settings");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $('#create_privacy_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/member/Privacy",
            data: {
                'data_privacy': privacy_editor.getData(),
                'active_user': active_user,
            },
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
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
                            window.location.replace(base_url + "Admin_FE/member_settings");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    function get_events() {
        $.ajax({
            type: "get",
            url: base_url + "api/calendar/Calendar",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                console.log(res);
                if (res.success) {
                    events = res.success.data;
                    var counter = 1;
                    events_table.clear().draw();
                    events.forEach(element => {

                        var del_id = "delete_event('" + element.id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var view_event = "show_event_details('" + element.id + "')";
                        var event_date = new Date(element.event_date);
                        event_date.toDateString();
                        date = event_date.toString().replace('00:00:00 GMT+0800 (Philippine Standard Time)', '');
                        events_table.row.add([
                            element.event_title.substr(0, 80) + (element.event_title.length > 80 ? " ..." : ""),
                            element.event_desc.substr(0, 80) + (element.event_desc.length > 80 ? " ..." : ""),
                            date,
                            '<button onclick="' + view_event + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></button>&nbsp;' +
                            '<a href="' + base_url + 'Admin_FE/member_settings_update_event/' + element.id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                            del
                        ]).draw(false);

                    });
                } else {
                    events_table.clear().draw();
                }

            }
        });
    }

    $('#create_event_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/calendar/Calendar",
            data: {
                'title': $('#title').val(),
                'datetime': $('#datetime').val(),
                'description': event_editor.getData(),
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
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
                            window.location.replace(base_url + "Admin_FE/member_settings");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $('#update_event_submit').click(function() {

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to update this event!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Update'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: base_url + "api/calendar/Update",
                    data: {
                        'id': $('#id').val(),
                        'title': $('#title').val(),
                        'datetime': $('#datetime').val(),
                        'description': event_editor.getData(),
                        'active_user': active_user
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res) {
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
                                    window.location.replace(base_url + "Admin_FE/member_settings_update_event/" + $('#id').val());
                                })

                            } else {
                                Swal.fire({
                                    title: 'Warning',
                                    html: res.error.message,
                                    icon: 'warning',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Okay'
                                })
                            }
                        }
                    }
                });
            }
        })

    });

    function delete_event(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/calendar/Calendar/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Event deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_events();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_events();
                            })
                        }
                    }
                });
            }
        })
    }

    function show_event_details(id) {

        $.ajax({
            type: "get",
            url: base_url + "api/calendar/Calendar/" + id,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                if (res.success) {
                    var event_date = new Date(res.success.data.datetime_created);
                    event_date.toDateString();
                    date = event_date.toString().replace('GMT+0800 (Philippine Standard Time)', '');
                    $('#event_details').modal('open');
                    $('#event_title').text(res.success.data.event_title);
                    $('#event_description').html(res.success.data.event_desc);
                    $('#event_date').text(date);
                } else {
                    window.location.href = base_url + '/Admin_FE/'
                }

            }
        });
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
            url: base_url + "api/reports/GetLastLogin",
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
            url: base_url + "api/reports/GetLastLogin",
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



    $(document).ready(function() {
        // Materialize initialization
        $('.collapsible').collapsible();
        $('.dropdown-trigger').dropdown();
        $('.materialboxed').materialbox();
        $('select').formSelect();
        $('.modal').modal();
    });
</script>