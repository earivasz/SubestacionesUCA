<script>
    <?php 
//        $datos = array('label: "primero", y: 18', 'label: "orange", y: 29', 'label: "apple", y: 40', 
//            'label: "mango", y: 34', 'label: "grape", y: 24');
//        foreach ($datos as $value) {
//            echo $value;
//        }
    ?>
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        
        zoomEnabled: true,
      title:{
        text: "Pruebas"              
      },
      axisX:{
        labelAngle: 30,
      },
      data: [//array of dataSeries              
        { //dataSeries object

         /*** Change type "column" to "bar", "area", "line" or "pie"***/
         type: "line",
         dataPoints: [
         { label: "banana", y: 18 },
         { label: "orange", y: 29 },
         { label: "apple", y: 40 },                                    
         { label: "mango", y: 34 },
         { label: "grape", y: 24 }
         ]
       }
       ]
     });

    chart.render();
  }
  </script>
<h2>GRAFICOS</h2>
<div id="chartContainer" style="height: 300px; width: 100%;">
  </div>