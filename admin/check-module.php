<?php 
$rslt=mysqli_query($con,"select * from tbl_modules");
if($userType==2)
	$rslt=mysqli_query($con,"select t2.* from tbl_previleges t1,tbl_modules t2 where t1.module=t2.id and t1.permission=1 and user='".$CurrentUserId."'");
while($row=mysqli_fetch_assoc($rslt))
{
	if($row["module"]=="Header" && $row["activeStatus"]==1)
		$m_header=1;
	if($row["module"]=="Banners" && $row["activeStatus"]==1)
		$m_banners=1;
	if($row["module"]=="Company Profile" && $row["activeStatus"]==1)
		$m_companyProfile=1;
	if($row["module"]=="Contact" && $row["activeStatus"]==1)
		$m_contact=1;
	if($row["module"]=="Services" && $row["activeStatus"]==1)
		$m_services=1;
	if($row["module"]=="Products" && $row["activeStatus"]==1)
		$m_products=1;
	if($row["module"]=="News and Events" && $row["activeStatus"]==1)
		$m_newsEvents=1;
	if($row["module"]=="Career" && $row["activeStatus"]==1)
		$m_career=1;
	if($row["module"]=="Gallery" && $row["activeStatus"]==1)
		$m_gallery=1;
	if($row["module"]=="Footer" && $row["activeStatus"]==1)
		$m_footer=1;
	if($row["module"]=="Pages" && $row["activeStatus"]==1)
		$m_pages=1;
	if($row["module"]=="Clients" && $row["activeStatus"]==1)
		$m_clients=1;
	if($row["module"]=="Projects" && $row["activeStatus"]==1)
		$m_projects=1;
	if($row["module"]=="Newsletter" && $row["activeStatus"]==1)
		$m_newsLetter=1;
	if($row["module"]=="Social Media" && $row["activeStatus"]==1)
		$m_socialMedia=1;
	if($row["module"]=="General Settings" && $row["activeStatus"]==1)
		$m_absolutePath=1;
	if($row["module"]=="Email Settings" && $row["activeStatus"]==1)
		$m_emailSettings=1;
	if($row["module"]=="Partners" && $row["activeStatus"]==1)
		$m_partners=1;
	if($row["module"]=="Brands" && $row["activeStatus"]==1)
		$m_brands=1;
	if($row["module"]=="Testimonials" && $row["activeStatus"]==1)
		$m_testimonials=1;
	if($row["module"]=="Team Members" && $row["activeStatus"]==1)
		$m_teamMembers=1;
	if($row["module"]=="Menu" && $row["activeStatus"]==1)
		$m_menu=1;
	if($row["module"]=="Image Size" && $row["activeStatus"]==1)
		$m_imageSize=1;			
	if($row["module"]=="Subscription" && $row["activeStatus"]==1)
		$m_subscription=1;			
	if($row["module"]=="SEO" && $row["activeStatus"]==1)
		$m_seo=1;			
	if($row["module"]=="Backup" && $row["activeStatus"]==1)
		$m_dbbackup=1;
	if($row["module"]=="Options" && $row["activeStatus"]==1)
		$m_options=1;
	if($row["module"]=="Documents" && $row["activeStatus"]==1)
		$m_documents=1;
}
?>