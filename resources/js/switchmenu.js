function showOnOff(root, pid, id) {
    var i, j, a;
    for (i = 0; (a = document.getElementsByTagName("div")[i]); i++) {
        if (a.getAttribute("id") == id) {
            if (a.style.display == "none") {
                a.style.display = "block";
                for (j = 0; (a = document.getElementsByTagName("div")[j]); j++) {
                    if (a.getAttribute("pid") != pid && a.getAttribute("pid")) {
                        a.style.display = "none";
                    }
                    if (a.getAttribute("root") == "no" && a.getAttribute("pid") == pid && a.getAttribute("id") != id) {
                        a.style.display = "none";
                    }
                }
            }
            else {
                a.style.display = "none";
            }

        }
    }

}