<?php
App::uses('CherishwsAppController', 'Cherishws.Controller');

/**
 * Mobileapi Controller
 */
class MobileapiController extends CherishwsAppController {

  /**
   * Components
   *
   * @var array
   */
    public $components = array('Paginator', 'Session', 'Image', 'Mpdf');
    public $uses = array('Shoppingcart', 'Product','Productimage','Order','Discounthistory', 'User', 'Whislist','Category','Productgemstone', 'Productdiamond', 'Gemstone', 'Clarity', 'Color', 'Price', 'Metalcolor', 'Metal', 'Diamond', 'Shape', 'Product', 'Vendorcontact', 'Vendor', 'Category', 'Subcategory', 'Productstone', 'Productimage', 'Size',
        'Metalcolor', 'Metal', 'Diamond', 'Clarity', 'Color', 'Carat', 'Shape', 'Settingtype', 'Purity', 'Productmetal', 'Referral', 'RelationshipManager','CustomerBGP',
        'Productgemstone', 'Productdiamond', 'Gemstone', 'Price', 'Collectiontype', 'Order', 'Franchiseebrokerage','PaymentMaster', 'Menu', 'Rating', 'Staticpage', 'States', 'Cities', 'Contactus', 'Emailcontent', 'Discount', 'Jewellrequest', 'Jewelldiamond', 'Jewellstone', 'Paymentdetails', 'Adminuser');

    
}
?>