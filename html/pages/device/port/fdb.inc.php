<?php
$no_refresh = true;
?>
<table id="port-fdb" class="table table-condensed table-hover table-striped">
    <thead>
        <tr>
            <th data-column-id="mac_address">MAC address</th>
            <th data-column-id="ipv4_address">IPv4 Address</th>
            <th data-column-id="interface" data-sortable="false">Port</th>
            <th data-column-id="vlan" data-sortable="false">Vlan</th>
        </tr>
    </thead>
</table>

<script>

var grid = $("#port-fdb").bootgrid({
    ajax: true,
    post: function ()
    {
        return {
            id: "fdb-search",
            device_id: "<?php echo $device['device_id']; ?>"
        };
    },
    url: "ajax_table.php"
});
</script>

