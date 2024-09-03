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
                <h4 class="page-title">Add Report</h4>
              </div> 
            </div>
                <form action="<?php echo admin_url('brainfood_campaigns/reports/add_report'); ?>" method="post" class="form-group">
                <input type="hidden" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                    <label>Campaign_name</label>
                    <input type="text" name="campaign_id" class="form-control" placeholder="Responses">
                </div>
                <div class="form-group">
                    <label>Responses</label>
                    <input type="text" name="responses" class="form-control" placeholder="Responses">
                </div>
                <div class="form-group">
                    <label>Impressions</label>
                    <input type="text" name="impressions" class="form-control" placeholder="Impressions">
                </div>
                <div class="form-group">
                    <label>Clicks</label>
                    <input type="text" name="clicks" class="form-control" placeholder="Clicks">
                </div>
                <div class="form-group">
                    <label>Campaign_name</label>
                    <input type="text" name="campaign_name" class="form-control" placeholder="Campaign_name">
                </div>
                
                <button type="submit" name="add_report" class="btn btn-default" value="Add Report">Submit</button>
                </form>

<?php init_tail(); ?>
