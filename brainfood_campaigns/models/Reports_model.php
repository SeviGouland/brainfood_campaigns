<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends App_Model {

    public function __construct() {

        parent::__construct();
        $this->load->database(); // Load the database
    }

    /** CRUD ************************************************************************************* */


    // περιμενει μια παραμετρο ωστε να επικοινωνησει ο controller με το model μεσω αυτης
    public function insert_report($details){  

        $data = array(

            "campaign_id" => $details['campaign_id'],
            "campaign_name" =>"Campaign " . $details['campaign_id'],
            "responses" => $details['responses'],
            "impressions" => $details['impressions'],
            "clicks" => $details['clicks']
            // "date" => date('Y-m-d H:m:s', strtotime(str_replace('/', '-', $details['date']))) 
        );
        

        $this->db->insert('sevi_reports', $data);



    }
    
    public function get_reports($filters = ['limit' => 10, 'offset' => 0]) {

        $last_year = date('Y', strtotime('-1 year'));

        $this->db->select('*');
        $this->db->from('sevi_reports');
        //$this->db->where('YEAR(date) >', $last_year);

        if (isset($filters['fromDate']) && $filters['fromDate'] !== '') {
            $this->db->where('date >=', $filters['fromDate']);
           // $this->db->where('YEAR(date) <=', $date_end);
        }
        if (isset($filters['endDate']) && $filters['fromDate'] !== '') {
            $this->db->where('date <=', $filters['endDate']);
           // $this->db->where('YEAR(date) <=', $date_end);
        }
        
        if(isset($filters['search']) && $filters['search'] !== '') {
            $this->db->like('campaign_name', $filters['search'], 'both');
        }
        if(isset($filters['order'])) {
            $this->db->order_by($filters['order'][0]['name'], $filters['order'][0]['dir']);   
        }
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
        $this->db->from('sevi_reports');
        $this->db->where('id', $report_id);
        return $this->db->delete('sevi_reports');
    }

    /** END CRUD ************************************************************************************* */





    public function get_count() {

        return $this->db->count_all('tblsevi_reports'); 
    }

    public function add_report_to_db($report_details) {

        $this->db->insert('sevi_reports', $report_details);
    }

    public function getReportsByCampaign($filters) {

        $this->db->select('
            sum(clicks) as clicks, 
            sum(impressions) as impressions,
            sum(responses) as responses,
            campaign_id,
            campaign_name
        ');
        $this->db->from('tblsevi_reports');
        $this->db->group_by('campaign_id');

        if (isset($filters['fromDate']) && $filters['fromDate'] !== '') {
            $this->db->where('date >=', $filters['fromDate']);
           // $this->db->where('YEAR(date) <=', $date_end);
        }
        if (isset($filters['endDate']) && $filters['fromDate'] !== '') {
            $this->db->where('date <=', $filters['endDate']);
           // $this->db->where('YEAR(date) <=', $date_end);
        }

        if(isset($filters['search']) && $filters['search'] !== '') {
            $this->db->like('campaign_name', $filters['search'], 'both');
        }
        if(isset($filters['order'])) {
            $this->db->order_by($filters['order'][0]['name'], $filters['order'][0]['dir']);   
        }

        $num_rows = $this->db->count_all_results('', false);
        $this->db->limit($filters['limit'], $filters['offset']);
        $query = $this->db->get()->result_array();
               
        return ['data' => $query, 'total'=> $num_rows];
        
        
        


        // $query = $this->d('select impressions, responses,
        //                             clicks, campaign_id, campaign_name  
        //                             from tblsevi_reports
        //                             group by campaign_id');
        // return $query->result();
    }

    public function report_exists($campaign_id) {
        $this->db->where('campaign_id', $campaign_id);
        $query = $this->db->get('sevi_reports'); 

        return $query->num_rows() > 0;
}
}