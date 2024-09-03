
<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php init_head();
$id = $this->uri->segment(5);
?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">

            <div class="row">
              <div class="col-xs-12">
                <h4 class="page-title">Update Report</h4>
              </div> 
            </div>
            <form action="<?php echo admin_url('brainfood_campaigns/reports/update_report_process/'. $id); ?>" method="post" class="form-group">
            <input type="hidden" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 

            <?php
            $report = $this->db->get_where('sevi_reports', array('id' => $id)); 

            foreach ($report->result() as $report) { ?>

                <div class="form-group hidden">
                        <input type="hidden" name="date" class="form-control" value="<?php echo $report->date;?>" placeholder="date">
                </div>
                <div class="form-group">
                    <label>Responses</label>
                    <input type="text" name="responses" class="form-control" value="<?php echo $report->responses;?>"  placeholder="responses">
                </div>
            
                <div class="form-group">
                    <label>Impressions</label>
                        <input type="text" name="impressions" class="form-control" value="<?php echo $report->impressions;?>" placeholder="impressions">
                </div>
                <div class="form-group">
                    <label>Clicks</label>
                        <input type="text" name="clicks" class="form-control" value="<?php echo $report->clicks;?>" placeholder="clicks">
                </div>
                
            <?php }
                ?>
                <div class="form-group">
                    <label>Campaign</label>
                    <input type="text" name="campaign_id" class="form-control" placeholder="Campaign">
                </div>
                <button type="submit" name="update_report" class="btn btn-default" value="Update Report">Update Report</button>
                </form>
            <?php init_tail(); ?>