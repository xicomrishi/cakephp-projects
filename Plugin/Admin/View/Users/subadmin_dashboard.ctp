<style>
.user_box{ padding: 15px; float:left; }
.user_div{ background-color: #999; height: 129px; width:136px; border: 1px solid #999; border-radius: 5px; text-align:center; box-shadow: 10px 10px 5px #ccc }
.user_div:hover{ border-radius: 10px; background-color: #ddd; box-shadow:10px 10px 5px #999}
.user_div:hover h3{color:#000;}
.user_div h3{ margin-top:10px; color: #fff}
.user_div img{ border-radius: 30px; max-height: 60px; margin-top:6px;}

</style>

  <!--Container Start from Here-->
 <div id="container">
    <h1>Dashboard</h1>   
    <div align="center" class="whitebox mtop15">
	<?php echo $this->Session->flash(); ?>
        <table cellspacing="0" cellpadding="5" border="0" align="center" style="margin-top:70px;">
          <tr>
          	<td>          	
              <?php if(!empty($users)){
              			foreach($users as $us){
				 ?>
				 <a href="<?php echo $this->webroot.'admin/users/get_admin_dashboard/'.$us['Admin']['id']; ?>">
              	<div class="user_box">
              		
              		<div class="user_div">
              			<?php if(!empty($us['Admin']['company_logo'])){ ?>
              			<img src="<?php echo $this->webroot.'img/company/M_'.$us['Admin']['company_logo']; ?>" alt="">
              		<?php }else{ ?>
              				<img src="<?php echo $this->webroot.'img/company_img.png'; ?>" alt="">
              		<?php } ?>		
              			<h3>
              				<?php echo $us['Admin']['username']; ?><br>
              				<?php echo $us['Admin']['company']; ?>
              			</h3>
              		</div>
              	</div>
              	</a>
              <?php }}?>
             </td>	
            
          </tr>
        </table>
    </div>
    