<div class="col-md-6 chart">
    {!! $orderByTableChart->container() !!}
    <h4 class="chart-title">Doanh Thu Theo Bàn</h4>
    @if($orderByTableChart)
    {!! $orderByTableChart->script() !!}
    @endif
</div>