<script src="Scripts/jquery-3.5.1.min.js"></script>
<script src="Scripts/script.js" type="text/javascript"></script>

<script src="Scripts/sweetalert.min.js"></script>
<script src="Scripts/toastr.min.js"></script>

<script src="Scripts/switchmenu.js" type="text/javascript"></script>

<script type="text/javascript">
    //非同步傳輸資料
    function ajax_crud(u, r, t, k, v, datas = []) {
        var data = {
            'router': r,
            'table': t,
            'key': k,
            'value': v
        }
        //假如還有資料就填充上去
        for (let key in datas) {
            data[key] = datas[key]
        }
        var url = window.location.href
        url = url.split('?')[0] || ''

        $.ajax({
            headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
            url: u,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            resetForm: true,
            success: function(rtndata) {
                // rtndata = JSON.parse(rtndata)
                if (rtndata.status) {
                    if (rtndata.id) {
                        url + '?show=' + rtndata.id
                    }
                    location.href = url
                }
                // toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                // swal("删除！", "你的虚拟文件已经被删除。", "success");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                // 通常情況下textStatus和errorThown只有其中一個有值 
                console.error('(' + XMLHttpRequest.status + ')' + XMLHttpRequest.readyState + ';' + textStatus)
            }
        });
    }

    
    document.addEventListener("DOMContentLoaded", function() {

        //時間模組
        let menu = $('.left_menu')
        menu.find('.date').text(getDateString())
        menu.find('.time').text(getTimeString())
        setInterval(function() {
            menu.find('.date').text(getDateString())
            menu.find('.time').text(getTimeString())
        }, 1000)

        //導向按鈕
        $('.btn-goto').click(function() {
            let u = $(this).data('url') || ''
            if (u=='') return false
            location.href = u
        })

        //登出處理
        $(".btn-logout").click(function() {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
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

        //上傳圖片即顯示
        $("#imgInp").change(function() {
            readURL(this, '#blah');
        });
        $("#imgInp2").change(function() {
            readURL(this, '#blah2');
        });
    })


    function readURL(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(target).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    function MM_preloadImages() { //v3.0
        var d = document;
        if (d.images) {
            if (!d.MM_p) d.MM_p = new Array();
            var i, j = d.MM_p.length,
                a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
                if (a[i].indexOf("#") != 0) {
                    d.MM_p[j] = new Image;
                    d.MM_p[j++].src = a[i];
                }
        }
    }

    function MM_swapImgRestore() { //v3.0
        var i, x, a = document.MM_sr;
        for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
    }

    function MM_findObj(n, d) { //v4.01
        var p, i, x;
        if (!d) d = document;
        if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
            d = parent.frames[n.substring(p + 1)].document;
            n = n.substring(0, p);
        }
        if (!(x = d[n]) && d.all) x = d.all[n];
        for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
        for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
        if (!x && d.getElementById) x = d.getElementById(n);
        return x;
    }

    function MM_swapImage() { //v3.0
        var i, j = 0,
            x, a = MM_swapImage.arguments;
        document.MM_sr = new Array;
        for (i = 0; i < (a.length - 2); i += 3)
            if ((x = MM_findObj(a[i])) != null) {
                document.MM_sr[j++] = x;
                if (!x.oSrc) x.oSrc = x.src;
                x.src = a[i + 2];
            }
    }
</script>