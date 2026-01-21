function selectItem(n) {
  var row = document.getElementById("item" + n);
  if (!row) {
    alert("row not found");
    return;
  }
  row.className = "success";

  var valueFields = row.getElementsByTagName("td");

  // Open popup
  $(function () {
    $("#dialog").dialog();
  });

  if (n > 50) {
    // When selling from portfolio, the current time is set to the time of the first quote loaded
    document.popupForm.name.value = valueFields[1].textContent;
    document.popupForm.ticker.value = valueFields[2].textContent;
    document.popupForm.price.value = valueFields[3].textContent;
    document.popupForm.count.value = valueFields[4].textContent;
  } else {
    document.popupForm.name.value = valueFields[1].textContent;
    document.popupForm.ticker.value = valueFields[2].textContent;
    document.popupForm.price.value = valueFields[3].textContent;
    document.popupForm.count.value = 10;
  }
}

function tableRuler() {
  if (document.getElementById) {
    tables = document.getElementsByTagName("table");
    for (i = 0; i < tables.length; i++) {
      if (
        tables[i].className ==
        "table table-striped table-bordered ruler dataTable"
      ) {
        trs = tables[i].getElementsByTagName("tr");
        for (j = 0; j < trs.length; j++) {
          if (trs[j].className != "header") {
            trs[j].onmouseover = function () {
              if (this.className != "success") this.className = "info";
              return false;
            };
            trs[j].onmouseout = function () {
              if (this.className == "info") this.className = "";
              return false;
            };
            trs[j].onclick = function () {
              var name = this.getElementsByTagName("td")[2].innerHTML;
              addToNames(name);
              if (this.className != "success") this.className = "success";
              else this.className = "";
              showIntradayGraphics();
              return false;
            };
          }
        }
      }
    }
  }
}
