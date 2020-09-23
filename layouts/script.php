<script src="Scripts/jquery-3.5.1.min.js"></script>
<script src="Scripts/script.js" type="text/javascript"></script>

<script src="Scripts/switchmenu.js" type="text/javascript"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {

        $(".btn-logout").click(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
                },
                url: "ajax/api_logout.php",
                type: "POST",
                data: {
                    'router': 'accounts',
                    'type': 'logout'
                },
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata)
                    if (rtndata.status > 0) {
                        location.href = rtndata.url
                    } else {
                        console.error(JSON.stringify(rtndata))
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // 通常情況下textStatus和errorThown只有其中一個有值 
                    console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
                }
            })
        })

        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });

    })
</script>