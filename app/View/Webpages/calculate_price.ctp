<?php
setlocale(LC_MONETARY, 'en_IN');

//pr($stone_details);exit;
if(!empty($stone_details)){	
	$sd_clarity='<tr><td width="170">Clarity</td>';
	$sd_color='<tr><td>Color</td>';
	$sd_nostones='<tr><td>No. of Stone</td>';
	$sd_weight='<tr><td>Weight</td>';
	$sd_shape='<tr><td>Shape</td>';
	$sd_setting_type='<tr><td>Setting Type</td>';
	$i=1;
	foreach($stone_details as $stone_detail){
		$sd_clarity.='<td class="widthtd">'.$json['clarity'].'</td>';
		$sd_color.='<td class="widthtd">'.$json['color'].'</td>';		
		$sd_nostones.='<td class="widthtd">'.$stone_detail['Productdiamond']['noofdiamonds'].'</td>';
		$sd_weight.='<td class="widthtd">'.$stone_detail['Productdiamond']['stone_weight'].'</td>';
		$sd_shape.='<td class="widthtd">'.$stone_detail['Productdiamond']['shape'].'</td>';
		$sd_setting_type.='<td class="widthtd">'.$stone_detail['Productdiamond']['settingtype'].'</td>';
		$i++;
	}
	$sd_clarity.='</tr>';
	$sd_color.='</tr>';
	$sd_shape.='</tr>';
	$sd_setting_type.='</tr>';
	$sd_nostones.='</tr>';
	$sd_weight.='</tr>';
	
		
	$stonehtml='<h1>Diamonds Details</h1>';	
	$stonehtml.=(($i>3)?('<div style="overflow-x:scroll;overflow:y:hidden; width:490px;">'):'');
	$stonehtml.='<table cellpadding="0" cellspacing="0" border="0" width="'.(($i>3)?($i*100):'100%').'">
     '.$sd_clarity.$sd_color.$sd_nostones.$sd_weight.$sd_shape.$sd_setting_type.'	 
     </table>';
	$stonehtml.=(($i>3)?('</div>'):'');	
	$stonehtml.='<table width="100%"><tr><td colspan="'.$i.'">&nbsp;</td></tr></table>';
	 
}else{
	$stonehtml='';
}

$product_details='';
$category=ClassRegistry::init('Category')->find('first',array('conditions'=>array('category_id'=>$product['Product']['category_id'])));
$product_details.='<table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td width="170">Product Code</td>
                    	<td>'.$category['Category']['category_code'].$product['Product']['product_code'].'-'.$json['purity'].'K'.$json['clarity'].$json['color'].'</td>
                    </tr>
                	<tr>
                    	<td>Metal</td>
                    	<td> '.$json['purity'].'K '.$json['gold_color'].' Gold</td>
                    </tr>
					<tr>
                    	<td>Approximate Metal weight</td>
                    	<td>'.$json['goldweight'].' gm</td>
                    </tr>
					<tr class="show_non_gold">
                    	<td>Approximate Product weight</td>
                    	<td>'.$json['weight'].' gm</td>
                    </tr>
					<tr class="show_non_gold">
                    	<td>Width</td>
                    	<td>'.$product['Product']['width'].' mm</td>
                    </tr>
					<tr class="show_non_gold">
                    	<td>Height</td>
                    	<td>'.$product['Product']['height'].' mm</td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                </table>';
if(!empty($sgemstone)){	
		$gemstone='';
		
		foreach($sgemstone as $sgemstones) {	
		$gemstone.='<h1>'.$sgemstones['Productgemstone']['gemstone'].' Details</h1>
					<div class="price_div"><table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td width="170">No. of Stone</td>
							<td>'.$sgemstones['Productgemstone']['no_of_stone'].'</td>
						</tr>
						<tr>
							<td>Shape</td>
							<td> '.$sgemstones['Productgemstone']['shape'].'</td>
						</tr>
						<tr>
							<td>Size</td>
							<td>'.$sgemstones['Productgemstone']['size'].' mm</td>
						</tr>
						<tr>
							<td>Setting Type</td>
							<td>'.$sgemstones['Productgemstone']['settingtype'].'</td>
						</tr>						
						<tr>
							<td>'.$sgemstones['Productgemstone']['gemstone'].' Weight</td>
							<td>'.$sgemstones['Productgemstone']['stone_weight'].' Carat</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
					</table>';
		}
	}
	else
	{
		$gemstone='';
	}
							
				
