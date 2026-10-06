@extends('layouts.app')
@section("content")
<script src="/js/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js"></script>
<script>
    var year = ['Jan','Feb','March', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'October', 'Nov', 'Dec'];
	var purchases = <?php echo $purchase; ?>;
    var sales = <?php echo $sale; ?>;

    var barChartData = {
        labels: year,
        datasets: [{
            label: 'Purchases',
            backgroundColor: "rgb(255, 159, 25)",
            data: purchases
        }, {
            label: 'Sales',
            backgroundColor: "rgb(128, 0, 0)",
            data: sales
        }]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Monthly Sale/Purchase'
                }
            }
        });

    };
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Monthly Purchase / Sale </div>
                <div class="canvas-chart">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section("scripts")
<!--Load JQuery-->
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
<script src="/js/functions.js"></script>
<!--ChartJs-->
<script src="/js/plugins/chartjs/Chart.min.js"></script>
<script src="/js/plugins/chartjs/chartjs-script.js"></script>
@stop

