INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.port_in_usage_perc','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','Ports using more than X perc of capacity IN','alerting',0,'macros',0,1,0);
INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.port_out_usage_perc','((%ports.ifOutOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifOutOctets_rate*8)/%ports.ifSpeed)*100','Ports using more than X perc of capacity OUT','alerting',0,'macros',0,1,0);
INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.port_now_down','%ports.ifOperStatus != %ports.ifOperStatus_prev && %ports.ifOperStatus_prev = "up" && %ports.ifAdminStatus = "up"','%ports.ifOperStatus != %ports.ifOperStatus_prev && %ports.ifOperStatus_prev = "up" && %ports.ifAdminStatus = "up"','Port has gone down','alerting',0,'macros',0,1,0);
INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.device_component_down_junos','%sensors.sensor_class = "state" && %sensors.sensor_current != "6" && %sensors.sensor_type = "jnxFruState" && %sensors.sensor_current != "2"','%sensors.sensor_class = "state" && %sensors.sensor_current != "6" && %sensors.sensor_type = "jnxFruState" && %sensors.sensor_current != "2"','Device Component down [JunOS]','alerting',0,'macros',0,1,0);
INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.device_component_down_cisco','%sensors.sensor_current != "1" && %sensors.sensor_current != "5" && %sensors.sensor_type ~ "^cisco.*State$"','%sensors.sensor_current != "1" && %sensors.sensor_current != "5" && %sensors.sensor_type ~ "^cisco.*State$"','Device Component down [Cisco]','alerting',0,'macros',0,1,0);
INSERT INTO `config` (config_name,config_value,config_default,config_descr,config_group,config_group_order,config_sub_group,config_sub_group_order,config_hidden,config_disabled) VALUES ('alert.macros.rule.pdu_over_ampage_apc','%sensors.sensor_class = "current" && %sensors.sensor_descr = "Bank Total" && %sensors.sensor_current > %sensors.sensor_limit && %devices.os = "apc"','%sensors.sensor_class = "current" && %sensors.sensor_descr = "Bank Total" && %sensors.sensor_current > %sensors.sensor_limit && %devices.os = "apc"','PDU Over Amperage [APC]','alerting',0,'macros',0,1,0);
INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','BGP Sessions.','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed\\r\\n{/if}\nTimestamp: %timestamp\\r\\n\nUnique-ID: %uid\\r\\n\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\n#%key: %value.string\\r\\n\nPeer: %value.astext\\r\\n\nPeer IP: %value.bgpPeerIdentifier\\r\\n\nPeer AS: %value.bgpPeerRemoteAs\\r\\n\nPeer EstTime: %value.bgpPeerFsmEstablishedTime\\r\\n\nPeer State: %value.bgpPeerState\\r\\n\n{/foreach}\n{/if}','','');
INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','Ports','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed{/if}\nTimestamp: %timestamp\nUnique-ID: %uid\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\\r\\n\n#%key: %value.string\\r\\n\nPort: %value.ifName\\r\\n\nPort Name: %value.ifAlias\\r\\n\nPort Status: %value.message\\r\\n\n{/foreach}\\r\\n\n{/if}\n','','');
INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','Temperature','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed{/if}\\r\\n\nTimestamp: %timestamp\\r\\n\nUnique-ID: %uid\\r\\n\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\\r\\n\n#%key: %value.string\\r\\n\nTemperature: %value.sensor_current\\r\\n\nPrevious Measurement: %value.sensor_prev\\r\\n\n{/foreach}\\r\\n\n{/if}','','');
