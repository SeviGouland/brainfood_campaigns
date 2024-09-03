<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'sevi_reports')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'sevi_reports` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `campaign_id` int(11) NOT NULL,
        `campaign_name` varchar(127),
        `responses` int(11),
        `impressions` int(11),
        `clicks` int(11),
        `date` datetime DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
