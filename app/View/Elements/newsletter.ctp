  <div style="clear:both;"></div>
  <div class="newletter">
 
   
   <div class="col-md-5">
      <div class="uppercaseheading">NEWSLETTER</div>
      <p style="color: #202020; font-weight: 400;text-align:justify">      Provide your email address and get notified about our latest products as well as other awesome offers.</p>
       <?php echo $this->Form->create('webpages', array('id'=>'myForm','action'=>'newsletter')); ?>
       <div class="form-group">

      <div class="col-md-12">
       <div class="input-group">
                                                  <input type="text" name="data[Newsletter][email]"  placeholder="Enter Email" class="validate[required,custom[email]] email form-control" value="">
 
                                                   <span class="input-group-btn">
                                                        <input name="submit" type="submit" value="Subscribe!" class="btn" id="submit" />

                                                   </span>
                                               </div>        
 </div>
           
    </div>
      <?php echo $this->Form->end(); ?>
    </div>
    <div class="col-md-7 border-left">
      <div class="uppercaseheading">LOCATE NEAREST FRANCHISEE</div>
											<div style=" text-align:justify">
													<p style="color: #202020; font-weight: 400;text-align:justify">      
(Delhi NCR, Gurgaon, Noida, Faridabad, Ghaziabad, Mumbai, Pune, Bangalore, Chennai, Chandigarh, Hyderabad, Ludhiana, Ambala, Patiala)<br/><br/>
      Now you can try on our jewellery from the comfort of your home. Please provide us your contact details below and our jewellery consultant will get in touch with you soon.</p>
       <?php echo $this->Form->create('webpages', array('id'=>'tryHome','action'=>'enquries')); ?>
      <div class="form-body">
		
		<div class="form-group">

      <div class="col-md-6">
             <input  type="text" name="data[Enquries][name]" placeholder="Name" class="validate[required] form-control">
         </div>   
   <div class="col-md-6">
            <input type="text" name="data[Enquries][phone]"  placeholder="Phone no" class="validate[required,custom[integer],minSize[10]] form-control" maxlength="10" onkeypress="return intnumbers(this, event)" >
</div> 		   
 </div>
          <div class="form-group">

      <div class="col-md-6">
                      <select  name="data[Enquries][city]" id="try_city" class="validate[required] form-control">
            <option value="">Select City</option>
            <option value="Delhi">Delhi (NCR)</option>
            <option value="Gurgaon">Gurgaon</option>
            <option value="Noida">Noida</option>
            <option value="Faridabad">Faridabad</option>
            <option value="Ghaziabad">Ghaziabad</option>
            <option value="Mumbai">Mumbai</option>
            <option value="Pune">Pune</option>
            <option value="Bangalore">Bangalore</option>
            <option value="Chennai">Chennai</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Hyderabad">Hyderabad</option>
            <option value="Ludhiana">Ludhiana</option>
            <option value="Ambala">Ambala</option>
            <option value="Patiala">Patiala</option>
            <option value="Other">Other</option>
          </select>
           </div>   
   <div class="col-md-6">
           <input  type="text" name="data[Enquries][pincode]"  placeholder="Pincode" class="validate[required,custom[integer],minSize[6]] form-control" maxlength="6" onkeypress="return intnumbers(this, event)" >
  </div> 		   
 </div>
     
	 <div class="form-group">
      <div class="col-md-6">
	     <input  name="submit" type="submit" value="Submit" class="btn">
      
	  </div>
	  </div>
   </div>
      
         <?php echo $this->Form->end(); ?>
     
    </div>
  </div>
  
   <script>
    $(document).ready(function(){
    $("#myForm").validationEngine();
	 $("#tryHome").validationEngine();
    });
</script>
<script>
$(document).ready(function(){
	$('#myForm').submit(function(event) {
		event.preventDefault();
		if(!$("#myForm").validationEngine('validate')){
         return false;
         }
		$('.helpfade').show();
		$('.helptips').show();
		var email=$('.email').val();
		$.ajax({
		type: "POST",
		url: "<?php echo BASE_URL; ?>webpages/newsletter/",
		data: 'id='+email,
		success: function (msg) {
			$('.helpfade').hide();
		    $('.helptips').hide();
				alert(msg);
			 $('.email').val('');
			 }
		});
		
		
	});
	
});
</script>
