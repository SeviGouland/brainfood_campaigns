<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends App_Model {

    public function __construct() {

        parent::__construct();
        $this->load->database(); // Load the database
    }

    public function get_reports($limit, $start) {

        $last_year = date('Y', strtotime('-1 year'));

        $this->db->where('YEAR(date) >', $last_year);
        $this->db->limit($limit, $start);
        $query = $this->db->get('sevi_reports');
        
        return $query->result();
    }

    public function get_count() {

        return $this->db->count_all('tblsevi_reports'); 
    }

    public function add_report_to_db($report_details) {

        $this->db->insert('sevi_reports', $report_details);
    }

    public function getReportsByCampaign() {

        $query = $this->db->query('select sum(impressions) as impressions, sum(responses) as responses,
                                    sum(clicks) as clicks, campaign_id, campaign_name  
                                    from tblsevi_reports
                                    group by campaign_id');
        return $query->result();
    }
}
