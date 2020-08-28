<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Sidebar Menu with sub-menu | CodingNepal</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

    <?php require_once( __DIR__.'/layouts/menu.php'); ?>

    <div class="content">
        <div class="header">
            Sidebar Menu with sub-menu</div>
        <p>
            HTML CSS & Javascript (Full Tutorial)</p>
    </div>
    
    <script>
        $(document).ready(function(){     
            $('.btn').toggleClass("click");   
            $('.sidebar').toggleClass("show");
        })
        $('.btn').click(function() {
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
        });
        $('.feat-btn').click(function() {
            var sn = $(this).data('sn');
            var el = $('.feat-show'+sn);

            /* ul元件顯示或隱藏 */
            if(el.css("display") == 'none'){
                el.css("display", "block");
            } else {
                el.css("display", "none");
            }
            $('.first'+sn).toggleClass("rotate");
        });
        $('nav ul li').click(function() {
            $(this).addClass("active").siblings().removeClass("active");
        });
    </script>

</body>

</html>