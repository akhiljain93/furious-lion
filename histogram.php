<!DOCTYPE html>
<meta charset="utf-8">
<style>
.bars rect {
  fill: darkmagenta;
}
.shads rect {
  fill: grey;
  fill-opacity: 20%;
}

.axis text {
  font: 10px sans-serif;
}
.axis path, .axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
.curve {
  fill: none;
  stroke: black;
  stroke-width: 3;
}

</style>
<body style="padding:3px;margin:3px;font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif;padding-top:50px">
<script src="js/d3.v2.js"></script>
<script src="js/histogram-chart.js"></script>
<script>

<?php
  function getvar($vname, $deflt)  { 
    if(isset($_GET[$vname]) && $_GET[$vname]!=''){
      echo urldecode($_GET[$vname]) ;
    }
    else
    echo "$deflt"; 
  }
?>

  var field ='<?php 
			getvar('field','Age');
			?>';
  var state =[<?php 
      getvar('state','');
      ?>];
  var party = [<?php 
      getvar('party','');
      ?>]; 
  var distribution = [];
  d3.csv("MPTrack.csv",function(mps) {
    for (var i = mps.length - 1; i >= 0; i--) {
      mps[i][field] = parseFloat(mps[i][field]);
      if ( (state.length == 0 || state.indexOf(mps[i]['State']) >= 0) && (party.length == 0 || party.indexOf(mps[i]['Political party']) >= 0) )
        distribution.push(mps[i][field]);
    }
    
    d3.select("body")
      .datum(distribution)
    .call(histogramChart(field)
      .bins(d3.scale.linear().domain(d3.extent(distribution)).ticks(2.75 * Math.ceil(Math.log(distribution.length)+1)))
    );
  });

</script>
</body>