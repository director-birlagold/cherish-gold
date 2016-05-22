<?php
/*
 File: /app/controllers/components/image.php
*/
class ImageComponent extends Component
{
    // available properties (variables)    REDEFINE IN PAGE AS NEEDED
    
    // GENERIC - as in used by upload and resize functions
    public $newName         = '';            // new image name (without file extension)
    public $returnType        = 'fullpath';     // specify return type - fullpath | array | bool | blob
    public $safeRename        = 'true';        // rename the new file to remove unsafe characters and spaces
    public $duplicates        = 'u';             // u = make unique / o = overwrite / e = error / a = abort
    
    // UPLOAD FUNCTION
    public $uploadTo        = 'uploaded/';    // folder to upload to (relative to calling document)
    
    // RESIZE FUNCTION
    public $source_file     = '';            // source file to resize
    public $newWidth         = '';            // new image width - e.g. '200' = 200 pixels
    public $newHeight         = '';            // new image height - e.g. '200' = 200 pixels
    public $namePrefix         = '';            // prefix the resized file
    public $newPath         = '';            // path to save the new resized file
    public $aspectRatio     = 'true';        // keep the aspect ratio - true | false
    public $padToFit         = 'true';        // pad the image with the pad colour to fit the new image dimensions - true | false
    public $upscale         = 'false';        // enlarge smaller images or not - true | false
    public $setPosition        = 'cc';            // set position of image within its canvas - e.g. 'cc' = center x center y OR 'tr' = top right
    public $padColour         = '#FFFFFF';    // set background padding colour - '#XXXXXX' or 'transparent' (transparent requires PNG type)
    public $padTransparent    = 'true';         // if uploading a GIF or PNG then set background as transparent - this overrides $padColour
    public $newImgType        = '';             // force resized image to be jpg | gif | png | wbmp - leave blank to match source type
    public $imgQuality        = '80';            // image quality 1-100 (%)
    
    
    
    // array of all generated error messages
    public $errors = array(
        'no-image'         => '<strong>Error:</strong> Please specify a source image - declare: $mj_Image->source_file = "path_to_your_image_here.jpg";',
        'no-width'         => '<strong>Error:</strong> Please specify a width for the new image - declare: $mj_Image->newWidth = 100;',
        'no-height'     => '<strong>Error:</strong> Please specify a height for the new image - declare: $mj_Image->newheight = 100;',
        'image-exists'     => '<strong>Error:</strong> The image you specified already exists',
        'upl-no-array'    => '<strong>Error:</strong> It appears the form did not submit a valid file - please try again.',
        'upl-ini-max'    => '<strong>Error:</strong> The file uploaded exceeds the filesize limit set on this server',
        'upl-maxsize'    => '<strong>Error:</strong> The file uploaded exceeds the filesize limit set for this form',
        'upl-partial'    => '<strong>Error:</strong> The file was only partially uploaded - please try again',
        'upl-no-file'    => '<strong>Error:</strong> No file was submitted for upload',
        'upl-no-tmpDir'    => '<strong>Error:</strong> The temporary upload directory is missing',
        'upl-cant-write'=> '<strong>Error:</strong> Failed to write to the temporary folder - please check the permissions',
        'upl-ext'        => '<strong>Error:</strong> The upload was stopped due to an invalid file extension',
        'upl-no-size'    => '<strong>Error:</strong> The file submitted for upload had a filesize of zero or was corrupt',
        'upl-failed'    => '<strong>Error:</strong> The upload failed - the file could not be moved to the target location - please check the permissions',
        'no-crop-width' => '<strong>Error:</strong> Please specify a crop width for the new image',
        'no-crop-height'=> '<strong>Error:</strong> Please specify a crop height for the new image',
        'no-crop-x'     => '<strong>Error:</strong> Please specify a crop x position for the new image',
        'no-crop-y'        => '<strong>Error:</strong> Please specify a crop y position for the new image',
        'crop-ext'        => '<strong>Error:</strong> The crop was stopped due to an invalid file extension',
    );
    
    #################################################
    #                     METHODS                   #
    #################################################

    // This function runs when this class is instantiated
    public function __construct() {
        //echo 'newImage Constructed';
    }
	
	function multiimageupload($data,$maxw, $maxh, $thumbscalew, $thumbscaleh, $folderName){
		$imgcount=count($data['name']);
		for($i=0;$i<$imgcount;$i++){
			$img='';
			if($data['name'][$i]!=''){
			$img['name']=$data['name'][$i];
			$img['type']=$data['type'][$i];
			$img['tmp_name']=$data['tmp_name'][$i];
			$img['error']=$data['error'][$i];
			$img['size']=$data['size'][$i];
			$image[]= $this->upload_image_and_thumbnail($img,$maxw, $maxh, $thumbscalew, $thumbscaleh, $folderName);
			$img=1;
			}
		}
		if($img=='') {$imagename='';}else{$imagename=implode(",",$image);}
		return $imagename;
	}

    private function hex2dec($_hex) {
        $_color = str_replace('#', '', $_hex);
        $_ret = array(
            'r' => hexdec(substr($_color, 0, 2)),
            'g' => hexdec(substr($_color, 2, 2)),
            'b' => hexdec(substr($_color, 4, 2))
        );
        return $_ret;
    }
    
    public function cleanUp($str) {
        $str = stripslashes($str);
        $str = str_replace(' ','_',$str);
        $str = str_replace('.JPG','.jpg',$str);
        $str = str_replace('.PNG','.png',$str);
        $str = str_replace('.GIF','.gif',$str);
        //$str = ereg_replace("[^A-Za-z0-9_\-\.]", "",$str);
        return $str;
    }
	
