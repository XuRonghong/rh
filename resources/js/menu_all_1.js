// You can find instructions for this file at http://www.treeview.net

//Environment variables are usually set at the top of this file.
USETEXTLINKS = 1
STARTALLOPEN = 0
USEFRAMES = 0
USEICONS = 0
WRAPTEXT = 1
PERSERVESTATE = 0
HIGHLIGHT = 1


var oReq = new XMLHttpRequest(); // New request object
oReq.onload = function() {
    // This is where you handle what to do with the response.
    // The actual data is found on this.responseText
    alert(this.responseText); // Will alert: 42
};
oReq.open("get", "get-data.php", true);
//                               ^ Don't block the rest of the execution.
//                                 Don't wait until the request finishes to
//                                 continue.
oReq.send();


foldersTree = gFld("<b>工項編碼</b>", "")
  aux0 = insFld(foldersTree, gFld("00契約要項", ""))
    insDoc(aux0, gLnk("R", "001營建費用", ""))
    insDoc(aux0, gLnk("R", "002其他", ""))
	
  aux1 = insFld(foldersTree, gFld("01假設", ""))
    insDoc(aux1, gLnk("R", "001整地放樣", "123"))
    insDoc(aux1, gLnk("R", "002鷹架防護", ""))
	insDoc(aux1, gLnk("R", "003工務所", ""))
	insDoc(aux1, gLnk("R", "004圍籬", ""))
	insDoc(aux1, gLnk("R", "005拆除及打除", ""))
	
  aux2 = insFld(foldersTree, gFld("02基礎", ""))
    insDoc(aux2, gLnk("R", "001地質改良", ""))
    insDoc(aux2, gLnk("R", "002鋼製樁類", ""))
	insDoc(aux2, gLnk("R", "003場鑄樁", ""))
	insDoc(aux2, gLnk("R", "004連續壁", ""))
	insDoc(aux2, gLnk("R", "005安全支撐", ""))
    insDoc(aux2, gLnk("R", "006觀測系統", ""))
	insDoc(aux2, gLnk("R", "007土方", ""))
	insDoc(aux2, gLnk("R", "008抽排水", ""))
  aux3 = insFld(foldersTree, gFld("03結構體", ""))
    insDoc(aux3, gLnk("R", "001混凝土", ""))
    insDoc(aux3, gLnk("R", "002竹節鋼筋", ""))
	insDoc(aux3, gLnk("R", "003鋼結構", ""))
	insDoc(aux3, gLnk("R", "004模板", ""))

  aux4 = insFld(foldersTree, gFld("04隔間牆", ""))
    insDoc(aux4, gLnk("R", "001砌磚", ""))
    insDoc(aux4, gLnk("R", "002輕隔間", ""))
	insDoc(aux4, gLnk("R", "003搗擺", ""))
	insDoc(aux4, gLnk("R", "004淋浴間", ""))

  aux5 = insFld(foldersTree, gFld("05防水處理", ""))
    insDoc(aux5, gLnk("R", "001樹脂砂漿", ""))
    insDoc(aux5, gLnk("R", "002防水處理", ""))
	insDoc(aux5, gLnk("R", "003PU防水層", ""))

  aux6 = insFld(foldersTree, gFld("06地坪裝修", ""))
	insDoc(aux6, gLnk("R", "001整體粉光", "p005_1c.htm"))
	insDoc(aux6, gLnk("R", "002水泥粉光", ""))
	insDoc(aux6, gLnk("R", "003耐磨塗料", ""))	

  aux7 = insFld(foldersTree, gFld("07內牆裝修", ""))
	insDoc(aux7, gLnk("R", "001內牆水泥粉光", ""))
    insDoc(aux7, gLnk("R", "002內牆刷漆", ""))
	insDoc(aux7, gLnk("R", "003內牆壁磚", ""))
	insDoc(aux7, gLnk("R", "004內牆石材", ""))
//		insDoc(aux71, gLnk("R", "行動方案維護", " "))
//  		insDoc(aux71, gLnk("R", "行動方案核准", " "))
//  		insDoc(aux71, gLnk("R", "行動方案查詢", " "))
//  		insDoc(aux71, gLnk("R", "執行計畫維護", " "))
//  		insDoc(aux71, gLnk("R", "執行計畫核准", " "))
//  		insDoc(aux71, gLnk("R", "執行計畫查詢", " "))
//  	aux72= insFld(aux7, gFld( "執行情形填報", "hello.htm"))  		
//		insDoc(aux72, gLnk("R", "執行情形填報", " "))
//  		insDoc(aux72, gLnk("R", "執行情形核准", " ))  	
//  	aux73= insFld(aux7, gFld( "結案管理", "hello.htm"))  			  		  		
//  		insDoc(aux73, gLnk("R", "行動方案結案", " "))
//  		insDoc(aux73, gLnk("R", "行動方案結案審核", " "))  		
//  	aux74= insFld(aux7, gFld( "彙整管理", " "))  			  		  		
//  		insDoc(aux74, gLnk("R", "彙整通知", " ")) 			  		  		
//  		insDoc(aux74, gLnk("R", "彙整查詢", " "))
//  	aux75= insFld(aux7, gFld( "改善方案管理", " "))  			  		  		
//  		insDoc(aux75, gLnk("R", "執行情形填報", " ")) 			  		  		
//  		insDoc(aux75, gLnk("R", "執行情形審核", " "))
//  		insDoc(aux75, gLnk("R", "改善方案查詢", " "))
//  aux8 = insFld(foldersTree, gFld("08平頂裝修", "javascript:undefined"))
// 	aux8a = insFld(aux8, gFld("001整體粉光", "javascript:undefined"))
//    insDoc(aux8a, gLnk("R", "1地坪整體粉光", " "))
//    insDoc(aux8a, gLnk("R", "2鋼梯踏步粉光", " "))
//    insDoc(aux8a, gLnk("R", "3地坪機械磨光", " "))
//	aux9a = insFld(aux8, gFld("002水泥粉光", "javascript:undefined"))
//    insDoc(aux9a, gLnk("R", "1地坪1:3水泥粉刷", " "))
//    insDoc(aux9a, gLnk("R", "2浴缸底水泥砂漿墊高", " "))
//    insDoc(aux9a, gLnk("R", "3地坪抿石子", " "))
//    insDoc(aux9a, gLnk("R", "4地坪寒水石粉光", " "))
//  aux9 = insFld(foldersTree, gFld("09踢腳裝修", "javascript:undefined"))
//		insDoc(aux9, gLnk("R", "檔案上傳作業", " "))
//		insDoc(aux9, gLnk("R", "資料轉入作業", " "))
//		insDoc(aux9, gLnk("R", "轉入結果查詢", " "))

//Set this string if FolderTree and other configuration files may also be loaded in the same sessino
foldersTree.treeID = "t2" 
 