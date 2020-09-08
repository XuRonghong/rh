<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
    <tr>
        <td width="100%">
            <table width="100%" cellpadding="2" cellspacing="0" id="form_edit1">
                <tr>
                    <td colspan="9" bgcolor="#FFFFFF" class="form1_td">
                        <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                <td width="90%">編輯項次</td>
                                <td width="7%">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php /*
                <tr>
                    <td class="list2"><strong>項次</strong></td>
                    <td class="list2">編號首項</td>
                    <td class="list2">
                        <select name="select" id="select1">
                            <option>請選擇</option>
                            <option>標題1</option>
                            <option>標題2</option>
                            <option>壹</option>
                            <option>貳</option>
                            <option>參</option>
                            <option>肆</option>
                            <option>伍</option>
                            <option>陸</option>
                            <option>柒</option>
                            <option>捌</option>
                            <option>玖</option>
                            <option>拾</option>
                        </select>
                    </td>
                    <td class="list2">編號中項</td>
                    <td class="list2">
                        <select name="select2" id="select2">
                            <option>請選擇</option>
                            <option>一</option>
                            <option>二</option>
                            <option>三</option>
                            <option>四</option>
                            <option>五</option>
                            <option>六</option>
                            <option>七</option>
                            <option>八</option>
                            <option>九</option>
                            <option>十</option>
                        </select>
                    </td>
                    <td class="list2">編號細項</td>
                    <td class="list2">
                        <select name="select3" id="select3">
                            <option>請選擇</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                            <option>24</option>
                            <option>25</option>
                            <option>26</option>
                            <option>27</option>
                            <option>28</option>
                            <option>29</option>
                            <option>30</option>
                        </select>
                    </td>
                    <td class="list2">審核</td>
                    <td class="list2"><input name="textfield10" type="text" id="textfield10" size="14" /></td>
                </tr>
                <?php */ ?>
                <tr>
                    <td class="list4">&nbsp;</td>
                    <td class="list4">料號編碼</td>
                    <td colspan="3" class="list4"><label></label>
                        <form action="index02_2.htm" method="post" name="form1" target="" id="form2">
                            <input type="text" name="material_no" id="material_no" />
                            <a href="#" id="btn-search1"><img src="images/search.png" width="62" height="22" border="0" align="middle" /></a>
                        </form>
                    </td>
                    <td class="list4">項目說明</td>
                    <td colspan="3" class="list4"><input name="textfield7" type="text" id="textfield7" value="" size="57" /></td>
                </tr>
                <tr>
                    <td class="list2">&nbsp;</td>
                    <td class="list2">單位</td>
                    <td class="list2">
                        <label>
                            <input type="text" name="textfield11" id="textfield11" />
                        </label>
                    </td>
                    <td class="list2">建案單價</td>
                    <td class="list2"><input name="textfield26" type="text" id="textfield26" /></td>
                    <td class="list2">項目別名</td>
                    <td colspan="3" class="list2"><input name="textfield" type="text" id="textfield" size="57" /></td>
                </tr>
                <tr>
                    <td class="list2"><strong>填報</strong></td>
                    <td class="list2">比率</td>
                    <td class="list2"><label><input name="textfield3" type="text" id="textfield3" /></label></td>
                    <td class="list2">數量</td>
                    <td class="list2"><input name="textfield6" type="text" id="textfield6" /></td>
                    <td class="list2">單價</td>
                    <td class="list2"><input name="textfield4" type="text" id="textfield4" /></td>
                    <td class="list2">備註</td>
                    <td class="list2"><input name="textfield8" type="text" id="textfield8" size="14" /></td>
                </tr>
                <tr>
                    <td class="list6"><strong>審核</strong></td>
                    <td class="list6">比率</td>
                    <td class="list6"><input name="textfield5" type="text" id="textfield5" /></td>
                    <td class="list6">數量</td>
                    <td class="list6"><input name="textfield6" type="text" id="textfield6" /></td>
                    <td class="list6">單價</td>
                    <td class="list6"><input name="textfield9" type="text" id="textfield9" /></td>
                    <td class="list6">差異金額</td>
                    <td class="list6">
                        <input name="textfield12" type="text" id="textfield12" size="7" />％
                        <input name="textfield13" type="text" id="textfield13" size="3" />
                    </td>
                </tr>
                <tr>
                    <td colspan="9" bgcolor="#FFFFFF"><label></label>
                        <div align="center">
                            <label>
                                <div align="center"></a></span>
                                    <input type="button" name="button" id="button1" value="確定" />
                                    <input type="button" name="清除2" id="清除2" value="取消" />
                                </div>
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>