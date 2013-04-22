function selectItem(n) {

	var row = document.getElementById('item' + n);	
	if (!row) {
		alert('row not found');
		return;
	}	
	row.className = "success";
	
	var valueFields = row.getElementsByTagName('td');

	//Popup form
	$(function () {
		$("#dialog").dialog();
	});
	//////////////////////////////////////////////////////////

	if (n > 50) {
		//При продаже из портфеля в качестве текущего времени указывается время загрузки первой котировки
		
    	document.popupForm.name.value = valueFields[1].innerHTML;
		document.popupForm.ticker.value = valueFields[2].innerHTML;
		document.popupForm.price.value = valueFields[3].innerHTML;
		document.popupForm.count.value = valueFields[4].innerHTML;
		//document.popupForm.time.value = valueFieldsNew[5].innerHTML;
	} else {
		document.popupForm.name.value = valueFields[1].innerHTML;
		document.popupForm.ticker.value = valueFields[2].innerHTML;
		document.popupForm.price.value = valueFields[3].innerHTML;
		document.popupForm.count.value = 10;
		//document.popupForm.time.value = valueFields[4].innerHTML;
	}
	//alert(typeof(valueFields[3].innerHTML));
}

function tableRuler() {
	if (document.getElementById) {
		tables = document.getElementsByTagName("table");
		for (i = 0; i < tables.length; i++) {
			//document.writeln(tables[i].className);
			if (tables[i].className == "table table-striped table-bordered ruler dataTable") {
				//document.writeln(tables[i].className);
				trs = tables[i].getElementsByTagName("tr");
				for (j = 0; j < trs.length; j++) {
					if (trs[j].className != "header") {
						trs[j].onmouseover = function () {
							if(this.className != "success")
								this.className = "info";
							return false
						}
						trs[j].onmouseout = function () {
							if(this.className == "info")
								this.className = "";
							return false
						}
						trs[j].onclick = function () {
							var name = this.getElementsByTagName("td")[2].innerHTML;
							//addToNames(name);
							if(this.className != "success")
								this.className = "success";							
							else 
								this.className = "";
							//showIntradayGraphics();
							return false
						}
					}
				}
			}
		}
	}
}