	public function delete_image($filename,$folderName) {
		if(is_file("img/".$folderName."/home/".$filename))
			unlink("img/".$folderName."/home/".$filename);
		if(is_file("img/".$folderName."/big/".$filename))
			unlink("img/".$folderName."/big/".$filename);
		if(is_file("img/".$folderName."/small/".$filename))
			unlink("img/".$folderName."/small/".$filename);
	}
	
	public function upload_image_and_thumbnail($data,$maxw, $maxh, $thumbscalew, $thumbscaleh,$folderName,$crop=NULL){
		
		$homeuploaddir = "img/".$folderName."/home"; // the /home/ directory
		$biguploaddir = "img/".$folderName."/big"; // the /big/ directory
		$smalluploaddir = "img/".$folderName."/small"; // the /small/ directory for thumbnails

		// Make sure the required directories exist, and create them if necessary
		ini_set('memory_limit','9999M');
		
		if(!is_dir($homeuploaddir)) mkdir($homeuploaddir,0755,true);
		if(!is_dir($biguploaddir)) mkdir($biguploaddir,0755,true);
		if(!is_dir($smalluploaddir)) mkdir($smalluploaddir,0755,true);
		list($ow, $oh) = getimagesize($data['tmp_name']);
		 if($ow>1200){
		 $nw=1200;
		 $nh=900;
		 }
		 else{
		 $nw=$ow;
		 $nh=$oh;
		 }
		$filetype = $this->getFileExtension($data['name']);
		$filetype = strtolower($filetype);

		if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
		{
			// verify the extension
			return;
		}
		$id_unic = $uuid = String::uuid();
		$filename = $id_unic;

		settype($filename,"string");
		$filename.= ".";
		$filename.=$filetype;
		
		$this->newName = $filename;
		$this->uploadTo = 'img/';
		$this->returnType = 'array'; // RETURN ARRAY OF IMAGE DETAILS
		/*if($filetype == 'gif')
		{
			$this->padColour = 'transparent'; // SET THE BACKGROUND TO A HIDEOUS ORANGEY COLOUR
			$img = $this->upload($data);
			if($img) {
				$this->source_file = $img['path'].$img['image']; // THIS IS AUTOMATICALLY SET BY UPLOAD - just here for reference 
				// creates small thumbnail
				$this->newPath = $smalluploaddir;
				$this->newWidth = $thumbscalew;
				$this->newHeight = $thumbscaleh;
				$i = $this->resize();
				// process main image to reduce storage requirements
				$this->newPath = $biguploaddir;
				$this->newWidth = $nw;
				$this->newHeight = $nh;
				$o = $this->resize(); 
				// resizes originally uploaded image
				$this->newPath = $homeuploaddir;
				$this->newWidth = $nw;
				$this->newHeight = $nh;
				$x = $this->resize(); 
			}
		}
		else
		{*/		
			$tempuploaddir = "img/temp"; // the /temp/ directory, should delete the image after we upload
			if(!is_dir($tempuploaddir)) mkdir($tempuploaddir,0755,true);
			
			$tempfile = $tempuploaddir . "/$filename";
			$homefile = $homeuploaddir . "/$filename";
			$resizedfile = $biguploaddir . "/$filename";
			$croppedfile = $smalluploaddir . "/$filename";
					
			if (is_uploaded_file($data['tmp_name']))
			{
				// Copy the image into the temporary directory
				if (!copy($data['tmp_name'],"$tempfile"))
				{
					//print "Error Uploading File!.";
					unset($filename);
					unlink($tempfile);
					exit();
				}
				else {
					/*
					 *	Generate the home page version of the image center cropped
					 */
					 if($ow>1200){
					 $ow=1200;
					 $oh=1200;
					 }
					$this->resizeImage('resize', $tempuploaddir, $filename, $homeuploaddir, $filename, $ow, $oh, 85);
					if($crop!=''){
						/*
						 *	Generate the big version of the image with max of $imgscale in either directions
						 */
						$this->resizeImage('resizeCrop', $tempuploaddir, $filename, $biguploaddir, $filename, $maxw, $maxh, 85);							
		
						/*
						 *	Generate the small thumbnail version of the image with scale of $thumbscalew and $thumbscaleh
						 */
						$this->resizeImage('resizeCrop', $tempuploaddir, $filename, $smalluploaddir, $filename, $thumbscalew, $thumbscaleh, 75);
					}else{
						/*
						 *	Generate the big version of the image with max of $imgscale in either directions
						 */
						$this->resizeImage('resize', $tempuploaddir, $filename, $biguploaddir, $filename, $maxw, $maxh, 85);							
		
						/*
						 *	Generate the small thumbnail version of the image with scale of $thumbscalew and $thumbscaleh
						 */
						$this->resizeImage('resize', $tempuploaddir, $filename, $smalluploaddir, $filename, $thumbscalew, $thumbscaleh, 75);
					}
	
					// Delete the temporary image
					unlink($tempfile);
				}
			}
		 //}
		return $filename;
	}	
	
