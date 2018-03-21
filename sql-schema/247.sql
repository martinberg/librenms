INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.now','NOW()','NOW()','Macro currenttime','alerting',0,'macros',0,'1','0'),('alert.macros.rule.past_5m','DATE_SUB(NOW(),INTERVAL 5 MINUTE)','DATE_SUB(NOW(),INTERVAL 5 MINUTE)','Macro past 5 minutes','alerting',0,'macros',0,'1','0'),('alert.macros.rule.past_10m','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','Macro past 10 minutes','alerting',0,'macros',0,'1','0'),('alert.macros.rule.past_15m','DATE_SUB(NOW(),INTERVAL 15 MINUTE)','DATE_SUB(NOW(),INTERVAL 15 MINUTE)','Macro past 15 minutes','alerting',0,'macros',0,'1','0'),('alert.macros.rule.past_30m','DATE_SUB(NOW(),INTERVAL 30 MINUTE)','DATE_SUB(NOW(),INTERVAL 30 MINUTE)','Macro past 30 minutes','alerting',0,'macros',0,'1','0'),('alert.macros.rule.device','(%devices.disabled = 0 && %devices.ignore = 0)','(%devices.disabled = 0 && %devices.ignore = 0)','Devices that aren\'t disabled or ignored','alerting',0,'macros',0,'1','0'),('alert.macros.rule.device_up','(%devices.status = 1 && %macros.device)','(%devices.status = 1 && %macros.device)','Devices that are up','alerting',0,'macros',0,'1','0'),('alert.macros.rule.device_down','(%devices.status = 0 && %macros.device)','(%devices.status = 0 && %macros.device)','Devices that are down','alerting',0,'macros',0,'1','0'),('alert.macros.rule.port','(%ports.deleted = 0 && %ports.ignore = 0 && %ports.disabled = 0)','(%ports.deleted = 0 && %ports.ignore = 0 && %ports.disabled = 0)','Ports that aren\'t disabled, ignored or delete','alerting',0,'macros',0,'1','0'),('alert.macros.rule.port_up','(%ports.ifOperStatus = \"up\" && %ports.ifAdminStatus = \"up\" && %macros.port)','(%ports.ifOperStatus = \"up\" && %ports.ifAdminStatus = \"up\" && %macros.port)','Ports that are up','alerting',0,'macros',0,'1','0'),('alert.admins','true','true','Alert administrators','alerting',0,'general',0,'0','0'),('alert.default_only','true','true','Only alert default mail contact','alerting',0,'general',0,'0','0'),('alert.default_mail','','','The default mail contact','alerting',0,'general',0,'0','0'),('alert.transports.pagerduty','','','Pagerduty transport - put your API key here','alerting',0,'transports',0,'0','0'),('alert.pagerduty.account','','','Pagerduty account name','alerting',0,'transports',0,'0','0'),('alert.pagerduty.service','','','Pagerduty service name','alerting',0,'transports',0,'0','0'),('alert.tolerance_window','5','5','Tolerance window in seconds','alerting',0,'general',0,'0','0'),('email_backend','mail','mail','The backend to use for sending email, can be mail, sendmail or smtp','alerting',0,'general',0,'0','0'),('alert.macros.rule.past_60m','DATE_SUB(NOW(),INTERVAL 60 MINUTE)','DATE_SUB(NOW(),INTERVAL 60 MINUTE)','Macro past 60 minutes','alerting',0,'macros',0,'1','0'),('alert.macros.rule.port_usage_perc','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','Ports using more than X perc','alerting',0,'macros',0,'1','0'),('alert.transports.dummy','false','false','Dummy transport','alerting',0,'transports',0,'0','0'),('alert.transports.mail','true','true','Mail alerting transport','alerting',0,'transports',0,'0','0'),('alert.transports.irc','FALSE','false','IRC alerting transport','alerting',0,'transports',0,'0','0'),('alert.globals','true','TRUE','Alert read only administrators','alerting',0,'general',0,'0','0'),('email_from','NULL','NULL','Email address used for sending emails (from)','alerting',0,'general',0,'0','0'),('email_user','LibreNMS','LibreNMS','Name used as part of the from address','alerting',0,'general',0,'0','0'),('email_sendmail_path','/usr/sbin/sendmail','/usr/sbin/sendmail','Location of sendmail if using this option','alerting',0,'general',0,'0','0'),('email_smtp_host','localhost','localhost','SMTP Host for sending email if using this option','alerting',0,'general',0,'0','0'),('email_smtp_port','25','25','SMTP port setting','alerting',0,'general',0,'0','0'),('email_smtp_timeout','10','10','SMTP timeout setting','alerting',0,'general',0,'0','0'),('email_smtp_secure','','','Enable / disable encryption (use tls or ssl)','alerting',0,'general',0,'0','0'),('email_smtp_auth','false','FALSE','Enable / disable smtp authentication','alerting',0,'general',0,'0','0'),('email_smtp_username','NULL','NULL','SMTP Auth username','alerting',0,'general',0,'0','0'),('email_smtp_password','NULL','NULL','SMTP Auth password','alerting',0,'general',0,'0','0'),('alert.macros.rule.port_down','(%ports.ifOperStatus = \"down\" && %ports.ifAdminStatus != \"down\" && %macros.port)','(%ports.ifOperStatus = \"down\" && %ports.ifAdminStatus != \"down\" && %macros.port)','Ports that are down','alerting',0,'macros',0,'1','0'),('alert.syscontact','true','TRUE','Issue alerts to sysContact','alerting',0,'general',0,'0','0'),('alert.fixed-contacts','true','TRUE','If TRUE any changes to sysContact or users emails will not be honoured whilst alert is active','alerting',0,'general',0,'0','0'),('alert.transports.nagios','','','Nagios compatible via FIFO','alerting',0,'transports',0,'0','0');
insert into `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) values ('alert.macros.rule.sensor','(%sensors.sensor_alert = 1)','(%sensors.sensor_alert = 1)','Sensors of interest','alerting',0,'macros',0,'1','0');
insert into config (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) values ('alert.macros.rule.packet_loss_15m','(%macros.past_15m && %device_perf.loss)','(%macros.past_15m && %device_perf.loss)','Packet loss over the last 15 minutes','alerting',0,'macros',0,'1','0');
insert into config (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) values ('alert.macros.rule.packet_loss_5m','(%macros.past_5m && %device_perf.loss)','(%macros.past_5m && %device_perf.loss)','Packet loss over the last 5 minutes','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.component','(%component.disabled = 0 && %component.ignore = 0)','(%component.disabled = 0 && %component.ignore = 0)','Component that isn\'t disabled or ignored','alerting',0,'macros',0,'1','0'),('alert.macros.rule.component_normal','(%component.status = 1 && %macros.component)','(%component.status = 1 && %macros.component)','Component that is in a normal state','alerting',0,'macros',0,'1','0'),('alert.macros.rule.component_alert','(%component.status = 0 && %macros.component)','(%component.status = 0 && %macros.component)','Component that alerting','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.port_in_usage_perc','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','Ports using more than X perc of capacity IN','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.port_out_usage_perc','((%ports.ifOutOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifOutOctets_rate*8)/%ports.ifSpeed)*100','Ports using more than X perc of capacity OUT','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.port_now_down','%ports.ifOperStatus != %ports.ifOperStatus_prev && %ports.ifOperStatus_prev = "up" && %ports.ifAdminStatus = "up"','%ports.ifOperStatus != %ports.ifOperStatus_prev && %ports.ifOperStatus_prev = "up" && %ports.ifAdminStatus = "up"','Port has gone down','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.device_component_down_junos','%sensors.sensor_class = "state" && %sensors.sensor_current != "6" && %sensors.sensor_type = "jnxFruState" && %sensors.sensor_current != "2"','%sensors.sensor_class = "state" && %sensors.sensor_current != "6" && %sensors.sensor_type = "jnxFruState" && %sensors.sensor_current != "2"','Device Component down [JunOS]','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.device_component_down_cisco','%sensors.sensor_current != "1" && %sensors.sensor_current != "5" && %sensors.sensor_type ~ "^cisco.*State$"','%sensors.sensor_current != "1" && %sensors.sensor_current != "5" && %sensors.sensor_type ~ "^cisco.*State$"','Device Component down [Cisco]','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.pdu_over_amperage_apc','%sensors.sensor_class = "current" && %sensors.sensor_descr = "Bank Total" && %sensors.sensor_current > %sensors.sensor_limit && %devices.os = "apc"','%sensors.sensor_class = "current" && %sensors.sensor_descr = "Bank Total" && %sensors.sensor_current > %sensors.sensor_limit && %devices.os = "apc"','PDU Over Amperage [APC]','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.component_critical','(%component.status = 2 && %macros.component)','(%component.status = 2 && %macros.component)','Component status Critical','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.bill_quota_over_quota','((%bills.total_data/%bills.bill_quota) * 100) && %bills.bill_type = "quota"','((%bills.total_data/%bills.bill_quota) * 100) && %bills.bill_type = "quota"','Quota bills over X perc of quota','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.bill_cdr_over_quota','((%bills.rate_95th/%bills.bill_cdr) * 100) && %bills.bill_type = "cdr"','((%bills.rate_95th/%bills.bill_cdr) * 100) && %bills.bill_type = "cdr"','CDR bills over X perc of quota','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.sensor_port_link',"(%sensors.entity_link_type = 'port' && %sensors.entity_link_index = %ports.ifIndex && %macros.port_up)","(%sensors.entity_link_type = 'port' && %sensors.entity_link_index = %ports.ifIndex && %macros.port_up)",'Sensors linked to port','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.state_sensor_ok','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 0','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 0','Ok state sensors','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.state_sensor_warning','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 1','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 1','Warning state sensors','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.state_sensor_critical','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 2','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 2','Critical state sensors','alerting',0,'macros',0,'1','0');
INSERT INTO `config` (`config_name`,`config_value`,`config_default`,`config_descr`,`config_group`,`config_group_order`,`config_sub_group`,`config_sub_group_order`,`config_hidden`,`config_disabled`) VALUES ('alert.macros.rule.state_sensor_unknown','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 3','%sensors.sensor_current = %state_translations.state_value && %state_translations.state_generic_value = 3','Unknown state sensors','alerting',0,'macros',0,'1','0');
