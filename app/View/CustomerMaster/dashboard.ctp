<?php $pageTitle = 'Customer'; ?>
<link href="<?php echo BASE_URL ?>css/bootstrap1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo BASE_URL ?>css/stylesheet.css" type="text/css" rel="stylesheet" />
<div id="container">
	<div class="clr"></div>
	<div class="wrapper">		
		<div class="MidSection">
			<div class="clr"></div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom:30px;">
						<h3 style="float:left;font-weight:bold;">Name : <?php echo $customer['CustomerBGP']['applicant_name']; ?> <a href="<?php echo BASE_URL."customer/edit" ?>"><b>(Edit)</b></a></h3>
						<div class="clr"></div>
						<h3 style="float:left;font-weight:bold;">Customer Id : <?php echo $customer['CustomerBGP']['customer_id']; ?></h3>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom:30px;">
						<h3 style="float:right;font-weight:bold;">Gold Price : <?php echo ($price['Price']['price'] * 0.92) ?>(22 K)</h3>
						<div class="clr"></div>
						<h3 style="float:right;font-weight:bold;">Relationship Manager : <?php if(isset($relation)) { echo $relation["RelationshipManager"]["manager_name"]; } ?></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Dashboard</h3>
				  <ul class="list-unstyled">
					<li><a href="#" data-toggle="modal" data-target="#bgplan" >BGP Plan</a></li>
					<li><a href="#" data-toggle="modal" data-target="#accumulated">Accumulation Gold</a></li>
					<li><a href="#" data-toggle="modal" data-target="#oustanding">Payments</a></li>
					
					<li><a href="<?php echo BASE_URL."orders/my_order" ?>">Order History</a></li>
				  </ul>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Referrals</h3>
				  <ul class="list-unstyled">
					<li><?php echo $this->Html->link('List Referrals',array('controller'=>'customermaster','action'=>'listreferral'));?></li>
					<li><?php echo $this->Html->link('Add Referrals',array('controller'=>'customermaster','action'=>'addreferral'));?></li>
				  </ul>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Distributor</h3>
				  <ul class="list-unstyled">
					<?php if($customer['CustomerBGP']['distributor'] == "yes") { ?>
						<li><a href="#" data-toggle="modal" data-target="#totalpoint">Total Points</a></li>
						<li><a href="#" data-toggle="modal" data-target="#prospective">Prospective Point</a></li>
						<li><a href="#">Levels</a></li>
					<?php }
					else
					 { ?>
						<li><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Become Distributor</a></li>
					<?php } ?>
				  </ul>
				</div>
				<!--
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Redeem</h3>
				  <ul class="list-unstyled">
					<li><a href="#">Click to Redeem</a></li>
				  </ul>
				</div>
				-->
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Top Up</h3>
				  <ul class="list-unstyled">
					<li><a href="javascript:void(0);" data-toggle="modal" data-target="#addamount"> Add Amount </a></li>
				  </ul>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-bottom:30px;">
				  <h3>Relationship Manager</h3>
				  <ul class="list-unstyled">
					<li><a href="javascript:void(0);" data-toggle="modal" data-target="#manager"> Details </a></li>
				  </ul>
				</div>
		  </div>
						
		</div>
	</div>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Distributor Agreement</b></h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.</p>
        <p>Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.</p>
        <p>Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.</p>
        <p>Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.</p>
        <p>Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.Some text in the modal.</p>
		 <div class=error style="display:none;"><p>Something went wrong, try again after sometime</p></div>
	 </div>
      <div class="modal-footer">
        <button type="button" class="button" onclick="distributoraccept();">Accept</button>
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="accumulated" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Accumulated Gold</b></h4>
      </div>
      <div class="modal-body">
        <p>Your accumulated gold: 2.2 grams</p>
	 </div>
      <div class="modal-footer">
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="prospective" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Prospective Points</b></h4>
      </div>
      <div class="modal-body">
        <p>Your Prospective Point: 200 Points</p>
	 </div>
      <div class="modal-footer">
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="totalpoint" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Total Points</b></h4>
      </div>
      <div class="modal-body">
        <p>Your Total Points: 100 Points</p>
	 </div>
      <div class="modal-footer">
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="oustanding" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Payments</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">                
			<div id="content" class="col-sm-12">      
            <div class="table-responsive">
				<table class="table table-bordered table-hover">
				  <thead>
					<tr>
					  <th class="text-right">ID</th>
					  <th class="text-left">Month</th>
					  <th class="text-left">Amount</th>
					  <th class="text-left">Status</th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					foreach($data as $dt) { ?>
							<tr>
							  <td class="text-right"><?php echo $dt["c"] ?></td>
							  <td class="text-right"><?php echo $dt["month"]." - ".$dt["year"] ?></td>
							  <td class="text-right"><?php echo $dt["amount"] ?></td>
							  <td class="text-right"><?php echo $dt["payment_done"] ?></td>
							</tr>
					<?php } ?>
				  </tbody>
				  </thead>
				</table>
			</div>
			</div>
		</div>	
	 </div>
      <div class="modal-footer">
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="manager" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" style="font-size: 18px;"><b>Relationship Manager</b></h4>
		</div>
		<div class="modal-body">
			<div class="row">                
				<div class="col-sm-12">      

				<fieldset>
				<h3><b>Name: <?php echo $relation['RelationshipManager']['manager_name']; ?></b></h3>
				<h3><b>Mobile: <?php echo $relation['RelationshipManager']['manager_mobile']; ?></b></h3>
				<h3><b>Phone: <?php echo $relation['RelationshipManager']['manager_phone']; ?></b></h3>
				<h3><b>Email: <?php echo $relation['RelationshipManager']['manager_email']; ?></b></h3>
				<h3><b>Address: <?php echo $relation['RelationshipManager']['manager_address']; ?></b></h3>
				</fieldset>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		<button type="button" class="button" data-dismiss="modal">Close</button>
		</div>
		</div>

	</div>
