<div class="modal fade" id="add-campaign-modal" tabindex="-1" role="dialog" aria-labelledby="cleon-modal-title"
    aria-hidden="true" style="z-index: 100001;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Report</h4>
            </div>

            <div id="cleon-modal-body" class="modal-body" style="overflow: auto;word-wrap: break-word;">

                <div id="add-campaign-form" class="form-group">
                <div class="form-group">
                        <label>Campaign ID</label>
                        <input type="text" name="campaign_id" class="form-control" style="width:100%;" required autocomplete="off"> </input>
                    </div>
                    <!-- <div class="form-group">
                        <label>Campaign</label>
                        <input type="text" name="campaign_name" class="form-control" placeholder="Campaign">
                    </div> -->
                    <div class="form-group">
                        <label>Responses</label>
                        <input type="text" name="responses" class="form-control" value="" placeholder="responses">
                    </div>
                    <div class="form-group">
                        <label>Impressions</label>
                        <input type="text" name="impressions" class="form-control" value="" placeholder="impressions">
                    </div>
                    <div class="form-group">
                        <label>Clicks</label>
                        <input type="text" name="clicks" class="form-control" value="" placeholder="clicks">
                    </div>

                    <!-- <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control datetimepicker" style="width:100%;" required autocomplete="off"> </input>
                    </div> -->

                    <input type="hidden" name="id">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="add_report" class="btn btn-default btn-info add-report-btn">Add Report</button>
            </div>
        </div>
    </div>
</div>