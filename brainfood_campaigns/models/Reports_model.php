<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends App_Model {

    public function __construct() {

        parent::__construct();
        $this->load->database(); // Load the database
    }

    /** CRUD ************************************************************************************* */

    public function insert_report($report){

    }

    public function get_reports($filters = ['limit' => 10, 'offset' => 0]) {

        $last_year = date('Y', strtotime('-1 year'));

        $this->db->select('*');
        $this->db->from('sevi_reports');
        //$this->db->where('YEAR(date) >', $last_year);
        $num_rows = $this->db->count_all_results('', false);
        $this->db->limit($filters['limit'], $filters['offset']);
        $query = $this->db->get()->result_array();
               
        return ['data' => $query, 'total'=> $num_rows];
    }

    public function update_report($report){
        $this->db->where('id', $report['id']);
        return $this->db->update('sevi_reports', $report);
    }

    public function delete_report($report_id){
        $this->db->where('id', $report_id['id']);
        return $this->db->delete('sevi_reports', $report_id);
    }

    /** END CRUD ************************************************************************************* */





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

    public function report_exists($campaign_id) {
        $this->db->where('campaign_id', $campaign_id);
        $query = $this->db->get('sevi_reports'); 

        return $query->num_rows() > 0;
}
}