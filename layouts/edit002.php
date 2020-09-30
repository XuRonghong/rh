<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
    <tr>
        <td width="100%">
            <form id="form_edit1">
                <table width="90%" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="3" bgcolor="#FFFFFF" class="form1_td">
                            <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                    <td width="90%" class="form1_title">新增項次</td>
                                    <td width="7%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="list2">
                            <div>類別
                                <p class="class_tree"></p>
                            </div>
                        </td>
                        <td class="list2">
                            <div>Floor
                                <input name="floor" type="text" id="floor" value="" disabled="true" /></div>
                        </td>
                        <td class="list2"></td>
                    </tr>
                    <tr>
                        <td class="list2">
                            <div>項目說明
                                <input name="title" type="text" id="title" value="" size="27" /></div>
                        </td>
                        <td class="list2">
                            <div><strong>Rank</strong>
                                <input name="rank" type="text" id="rank" size="8" value="5" /></div>
                        </td>
                        <td class="list2">
                            <div>備註
                                <input name="remark" type="text" id="remark" size="35" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="list2">
                            <div>單位<input name="unit" type="text" id="unit" /></div>
                        </td>
                        <td class="list2">
                            <div>比率<label><input name="ratio" type="text" id="ratio" /></label></div>
                        </td>
                        <td class="list2">
                            <div>數量<input name="quantity" type="text" id="quantity" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="list2">
                            <div>單價<input name="price" type="text" id="price" /></div>
                        </td>
                        <td class="list2">
                            <div>複價<input name="reprice" type="text" id="reprice" /></div>
                        </td>
                        <td class="list2">
                            <div id="nomore"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" bgcolor="#FFFFFF">
                            <label>
                                <div align="center">
                                    <input type="button" name="btn-submit" id="btn-submit" value="確定" />
                                    <!-- <input type="button" name="btn-cancel" id="btn-cancel" value="取消" /> -->

                                    <input type="hidden" name="router" id="router" value="create" />
                                    <input type="hidden" name="id" id="id" value="0" />
                                </div>
                            </label>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>