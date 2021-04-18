<script>
    var base_url = "<?= base_url() ?>";

    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/user/Forgot",
            data: $('form').serialize(),
            dataType: "json",
            success: function(response) {
                if (response) {
                    if (response.success) {
                        window.location.replace(base_url + "Login_FE/entersecuritycode");
                        // console.log(response.success);
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: response.error.message,
                            icon: 'warning',
                            timer: 2000,
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