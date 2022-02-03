 <script language="javascript" type="text/javascript" src="<?php echo config_item('plugin'); ?>gfx/js/highchart/highcharts.js"></script>
	   <script type="text/javascript">
	var jq1 = $.noConflict();
       jq1(function () {
    jq1('#chart2').highcharts({
       chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Persentase Jenis Pinjaman KPKB'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Jenis Pinjaman',
            colorByPoint: true,
            data: [<?php foreach($pinj->result() as $d){$rute2=$d->nama_pinjaman;$total=$d->total;
		{ echo "{ name:'$rute2',y: $total},";}} ?>]
        }]
    });
});
    </script> 
	<div id="chart2"  style="width: 98%; height: 100%; margin:0px"></div>
	
	