<script src="<?= base_url('assets/raterjs/') ?>/rater.min.js" charset="utf-8"></script>

<script>
    $(document).ready(function() {
        $('.modal').modal();
    });

    $('.datatables').DataTable();

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";

    function show_description(id) {
        $.ajax({
            type: "get",
            url: base_url + "api/lectures/Lectures/" + id,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                $('#video_desc').modal('open');
                $('#video_title').text(res.success.data.video_title);
                $('#video_description').html(res.success.data.video_desc);
            }
        });
    }

    var gen_options = {
        max_value: 5,
        step_size: 1,
        readonly: true,
    };

    $(".gen_rate").rate(gen_options);

    function rate_video(id) {

        $.ajax({
            type: "get",
            url: base_url + "api/surgical/Videos/" + id,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                var options = {
                    max_value: 5,
                    step_size: 1,
                    initial_value: 0,
                    readonly: false,
                    change_once: false, // Determines if the rating can only be set once
                    // ajax_method: 'POST',
                    // url: base_url + "api/surgical/Rate/",
                    // additional_data: {
                    //     'id': id,
                    //     'active_user': active_user,
                    //     'rating': 5
                    // }, // Additional data to send to the server
                    only_select_one_symbol: false, // If set to true, only selects the hovered/selected symbol and nothing prior to it
                };

                $(".rate").rate(options);

                $(".rate").on("change", function(ev, data) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "api/lectures/Rate/",
                        data: {
                            'id': id,
                            'active_user': active_user,
                            'rating': data.to
                        },
                        dataType: "JSON",
                        headers: {
                            "Authorization": "Bearer " + token
                        },
                        success: function(res) {
                            if (res.success.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    html: res.success.message,
                                    icon: 'success',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                }).then(() => {
                                    $('#rate_video').modal('close');
                                })
                            } else {
                                Swal.fire({
                                    title: 'Warning!',
                                    html: res.success.message,
                                    icon: 'warning',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                }).then(() => {
                                    $('#rate_video').modal('close');
                                })
                            }
                        }
                    });
                });
                $('#rate_video').modal('open');
            }
        });


    }

    $('input[name ="rate"]').change(function() {
        console.log($('input[name ="rate"]:checked').val());
    })
</script>