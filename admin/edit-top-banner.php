<div class="control-group <?php if(isset($editId) && $editId==4) echo "hide";?>">
	                                <label class="control-label">Top Banner: <br><?php echo "w:2048px &nbsp;&nbsp; h:310px"; ?></label>
	                                <div class="controls">
                                    <?php if(!empty($topBanner))
									{?>
                                    	<img src="../images/<?php echo $topBanner; ?>" width="75" height="100" />
										<button type="submit" name="deleteBanner" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
                                    <?php } 
									else
									{
									?>
                                    	<img src="../images/default.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="topBanner" id="topBanner" class="validate[custom[images]]">
										<span style="color:red;"><?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);}?></span>
									<br clear="all"/>
									</div>
	                                <label class="control-label">Alt Tag</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $bannerAlt;?>" class="validate[] input-xlarge" name="bannerAlt" id="bannerAlt"/>
									</div>
	                                <label class="control-label hide">Caption </label>									
	                                <div class="controls hide">
	                                    <input type="text" value="<?php echo $bannerText1;?>" class="validate[] input-xlarge" name="bannerText1" id="bannerText1"/>
									</div>
	                                <label class="control-label hide">Caption 2</label>									
	                                <div class="controls hide">
	                                    <input type="text" value="<?php echo $bannerText2;?>" class="validate[] input-xlarge" name="bannerText2" id="bannerText2"/>
	                                </div>
	                            </div>