</div>

<div id="bgplan" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" style="font-size: 18px;"><b>BGP Plan Details</b></h4>
		</div>
		<div class="modal-body">
			<div class="row">                 
				<div class="col-sm-6">      
					<div class="form-group required">
					<label class="col-sm-2 control-label" for="initial_amount">Amount</label>
					<div class="col-sm-10 boss-input">
					  <input type="text" name="data[CustomerBGP][initial_amount]" value="<?php echo $customer['CustomerBGP']['initial_amount'] ?>" id="initial_amount" class="form-control" disabled style="height:35px;"/>
					</div>
					</div>
				</div>			
			</div>
			<div class="row">                 
				<div class="col-sm-6">      
					<div class="form-group required">
					<label class="col-sm-2 control-label" for="fulfilment">Fulfilment Size</label>
					<div class="col-sm-10 boss-input">
					  <select name="data[CustomerBGP][fulfilment]" id="fulfilment" class="form-control">
						<option value="Coin" <?php if($customer['CustomerBGP']['fulfilment'] == "Coin") { echo "selected"; } ?> >Gold Jewellery.</option>
						<option value="Jewellery" <?php if($customer['CustomerBGP']['fulfilment'] == "Jewellery") { echo "selected"; } ?>>Diamond Jewellery.</option>
						<option value="Pendant" <?php if($customer['CustomerBGP']['fulfilment'] == "Pendant") { echo "selected"; } ?>>Gold Pendant.</option>
						</select>
					</div>
					</div>
				</div>			
			</div>
			<div class="row">                 
				<div class="col-sm-6">      
					<div class="form-group required">
					<label class="col-sm-2 control-label" for="period_from">Date From</label>
					<div class="col-sm-10 boss-input">
					  <input type="text" name="data[CustomerBGP][period_from]" value="<?php echo $customer['CustomerBGP']['period_from'] ?>" id="period_from" class="form-control" disabled style="height:35px;"/>
					</div>
					</div>
				</div>			
			</div>
			<div class="row">                 
				<div class="col-sm-6">      
					<div class="form-group required">
					<label class="col-sm-2 control-label" for="period_to">Date To</label>
					<div class="col-sm-10 boss-input">
					  <input type="text" name="data[CustomerBGP][period_to]" value="<?php echo $customer['CustomerBGP']['period_to'] ?>" id="period_to" class="form-control" disabled style="height:35px;"/>
					</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="modal-footer">
		<button type="button" class="button" onclick="changefulfilment();">Submit</button>
		<button type="button" class="button" data-dismiss="modal">Close</button>
		</div>
		</div>

	</div>
</div>

<div id="addamount" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-size: 18px;"><b>Top Up Amount</b></h4>
      </div>
	  <div class="modal-body">
       <div class="row">                
			<div class="col-sm-6">      
				<div class="form-group required">
				<label class="col-sm-2 control-label" for="topup_amount">Amount (in multiple of 1000)</label>
				<div class="col-sm-10 boss-input">
				  <input type="text" name="topup_amount" value="1000" id="topup_amount" class="form-control" style="height:35px;"/>
				</div>
			    </div>
			</div>
	 </div>
	 </div>
      <div class="modal-footer">
		<button type="button" class="button" onclick="addAmount();">Add Amount</button>
        <button type="button" class="button" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
function distributoraccept()
{
	$.ajax({
 		url: '<?php echo BASE_URL ?>customermaster/setDistributor',
 		data:'', 		
 		type: 'post',
		cache: false,
		clearForm: false,
 		success: function(response){
			if(response == "success")
			{
				window.location.href="<?php echo BASE_URL ?>customer/dashboard";
			}
			else{
				$(".error").show();
			}
		}
	});
}	

function changefulfilment()
{
	var fulfil = $("#fulfilment").val();
	$.ajax({
 		url: '<?php echo BASE_URL ?>customermaster/changefulfilment',
 		data:{'fulfilment':fulfil,'action':'fulfilment'}, 		
 		type: 'post',
		cache: false,
		clearForm: false,
 		success: function(response){
			if(response == "success")
			{
				window.location.href="<?php echo BASE_URL ?>customer/dashboard";
			}
			else{
				$(".error").show();
			}
		}
	});
}

function addAmount()
{
	var amount = $("#topup_amount").val();
	if (amount % 1000 == 0) {
		$.ajax({
			url: '<?php echo BASE_URL ?>customermaster/topupamount',
			data:{'amount':amount,'action':'topup'},		
			type: 'post',
			cache: false,
			clearForm: false,
			success: function(response){
				var res = eval('('+response+')');
				if(res["msg"] == "success")
				{
					window.location.href="<?php echo BASE_URL ?>pay?text="+res['encode_application_no'];
				}
				else{
					$("#topup_amount").val("");
					$("#topup_amount").attr("placeholder","Enter values in multiple of 1000");
				}
			}
		});
	}
	else
	{
		$("#topup_amount").val("");
		$("#topup_amount").attr("placeholder","Enter values in multiple of 1000");
	}
}
</script>