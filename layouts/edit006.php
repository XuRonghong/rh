<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
    <tr>
        <td width="100%">
            <form id="form_edit1" >
                <table width="100%" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="8" bgcolor="#FFFFFF" class="form1_td">
                            <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                    <td width="90%" class="form1_title">編輯內容</td>
                                    <td width="7%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="6%" class="list2">Rank</td>
                        <td width="18%" class="list2">
                            <label>
                                <input type="text" name="rank" id="rank" value="" />
                            </label>
                        </td>
                        <td width="6%" class="list2">單位統編</td>
                        <td width="18%" class="list2">
                            <label>
                                <input type="text" name="Code1" id="Code1" value="" />
                            </label>
                        </td>
                        <td width="6%" class="list2">帳號</td>
                        <td colspan="1" class="list2">
                            <label>
                                <input type="text" name="Account" id="Account" value="" />
                            </label>
                        </td>
                        <td width="6%" class="list2">使用人員</td>
                        <td width="22%" class="list2">
                            <label>
                                <input type="text" name="Name" id="Name" value="" />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="list2">系統權限</td>
                        <td class="list2">
                            <label>
                                <select name="System" id="System" class="optSystem">
                                    <option value="3">填報人員</option>
                                    <option value="2">審核人員</option>
                                    <option value="1">系統人員</option>
                                </select>
                            </label>
                        </td>
                        <td width="6%" class="list2"></td>
                        <td width="18%" class="list2">
                            <input type="radio" name="active" class="active" value="1" >啟用
                            <input type="radio" name="active" class="active" value="0" checked>未啟用
                        </td>
                        <td class="list2">狀態</td>
                        <td class="list2">
                            <select name="status" class="optStatus">
                                <option value="0">0</option>
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                            </select>
                        </td>
                        <td class="list2"></td>
                        <td width="18%" class="list2">
                            <label>
                                
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="list6">&nbsp;</td>
                        <td class="list2">&nbsp;</td>
                        <td class="list2">&nbsp;</td>
                        <td colspan="3" class="list2">&nbsp;</td>
                        <td class="list2">&nbsp;</td>
                        <td class="list2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="8" style="background-color: #FFFFFF; text-align: center;">
                            <label>
                                <input type="button" name="btn-submit" id="btn-submit" value="確定" />
                                <!-- <input type="button" name="btn-cancel" id="btn-cancel" value="取消" /> -->

                                <input type="hidden" name="router" id="router" value="create" />
                                <input type="hidden" name="id" id="id" value="" />
                            </label>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>