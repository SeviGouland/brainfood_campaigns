<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reports_model');
        $this->load->library('pagination');
    }

    public function homeIndex()
    {
        $this->load->view('home');
    }

    // public function view_report_list() {

    //     $id = $this->uri->segment(6);
    //     $data['reportsByCampaign'] = $this->Reports_model->getReportsByCampaign();

    //     $config = array();
    //     $config['base_url'] = admin_url('brainfood_campaigns/reports/view_report_list' . $id);
    //     $config['total_rows'] = $this->Reports_model->get_count();
    //     $config['per_page'] = 5;
    //     $config['uri_segment'] = 5;
    //     $config['num_links'] = 5;

    //     // Bootstrap pagination configuration
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['first_link'] = 'First';
    //     $config['last_link'] = 'Last';
    //     $config['first_tag_open'] = '<li class="page-item">';
    //     $config['first_tag_close'] = '</li>';
    //     $config['prev_link'] = '&laquo';
    //     $config['prev_tag_open'] = '<li class="page-item">';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['next_link'] = '&raquo';
    //     $config['next_tag_open'] = '<li class="page-item">';
    //     $config['next_tag_close'] = '</li>';
    //     $config['last_tag_open'] = '<li class="page-item">';
    //     $config['last_tag_close'] = '</li>';
    //     $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    //     $config['cur_tag_close'] = '</a></li>';
    //     $config['num_tag_open'] = '<li class="page-item">';
    //     $config['num_tag_close'] = '</li>';
    //     $config['attributes'] = array('class' => 'page-link');

    //     $this->pagination->initialize($config);

    //     $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    //     $data['reports'] = $this->Reports_model->get_reports($config['per_page'], $page);
    //     $data['pagination'] = $this->pagination->create_links();

    //     $this->load->view('reports_list', $data);
    // }

    public function get_reports_with_filters() {

        $filters = $this->input->get();
        $reports = $this->Reports_model->get_reports($filters);
        echo json_encode($reports);
    }


    public function add_reports() {

        $this->Reports_model->insert_report($this->input->post());
        echo json_encode("success");
    }

    // public function view_add_report()
    // {
    //     $this->load->view('add');
    // }

    // public function add_report()
    // {
    //     if ($this->input->post('add_report')) {
    //         date_default_timezone_set('Europe/Athens');
    //         $date = date('Y-m-d H:i:s');
    //         $responses = $this->input->post('responses');
    //         $impressions = $this->input->post('impressions');
    //         $clicks = $this->input->post('clicks');
    //         $campaign_id = $this->input->post('campaign_id');
    //         $campaign_name = "Campaign $campaign_id";

    //         $report_data = array(
    //             'date' => $date,
    //             'responses' => $responses,
    //             'impressions' => $impressions,
    //             'clicks' => $clicks,
    //             'campaign_id' => $campaign_id,
    //             'campaign_name' => $campaign_name
    //         );

    //         $this->Reports_model->add_report_to_db($report_data);
    //         redirect('admin/brainfood_campaigns/reports/view_report_list', 'refresh');
    //     }
    // }

    public function update_report($id)
    {
        $this->load->view('update');
    }

    public function update_report_process()
    {
        //get the data sended by the client
        $report = $this->input->post();
        //send the data to  a model method
        $modal_resp = $this->Reports_model->update_report($report);
        //get the model response and send it back to the client
        echo json_encode($modal_resp);
    }

    public function delete_report_process($id)
    {
        $modal_resp = $this->Reports_model->delete_report($id);
        echo json_encode($modal_resp);
    }

    public function get_request()
    {

        $reports_url = 'https://api.adbutler.com/v2/reports?type=campaign&period=year&preset=last-12-months';
        $ch = curl_init($reports_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ef1e863b7a65a6f1e9d2b5eb5c3a5d80'
        ]);
        $JSONresponse = curl_exec($ch);
        curl_close($ch);
        $responses = json_decode($JSONresponse, true);

        // echo '<pre>';
        // echo 'RESPONSE:';
        // var_dump($responses);
        // echo '</pre>';


        foreach ($responses['data'] as $item) {

            if ($item['id'] && !empty($item['id'])) {

                $campaign_id = $item['id'];

                if (!$this->Reports_model->report_exists($campaign_id)) {



                    // echo "<pre>";
                    // print_r ($item);
                    // echo "</pre>";

                    $summary = $item['summary'];

                    $obToInsert = array(
                        'campaign_id' => $item['id'],
                        'campaign_name' => 'Campaign' . ' ' . $item['id'],
                        'responses' => $item['summary']['responses'],
                        'impressions' => $item['summary']['impressions'],
                        'clicks' => $item['summary']['clicks']
                    );

                    echo "<pre>";
                    print_r($obToInsert);
                    echo "</pre>";

                    $this->Reports_model->add_report_to_db($obToInsert);
                }
            }
        }
    }
}
