
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