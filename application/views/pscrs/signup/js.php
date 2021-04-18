<script>
    var base_url = "<?= base_url() ?>";

    $('form').submit(function(e) {
        e.preventDefault();
        console.log($('form').serialize());
        $.ajax({
            type: "post",
            url: base_url + "api/user/Register",
            data: $('form').serialize(),
            dataType: "json",
            success: function(res) {
                if (res) {
                    console.log(res);
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
                            window.location.replace(base_url + "Login_FE");
                        })

                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                        })
                    }
                }
            }
        });
    });
</script>