var names = [];
function addToNames(ticker) {
	//push ticker in names array if not exists. If exists - delete
	for (var i = 0; i < names.length - 1; i++) {
		if (names[i] == ticker) {
			names[i] = null;
			break;
		}
	}
	if (i == names.length - 1 && names[i] == ticker) {
		names.pop();
		while(names.length > 0 && names[names.length-1] ==null)
			names.pop();
		return;
	}
	if (i == names.length - 1) {
		for (var j = 0; j < names.length; j++) {
			if (names[j] == null) {
				names[j] = ticker;
				break;
			}
		}
		if (j == names.length){
			names.push(ticker);
		}
	}
	else if(names.length == 0)
		names.push(ticker);
}

function showgraphics() {
	var seriesOptions = [],
		yAxisOptions = [],
		seriesCounter = 0,
		colors = Highcharts.getOptions().colors;
	
	$.each(names, function(i, name) {
		$.get('../ajaxrequest/request.php',
			{
				stock : name
			},
			function(data) {
			var jsonData = jQuery.parseJSON(data);
			seriesOptions[i] = {
				name: name,
				data: jsonData
			};

			// As we're loading the data asynchronously, we don't know what order it will arrive. So
			// we keep a counter and create the chart when all the data is loaded.
			seriesCounter++;

			if (seriesCounter == names.length) {
				createChart();
			}
		});
	});	
	
		// create the chart when all data is loaded
	function createChart() {

		chart = new Highcharts.StockChart({
		    chart: {
		        renderTo: 'container'
		    },

		    rangeSelector: {
		        selected: 4
		    },

		    yAxis: {
		    	labels: {
		    		formatter: function() {
		    			return (this.value > 0 ? '+' : '') + this.value + '%';
		    		}
		    	},
		    	plotLines: [{
		    		value: 0,
		    		width: 2,
		    		color: 'silver'
		    	}]
		    },
		    
		    plotOptions: {
		    	series: {
		    		compare: 'percent'
		    	}
		    },
		    
		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
		    	valueDecimals: 2
		    },
		    
		    series: seriesOptions
		});
	}
	
}

function showIntradayGraphics() {
	var seriesOptions = [],
		yAxisOptions = [],
		seriesCounter = 0,
		colors = Highcharts.getOptions().colors;
	
	$.each(names, function(i, name) {
		$.get('../ajaxrequest/intradayreq.php',
			{
				stock : name
			},
			function(data) {
			var jsonData = jQuery.parseJSON(data);
			seriesOptions[i] = {
				name : name,
				data : jsonData,
				tooltip : {
					valueDecimals : 2
				},
				fillColor : {
					linearGradient : {
						x1 : 0,
						y1 : 0,
						x2 : 0,
						y2 : 1
					},
					stops : [[0, Highcharts.getOptions().colors[0]], [1, 'rgba(0,0,0,0)']]
				},
				threshold : null
			};

			// As we're loading the data asynchronously, we don't know what order it will arrive. So
			// we keep a counter and create the chart when all the data is loaded.
			seriesCounter++;

			if (seriesCounter == names.length) {
				createChart();
			}
		});
	});	
	
		// create the chart when all data is loaded
	function createChart() {

		chart = new Highcharts.StockChart({
		    chart: {
		        renderTo: 'container'
		    },
			
			rangeSelector : {
					buttons : [{
							type : 'hour',
							count : 1,
							text : '1h'
						}, {
							type : 'day',
							count : 1,
							text : '1D'
						}, 
						{
							type: 'month',
							count: 1,
							text: '1m'
						},
						{
							type: 'month',
							count: 6,
							text: '6m'
						},
						{
							type : 'year',
							count : 1,
							text : '1y'
						},
						{
							type : 'all',
							count : 1,
							text : 'All'
						}
					],
					selected : 3,
					inputEnabled : false
				},

		    yAxis: {
		    	labels: {
		    		formatter: function() {
		    			return (this.value > 0 ? '+' : '') + this.value + '%';
		    		}
		    	},
		    	plotLines: [{
		    		value: 0,
		    		width: 2,
		    		color: 'silver'
		    	}]
		    },
		    
		    plotOptions: {
		    	series: {
		    		compare: 'percent'
		    	}
		    },
		    
		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
		    	valueDecimals: 2
		    },
		    
		    series: seriesOptions
		});
	}
	
}

function showgraph(ticker) {
	$.get('../ajaxrequest/intradayreq.php', {
		stock : ticker
	},
		function (data) {

		var jsonData = jQuery.parseJSON(data);
		//document.getElementById("ajax_info").innerHTML = data;

		// create the chart
		chart = new Highcharts.StockChart({
				chart : {
					renderTo : 'container'
				},

				title : {
					text : 'AAPL stock price by minute'
				},

				xAxis : {
					gapGridLineWidth : 0
				},

				rangeSelector : {
					buttons : [{
							type : 'hour',
							count : 1,
							text : '1h'
						}, {
							type : 'day',
							count : 1,
							text : '1D'
						}, {
							type : 'all',
							count : 1,
							text : 'All'
						}
					],
					selected : 2,
					inputEnabled : false
				},

				series : [{
						name : 'AAPL',

						data : jsonData,
						//gapSize: 5,
						tooltip : {
							valueDecimals : 2
						},
						fillColor : {
							linearGradient : {
								x1 : 0,
								y1 : 0,
								x2 : 0,
								y2 : 1
							},
							stops : [[0, Highcharts.getOptions().colors[0]], [1, 'rgba(0,0,0,0)']]
						},
						threshold : null
					}
				]
			});
	});
}