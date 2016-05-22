<?php //echo $this->Html->script(array('highcharts','exporting'));?>

<div id="content" class="clearfix" align="center">
  <div id="overviewContent">
    <h2>DASHBOARD</h2>
    <!--<script type="text/javascript">		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'charts',
						defaultSeriesType: 'line'
					},
					title: {
						text: 'Monthly New User Registration'
					},
					subtitle: {
						text: 'Goolgoal'
					},
					xAxis: {
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					},
					yAxis: {
						title: {
							text: 'Users'
						}
					},
					tooltip: {
						enabled: true,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y;
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: true
						}
					},
					series: [
					<?php 
					/*if(!empty($year)){
						$y=1;
						foreach($year as $years){
							echo "{ name : '".$years."',";
							echo "data : [";
							$k=1;
							foreach($monthlyusers[$years] as $muser){
								echo $muser;
								if($k < count($monthlyusers[$years])){
									echo ",";
								}
								$k++;
							}
							echo "]";
							echo "}";
							if($y < count($year)){
								echo ",";
							}
							$y++;
						}
					}*/
					?>
					]
				});
				
				
			});
				
		</script>-->
    <div id="charts"></div>
  </div>
  <div id="quickLinks">
    
    
  </div>
</div>
