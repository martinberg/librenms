ALTER TABLE  `device_perf` DROP INDEX  `id` , ADD INDEX  `id` (  `id` ), ADD INDEX (  `device_id` );
DELETE n1 FROM pollers n1, pollers n2 WHERE n1.last_polled < n2.last_polled and n1.poller_name = n2.poller_name;
ALTER TABLE pollers ADD PRIMARY KEY (poller_name);
