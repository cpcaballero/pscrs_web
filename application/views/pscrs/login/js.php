<script>
    var base_url = "<?= base_url() ?>";

    size_changed();

    function size_changed() {
        if ($(window).width() >= 992) {
            $('#signup_link').addClass('float-right');
        } else {
            $('#signup_link').removeClass('float-right');
        }
    }

    $(window).resize(function() {
        size_changed();
    })



    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/auth/Login",
            data: $('form').serialize(),
            dataType: "json",
            success: function(response) {
                if (response) {
                    if (response.success) {
                        if (response.success.data.details.role == "admin") {
                            window.location.replace(base_url + "Admin_FE/dashboard");
                        } else if (response.success.data.details.role == "member") {
                            window.location.replace(base_url + "Subscriber_FE/dashboard");
                        } else {
                            window.location.replace(base_url + "Login_FE");
                        }
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: response.error.message,
                            icon: 'warning',
                            timer: 1500,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false,
                        })
                    }
                }
            }
        });
    });
</script>