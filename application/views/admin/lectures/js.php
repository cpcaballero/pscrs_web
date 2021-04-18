<script>
    $(document).ready(function() {
        // Materialize initialization
        $('.select2').select2();
        $('.normal_select').formSelect();

    });
</script>

<script>
    if ($('textarea').length == 1) {
        var editor = CKEDITOR.replace('description');
    }

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var lectures_table = $('#lecture_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    // get lectures for index

    function get_lectures() {
        $.ajax({
            type: "get",
            url: base_url + "api/lectures/Lectures",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    lectures = res.success.data;
                    var counter = 1;
                    lectures_table.clear().draw();

                    lectures.forEach(element => {
                        var del_id = "delete_lecture('" + element.video_id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "unpublish_lecture('" + element.video_id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "publish_lecture('" + element.video_id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.video_status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }

                        //get the video number from vimeo link
                        var video_ref;
                        video_ref = element.video_link.split('/');

                        var video = '<iframe src="https://player.vimeo.com/video/' + video_ref[3] + '?title=0&byline=0&portrait=0" style="top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

                        var video_details = '<strong>' + element.video_title + "</strong></br>" + element.video_desc

                        lectures_table.row.add([
                            video,
                            video_details.substr(0, 80),
                            element.video_link,
                            '<a href="' + base_url + 'Admin_FE/view_lecture/' + element.video_id + '" class="btn light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                            '<a href="' + base_url + 'Admin_FE/edit_lecture/' + element.video_id + '" class="btn yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                            del +
                            status
                        ]).draw(false);
                    });
                } else {
                    lectures_table.clear().draw();
                }

            }
        });
    }

    // delete lecture

    function delete_lecture(id) {
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
                    url: base_url + "api/lectures/Lectures/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Lecture deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_lectures();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_lectures();
                            })
                        }
                    }
                });
            }
        })
    }

    // delete lecture

    // unpublish lecture

    function unpublish_lecture(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to unpublish this lecture?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/lectures/Block/",
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
                                html: 'Lecture unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_lectures();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_lectures();
                            })
                        }
                    }
                });
            }
        })
    }

    // unpublish lecture

    // publish lecture

    function publish_lecture(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to publish this lecture?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/lectures/Allow",
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
                                html: 'Lecture unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_lectures();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_lectures();
                            })
                        }
                    }
                });
            }
        })
    }

    // publish lecture

    // create lecture

    $('#create_lecture_submit').click(function() {

        $.ajax({
            type: "post",
            url: base_url + "api/lectures/Lectures",
            data: {
                'title': $('#title').val(),
                'description': editor.getData(),
                'video_link': $('#video_link').val(),
                'owner_user_id': $('#owner_user_id').val(),
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
                            window.location.replace(base_url + "Admin_FE/create_lecture");
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

    // create lecture

    // update lecture

    $('#update_lecture_submit').click(function(e) {
        $.ajax({
            type: "post",
            url: base_url + "api/lectures/Update",
            data: {
                'id': $('#id').val(),
                'title': $('#title').val(),
                'description': editor.getData(),
                'video_link': $('#video_link').val(),
                'owner_user_id': $('#owner_user_id').val(),
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
                            window.location.replace(base_url + "Admin_FE/edit_lecture/" + $('#id').val());
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

    // update lecture

    $("#report_csv_download").on("click", function (e ){
        e.preventDefault();
        export_csv();
    });
    function export_csv() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/LectureReport",
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
            url: base_url + "api/reports/LectureReport",
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

    get_lectures();
</script>