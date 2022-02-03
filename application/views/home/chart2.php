

 <script language="javascript" type="text/javascript" src="<?php echo config_item('plugin'); ?>gfx/js/jquery.1.9.1.min.js"></script>

      <script type="text/javascript">
	               $(document).ready(function() {
                var options = {
                    chart: {
                        renderTo: 'container2',
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Pinjaman Non Anggota Per Bulan',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '<?php echo config_item('web_title'); ?>',
                        x: -20
                    },
                   xAxis: {
							categories: []
						},
                    yAxis: {
                        title: {
                            text: 'Jumlah'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> Peminjam<br/>'
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}'
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 100,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                        shadow: true
                    },
                    series: []
                };
                $.getJSON("<?php echo base_url('ajax/peminjam'); ?>", function(json) {
                    options.xAxis.categories = json[0]['data']; 
					//xAxis: {categories: []}
                    options.series[0] = json[1];
                    chart = new Highcharts.Chart(options);
                });
            });
        </script>
 
    
 <script language="javascript" type="text/javascript" src="<?php echo config_item('plugin'); ?>gfx/js/highchart/highcharts.js"></script>

        <script src="<?php echo config_item('plugin'); ?>gfx/js/highchart/modules/exporting.js"></script>
		
	  <div id="container2" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	
	