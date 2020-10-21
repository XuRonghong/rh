<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
    <tr>
        <td width="100%">
            <form id="form_edit1" enctype="multipart/form-data" method="post">
                <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
                    <tr>
                        <td width="100%">
                            <table width="100%" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td colspan="8" bgcolor="#FFFFFF" class="form1_td">
                                        <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="3%">
                                                    <div class="doCloseModal">
                                                        <img src="images/Previous_01.gif" width="24" height="16" border="0">
                                                    </div>
                                                </td>
                                                <td class="form1_title" width="90%">編輯項次</td>
                                                <td width="7%">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="list" rowspan="2"><strong>建案名稱</strong></td>
                                    <td class="list4 td_title">工程編號*</td>
                                    <td class="list4"><input type="text" name="ECode1" class="txt" required></td>
                                    <td class="list4 td_title">工程名稱*</td>
                                    <td class="list4"><input type="text" name="Name" class="txt" required></td>
                                    <td class="list4 td_title">工程別號</td>
                                    <td class="list4"><input type="text" name="ECode2" class="txt"></td>
                                </tr>
                                <tr>
                                    <td class="list2 td_title">縣市</td>
                                    <td class="list2">
                                        <select name="area" class="opt optArea">
                                            <option value="">請選擇</option>
                                            <?php foreach ($area_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="list2 td_title">區域地號</td>
                                    <td class="list2"><input type="text" name="Location" class="txt" ></td>
                                    <td class="list2 td_title">備註</td>
                                    <td class="list2"><input type="text" name="Note" class="txt"></td>
                                </tr>
                                <tr>
                                    <td class="list"><strong>承攬關係</strong></td>
                                    <td class="list2 td_title">業主</td>
                                    <td class="list2"><input type="text" name="Owners" class="txt" /></td>
                                    <td class="list2 td_title">建築師</td>
                                    <td class="list2"><input type="text" name="architect" class="txt" /></td>
                                    <td class="list2 td_title">承攬公司</td>
                                    <td class="list2"><input type="text" name="Company" class="txt" /></td>
                                </tr>
                                <tr>
                                    <td class="list"><strong>工程期限</strong></td>
                                    <td class="list2 td_title">放樣勘驗</td>
                                    <td class="list2"><input type="date" name="Start_date" class="txt" /></td>
                                    <td class="list2 td_title">使照取得</td>
                                    <td class="list2"><input type="date" name="Completion_date" class="txt" /></td>
                                    <td class="list2 td_title">合約工期</td>
                                    <td class="list2"><input type="date" name="Contract_date" class="txt" /></td>
                                </tr>
                                <tr>
                                    <td class="list" rowspan="5"><strong>建案內容</strong></td>
                                    <td class="list4 td_title">建物用途</td>
                                    <td class="list4">
                                        <select name="Building_use" class="opt">
                                            <option value="">請選擇</option>
                                            <?php foreach ($building_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="list4 td_title">結構形式</td>
                                    <td class="list4">
                                        <select name="Structure2" class="opt">
                                            <option value="">請選擇</option>
                                            <?php foreach ($structure2_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="list4 td_title">建造工法</td>
                                    <td class="list4">
                                        <select name="Structure3" class="opt">
                                            <option value="">請選擇</option>
                                            <?php foreach ($structure3_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="list4 td_title">擋土開挖</td>
                                    <td class="list4">
                                        <select name="Retaining_patterns" class="opt">
                                            <option value="">請選擇</option>
                                            <?php foreach ($rp_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="list4 td_title">外牆型態</td>
                                    <td class="list4">
                                        <select name="Facades" class="opt">
                                            <option value="">請選擇</option>
                                            <?php foreach ($facades_conf as $val) { ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="list4"></td>
                                    <td class="list4"></td>
                                </tr>
                                <tr>
                                    <td class="list4 td_title">地下樓層</td>
                                    <td class="list4"><input type="text" name="Underground1" class="txt" /></td>
                                    <td class="list4 td_title">地上層數</td>
                                    <td class="list4"><input type="text" name="Derground1" class="txt" /></td>
                                    <td class="list4 td_title">屋突層數</td>
                                    <td class="list4"><input type="text" name="Roof" class="txt" /></td>
                                </tr>
                                <tr>
                                    <td class="list4 td_title">基地面積</td>
                                    <td class="list4"><input type="text" name="Base_area" class="txt" /></td>
                                    <td class="list4 td_title">樓板面積</td>
                                    <td class="list4"><input type="text" name="total_floor_area" class="txt" /></td>
                                    <td class="list4 td_title">銷售戶數</td>
                                    <td class="list4"><input type="text" name="Households" class="txt" /></td>
                                </tr>
                                <tr>
                                    <td class="list2 td_title">影像資料</td>
                                    <td class="list2">
                                        <img id="blah" src="storage/<?php echo $tablename . '/img/' . data_get($row, 'Photo1_5', '../../../images/246x0w.png'); ?>" alt="project image" style="width: 100px;" />
                                        <input name="file" type="file" id="imgInp" class="iptFile" accept="image/gif, image/jpeg, image/png" />
                                    </td>
                                    <td class="list2 td_title">文件資料</td>
                                    <td class="list2">
                                        <a id="blah2" alt="project file" Target="_blank" ></a>
                                        <input name="file2" type="file" id="fileInp" class="iptFile" accept="application/msexcel,application/msword,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                    </td>
                                    <td class="list2 td_title">檔案鎖定</td>
                                    <td class="list2"><input type="text" name="Lock" class="txt" /></td>
                                </tr>
                                <tr>
                                    <td class="list5" colspan="8">
                                        <div align="center">
                                            <input name="button1" type="submit" class="btn-submit" value="儲存" />
                                            <input name="button2" type="reset" class="btn-clear" value="清空" />

                                            <input type="hidden" name="router" id="router" value="create" />
                                            <input type="hidden" name="table" id="table" value="<?php echo $tablename;?>" />
                                            <input type="hidden" name="key" value="id" />
                                            <input type="hidden" name="value" id="id" value="" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>