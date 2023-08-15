<div class="col-md-12 chart">
    {!! $chart->container() !!}
    <h4 class="chart-title">Doanh Thu Theo Tháng</h4>
    @if($chart)
    {!! $chart->script() !!}
    @endif
</div>