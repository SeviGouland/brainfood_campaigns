<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">

            <div class="row">
              <div class="col-xs-12">
                <h4 class="page-title">Page Title</h4>
              </div>
            </div>

            <!-- PAGE CONTENT HERE -------------------------->
            <div class="row mtop10">

              <table id="cleon-datatable" class="table table-striped table-bordered" width="100%"></table>


            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php 
$this->load->view('templates/modals/edit-campaign-modal.php');
?>

<?php init_tail(); ?>


<script>

  $(document).ready(function(){

    const reportsEndpoint = `${admin_url}brainfood_campaigns/reports/get_reports_with_filters`;
    const reportsColumns = [{
        title: 'Date',
        searchable: false,
        data: 'date',
        name: 'AdvertiserName'
      },
      {
        title: 'Responses',
        searchable: false,
        data: 'responses',
        name: 'AdvertiserName'
      },
      {
        title: 'Impressions',
        searchable: false,
        data: 'impressions',
        name: 'AdvertiserName'
      },
      {
        title: 'Campaign_ID',
        searchable: false,
        data: 'campaign_id',
        name: 'AdvertiserName'
      },
      {
        title: 'Campaign Name',
        searchable: false,
        data: 'campaign_name',
        name: 'AdvertiserName'
      },
      {
        title: 'Status',
        searchable: false,
        data: null,
        render: function(data, type, row) {
          //console.log(data);
          return parseInt(data.impressions) > 30 ? 'Has many Impressions' : 'Has few impressions';
        }
      },
      {
        title: 'Status',
        searchable: false,
        data: null,
        render: function(data, type, row) {
          return `
            <div><button class="btn btn-info edit-button"
            data_campaign_id="${row.id}"
            <span role="link" data-campaign='${JSON.stringify(row)}' class="edit-campaign">
            Edit
            </button></div>`;
        },
      },
    ];
  
    giveDatatable(reportsEndpoint, reportsColumns, () => {}, {
      searching: true,
    });
  
    $(document).on('click', '.edit-button', function() {
      // Parse the campaign data from the button's data attribute
      const campaign = JSON.parse($(this).attr('data-campaign'));

      for(const prop in campaign){
        $(`[name="${prop}"]`).val(campaign[prop]);
      }

      $('#edit-campaign-modal').modal('show');

      // Populate the form with the data from the selected row
      // $('input[name="responses"]').val(campaign.responses);
      // $('input[name="impressions"]').val(campaign.impressions);
      // $('input[name="clicks"]').val(campaign.clicks);
      // $('input[name="campaign_id"]').val(campaign.campaign_id);
    });
  
    $('.update-report-btn').on('click', function(){
 
      let data = getCustomFormData('#edit-campaign-form', 'input');   
      const controllerName = 'reports';
      const methodName = 'update_report_process';
      //make a POST ajax call to a controller method that passes the data
      $.ajax({
        url: `${admin_url}/brainfood_campaigns/${controllerName}/${methodName}`,
        type: 'POST',      //or GET
        dataType: 'json', //data type of resposne
        data: data,       //the data to be sent
        //what to do with the response after the request completes
        success: function(response) {
          console.log(response);
        }
      });

      
      //create the corresponding controller method
      //the controller method should call a model method which updates the selected campaign
      //after a successful update also close the modal and update the table data

//       {
//     "campaign_name": "Campaign 878076",
//     "responses": "68",
//     "impressions": "68",
//     "clicks": "0",
//     "date": "2024-09-04 16:05:17"
// }
      
    });
  });


</script>