@section('content')
<div class="container main">
	<div id="chart" style="width: 100%; height: 450px"></div>
</div>


<script src="https://www.google.com/jsapi"></script>
<script>
	// Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      	var formatter = new google.visualization.DateFormat({format: "medium"});

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'Time');
        data.addColumn('number', 'Listeners');
        data.addColumn({type: 'string', role: 'tooltip', p: { 'html' : true}});
        data.addColumn({type: 'boolean', role: 'scope'});
        
        graph = {{ $json }};

        for(var i = 0; i < graph.length; i++) {
        	var d = graph[i][0].split(',');
        	graph[i][0] = new Date(d[0], d[1], d[2], d[3], d[4], d[5]);
        	data.addRow(graph[i]);
        }

        // Set chart options
        var options = {'title':'R/a/dio Listeners (hover for DJ)',
                       'tooltip' : { isHtml: true }
                   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
</script>

@stop