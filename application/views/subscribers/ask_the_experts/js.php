<script>
    // CKEDITOR.replace('message');

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var user_is_expert = "<?php echo $_SESSION['account']['details']['is_expert'] ?>";
    var expert_table = $('#experts_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });
    var inquiries_table = $('#inquiries_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    if ($(".myBox").length == 1) {
        $('.myBox').scrollTop($(".myBox")[0].scrollHeight);
    }

    get_conversations();

    function get_conversations() {
        if (user_is_expert == 1) {
            $.ajax({
                type: "get",
                url: base_url + "api/messaging/Conversations/" + active_user,
                headers: {
                    "Authorization": "Bearer " + token
                },
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        experts = res.success.data;
                        var counter = 1;
                        expert_table.clear().draw();

                        experts.forEach(element => {
                            expert_table.row.add([
                                element.sender_name,
                                element.sender_email,
                                element.sender_contact,
                                '<a href="' + base_url + 'Subscribers_FE/ask_the_experts_message/' + element.sender_id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-envelope"></span></a>'
                            ]).draw(false);
                        });
                    } else {
                        expert_table.clear().draw();
                    }
                }
            });
        } else {
            $.ajax({
                type: "get",
                url: base_url + "api/user/Users",
                headers: {
                    "Authorization": "Bearer " + token
                },
                dataType: "json",
                success: function(res) {

                    console.log(res);
                    if (res.success) {
                        experts = res.success.data;
                        var counter = 1;
                        expert_table.clear().draw();

                        experts.forEach(element => {
                            if (element.is_expert == 1 && element.id != active_user) {
                                expert_table.row.add([
                                    element.fullname,
                                    element.id,
                                    element.field_study,
                                    '<a href="' + base_url + 'Subscribers_FE/ask_the_experts_message/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-envelope"></span></a>'
                                ]).draw(false);
                            }
                        });
                    } else {
                        expert_table.clear().draw();
                    }
                }
            });

        }

    }

    function send_message(sender, receiver) {
        console.log({
            'message': $('#message').val(),
            'sender': sender,
            'receiver': receiver,
            'convo_id': $('#convo_id').val(),
        });
        $.ajax({
            type: "POST",
            url: base_url + "api/messaging/Messages",
            data: {
                'message': $('#message').val(),
                'sender': sender,
                'receiver': receiver,
                'convo_id': $('#convo_id').val(),
            },
            dataType: "JSON",
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                if (!res.success) {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                } else {
                    window.location.replace(base_url + "Subscribers_FE/ask_the_experts_message/" + receiver);
                }
            }
        });
    }
</script>