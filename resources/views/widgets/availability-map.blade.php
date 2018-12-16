@if($device_totals)
<div class="widget-availability-host">
    <span>@lang('Total hosts')</span>
    @if($show_disabled_and_ignored)
        <span class="label label-default label-font-border label-border">@lang('ignored'): {{ $device_totals['ignored'] }}</span>
        <span class="label blackbg label-font-border label-border">@lang('disabled'): {{ $device_totals['disabled'] }}</span>
    @endif
    <span class="label label-success label-font-border label-border">@lang('up'): {{ $device_totals['up'] }}</span>
    <span class="label label-warning label-font-border label-border">@lang('warn'): {{ $device_totals['warn'] }}</span>
    <span class="label label-danger label-font-border label-border">@lang('down'): {{ $device_totals['down'] }}</span>
</div>
@endif

@if($services_totals)
<div class="widget-availability-service">
    <span>@lang('Total services')</span>
    <span class="label label-success label-font-border label-border">@lang('up'): {{ $services_totals['up'] }}</span>
    <span class="label label-warning label-font-border label-border">@lang('warn'): {{ $services_totals['warn'] }}</span>
    <span class="label label-danger label-font-border label-border">@lang('down'): {{ $services_totals['down'] }}</span>
</div>
@endif

<br style="clear:both;">

@foreach($devices as $device)
    <a href="{{ \LibreNMS\Util\Url::deviceUrl($device) }}" title="{{ $device->displayName() }} - {{ $device->formatUptime(true) }}">
        @if($type == 0)
            @if($color_only_select)
                <span class="label {{ $device->labelClass }} widget-availability label-font-border">@lang($device->stateName)</span>
            @else
                <span class="label {{ $device->labelClass }} widget-availability-fixed widget-availability label-font-border"> </span>
            @endif
        @else
            <div class="availability-map-oldview-box-{{ $device->stateName }}" style="width:{{ $tile_size }}px;height:{{ $tile_size }}px;"></div>
        @endif
    </a>
@endforeach

@foreach($services as $service)
    <a href="{{ \LibreNMS\Util\Url::deviceUrl($service->device, ['tab' => 'services']) }}" title="{{ $service->device->displayName() }} - {{ $service->service_type }} - {{ $service->service_desc }}">
        @if($type == 0)
            @if($color_only_select)
                <span class="label {{ $service->labelClass }} widget-availability label-font-border">{{ $service->service_type }} - {{ $service->stateName }}</span>
            @else
                <span class="label {{ $service->labelClass }} widget-availability-fixed widget-availability label-font-border"> </span>
            @endif
        @else
            <div class="availability-map-oldview-box-{{ $service->stateName }}" style="width:{{ $tile_size }}px;height:{{ $tile_size }}px;"></div>
        @endif
    </a>
@endforeach
