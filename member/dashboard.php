<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "SELECT
                 COUNT(case when aws_cloud = '1' then 1 END) AS aws_small1,
            	 COUNT(case when aws_cloud = '2' then 2 END) AS aws_small2,
                 COUNT(case when aws_cloud = '3' then 3 END) AS aws_small3,
                 COUNT(case when aws_cloud = '4' then 4 END) AS aws_small4,
                 COUNT(case when aws_cloud = '5' then 4 END) AS aws_small5
          FROM user";

$result = sql_query($query);
$row = sql_fetch($result);

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);   
    google.charts.setOnLoadCallback(drawChart3);
    google.charts.setOnLoadCallback(drawChart4);  
    google.charts.setOnLoadCallback(drawChart5);    
    google.charts.setOnLoadCallback(drawChart6); 
    google.charts.setOnLoadCallback(drawChart7);    
    google.charts.setOnLoadCallback(drawChart8);    
    google.charts.setOnLoadCallback(drawChart9);   
    google.charts.setOnLoadCallback(drawChart10);    
    google.charts.setOnLoadCallback(drawChart11);    
    google.charts.setOnLoadCallback(drawChart12);   
       
    function drawChart1() {
    
        // Create the data table.
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', 'Topping');
        data1.addColumn('number', 'Slices');
        data1.addRows([
            ['t3_small1', <?php echo $row['aws_small1']?>],
            ['t3_small2', <?php echo $row['aws_small2']?>],
            ['t3_small3', <?php echo $row['aws_small3']?>],
            ['t3_small4', <?php echo $row['aws_small4']?>],
            ['t3_small5', <?php echo $row['aws_small5']?>],
        ]);
        
        // Set chart options
        var options1 = {'title':'?????? ?????????',
                       'width':400,
                       'height':300,
                       'pieHole': 0.2};
        
        // Instantiate and draw our chart, passing in some options.
        
        var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
        chart1.draw(data1, options1);
    } 
                
   function drawChart2() {
        
        // Create the data table.
        var data2 = new google.visualization.DataTable();
        data2.addColumn('string', 'Topping');
        data2.addColumn('number', 'Slices');
        data2.addRows([
        	['????????????', 14],
            ['????????????', 6.3],
        ]);
        
        // Set chart options
        var options2 = {'title':'aws_t3_small1 ??????(??????:GB)',
                       'width':400,
                       'height':300,
                       'pieHole': 0.2};
        
        // Instantiate and draw our chart, passing in some options.
        
        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);
    } 

   function drawChart3() {
       
       // Create the data table.
       var data3 = new google.visualization.DataTable();
       data3.addColumn('string', 'Topping');
       data3.addColumn('number', 'Slices');
       data3.addRows([
       	['????????????', 17],
           ['????????????', 14],
       ]);
       
       // Set chart options
       var options3 = {'title':'aws_t3_small2 ??????(??????:GB)',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));
       chart3.draw(data3, options3);
   }

   function drawChart4() {
       
       // Create the data table.
       var data4 = new google.visualization.DataTable();
       data4.addColumn('string', 'Topping');
       data4.addColumn('number', 'Slices');
       data4.addRows([
       	['????????????', 13],
           ['????????????', 18],
       ]);
       
       // Set chart options
       var options4 = {'title':'aws_t3_small3 ??????(??????:GB)',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart4 = new google.visualization.PieChart(document.getElementById('chart_div4'));
       chart4.draw(data4, options4);
   } 

   function drawChart5() {
       
       // Create the data table.
       var data5 = new google.visualization.DataTable();
       data5.addColumn('string', 'Topping');
       data5.addColumn('number', 'Slices');
       data5.addRows([
       	['????????????', 13],
           ['????????????', 18],
       ]);
       
       // Set chart options
       var options5 = {'title':'aws_t3_small4 ??????(??????:GB)',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart5 = new google.visualization.PieChart(document.getElementById('chart_div5'));
       chart5.draw(data5, options5);
   } 

   function drawChart6() {
       
       // Create the data table.
       var data6 = new google.visualization.DataTable();
       data6.addColumn('string', 'Topping');
       data6.addColumn('number', 'Slices');
       data6.addRows([
       	['????????????', 7.4],
           ['????????????', 23],
       ]);
       
       // Set chart options
       var options6 = {'title':'aws_t3_large ??????(??????:GB)',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart6 = new google.visualization.PieChart(document.getElementById('chart_div6'));
       chart6.draw(data6, options6);
   } 

   function drawChart12() {
       
       // Create the data table.
       var data12 = new google.visualization.DataTable();
       data12.addColumn('string', 'Topping');
       data12.addColumn('number', 'Slices');
       data12.addRows([
       	['????????????', 3.5],
           ['????????????', 27],
       ]);
       
       // Set chart options
       var options12 = {'title':'aws_t3_small5 ??????(??????:GB)',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart12 = new google.visualization.PieChart(document.getElementById('chart_div12'));
       chart12.draw(data12, options12);
   } 

   function drawChart7() {
       
       // Create the data table.
       var data7 = new google.visualization.DataTable();
       data7.addColumn('string', 'Topping');
       data7.addColumn('number', 'Slices');
       data7.addRows([
       	   ['(???)????????????', 20],
           ['(???)???????????????????????????', 20],
           ['??????', 20],
           ['(???)??????????????????', 20],
           ['????????????', 20],
       ]);
       
       // Set chart options
       var options7 = {'title':'aws_t3_small1 ?????????',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart7 = new google.visualization.PieChart(document.getElementById('chart_div7'));
       chart7.draw(data7, options7);
   } 

   function drawChart8() {
       
       // Create the data table.
       var data8 = new google.visualization.DataTable();
       data8.addColumn('string', 'Topping');
       data8.addColumn('number', 'Slices');
       data8.addRows([
       	   ['???????????? ??????', 16.6],
           ['(???)??????????????????????????????', 16.6],
           ['???????????? ????????????', 16.6],
           ['??????????????????(???)', 16.6],
           ['???????????????', 16.6],
       ]);
       
       // Set chart options
       var options8 = {'title':'aws_t3_small2 ?????????',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart8 = new google.visualization.PieChart(document.getElementById('chart_div8'));
       chart8.draw(data8, options8);
   } 

   function drawChart9() {
       
       // Create the data table.
       var data9 = new google.visualization.DataTable();
       data9.addColumn('string', 'Topping');
       data9.addColumn('number', 'Slices');
       data9.addRows([
       	   ['(???)?????????????????????', 20],
           ['?????????', 20],
           ['?????????', 20],
           ['?????????????????????', 20],
           ['????????????????????????????????????', 20],
       ]);
       
       // Set chart options
       var options9 = {'title':'aws_t3_small3 ?????????',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2};
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart9 = new google.visualization.PieChart(document.getElementById('chart_div9'));
       chart9.draw(data9, options9);
   } 

   function drawChart10() {
       
       // Create the data table.
       var data10 = new google.visualization.DataTable();
       data10.addColumn('string', 'Topping');
       data10.addColumn('number', 'Slices');
       data10.addRows([
       	   ['?????????', 20],
       	   ['?????????', 20],
           ['???????????????', 20],
           ['????????????', 20],
           ['???????????????', 20],
       ]);
       
       // Set chart options
       var options10 = {'title':'aws_t3_small4 ?????????',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2
                      };
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart10 = new google.visualization.PieChart(document.getElementById('chart_div10'));
       chart10.draw(data10, options10);
   } 

   function drawChart11() {
       
       // Create the data table.
       var data11 = new google.visualization.DataTable();
       data11.addColumn('string', 'Topping');
       data11.addColumn('number', 'Slices');
       data11.addRows([
       	   ['?????????????????????', 33.3],
           ['????????????????????????', 33.3],
       	   ['?????????', 33.3]
       ]);
       
       // Set chart options
       var options11 = {'title':'aws_t3_small5 ?????????',
                      'width':400,
                      'height':300,
                      'pieHole': 0.2
                      };
       
       // Instantiate and draw our chart, passing in some options.
       
       var chart11 = new google.visualization.PieChart(document.getElementById('chart_div11'));
       chart11.draw(data11, options11);
   } 

    </script>
  </head>
  <body>
    <div id="chart_div1" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div2" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div3" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div4" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div5" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div6" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div12" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div7" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div8" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div9" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div10" style="width:200px; height: 300px; margin: 100px;"></div>
    <div id="chart_div11" style="width:200px; height: 300px; margin: 100px;"></div>
  </body>
</html>
