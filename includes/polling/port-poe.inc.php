<?php

$cpe_oids = array(
    'cpeExtPsePortEnable',
    'cpeExtPsePortDiscoverMode',
    'cpeExtPsePortDeviceDetected',
    'cpeExtPsePortIeeePd',
    'cpeExtPsePortAdditionalStatus',
    'cpeExtPsePortPwrMax',
    'cpeExtPsePortPwrAllocated',
    'cpeExtPsePortPwrAvailable',
    'cpeExtPsePortPwrConsumption',
    'cpeExtPsePortMaxPwrDrawn',
    'cpeExtPsePortEntPhyIndex',
    'cpeExtPsePortEntPhyIndex',
    'cpeExtPsePortPolicingCapable',
    'cpeExtPsePortPolicingEnable',
    'cpeExtPsePortPolicingAction',
    'cpeExtPsePortPwrManAlloc',
);

$peth_oids = array(
    'pethPsePortAdminEnable',
    'pethPsePortPowerPairsControlAbility',
    'pethPsePortPowerPairs',
    'pethPsePortDetectionStatus',
    'pethPsePortPowerPriority',
    'pethPsePortMPSAbsentCounter',
    'pethPsePortType',
    'pethPsePortPowerClassifications',
    'pethPsePortInvalidSignatureCounter',
    'pethPsePortPowerDeniedCounter',
    'pethPsePortOverLoadCounter',
    'pethPsePortShortCounter',
    'pethMainPseConsumptionPower',
);

if ($this_port['dot3StatsIndex'] && $port['ifType'] == 'ethernetCsmacd') {
    $rrdfile = get_port_rrdfile_path ($device['hostname'], $port_id, 'poe');
    if (!file_exists($rrdfile)) {
        $rrd_create .= $config['rrd_rra'];

        // FIXME CISCOSPECIFIC
        $rrd_create .= ' DS:PortPwrAllocated:GAUGE:600:0:U';
        $rrd_create .= ' DS:PortPwrAvailable:GAUGE:600:0:U';
        $rrd_create .= ' DS:PortConsumption:DERIVE:600:0:U';
        $rrd_create .= ' DS:PortMaxPwrDrawn:GAUGE:600:0:U ';

        rrdtool_create($rrdfile, $rrd_create);
    }

    $upd = "$polled:".$port['cpeExtPsePortPwrAllocated'].':'.$port['cpeExtPsePortPwrAvailable'].':'.$port['cpeExtPsePortPwrConsumption'].':'.$port['cpeExtPsePortMaxPwrDrawn'];

    $fields = array(
        'PortPwrAllocated'   => $port['cpeExtPsePortPwrAllocated'],
        'PortPwrAvailable'   => $port['cpeExtPsePortPwrAvailable'],
        'PortConsumption'    => $port['cpeExtPsePortPwrConsumption'],
        'PortMaxPwrDrawn'    => $port['cpeExtPsePortMaxPwrDrawn'],
    );

    $ret = rrdtool_update("$rrdfile", $fields);

    $tags = array('ifName' => $port['ifName']);
    influx_update($device,'poe',$tags,$fields);

    echo 'PoE ';
}//end if
