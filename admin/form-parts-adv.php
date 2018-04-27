<?php 
$fromDate	= "displayFrom";
$toDate		= "displayTill";
?>
							<div class="well row-fluid">                            	                                
                                
                                <div class="control-group">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br> <?php if($type == "Large") echo image_size('large_ads');else if($type == "Medium") echo image_size('medium_ads');else if($type == "Small") echo image_size('small_ads');?></label>
	                                <div class="controls">
										<input type="file" name="advBanner" id="advBanner" class="validate[required,custom[images]]">									
	                                </div>
	                            </div>
                                <!--<div class="control-group">
		                            <label class="control-label">Display From: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="" name="<?php echo $fromDate;?>" id="<?php echo $fromDate;?>"/>
		                            </div>
		                        </div>
                                <div class="control-group">
		                            <label class="control-label">Display Till: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="" name="<?php echo $toDate;?>" id="<?php echo $toDate;?>"/>
		                            </div>
		                        </div>-->
								<div class="control-group">
		                            <label class="control-label">Alt Tag:</label>
		                            <div class="controls">
		                                <input type="text" class="validate[] input-xlarge" value="" name="title" id="title"/>
		                            </div>
		                        </div>
								<div class="control-group">
		                            <label class="control-label">Link:</label>
		                            <div class="controls">
		                                <input type="text" class="validate[] input-xlarge" value="" name="link" id="link"/>
		                            </div>
		                        </div>
                                <div class="control-group">
	                                <label class="control-label">Status:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
                            </div>