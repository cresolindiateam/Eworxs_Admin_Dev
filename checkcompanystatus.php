<script>


function checkcompanyStatus(status_val) {
    $.ajax({
        type: "GET",
        url: "checkcompanystatusvalue.php",
        data: {status: status_val},
        success: function (result) {
            console.log("hello");
            console.log(result);
            console.log("hello");
             if (result == 0) {
                    // Delay the redirect for 2 seconds (2000 milliseconds)
                    setTimeout(function() {
                        // Redirect to the admin login page
                        window.location.href = 'admin_login.php';
                    }, 2000);
                }
            // lastUpdated();
        }
    });
}

 // checkcompanyStatus();
 setInterval(checkcompanyStatus, 1000);
</script>