$price='';
$n_gold_price = !empty($goldprice) ? $goldprice['Price']['price'] : 0;
$price.='<table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td colspan="2" style="border-bottom:none;">
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td><strong>Component</strong></td>
                                	<td><strong>Rate</strong></td>
                                	<td><strong>Weight</strong></td>
                                	<td><strong>Value</strong></td>
                                </tr>
                            	<tr>
                                	<td>'.$json['purity'].'K  '.$json['gold_color'].' Gold</td>
                                	<td>Rs. '.indian_number_format(round($n_gold_price*($json['purity']/24))).'/gm</td>
                                	<td>'.$json['goldweight'].' gm</td>
                                	<td><span  style="float:left;">Rs.</span><span style="float:right;"> '.($json['gold_price']).'</span></td>
                                </tr>';
							if(!empty($stone_details)){
                            	$price.='<tr>
                                	<td colspan="4"><strong>Diamonds</strong></td>
                                </tr>
                            	<tr>
                                	<td>'.$json['clarity'].'-'.$json['color'].' - '.$noofstones.' Nos.</td>
                                	<td>Rs. '.indian_number_format($stoneprice['Price']['price']).'/ct</td>
                                	<td>'.$stoneweight.' ct</td>
                                	<td><span style="float:left;">Rs.</span><span style="float:right;"> '.($json['stone_price']).'</span></td>
                                </tr>';
								}
								if(!empty($sgemstone)){	
									foreach($sgemstone as $sgemstones) {
										$stone=ClassRegistry::init('Gemstone')->find('first',array('conditions'=>array('stone'=>$sgemstones['Productgemstone']['gemstone'])));
										$stone_shape=ClassRegistry::init('Shape')->find('first',array('conditions'=>array('shape'=>$sgemstones['Productgemstone']['shape'])));
										$prices=ClassRegistry::init('Price')->find('first',array('conditions'=>array('gemstone_id'=>$stone['Gemstone']['gemstone_id'],'gemstoneshape'=>$stone_shape['Shape']['shape_id'])));
											$price.='<tr>
													<td colspan="4"><strong>'.$sgemstones['Productgemstone']['gemstone'].'</strong></td>
												</tr>
												<tr>
													<td>'.$sgemstones['Productgemstone']['shape'].' - '.$sgemstones['Productgemstone']['no_of_stone'].' Nos.</td>
													<td>Rs. '.indian_number_format(round($prices['Price']['price'])).'/ct</td>
													<td>'.$sgemstones['Productgemstone']['stone_weight'].' ct</td>
													<td><span style="float:left;">Rs.</span><span style="float:right;"> '.round($prices['Price']['price'])*$sgemstones['Productgemstone']['stone_weight'].'</span></td>
												</tr>';
									}
								}
								 
								
                            	 $price.='<tr>
                                	<td><strong>Making Charges</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td ><span  style="float:left;">Rs.</span><span style="float:right;"> '.($json['making_charge']>1000?indian_number_format($json['making_charge']):$json['making_charge']).'</span></td>
                                </tr>
                            	<tr>
                                	<td><strong>VAT</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td><span  style="float:left;">Rs.</span><span style="float:right;"> '.($json['vat']>1000? indian_number_format($json['vat']):$json['vat']).'</span></td>
                                </tr>
								<tr>
                                	<td><strong>Total</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td ><strong><span style="float:left;">Rs.</span><span style="float:right;">'.$json['total'].'</span></strong></td>
                                </tr>						
                          </table>
                        ';

$cart='';
$cart.='<input type="hidden" name="data[Shoppingcart][product_id]" value="'.$product['Product']['product_id'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][metal]" value="Gold">';
$cart.='<input type="hidden" name="data[Shoppingcart][size]" value="'.$json['size'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][color]" value="'.$json['color'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][clarity]" value="'.$json['clarity'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][purity]" value="'.$json['purity'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][metalcolor]" value="'.$json['gold_color'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][weight]" value="'.$json['goldweight'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][stoneamount]" value="'.$json['stone_price'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][goldamount]" value="'.$json['gold_price'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][vat]" value="'.$json['vat'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][vat_per]" value="'.$product['Product']['vat_cst'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][making_charge]" value="'.$json['making_charge'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][making_per]" value="'.$product['Product']['making_charge'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][total]" value="'.$json['total'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][goldprice]" value="'.$n_gold_price.'">';
$cart.='<input type="hidden" name="data[Shoppingcart][stoneprice]" value="'.(!empty($stoneprice)?$stoneprice['Price']['price']:'0').'">';
$cart.='<input type="hidden" name="data[Shoppingcart][gemstoneamount]" value="'.$json['gemstone'].'">';
$cart.='<input type="hidden" name="data[Shoppingcart][no_of_diamond]" value="'.(!empty($stone_details)?$noofstones:'').'">';
$cart.='<input type="hidden" name="data[Shoppingcart][quantity]" value="1">';

						
						
$array=array_merge(array('pricediv'=>$price,'product_details'=>$product_details,'stonedetails'=>$stonehtml,'gemstonediv'=>$gemstone,'cartdiv'=>$cart),$json);

echo json_encode($array);
?> 
