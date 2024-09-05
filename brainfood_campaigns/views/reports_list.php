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

            <form method="GET">
              <button type="submit" name="trigger_request" value="1">Check Request</button>
            </form>

            <table id="example" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Responses</th>
                  <th>Impressions</th>
                  <th>Clicks</th>
                  <th>Campaign</th>
                  <th>Campaign Name</th>
                </tr>
              </thead>

              <?php foreach ($reports as $report) :  ?>
                <tbody>
                  <tr>
                    <td><?php echo $report->date; ?></td>
                    <td><?php echo $report->responses; ?></td>
                    <td><?php echo $report->impressions; ?></td>
                    <td><?php echo $report->clicks; ?></td>
                    <td><?php echo $report->campaign_id; ?></td>
                    <td><?php echo $report->campaign_name; ?></td>
                    <td><a href="<?php echo site_url(); ?>/admin/brainfood_campaigns/reports/update_report/<?php echo $report->id; ?>" class="btn btn-warning btn-block btn-xs">Edit</a></td>
                    <td><a href="<?php echo site_url(); ?>/admin/brainfood_campaigns/reports/delete_report/<?php echo $report->id; ?>" class="btn btn-danger btn-block btn-xs">Delete</a></td>
                  </tr>
                <?php endforeach ?>
                </tr>
                </tbody>
            </table>
            <p><?php echo $pagination; ?></p>
            <a href="<?php echo site_url('admin/brainfood_campaigns/reports/view_add_report'); ?>" class="btn btn-primary">Add Report</a>


 



            <table class="table table-striped">
              <h3>Reports per campaign</h3>

              <tr>
                <th>Responses</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <th>Campaign ID</th>
                <th>Campaign Name</th>
              </tr>
              <?php foreach ($reportsByCampaign as $report) :  ?>

                <tr>
                  <td><?php echo $report->responses; ?></td>
                  <td><?php echo $report->impressions; ?></td>
                  <td><?php echo $report->clicks; ?></td>
                  <td><?php echo $report->campaign_id; ?></td>
                  <td><?php echo $report->campaign_name; ?></td>
                </tr>

              <?php endforeach ?>
              </tr>
            </table>

            <?php init_tail(); ?>

            <script>
              new DataTable('#example');
            </script>