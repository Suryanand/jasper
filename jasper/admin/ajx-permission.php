<?php
include_once('config.php');
include_once('session.php');
if(isset($_POST["user"]))
{
	$i=0;
	$rslt=mysqli_query($con,"select * from tbl_previleges where user='".$_POST["user"]."'");
	if(mysqli_num_rows($rslt)>0)
	{
		while($row=mysqli_fetch_assoc($rslt))
		{		
		$i++;			
			$rslt2=mysqli_query($con,"select * from tbl_modules where id='".$row["module"]."'");
			while($row2=mysqli_fetch_assoc($rslt2))
			{
				
			?>
                <tr>
					<td><?php echo $i;?></td>
			        <td><?php echo $row2["module"];?>
						<input type="hidden" name="module[]" value="<?php echo $row2["id"];?>"></td>
                        <td class="view"><i class="fam-tick" <?php if($row["permission"]==0) echo 'style="display:none;"';?>></i><i class="fam-cross" <?php if($row["permission"]!=0) echo 'style="display:none;"';?>></i></td>
                        <td class="add"><i class="fam-tick" <?php if($row["permission"]==1 || $row["permission"]==0) echo 'style="display:none;"';?>></i><i class="fam-cross" <?php if($row["permission"]!=1 && $row["permission"]!=0) echo 'style="display:none;"';?>></i></td>
                        <td class="edit"><i class="fam-tick" <?php if($row["permission"]!=4 && $row["permission"]!=3) echo 'style="display:none;"';?>></i><i class="fam-cross" <?php if($row["permission"]==4 || $row["permission"]==3) echo 'style="display:none;"';?>></i></td>
                        <td class="delete"><i class="fam-tick" <?php if($row["permission"]!=4) echo 'style="display:none;"';?>></i><i class="fam-cross" <?php if($row["permission"]==4) echo 'style="display:none;"';?>></i></td>
					<td>
						<select name="permission<?php echo $row2["id"];?>" onChange="setPermission(this.value,this.parentNode.parentNode)" id="permission<?php echo $row2["id"];?>" data-placeholder="Choose Permission" class="" data-prompt-position="topLeft:-1,-5">
							<option value="">0</option>
							<option value="1" <?php if($row["permission"]==1) echo "selected";?>>1</option>
							<option value="2" <?php if($row["permission"]==2) echo "selected";?>>2</option>
							<option value="3" <?php if($row["permission"]==3) echo "selected";?>>3</option>
							<option value="4" <?php if($row["permission"]==4) echo "selected";?>>4</option>
						</select>
					</td>
                </tr>
            <?php }
		}
	}
	else
	{
		echo "no";
	}
}
