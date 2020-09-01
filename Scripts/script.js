
    // none, bounce, rotateplane, stretch, orbit,
    // roundBounce, win8, win8_linear or ios
    function run_waitMe(selector='body', effect='roundBounce')
    {
        $(selector).waitMe({
            //none, rotateplane, stretch, orbit, roundBounce, win8,
            //win8_linear, ios, facebook, rotation, timer, pulse,
            //progressBar, bouncePulse or img
            effect: effect,
            //place text under the effect (string).
            text: 'Please waiting...',
            //background for container (string).
            bg: 'rgba(255,255,255,0.7)',
            //color for background animation and text (string).
            color: '#000',
            //max size
            maxSize: '',
            //wait time im ms to close
            waitTime: -1,
            //url to image
            source: '',
            //or 'horizontal'
            textPos: 'vertical',
            //font size
            fontSize: '',
            // callback
            onClose: function() {}
        })
    }

    function toastr_options()
    {
        toastr.options = {
            "closeButton": false,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function ajax(url='', data={}, method='POST', redirect=1)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: url,
            method: method,
            // type: "POST",
            dataType:"json",
            contentType: false,
            processData: false,
            cache: false,
            data: data,
            resetForm: true,
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message, "{{trans('web_alert.notice')}}", { timeOut: 1300 }).css("width","360px")
                    if (redirect) {
                        setTimeout(function () {
                            location.href = data.redirectUrl
                        }, 500)
                    }
                } else {
                    toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                    Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(data.errors), "error");
                }
            },
            error: function (err) {
                console.log(err.responseJSON)
                Swal.fire("{{trans('web_alert.error')}}"+err.status,
                    JSON.stringify(err.responseJSON.message)+"<br>"+
                    JSON.stringify(err.responseJSON.errors),
                    "error");
            }
        })
    }

    function ajaxOpen(url='', data={}, method='POST', DOM=null)
    {
        toastr.info("", "Please wait me ... Thank you.", { timeOut: 2200 }).css("width","360px")
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: url,
            method: method,
            data: data,
            // type: "POST",
            //async: false,
            success: function (data) {
                if (data.status) {
//                    Swal.fire("{{trans('web_alert.notice')}}", data.message, "success");
//                     setTimeout(function () {
                    DOM.api().ajax.reload(null, false);
                    toastr.success("{{trans('web_message.add.success')}}", "{{trans('web_alert.notice')}}", { timeOut: 1200 }).css("width","360px")
                    //toastr.success(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                        // table.api().ajax.reload(null, false);
                    // }, 100);
                } else {
                    toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                    Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(data.errors), "error");
                }
            },
            error: function (err) {
                console.log(err.responseJSON)
                Swal.fire("{{trans('web_alert.error')}}"+err.status,
                    JSON.stringify(err.responseJSON.message)+"<br>"+
                    JSON.stringify(err.responseJSON.errors),
                    "error");
            }
        })
    }

    function ajaxModal(url='', data={}, method='GET')
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            url: url,
            method: method,
            data: data,
            success: function (data) {
                $('#createModalLabel').html(data.Title)
                for (var prop in data['arr']) {
                    console.log(prop + ':' + data['arr'][prop]);
                    $('.'+prop).val(data['arr'][prop])
                    $('.'+prop).html(data['arr'][prop])
                }
                for(var val in data['arr']['image']) {
                    let html = '<img id="img1" src="'+data['arr']['image'][val]+'" style="height:100px" alt="">'
                    $('.images').html(html)
                }
            },
            error: function (err) {
                console.log(err.responseJSON)
                Swal.fire("{{trans('web_alert.error')}}"+err.status,
                    JSON.stringify(err.responseJSON.message)+"<br>"+
                    JSON.stringify(err.responseJSON.errors)
                    ,"error");
            }
        })
    }

    function ajaxUploadFile(url='', data={}, method='POST')
    {
        let file_id
        $.ajax({
            data: data,
            type: method,
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            success: function (data) {
                if (data.status) {
                    file_id = data.fileid;
                } else {
                    toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                    Swal.fire("{{trans('web_alert.error')}}"+data.status, JSON.stringify(data.errors), "error");
                }
            },
            error: function (err) {
                console.log(err.responseJSON)
                Swal.fire("{{trans('web_alert.notice')}}", JSON.stringify(err.responseJSON), "error");
            }
        })
        return file_id
    }

    function doDelete(url, data, table)
    {
        Swal.fire({
            title: "{{trans('web_alert.del.title')}}",
            text: "{{trans('web_alert.del.note')}}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{trans('web_alert.ok')}}",
            cancelButtonText: "{{trans('web_alert.cancel')}}",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    data: data,
                    type: "POST",
                    //async: false,
                    success: function (rtndata) {
                        if (rtndata.status) {
                            Swal.fire(
                                "{{trans('web_alert.notice')}}",
                                rtndata.message,
                                'success'
                            )
                            setTimeout(function () {
                                table.api().ajax.reload(null, false)
                            }, 100)
                        } else {
                            Swal.fire(
                                "{{trans('web_alert.notice')}}",
                                rtndata.message,
                                'error'
                            )
                        }
                    },
                    error: function (err) {
                        console.log(err.responseJSON)
                        Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(err.responseJSON.message), "error");
                    }
                })
            }
        })
    }

    function doDelete_2016(id, data)
    {
        swal({
            title: "{{trans('web_alert.del.title')}}",
            text: "{{trans('web_alert.del.note')}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('web_alert.ok')}}",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "{{trans('web_alert.cancel')}}",
            closeOnConfirm: true,
        }, function () {
            $.ajax({
                url: '{{data_get($data,"route_url.destroy")}}'+'/'+id,
                data: data,
                type: "POST",
                //async: false,
                success: function (rtndata) {
                    if (rtndata.status) {
                        toastr.success(rtndata.message, "{{trans('web_alert.notice')}}")
                        setTimeout(function () {
                            table.api().ajax.reload(null, false)
                        }, 100)
                    } else {
                        swal("{{trans('web_alert.notice')}}", rtndata.message, "error")
                    }
                },
                error: function (err) {
                    console.log(err.responseJSON)
                    toastr.error(JSON.stringify(err.responseJSON), "{{trans('web_alert.notice')}}")
                }
            })
        })
    }
    
    function doMessDelete(table)
    {
        $(document).on('click', '#bulk_delete', function(){
            let id = [];
            if(confirm("Are you sure you want to Delete this data?"))
            {
                $('.group_checkbox:checked').each(function(){
                    id.push($(this).val());
                });
                if(id.length > 0)
                {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        // url:"{{ route('group.mass_destroy')}}",
                        url:'{{data_get($data,"route_url.mass_destroy")}}',
                        method:"delete",
                        data:{id:id},
                        success:function(rtndata)
                        {
                            if (rtndata.status) {
                                toastr.success(rtndata.message, "{{trans('web_alert.notice')}}")
                                setTimeout(function () {
                                    table.api().ajax.reload(null, false)
                                }, 100)
                            } else {
                                Swal.fire("{{trans('web_alert.notice')}}", rtndata.message, "error")
                            }
                        },
                        error: function (err) {
                            console.log(err.responseJSON)
                            toastr.error(JSON.stringify(err.responseJSON), "{{trans('web_alert.notice')}}")
                        }
                    });
                }
                else
                {
                    alert("Please select atleast one checkbox");
                }
            }
        });
    }

    function do_upload_file_fun()
    {
        //上傳檔案資料庫，回傳file id
        let url = '{{data_get($data, "upload_file_url")}}'
        let file_data = $('.uploadfile').prop('files')[0]
        let data = new FormData()
        data.append("_token", "{{ csrf_token() }}")
        data.append('file', file_data)
        return ajaxUploadFile(url, data, 'POST')
    }

    function prop_fromData_fun(formHTML, datas=[])
    {
        let form_data = new FormData(formHTML)

        /*** 上傳檔案資料庫，需要再呼叫，回傳file id ***/
        // let file_id = do_upload_file_fun();

        if (typeof(current_modal.find("img").attr('id')) != "undefined") {
            form_data.append('file_id', current_modal.find("img").attr('id'))
        }
        if (typeof(current_modal.find("img").attr('src')) != "undefined") {
            form_data.append('image', current_modal.find("img").attr('src'))
        }

        //撈取html content
        if (document.getElementById("content")) {
            form_data.append('content', $('#content').summernote('code'))
        }
        //撈取html detail
        if (document.getElementById("detail")) {
            // form_data.append('detail', $('#detail').summernote('code'))
        }

        //撈取html 滑動開關切換按鈕
        if (document.getElementById("switch_demo") && JSON.stringify(document.getElementById("switch_demo")) != '{}') {
            form_data.append('open', document.getElementById("switch_demo").value)
        }

        //多選項
        if (document.getElementById("multi1")) {
            form_data.append('product_id', $('#multi1').val())
        }

        //假如還有資料就填充上去
        for (let key in datas) {
            form_data.append(key, datas[key])
        }

        return form_data
    }

    function prop_fromData_multpleFile(formHTML, datas=[])
    {
        let form_data = new FormData(formHTML)

        /*** 上傳檔案資料庫，需要再呼叫，回傳file id ***/
        // let file_id = do_upload_file_fun();

        /*** 多圖片串連 ***/
        let images = ""
        $(".cropper_image").find('img').each(function () {
            if ($(this).attr('id') != "Image") {
                images = images + $(this).attr('id') + ";"
            }
        });
        // form_data.append('file_id', file_id)
        // form_data.append('file_id', current_modal.find("img").attr('id'))
        // form_data.append('image', current_modal.find("img").attr('src'))
        if (images!=="") {
            form_data.append('file_id', images)
        }

        //撈取html content
        if (document.getElementById("content")) {
            form_data.append('content', $('#content').summernote('code'))
        }
        //撈取html detail
        if (document.getElementById("detail")) {
            form_data.append('detail', $('#detail').summernote('code'))
        }

        //撈取html 滑動開關切換按鈕
        if (document.getElementById("switch_demo") && JSON.stringify(document.getElementById("switch_demo")) != '{}') {
            form_data.append('open', document.getElementById("switch_demo").value)
        }

        //多選項
        if (document.getElementById("multi1")) {
            form_data.append('product_id', $('#multi1').val())
        }

        //假如還有資料就填充上去
        for (let key in datas) {
            form_data.append(key, datas[key])
        }

        return form_data
    }