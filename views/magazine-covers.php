<div class="wrap">
    <h1 class="inline">Magazine Covers</h1>
        <h2 class="nav-tab-wrapper">
            <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
            <?php if($this->region != 'featured'): ?>           
              <?php for ($i=2013; $i <= date('Y'); $i++) { ?>
                  <a href="?page=<?php echo $this->page ?>&year=<?php echo $i ?>" class="nav-tab <?php if($this->year_tab == $i){echo 'nav-tab-active';} ?> "><?php echo $i ?></a>
              <?php } ?>
            <?php endif; ?>
        </h2>

         <form method="post" action="options.php" enctype="multipart/form-data">
             <?php settings_fields($this->year_tab."_".$this->region."_magazine_covers_section"); ?>
            <div id="<?php echo $this->region ?>-list">
                 <h2><?php echo strtoupper($this->region) ?> MAGAZINES</h2>
                  <button class="inline button-primary button button-icon add_month_button">Add New Cover</button>
                <ul class="<?php echo $this->year_tab . '-' . $this->region ?>-ui-sortable ui-sortable magazine-list list-inline magazine-months list-unstyled" data-region="<?php echo $this->region ?>" data-year="<?php echo $this->year_tab ?>">
                <?php
                foreach ($this->view_data as $key => $value) {
                    $cover_month = get_option( $value );
                    $label = explode('_', $key);
                    if ( !empty($cover_month) ) {
                        ?>
                        <li>
                        <?php if($this->region != 'featured'): ?>
                                <label for="<?php echo $value; ?>"><?php echo $label[0]; ?></label>
                        <?php endif; ?>
                                    <img class="<?php echo $value; ?>_preview" src="<?php if ($cover_month['src']) { echo $cover_month['src']; } ?>"  width="185" height="240"/>
                                    <input class="hidden custom_upload_image" type="text" name="<?php echo $value; ?>[src]" id="<?php echo $value; ?>[src]" value="<?php if ($cover_month['src']) { echo $cover_month['src']; } ?>" size="70" />
                                     <br />
                                     <input id="<?php echo $value; ?>_button" name="<?php echo $value; ?>_button" class="custom_upload_image_button button" name="upload_input_button" type="button" value="Choose Image" />
                               
                          </li>

                 <?php  }
                }
                ?>
                </ul>
            </div>
            <?php submit_button(); ?>
        </form>
</div>