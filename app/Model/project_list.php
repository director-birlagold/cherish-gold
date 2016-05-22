<?php 
require_once("config/config.php");
admincheck($mysql);
$client=$mysql->selectdata("select * from `client` order by `Cid` DESC");
if(isset($_REQUEST['delete'])){
			$delete="delete from `client` where `Cid`='".$_GET['Cid']."'";
			$check=$mysql->executequery($delete);
			$msg->add('s','Client deleted successfully');
			header("Location:clientList.php");
			exit();
	}
?>
  <?php include("includes/header.php");?>
  <div id="content" class="clearfix">
    <div class="container">
      <div class="mainheading">
        <div class="btnlink" style="float:right;"><a href="clientadd.php" class="button">Add Client</a></div>
        <div class="button">
                    <div class="add_button"><a href="add_client_details.php">Add Clients</a></div>
                    <div class="add_button"><a href="client_list.php">Client List</a></div>
        		</div>
                <div id="list">	
                <h2 align="left">Project Lists</h2>
                <div align="right">
                    <form method="get">
                    <select name="proj_status" class="select">
                        <option value="">All Status</option>
                        <option value="running">Running</option>
                        <option value="pending">Pending</option>
                         <option value="droped">Droped</option>
                        <option value="success">Success</option>
                        <option value="notyetdecide">Not yet Decide</option>
                    </select>
                    <input type="submit" name="search" value="Search" class="sbutton" />&nbsp;&nbsp;&nbsp;&nbsp;
                    </form>
        		</div>
        <div class="titletag">
          <h1>List of Clients</h1>
        </div>
      </div>
      <table class="gtable sortable">
        <thead>
          <tr>
            <th  width="20" align="center"><img src="img/icons/arrow.jpg" /></th>
            <th width="20" align="left">#</th>
            <th align="left" width="30">Client Name </th>
            <th align="left" width="30">Email ID </th>
            <th align="left" width="30">Skype ID</th>
            <th align="left" width="30">Mobile NO</th>
            <th align="left" width="30">Date Of Birth </th>
            <th align="left" width="30">Country </th>
            <th align="left" width="30">Edit </th>
            <th align="left" width="30">Delete </th>
          </tr>
        </thead>
        <tbody>
          <?php 
				$I=0;
				foreach ($client as $employee_list) {
				$I=$I+1;
				?>
            </td>
          <?php  echo "<tr style='background:".($I % 2 == 0 ? '#FFF4FF' : '#ffffff')."'>"; ?> 
          <td align="center"><img src="img/icons/arrow.jpg" /></td>
          <td align="left"><?php echo $I;?></td>
           <td align="left"><?php echo$employee_list['ClientName'];?></td>
          <td align="left"><?php echo $employee_list['ClientEmail'];?></td>
          <td align="left"><?php  echo $employee_list['Skype'];?></td>
          <td align="left"><?php echo $employee_list['Mobile'];?> </td>
          <td align="left"><?php  echo $employee_list['DOB'];?></td>
          <td align="left"><?php echo $employee_list['Country'];?> </td>
          <td align="center"><a href="clientedit.php?Cid=<?php echo $employee_list['Cid'];?>"><img  src="img/icons/edit.png"/></a></td>
          <td align="center"><a class="confirdel" href="clientList.php?Cid=<?php echo $employee_list['Cid'];?>&amp;delete"><img src="img/icons/cross.png"></a></td>
         </tr>
          <?php 
				}
               ?>
          </tbody>
        
      </table>
      </form>

    </div>
  </div>
</div>
<?php include("includes/footer.php");?>