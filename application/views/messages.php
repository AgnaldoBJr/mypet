<?php if($this->session->flashdata('msg')){ ?>             
    <div id="mp-toast" class="mp-toast">
        <div class="row">
            <button type="button"  class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" onclick="dismiss()">
                <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="row"><?php echo $this->session->flashdata('msg'); ?></div>
  </div>
<?php } ?>