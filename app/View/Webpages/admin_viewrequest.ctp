<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody><tr>
<td align="left" valign="top">

<div class="clearfix" id="content">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;"><a class="button" href="<?php echo BASE_URL ?>admin/webpages/customizedrequest">Back to customized request</a></div>   
        <div class="texttabBox"> 
            <form>       	
           <fieldset>
           <legend>Request  Details</legend>
            <dl class="inline">
                              
<h3>Order Details</h3>
<br/><table border="0" cellspacing="10" cellpadding="10" class="table gtable chgovr">
    <tbody>
<tr><td><strong>Name</strong></td><td><?php echo  $requests['Jewellrequest']['name']; ?></td></tr>
<tr><td><strong>Address</strong><td><?php echo  $requests['Jewellrequest']['address']; ?></td></tr>
<tr><td><strong>Mobile</strong><td><?php echo  $requests['Jewellrequest']['mobile']; ?></td></tr>
<tr><td><strong>Email</strong><td><?php echo  $requests['Jewellrequest']['email']; ?></td></tr>
<tr><td><strong>Category</strong><td><?php echo  $requests['Jewellrequest']['product_cat']; ?></td></tr>
</tbody>
</table>
<br/>
<h3>Product Details</h3>
<br/>
<table border="0" cellspacing="10" cellpadding="10" class="table gtable chgovr">
<tbody>
<tr><td><strong>Size</strong></td><td><?php echo  $requests['Jewellrequest']['size']; ?></td></tr>
<tr><td><strong>Height</strong></td><td><?php echo  $requests['Jewellrequest']['height']; ?></td></tr>
<tr><td><strong>Width</strong></td><td><?php echo  $requests['Jewellrequest']['weight']; ?></td></tr>
<tr><td><strong>Length</strong></td><td><?php echo  $requests['Jewellrequest']['length']; ?></td></tr>
<tr><td><strong>Total Weight</strong></td><td><?php echo  $requests['Jewellrequest']['total_weight']; ?></td></tr>
<tr><td><strong>Image</strong></td> <td>
        
        <img width="200px" height="200px" src="<?php echo BASE_URL ?>img/request/<?php echo  $requests['Jewellrequest']['image']; ?>" alt="Not uploaded"></td></tr>
</tbody>
</table>
<br/>
<h3>Metals Details</h3>
<br/>
<table border="0" cellspacing="10" cellpadding="10" class="table gtable chgovr">
<tbody>
<tr><td><strong>Metals Weight</strong></td><td><?php echo  $requests['Jewellrequest']['metal_weight']; ?></td>    </tr>
<tr><td><strong>Purity</strong></td><td><?php echo  $requests['Jewellrequest']['purity']; ?></td>    </tr>
<tr><td><strong>Width</strong></td><td><?php echo  $requests['Jewellrequest']['width']; ?></td>    </tr>
<tr><td><strong>Color</strong></td><td><?php echo  $requests['Jewellrequest']['color']; ?></td>    </tr>
<tr><td><strong>Metals</strong></td><td><?php echo  $requests['Jewellrequest']['metals']; ?></td>    </tr>
</tbody>
</table>
<br/><h3>Diamond Details</h3>
<br/><table border="0" cellspacing="10" cellpadding="10" class="table gtable chgovr">
<thead>
<th>SI-IJ</th>
<th>SI-GH</th>
<th>VS-GH</th>
<th>VVS-EF</th>
<th>Setting</th>
<th>Shape</th>
<th>No.of Stone </th>
<th>Weight/Carat </th>
</thead> <tbody> 
            
       <?php     foreach($dimonds as $dimond) {  
                       ?>
                         <tr>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['si_ij']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['si_gh']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['vs_gh']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['vvs_ef']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['setting']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['shape']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['no_of_stone']; ?></td>
                                                                    <td><?php echo  $dimond['Jewelldiamond']['weight']; ?></td>
                                                                  </tr>
                    
     <?       } ?>

</tbody></table>
<br/><h3>Stone Details</h3>
<br/><table border="0" cellspacing="10" cellpadding="10" class="table gtable chgovr">
<thead>
<th>Stone Name</th>
<th>Shape</th>
<th>Weight/Carat</th>
<th>Setting</th>
<th>No.of Stone</th>
</thead> <tbody> <?php     foreach($stones as $stone) {  
                       ?>
    <tr>
                                                                    <td><?php echo  $stone['Jewellstone']['name']; ?></td>
                                                                    <td><?php echo  $stone['Jewellstone']['shape']; ?></td>
                                                                    <td><?php echo  $stone['Jewellstone']['weight']; ?></td>
                                                                    <td><?php echo  $stone['Jewellstone']['setting']; ?></td>
                                                                    <td><?php echo  $stone['Jewellstone']['no_of_stone']; ?></td>                                                                   
                                                                  </tr>
       <?php        } ?>
           </tbody></table>
                
                
                      </dl>    
                                                 
            </fieldset>
            </form>
          </div>
       </div> 
    </div>

</td>
</tr>
</tbody></table>
