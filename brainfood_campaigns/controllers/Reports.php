<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends AdminController 
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Reports_model');
        $this->load->library('pagination');
    }

    public function homeIndex() {
        $this->load->view('home');
    }

    public function view_report_list() {
        $data['reportsByCampaign'] = $this->Reports_model->getReportsByCampaign();

        $config = array();
        $config['base_url'] = admin_url('reports/view_report_list');
        $config['total_rows'] = $this->Reports_model->get_count();
        $config['per_page'] = 5;
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;

        // Bootstrap pagination configuration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['reports'] = $this->Reports_model->get_reports($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('reports_list', $data);
    }

    public function view_add_report() {
        $this->load->view('add');
    }

    public function add_report() {
        if ($this->input->post('add_report')) {
            date_default_timezone_set('Europe/Athens');
            $date = date('Y-m-d H:i:s');
            $responses = $this->input->post('responses');
            $impressions = $this->input->post('impressions');
            $clicks = $this->input->post('clicks');
            $campaign_id = $this->input->post('campaign_id');
            $campaign_name = "Campaign $campaign_id";

            $report_data = array(
                'date' => $date,
                'responses' => $responses,
                'impressions' => $impressions,
                'clicks' => $clicks,
                'campaign_id' => $campaign_id,
                'campaign_name' => $campaign_name
            );

            $this->Reports_model->add_report_to_db($report_data);
            redirect('admin/brainfood_campaigns/reports/view_report_list', 'refresh');
        }
    }

    public function update_report($id) {
        $this->load->view('update');
    }

    public function update_report_process($id) {
        if ($this->input->post('update_report')) {
            $date = $this->input->post('date');
            $responses = $this->input->post('responses');
            $impressions = $this->input->post('impressions');
            $clicks = $this->input->post('clicks');
            $campaign_id = $this->input->post('campaign_id');
            
            $report_details = array(
                'date' => $date,
                'responses' => $responses,
                'impressions' => $impressions,
                'clicks' => $clicks,
                'campaign_id' => $campaign_id,
                'campaign_name' => "Campaign $campaign_id"
            );

            $this->db->where('id', $id);
            $this->db->update('sevi_reports', $report_details);
            redirect('admin/brainfood_campaigns/reports/view_report_list', 'refresh');
        }
    }

    public function delete_report($id) {
        $this->db->where('id', $id);
        $this->db->delete('sevi_reports');
        redirect('admin/brainfood_campaigns/reports/view_report_list', 'refresh');
    }

    public function get_request() {
        // Initialize a cURL session
        $curl = curl_init();
    
        // Set the URL to fetch
        $url = "https://api.adbutler.com/v2/reports?type=campaign&period=year&preset=last-12-months";
    
        // Set the Authorization header
        $authorization = "Basic ef1e863b7a65a6f1e9d2b5eb5c3a5d80";
    
        // Set the cURL options
        curl_setopt($curl, CURLOPT_URL, $url);                // Set the URL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);     // Return the response as a string
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: $authorization",
            "Content-Type: application/json"
        )); // Set the Authorization header
    
        $response = curl_exec($curl);
        curl_close($curl); // Close the cURL session
    
        // Check if the response was received
        if ($response === false) {
            echo "cURL Error: " . curl_error($curl);
            exit;
        }
    
        // Decode the JSON response into an associative array
        $decodedResponse = json_decode($response, true);

        // Ensure the decoded response is an array
        if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
            foreach ($decodedResponse['data'] as $item) {
                // Debug output for the current item
                // print_r($item);
    
                // Ensure 'summary' is set and is an array
                if (isset($item['summary']) && is_array($item['summary'])) {
                    // Extract the required fields
                    $summary = $item['summary'];
                    
                    $obToInsert = array(
                        'id' => isset($item['id']) ? $item['id'] : null,              // Add the 'id' field
                        'impressions' => isset($summary['impressions']) ? $summary['impressions'] : null,  // Add the 'impressions' field
                        'clicks' => isset($summary['clicks']) ? $summary['clicks'] : null,      // Add the 'clicks' field
                        'responses' => isset($summary['responses']) ? $summary['responses'] : null  // Add the 'responses' field if it exists
                    );
    
                    // Print the object to be inserted for debugging
                    print_r($obToInsert);
    
                    // Insert the data into the database using your model
                    $this->Reports_model->add_report_to_db($obToInsert);
                } else {
                    echo "Summary data is missing or not an array for item: ";
                    print_r($item);
                }
            }
        } else {
            echo "Decoded response is not in expected format: ";
            print_r($decodedResponse);
        }
    }
    
}
?>
