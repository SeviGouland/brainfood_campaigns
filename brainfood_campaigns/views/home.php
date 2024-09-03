<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php init_head();?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">

            <div class="row">
              <div class="col-xs-12">
                <h4 class="page-title">Page</h4>
              </div> 
            </div>

			<!-- PAGE CONTENT HERE -------------------------->
            <div class="container vh-100 d-flex justify-content-center align-items-center">
                 <div class="card">
                <div class="card-header">
                <p class="text-center fw-semibold fs-4">Brainfood Reports</p>
                </div>
                <div class="card-body">
                    <p class="card-text text-center fw-medium">Click below to see the Reports</p>
                    <a href="<?php echo site_url('admin/brainfood_campaigns/reports/view_report_list'); ?>" class="btn btn-primary btn-sm d-flex justify-content-center">Show Reports</a>
                </div>
                </div>
                </div>

<?php init_tail(); ?>