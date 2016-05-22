<?php      
echo $this->Facebook->login(array('width' => '174','height'=>'25','scope' => 'email'),
                     __('Login with Facebook',true));
?>