    public function getFileExtension($str) {

        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
	
	function resizeImage($cType = 'resize', $srcfolder, $srcname, $dstfolder, $dstname = false, $newWidth=false, $newHeight=false, $quality = 100)
	{
		$srcimg = $srcfolder.DS.$srcname;
		list($oldWidth, $oldHeight, $type) = getimagesize($srcimg);
		$ext = $this->image_type_to_extension($type);

		//check to make sure that the file is writeable, if so, create destination image (temp image)
		if (is_writeable($dstfolder))
		{
			$dstimg = $dstfolder.DS.$dstname;
		}
		else
		{
			//if not let developer know
			debug("You must allow proper permissions for image processing. And the folder has to be writable.");
			debug("Run \"chmod 777 on '$dstfolder' folder\"");
			exit();
		}
		

				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($srcimg);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($srcimg);
						break;
					case 'jpg' :
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($srcimg);
						break;
					default :
						//image type is not a possible option
						return false;
						break;
				}

		//check to make sure that something is requested, otherwise there is nothing to resize.
		//although, could create option for quality only
		if ($newWidth OR $newHeight)
		{
			/*
			 * check to make sure temp file doesn't exist from a mistake or system hang up.
			 * If so delete.
			 */
			if(file_exists($dstimg))
			{
				unlink($dstimg);
			}
			else
			{
				switch ($cType){
					default:
					case 'resize':
						# Maintains the aspect ration of the image and makes sure that it fits
						# within the maxW(newWidth) and maxH(newHeight) (thus some side will be smaller)
						$widthScale = 2;
						$heightScale = 2;

						// Check to see that we are not over resizing, otherwise, set the new scale
						if($newWidth) {
							if($newWidth > $oldWidth) $newWidth = $oldWidth;
							$widthScale = 	$newWidth / $oldWidth;
						}
						if($newHeight) {
							if($newHeight > $oldHeight) $newHeight = $oldHeight;
							$heightScale = $newHeight / $oldHeight;
						}
						//debug("W: $widthScale  H: $heightScale<br>");
						if($widthScale < $heightScale) {
							$maxWidth = $newWidth;
							$maxHeight = false;
						} elseif ($widthScale > $heightScale ) {
							$maxHeight = $newHeight;
							$maxWidth = false;
						} else {
							$maxHeight = $newHeight;
							$maxWidth = $newWidth;
						}

						if($maxWidth > $maxHeight){
							$applyWidth = $maxWidth;
							$applyHeight = ($oldHeight*$applyWidth)/$oldWidth;
						} elseif ($maxHeight > $maxWidth) {
							$applyHeight = $maxHeight;
							$applyWidth = ($applyHeight*$oldWidth)/$oldHeight;
						} else {
							$applyWidth = $maxWidth;
								$applyHeight = $maxHeight;
						}
						$startX = 0;
						$startY = 0;
						break;
					case 'resizeCrop':

						// Check to see that we are not over resizing, otherwise, set the new scale
						// -- resize to max, then crop to center
						if($newWidth > $oldWidth) $newWidth = $oldWidth;
							$ratioX = $newWidth / $oldWidth;

						if($newHeight > $oldHeight) $newHeight = $oldHeight;
							$ratioY = $newHeight / $oldHeight;									

						if ($ratioX < $ratioY) {
							$startX = round(($oldWidth - ($newWidth / $ratioY))/2);
							$startY = 0;
							$oldWidth = round($newWidth / $ratioY);
							$oldHeight = $oldHeight;
						} else {
							$startX = 0;
							$startY = round(($oldHeight - ($newHeight / $ratioX))/2);
							$oldWidth = $oldWidth;
							$oldHeight = round($newHeight / $ratioX);
						}
						$applyWidth = $newWidth;
						$applyHeight = $newHeight;
						break;
					case 'crop':
						// -- a straight centered crop
						$startY = ($oldHeight - $newHeight)/2;
						$startX = ($oldWidth - $newWidth)/2;
						$oldHeight = $newHeight;
						$applyHeight = $newHeight;
						$oldWidth = $newWidth;
						$applyWidth = $newWidth;
						break;
				}

				//create new image
				$newImage = imagecreatetruecolor($applyWidth, $applyHeight);
			    //imagecolortransparent($newImage, imagecolorallocate($newImage,0,0,0));
			    //imagealphablending($newImage, false);
				
				
            $trans_colour = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $trans_colour);
            imagealphablending($newImage, true);
            imagesavealpha($newImage, true);
 				
 				//put old image on top of new image
				imagecopyresampled($newImage, $oldImage, 0,0 , $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);


					switch($ext)
					{
						case 'gif' :
							imagetruecolortopalette($newImage, false, 256);
							imagegif($newImage, $dstimg, $quality);
							break;
						case 'png' :
 							imagepng($newImage, $dstimg, 8);
							break;
						case 'jpg' :
						case 'jpeg' :
							imagejpeg($newImage, $dstimg, $quality);
							break;
						default :
							return false;
							break;
					}

				imagedestroy($newImage);
				imagedestroy($oldImage);

				return true;
			}

		} else {
			return false;
		}

	}
	
	/***********Water Mark **********/
	function watermark($data, $maxw, $maxh, $thumbscalew, $thumbscaleh,$folderName,$BigWatermarkFile,$SmallWatermarkFile)
	{		
		$returnimage=$this->upload_image_and_thumbnail($data,$maxw, $maxh, $thumbscalew, $thumbscaleh,$folderName);
		$this->watermark_imageupload("img/".$folderName."/big/",$returnimage,$BigWatermarkFile);
		$this->watermark_imageupload("img/".$folderName."/small/",$returnimage,$SmallWatermarkFile);
		$this->watermark_imageupload("img/".$folderName."/home/",$returnimage,$BigWatermarkFile);
		//ini_set('memory_limit','9999M');
		//if(!is_dir($watermarkdir)) mkdir($watermarkdir,0755,true);
	    return $returnimage;
	}
	
	function watermark_imageupload($folderName,$fileName,$WatermarkFile){
		$filetype = $this->getFileExtension($WatermarkFile);
		$filetype = strtolower($filetype);

		if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
		{
			// verify the extension
			return;
		}
		switch($filetype)
		{
			case 'gif' :
				$watermark = @imagecreatefromgif($WatermarkFile) or exit('Cannot open the watermark file.');	
				imageAlphaBlending($watermark, false);	
				imageSaveAlpha($watermark, true);
				break;
			case 'png' :
				$watermark = @imagecreatefrompng($WatermarkFile) or exit('Cannot open the watermark file.');	
				imageAlphaBlending($watermark, false);	
				imageSaveAlpha($watermark, true);
				break;
			case 'jpg' :
			case 'jpeg' :
				$watermark = @imagecreatefromjpeg($WatermarkFile) or exit('Cannot open the watermark file.');	
				imageAlphaBlending($watermark, false);	
				imageSaveAlpha($watermark, true);
				break;
			default :
				//image type is not a possible option
				return false;
				break;
		}
		
		$imgfiletype = $this->getFileExtension($fileName);
		$imgfiletype = strtolower($imgfiletype);		
		$image_string = $folderName.DS.$fileName;
		list($width, $height) = getimagesize($image_string);		
		switch($imgfiletype)
		{
			case 'jpg' :
			case 'jpeg' :
				$image = imagecreatefromjpeg($image_string);
				break;
			case 'png' :
				$image = imagecreatefrompng($image_string);
				break;
			case 'gif' :
				$image = imagecreatefromgif($image_string);
				break;
		
			default :
				//image type is not a possible option
				return false;
				break;
		}
		
		
		$imageWidth=imagesx($image);
		$imageHeight=imagesy($image);
		$watermarkwidth=imagesx($watermark);
		$watermarkheight=imagesy($watermark);
		$coordinate_X = ( $imageWidth - 5) - ( $watermarkwidth);
		$coordinate_Y = ( $imageHeight - 5) - ( $watermarkheight);	
		$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);        
		imagealphablending($image, true);
		imagesavealpha($image, true);
		imagecopy($image, $watermark,  $coordinate_X, $coordinate_Y, 0, 0, $watermarkwidth, $watermarkheight);			
		$quality=100;
		switch($imgfiletype)
		{
			case 'gif' :
				if(!($folderName)) header('Content-Type: image/gif');					
				imagegif($image, $folderName.DS.$fileName, $quality);
				break;
			case 'png' :
				if(!($folderName)) header('Content-Type: image/png');	
				imagepng($image, $folderName.DS.$fileName, 8);
				break;
			case 'jpg' :
			case 'jpeg' :
				if(!($folderName)) header('Content-Type: image/jpeg');	
				imagejpeg($image, $folderName.DS.$fileName, $quality);
				break;
			default :
				return false;
				break;
		}	
		
	}
	
	/******cropimage fixed size********/
	function CropImage($srcfolder, $srcname, $dstfolder, $dstname, $newWidth, $newHeight, $applyWidth, $applyHeight, $startX, $startY, $quality = 100)
	{
		$srcimg = $srcfolder.DS.$srcname;
		list($oldWidth, $oldHeight, $type) = getimagesize($srcimg);
		$ext = $this->image_type_to_extension($type);

		//check to make sure that the file is writeable, if so, create destination image (temp image)
		if (is_writeable($dstfolder))
		{
			$dstimg = $dstfolder.DS.$dstname;
		}
		else
		{
			//if not let developer know
			debug("You must allow proper permissions for image processing. And the folder has to be writable.");
			debug("Run \"chmod 777 on '$dstfolder' folder\"");
			exit();
		}
		

				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($srcimg);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($srcimg);
						break;
					case 'jpg' :
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($srcimg);
						break;
					default :
						//image type is not a possible option
						return false;
						break;
				}

		//check to make sure that something is requested, otherwise there is nothing to resize.
		//although, could create option for quality only
		if ($newWidth OR $newHeight)
		{
			/*
			 * check to make sure temp file doesn't exist from a mistake or system hang up.
			 * If so delete.
			 */
		
				
			// -- a straight centered crop
			/*$startY = ($oldHeight - $newHeight)/2;
			$startX = ($oldWidth - $newWidth)/2;*/
			$oldHeight = $newHeight;
			//$applyHeight = $newHeight;
			$oldWidth = $newWidth;
			//$applyWidth = $newWidth;
						
				//create new image
				$newImage = imagecreatetruecolor($applyWidth, $applyHeight);
			    //imagecolortransparent($newImage, imagecolorallocate($newImage,0,0,0));
			    //imagealphablending($newImage, false);
				
				
            $trans_colour = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $trans_colour);
            imagealphablending($newImage, true);
            imagesavealpha($newImage, true);
 				
 				//put old image on top of new image
				imagecopyresampled($newImage, $oldImage, 0,0 , $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);

					switch($ext)
					{
						case 'gif' :
							imagejpeg($newImage, $dstimg, $quality);
							break;
						case 'png' :
 							imagepng($newImage, $dstimg, 8);
							break;
						case 'jpg' :
						case 'jpeg' :
							imagejpeg($newImage, $dstimg, $quality);
							break;
						default :
							return false;
							break;
					}

				imagedestroy($newImage);
				imagedestroy($oldImage);

				return true;
				
		} else {
			return false;
		}

	}
	/**end*****/

	function image_type_to_extension($imagetype)
	{
	if(empty($imagetype)) return false;
		switch($imagetype)
		{
			case IMAGETYPE_GIF    : return 'gif';
			case IMAGETYPE_JPEG    : return 'jpg';
			case IMAGETYPE_PNG    : return 'png';
			case IMAGETYPE_SWF    : return 'swf';
			case IMAGETYPE_PSD    : return 'psd';
			case IMAGETYPE_BMP    : return 'bmp';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_JPC    : return 'jpc';
			case IMAGETYPE_JP2    : return 'jp2';
			case IMAGETYPE_JPX    : return 'jpf';
			case IMAGETYPE_JB2    : return 'jb2';
			case IMAGETYPE_SWC    : return 'swc';
			case IMAGETYPE_IFF    : return 'aiff';
			case IMAGETYPE_WBMP    : return 'wbmp';
			case IMAGETYPE_XBM    : return 'xbm';
			default                : return false;
		}
	}
    
    public function upload($ar) {
        // ERROR CAPTURE
        if(!isset($ar['name'])) { $this->doDie($this->errors['upl-no-array']); exit; } 
        if($ar['error']!=0) { 
            switch($ar['error']) {
                case 1: $this->doDie($this->errors['upl-ini-max']);     exit; break;
                case 2: $this->doDie($this->errors['upl-maxsize']);     exit; break;
                case 3: $this->doDie($this->errors['upl-partial']);     exit; break;
                case 4: $this->doDie($this->errors['upl-no-file']);     exit; break;
                case 6: $this->doDie($this->errors['upl-no-tmpDir']);     exit; break;
                case 7: $this->doDie($this->errors['upl-cant-write']);     exit; break;
                case 8: $this->doDie($this->errors['upl-ext']);         exit; break;
            }
        }
        if($ar['size']==0) { $this->doDie($this->errors['upl-no-size']); exit; } 

        // create variables
        $img_name         = $ar['name'];
        $img_type         = $ar['type'];
        $img_tmp_name     = $ar['tmp_name'];
        $img_error        = $ar['error'];
        $img_size        = $ar['size'];
        
        // rename file to safe filename
        if($this->safeRename=='true') {
            $imgName = ($this->newName!='') ? $this->newName : $img_name;
            $imgName = $this->cleanUp(basename($img_name));
            $imgPath = str_replace(basename($img_name),"",$img_name);
            $img_name = $imgPath.$imgName;
        }
        
        // set target path
        $target_path = $this->uploadTo . basename($img_name);
        
        // Handle duplicates
        if(file_exists($target_path)) {
            switch($this->duplicates) {
                case 'o': break;
                case 'e': $this->doDie($this->errors['image-exists']); exit;
                case 'a': return false; break;
                default: // make unique
                    $im = (strstr(basename($img_name),'.')) ? substr(basename($img_name),0,strrpos(basename($img_name),'.')) : basename($img_name);
                    $ext = str_replace($im,"",basename($img_name));
                    $path = $this->uploadTo;
                    $i=1;
                    while(file_exists($path.$im.$i.$ext)) {
                        $i++;
                    }
                    $imgName = $im.$i.$ext;
                    $imgPath = str_replace(basename($img_name),"",$img_name);
                    $img_name = $imgPath.$imgName;
                    $target_path = $this->uploadTo . $imgName;
            }
        }
        
        // Make path writable // chmod file to 0777 if possible
        if(file_exists($target_path)) {
            @chmod($target_path, 0777);
        }
        
        // Do upload / move image to target path
        if(move_uploaded_file($img_tmp_name, $target_path)) {
            
            // add uploaded file to $this->source_file for resize function quick access
            $this->source_file = $this->uploadTo.basename($img_name);
            
            // Return image, array or blob if required
            switch(strtolower($this->returnType)) {
                case 'array': 
                    $_ar = array(
                        'image'     => basename($img_name),
                        'path'        => $this->uploadTo,
                        'size'        => $img_size
                    );
                    return $_ar; break;
                case 'fullpath':
                    return (file_exists($target_path)) ? $target_path : false; break;
                case 'blob':
                    if(file_exists($target_path)) {
                        $fo = fopen($target_path, 'r');
                        $blob = mysql_real_escape_string(fread($fo, filesize($target_path)));
                        fclose($fo);
                        return $blob; break;
                    } else { return false; break; }
                default:
                    return (file_exists($target_path)) ? true : false; break;
            }
        } else{
            $this->doDie($this->errors['upl-failed']); exit;
        }
    }
    
    public function crop($w=false,$h=false,$x=false,$y=false) {
        // ERROR CAPTURE
        if(!$w) {     $this->doDie($this->errors['no-crop-width']); exit; }
        if(!$h) {     $this->doDie($this->errors['no-crop-height']); exit; }
        if(is_int($x)) {     $this->doDie($this->errors['no-crop-x']); exit; }
        if(is_int($y)) {     $this->doDie($this->errors['no-crop-y']); exit; }
        $sImage = (($this->source_file!='')&&(file_exists($this->source_file))) ? $this->source_file : $this->doDie($this->errors['no-image']);
        
        // make sure the new dimensions are numbers
        $w = (!is_int($w)) ? intval($w) : $w;
        $h = (!is_int($h)) ? intval($h) : $h;
        $x = (!is_int($x)) ? intval($x) : $x;
        $y = (!is_int($y)) ? intval($y) : $y;
        
        // get image details
        $image_info = getimagesize($sImage);
        
        // set source as resource
        switch($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF)  { // not the same as IMAGETYPE
                    $src = imagecreatefromgif($this->source_file);
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'gif';
                } else {
                    $this->doDie($this->errors['crop-ext'].' - GIF images are not supported');
                }
                break;
            case 'image/jpeg':
                if (imagetypes() & IMG_JPG)  {
                    $src = imagecreatefromjpeg($this->source_file) ;
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'jpg';
                } else {
                    $this->doDie($this->errors['crop-ext'].' - JPEG images are not supported');
                }
                break;
            case 'image/png':
                if (imagetypes() & IMG_PNG)  {
                    $src = imagecreatefrompng($this->source_file);
                    imagealphablending($src, true); // setting alpha blending on (we want to blend this image with the canvas)
                    imagesavealpha($src, true); // save alphablending setting
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'png';
                } else {
                    $this->doDie($this->errors['crop-ext'].' - PNG images are not supported');
                }
                break;
            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP)  {
                    $src = imagecreatefromwbmp($this->source_file) ;
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'wbmp';
                } else {
                    $this->doDie($this->errors['crop-ext'].' - WBMP images are not supported');
                }
                break;
            default:
                $this->doDie($this->errors['crop-ext'].' - '.$image_info['mime'].' files are not supported');
                break;
        }
        
        $srcPath = (strstr($sImage,'/')) ? substr($sImage,0,strrpos($sImage,'/')+1) : '';
        $srcName = str_replace($srcPath,'',$sImage);
        
        $path = ($this->newPath!='') ? trim($this->newPath) : trim($srcPath);
        $path = (substr($path,strlen($path)-1,strlen($path))!='/') ? $path.'/' : $path;
        $imgName = ($this->newName!='') ? $this->newName : $srcName;
        
        $imgName = (strstr($imgName,'.')) ? substr($imgName,0,strrpos($imgName,'.')).'.'.$this->imgType 
                                          : $imgName.'.'.$this->imgType; // make sure it has the correct extension
        
        $preFix = ($this->namePrefix!='') ? $this->namePrefix : '';
        
        // if path doesn't exist then create it and chmod to 0777
        if(!file_exists($path)) { mkdir($path, 0777); }
        
        // rename file to safe filename
        if($this->safeRename=='true') {
            $imgName = $this->cleanUp($imgName);
        }
        
        // Handle duplicates
        if(file_exists($path.$preFix.$imgName)) {
            switch($this->duplicates) {
                case 'o': break;
                case 'e': $this->doDie($this->errors['image-exists']); exit;
                case 'a': return false; break;
                default: // make unique
                    $im = (strstr($imgName,'.')) ? substr($imgName,0,strrpos($imgName,'.')) : $imgName;
                    $i=1;
                    while(file_exists($path.$im.$i.'.'.$this->imgType)) {
                        $i++;
                    }
                    $imgName = $im.$i.'.'.$this->imgType;
            }
        }
        
        // Source dimensions
        $s_width = imagesx($src);
        $s_height = imagesy($src);
        
        // Create target image
        $canvas = imagecreatetruecolor($w, $h);
        
        //echo ($canvas.' - '.$src.' - '.$x.' - '.$y.' - 0 - 0 - '.$s_width.' - '.$s_height.' - '.$s_width.' - '.$s_height);
        
        // Copy image
        imagecopyresampled($canvas, $src, $x, $y, 0, 0, $s_width, $s_height, $s_width, $s_height);
        
        // output image
        switch($this->imgType) {
            case 'gif':     $newImg = imagejpeg($canvas, $path.$preFix.$imgName, $this->imgQuality);
            case 'png':
                $quality = (intval($this->imgQuality) > 90) ? 9 : round(intval($this->imgQuality)/10);
                //imagealphablending($canvas, false);
                //imagesavealpha($canvas, true);
                $newImg = imagepng($canvas, $path.$preFix.$imgName,$quality);
            case 'wbmp':     $newImg = imagewbmp($canvas, $path.$preFix.$imgName);
            default:         $newImg = imagejpeg($canvas, $path.$preFix.$imgName, $this->imgQuality);
        }
        
        // clean up
        imagedestroy($src);
        imagedestroy($canvas);
        
        // Return image, array or blob if required
        switch(strtolower($this->returnType)) {
            case 'array': 
                $_ar = array(
                    'image'     => $imgName,
                    'prefix'    => $preFix,
                    'path'        => $path,
                    'height'    => $h,
                    'width'        => $w
                );
                return $_ar; break;
            case 'fullpath':
                return (file_exists($path.$preFix.$imgName)) ? $path.$preFix.$imgName : false; break;
            case 'blob':
                if(file_exists($path.$preFix.$imgName)) {
                    $fo = fopen($path.$preFix.$imgName, 'r');
                    $blob = mysql_real_escape_string(fread($fo, filesize($path.$preFix.$imgName)));
                    fclose($fo);
                    return $blob; break;
                } else { return false; break; }
            default:
                return (file_exists($path.$preFix.$imgName)) ? true : false; break;
        }
    }
    
    public function resize() {
        // ERROR CAPTURE
        if($this->newWidth=='') {     $this->doDie($this->errors['no-width']); exit; }
        if($this->newHeight=='') {     $this->doDie($this->errors['no-height']); exit; }
        $sImage = (($this->source_file!='')&&(file_exists($this->source_file))) ? $this->source_file : $this->doDie($this->errors['no-image']);
        
        // make sure the new dimensions are numbers
        $this->newWidth = (!is_int($this->newWidth)) ? intval($this->newWidth) : $this->newWidth;
        $this->newHeight = (!is_int($this->newHeight)) ? intval($this->newHeight) : $this->newHeight;
        
        // get image details
        $image_info = getimagesize($sImage);
        
        // select the filetype based on file MIME
        // set source as resource
        switch ($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF)  { // not the same as IMAGETYPE
                    $src = imagecreatefromgif($this->source_file);
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'gif';
                } else {
                    $this->doDie($this->errors['upl-ext'].' - GIF images are not supported');
                }
                break;
            case 'image/jpeg':
                if (imagetypes() & IMG_JPG)  {
                    $src = imagecreatefromjpeg($this->source_file) ;
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'jpg';
                } else {
                    $this->doDie($this->errors['upl-ext'].' - JPEG images are not supported');
                }
                break;
            case 'image/png':
                if (imagetypes() & IMG_PNG)  {
                    $src = imagecreatefrompng($this->source_file);
                    imagealphablending($src, true); // setting alpha blending on (we want to blend this image with the canvas)
                    imagesavealpha($src, true); // save alphablending setting
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'png';
                } else {
                    $this->doDie($this->errors['upl-ext'].' - PNG images are not supported');
                }
                break;
            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP)  {
                    $src = imagecreatefromwbmp($this->source_file) ;
                    $this->imgType = ($this->newImgType!=='') ? $this->newImgType : 'wbmp';
                } else {
                    $this->doDie($this->errors['upl-ext'].' - WBMP images are not supported');
                }
                break;
            default:
                $this->doDie($this->errors['upl-ext'].' - '.$image_info['mime'].' files are not supported');
                break;
        }
        
        $srcPath = (strstr($sImage,'/')) ? substr($sImage,0,strrpos($sImage,'/')+1) : '';
        $srcName = str_replace($srcPath,'',$sImage);
        
        $path = ($this->newPath!='') ? trim($this->newPath) : trim($srcPath);
        $path = (substr($path,strlen($path)-1,strlen($path))!='/') ? $path.'/' : $path;
        $imgName = ($this->newName!='') ? $this->newName : $srcName;
        
        $imgName = (strstr($imgName,'.')) ? substr($imgName,0,strrpos($imgName,'.')).'.'.$this->imgType 
                                          : $imgName.'.'.$this->imgType; // make sure it has the correct extension
        
        $preFix = ($this->namePrefix!='') ? $this->namePrefix : '';
        
        // if path doesn't exist then create it and chmod to 0777
        if(!file_exists($path)) { mkdir($path, 0777); }
        
        // rename file to safe filename
        if($this->safeRename=='true') {
            $imgName = $this->cleanUp($imgName);
        }
        
        // Handle duplicates
        if(file_exists($path.$preFix.$imgName)) {
            switch($this->duplicates) {
                case 'o': break;
                case 'e': $this->doDie($this->errors['image-exists']); exit;
                case 'a': return false; break;
                default: // make unique
                    $im = (strstr($imgName,'.')) ? substr($imgName,0,strrpos($imgName,'.')) : $imgName;
                    $i=1;
                    while(file_exists($path.$im.$i.'.'.$this->imgType)) {
                        $i++;
                    }
                    $imgName = $im.$i.'.'.$this->imgType;
            }
        }
        
        // Source dimensions
        $s_width = imagesx($src);
        $s_height = imagesy($src);
        
        // canvas dimensions
        $c_width = $this->newWidth;
        $c_height = $this->newHeight;
        
        // maintain the aspect ratio
        if($this->aspectRatio=='true') {
            if($s_width > $s_height) { 
                $resize_pc = ($this->newWidth/$s_width);
                // make sure the new dimensions fit into defined space
                if(round($s_height*$resize_pc)<=$this->newHeight) {
                    $this->newHeight = round($s_height*$resize_pc);
                } else {
                    $resize_pc = ($this->newHeight/$s_height);
                    $this->newWidth = round($s_width*$resize_pc);
                }
            } else { 
                $resize_pc = ($this->newHeight/$s_height);
                // make sure the new dimensions fit into defined space
                if(round($s_width*$resize_pc)<=$this->newWidth) {
                    $this->newWidth = round($s_width*$resize_pc);
                } else {
                    $resize_pc = ($this->newWidth/$s_width);
                    $this->newHeight = round($s_height*$resize_pc);
                }
            } 
        }
        
        if($this->padToFit!='true') { // if padding not required then set canvas size to new image size aspect
            $c_width = $this->newWidth;
            $c_height = $this->newHeight;
        } 
        
        if($this->upscale!='true'){
            // do not upscale image
            if(($s_width<=$this->newWidth)&&($s_height<=$this->newHeight)) {
                $this->newWidth = $s_width;
                $this->newHeight = $s_height;
            }
        }
         
        
        // set the position of source in the canvas
        if($this->padToFit=='true') {
            // set positions
            $top = $left = 0;
            $right = $c_width-$this->newWidth;
            $cenX = ($c_width/2)-($this->newWidth/2);
            $cenY = ($c_height/2)-($this->newHeight/2);
            $bottom = $c_height-$this->newHeight;
            switch(true) {
                case (strstr($this->setPosition,',')): // pixel x,y entered
                    $dim = explode($this->setPosition,',');
                    $x = intval(@$dim[0]);
                    $y = intval(@$dim[1]);
                    $toPos = array('dx'=>$x,'dy'=>$y,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='tl'): // top left
                    $toPos = array('dx'=>$left,'dy'=>$top,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='tr'): // top right
                    $toPos = array('dx'=>$right,'dy'=>$top,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='tc'): // top centre
                    $toPos = array('dx'=>$cenX,'dy'=>$top,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='bl'): // bottom left
                    $toPos = array('dx'=>$left,'dy'=>$bottom,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='br'): // bottom right
                    $toPos = array('dx'=>$right,'dy'=>$bottom,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='bc'): // bottom centre
                    $toPos = array('dx'=>$cenX,'dy'=>$bottom,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='cl'): // centre left
                    $toPos = array('dx'=>$left,'dy'=>$cenY,'sx'=>0,'sy'=>0); break;
                case ($this->setPosition=='cr'): // centre right
                    $toPos = array('dx'=>$right,'dy'=>$cenY,'sx'=>0,'sy'=>0); break;
                default: // centred horz + vert
                    $toPos = array('dx'=>$cenX,'dy'=>$cenY,'sx'=>0,'sy'=>0); break;
            }
        } else {
            $toPos = array('dx'=>0,'dy'=>0,'sx'=>0,'sy'=>0);
        }
        
        // Create target image
        $canvas = imagecreatetruecolor($c_width, $c_height);
        
        // colour the canvas
        if($this->padColour=='transparent')  {
            $trans_colour = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefill($canvas, 0, 0, $trans_colour);
            imagealphablending($canvas, true);
            imagesavealpha($canvas, true);
        } else {
            $col = $this->hex2dec($this->padColour);
            $bgCol = imagecolorallocate($canvas, $col['r'], $col['g'], $col['b']);
            imagefill($canvas, 0, 0, $bgCol);
        }

        // Copy image
        imagecopyresampled($canvas, $src, $toPos['dx'], $toPos['dy'], $toPos['sx'], $toPos['sy'], $this->newWidth, $this->newHeight, $s_width, $s_height);
        
		imagetruecolortopalette($canvas, false, 256);
        // Output
        if($this->padColour=='transparent')  {
            switch($this->imgType) {
                case 'gif': $newImg = imagegif($canvas, $path.$preFix.$imgName);
                default:     
                    $quality = (intval($this->imgQuality) > 90) ? 9 : round(intval($this->imgQuality)/10);
                    //imagealphablending($canvas, false);
                    //imagesavealpha($canvas, true);
                    $newImg = imagepng($canvas, $path.$preFix.$imgName, $quality);
                    
            }
        } else {
            switch($this->imgType) {
                case 'gif':     $newImg = imagejpeg($canvas, $path.$preFix.$imgName, $this->imgQuality);
                case 'png':
                    $quality = (intval($this->imgQuality) > 90) ? 9 : round(intval($this->imgQuality)/10);
                    //imagealphablending($canvas, false);
                    //imagesavealpha($canvas, true);
                    $newImg = imagepng($canvas, $path.$preFix.$imgName,$quality);
                case 'wbmp':     $newImg = imagewbmp($canvas, $path.$preFix.$imgName);
                default:         $newImg = imagejpeg($canvas, $path.$preFix.$imgName, $this->imgQuality);
            }
        }
        
        // clean up
        imagedestroy($src);
        imagedestroy($canvas);
        
        // Return image, array or blob if required
        switch(strtolower($this->returnType)) {
            case 'array': 
                $_ar = array(
                    'image'     => $imgName,
                    'prefix'    => $preFix,
                    'path'        => $path,
                    'height'    => $c_height,
                    'width'        => $c_width,
                    'bgcolor'    => $this->padColour
                );
                return $_ar; break;
            case 'fullpath':
                return (file_exists($path.$preFix.$imgName)) ? $path.$preFix.$imgName : false; break;
            case 'blob':
                if(file_exists($path.$preFix.$imgName)) {
                    $fo = fopen($path.$preFix.$imgName, 'r');
                    $blob = mysql_real_escape_string(fread($fo, filesize($path.$preFix.$imgName)));
                    fclose($fo);
                    return $blob; break;
                } else { return false; break; }
            default:
                return (file_exists($path.$preFix.$imgName)) ? true : false; break;
        }
    }

    #######################################################
    #
    #        EXTRA IMAGE METHODS
    #
    #######################################################
    
    public function get_image_width($img) {
        if(file_exists($img)) {
            list($width, $height) = getimagesize($img);
            return $width;
        } else {
            return 0;
        }
    }
    
    public function get_image_height($img) {
        if(file_exists($img)) {
            list($width, $height) = getimagesize($img);
            return $height;
        } else {
            return 0;
        }
    }
    
    public function get_image_size($img) {
        if(file_exists($img)) {
            list($width, $height) = getimagesize($img);
            return array('width'=>$width,'height'=>$height);
        } else {
            return array('width'=>0,'height'=>0);
        }
    }
    
    public function doDie($msg,$file="",$line="") {                     // doDie - calls a die function with custom error
        if (($file!='')&&($line!='')) {
        die(    '<h4>Error:</h4>'.$msg.'<br/><br/>'.
                 '<strong>File:</strong> '.$file.
                ' - <strong>on line:</strong> '.$line.
                '</body></html>');
        } else {
        die(    $msg);
        }
    }
}
?>
