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
            <div>
              <button class="btn btn-primary add-campaign">Add Campaign</button>
            </div>
            <div class="row mtop10">
              <table id="second-table" class="table table-striped table-bordered" width="100%"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$this->load->view('templates/modals/edit-campaign-modal.php');
$this->load->view('templates/modals/add-campaign-modal.php');
?>

<?php init_tail(); ?>


<script>
  $(document).ready(function() {

    const reportsEndpoint = `${admin_url}brainfood_campaigns/reports/get_reports_with_filters`;
    const reportsColumns = [{
        title: 'Date',
        searchable: false,
        data: 'date',
        name: 'date'
      },
      {
        title: 'Responses',
        searchable: false,
        data: 'responses',
        name: 'responses'
      },
      {
        title: 'Impressions',
        searchable: false,
        data: 'impressions',
        name: 'impressions'
      },
      {
        title: 'Campaign_ID',
        searchable: false,
        data: 'campaign_id',
        name: 'campaign_id'
      },
      {
        title: 'Campaign Name',
        searchable: false,
        data: 'campaign_name',
        name: 'campaign_name'
      },
      {
        title: 'Clicks',
        searchable: false,
        data: 'clicks',
        name: 'clicks'
      },
      // {
      //   title: 'Status',
      //   searchable: false,
      //   data: null,
      //   render: function(data, type, row) {
      //     //console.log(data);
      //     return parseInt(data.impressions) > 30 ? 'Has many Impressions' : 'Has few impressions';
      //   }
      // },
      {
        title: 'Edit',
        searchable: false,
        data: null,
        render: function(data, type, row) {
          return `
            <div><button class="btn btn-info edit-button"
            data_campaign_id="${row.id}" data-campaign='${JSON.stringify(row)}'>
            Edit
            </button></div>`;
        },
      },
      {
        title: 'Delete',
        searchable: false,
        data: null,
        render: function(data, type, row) {
          return `
            <div><button class="btn btn-danger delete-button"
            data-campaign-id="${row.id}">
            Delete
            </button></div>`;
        },
      }
    ];

    const reportsEndpoint2 = `${admin_url}brainfood_campaigns/reports/get_reports_by_campaign_id`;
    const reportsColumns2 = [{

        title: 'Responses',
        searchable: false,
        data: 'responses',
        name: 'responses'
      },
      {
        title: 'Impressions',
        searchable: false,
        data: 'impressions',
        name: 'impressions'
      },
      {
        title: 'Campaign_ID',
        searchable: false,
        data: 'campaign_id',
        name: 'campaign_id'
      },
      {
        title: 'Campaign Name',
        searchable: false,
        data: 'campaign_name',
        name: 'campaign_name'
      },
      {
        title: 'Clicks',
        searchable: false,
        data: 'clicks',
        name: 'clicks'
      }
    ];


    giveDatatable(reportsEndpoint, reportsColumns, () => {}, {
      searching: true,
      ordering: true
    });

    giveDatatable(reportsEndpoint, reportsColumns2, () => {}, {
      searching: true
    }, '#second-table')

    


    $(document).on('click', '.edit-button', function() {
      // Parse the campaign data from the button's data attribute
      const campaign = JSON.parse($(this).attr('data-campaign'));

      for (const prop in campaign) {
        $(`[name="${prop}"]`).val(campaign[prop]);
      }

      $('#edit-campaign-modal').modal('show');

      // Populate the form with the data from the selected row
      // $('input[name="responses"]').val(campaign.responses);
      // $('input[name="impressions"]').val(campaign.impressions);
      // $('input[name="clicks"]').val(campaign.clicks);
      // $('input[name="campaign_id"]').val(campaign.campaign_id);
    });

    function clearFormFields() {

      $('input[name="responses"], input[name="impressions"], input[name="clicks"],input[name="campaign_id"]').val('')
    }



    $('.update-report-btn').on('click', function() {

      let data = getCustomFormData('#edit-campaign-form', 'input');
      const controllerName = 'reports';
      const methodName = 'update_report_process';
      //make a POST ajax call to a controller method that passes the data
      $.ajax({
        url: `${admin_url}/brainfood_campaigns/${controllerName}/${methodName}`,
        type: 'POST', //or GET
        dataType: 'json', //data type of resposne
        data: data, //the data to be sent
        //what to do with the response after the request completes
        success: function(response) {
          console.log(response);
        }
      });
    });

    $('.add-report-btn').on('click', function() {

      let data = getCustomFormData('#add-campaign-modal', 'input');
      const controllerName = 'reports';

      const methodName = 'add_reports';



      $.ajax({
        url: `${admin_url}/brainfood_campaigns/${controllerName}/${methodName}`,
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
          $('#add-campaign-modal').modal('hide');
          clearFormFields();
          console.log(response);
        }
      });
    })

    $(document).on('click', '.delete-button', function() {
      const id = $(this).data('campaign-id');
      let data = getCustomFormData('#delete-button', id)
      const controllerName = 'reports';
      const methodName = 'delete_report_process';
      $.ajax({
        url: `${admin_url}/brainfood_campaigns/${controllerName}/${methodName}/${id}`,
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
          console.log(response);
        }

      });
    });

    $(document).on('click', '.add-campaign', function() {

      console.log($('#add-campaign-modal'));
      $('#add-campaign-modal').modal('show');
    });

  });

  //create the corresponding controller method
  //the controller method should call a model method which updates the selected campaign
  //after a successful update also close the modal and update the table data

  // {
  // "campaign_name": "Campaign 878076",
  // "responses": "68",
  // "impressions": "68",
  // "clicks": "0",
  // "date": "2024-09-04 16:05:17"
  // }
</script>