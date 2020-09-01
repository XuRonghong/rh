<?php

require_once 'sys/db.php';
require_once 'sys/function.php';


$rs = $db->prepare("SELECT * FROM class where class=1");
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>建築工料分析系統</title>
    <link rel="stylesheet" href="resources/css/style.css">

    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <script src="Scripts/switchmenu.js" type="text/javascript"></script>
    <link href="css/tree.css" rel="stylesheet" type="text/css" />
    <link href="css/first.css" rel="stylesheet" type="text/css"/>


    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

<div class="btn">
        <span class="fas fa-bars"></span>
    </div>
    <nav class="sidebar">
        <div class="text">工項編碼</div>
        <div><a href="index.php?r=login&f=logout">登出</a></div>
        <ul>
            <?php 
            foreach($rows as $key => $row) {
                $subs = sql_get($db, "SELECT * FROM class where parent_id=? and class=2", array($row['id']) );
                ?>
                <?php if(empty($subs)) { ?>
                    <li><a href="#"><?php echo $row['title'];?></a></li>
                <?php } else { ?>
                    <li>
                        <a href="#" class="feat-btn" data-sn="<?php echo $key;?>">
                            <?php echo $row['title'];?>
                            <span class="fas fa-caret-down first<?php echo $key;?>"></span>
                        </a>
                        <ul class="feat-show<?php echo $key;?>">
                            <?php 
                            foreach($subs as $key2 => $sub) {
                                $sql = "SELECT * FROM class where parent_id=? and class=3";
                                $exec = array($sub['id']);
                                $subs2 = sql_get($db, $sql, $exec);
                                ?>
                                <li>
                                    <?php if(empty($subs2)) { ?>
                                        <a href="#"><?php echo $sub['title'];?></a>
                                    <?php } else { ?>
                                        <a href="#" class="feat-btn" data-sn="<?php echo $key.$key2;?>">
                                            <?php echo $sub['title'];?>
                                            <span class="fas fa-caret-down first<?php echo $key.$key2;?>"></span>
                                        </a>
                                        <ul class="feat-show<?php echo $key.$key2;?>">
                                            <?php 
                                            foreach($subs2 as $key3 => $sub2) {
                                                ?>
                                                <li><a href="#"><?php echo $sub2['title'];?></a></li>
                                                <?php 
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                                <?php 
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php 
            }
            ?>
        </ul>
    </nav>

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