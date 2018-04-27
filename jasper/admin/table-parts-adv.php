			<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Image</th>
                                    <th>Alt Tag</th>
                                    <th>Link</th>
                                    <th>Order</th>
                                    <!--<th>Display Till</th>-->
                                    <th>Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_adv_banner where type='".$type."'");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><img src="../uploads/<?php echo $row["imageName"]; ?>" width="70" /></td>
			                        <!--<td><?php echo date('d M Y',strtotime($row["displayFrom"])); ?></td>
			                        <td><?php echo date('d M Y',strtotime($row["displayTill"])); ?></td>-->
									<td><?php echo $row["title"];?></td>
									<td><?php echo $row["link"];?></td>
									<td>
										<input type="text" value="<?php echo $row["sortOrder"];?>"  maxlength="65" class="validate[] input-small" name="imageOrder<?php echo $row["id"];?>"/>                                        
                                        <button type="submit" value="<?php echo $row["id"];?>" class="btn btn-info" name="order">Update</button>
									</td>
			                        <td><?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-adv-banner.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                    </form>
                    </div>