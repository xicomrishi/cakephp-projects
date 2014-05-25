<?php 
function show_formatted_datetime($p_date='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date(' F d, Y h:i A', strtotime($p_date));
}

function show_formatted_date($p_date ='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date('M d, Y', strtotime($p_date));
}

function removeSpecialChar($image_name) {

    $image_name = str_replace(" ", "", $image_name);

    $image_name = str_replace("(", "", $image_name);

    $image_name = str_replace(")", "", $image_name);

    $image_name = str_replace("{", "", $image_name);

    $image_name = str_replace("}", "", $image_name);

    $image_name = str_replace("[", "", $image_name);

    $image_name = str_replace("]", "", $image_name);
	

    return $image_name;
}

function percentage($val1, $totalWidth, $precision) 
{
	$new_val = ($val1 / 100) * $totalWidth;
	$new_val = round($new_val, $precision);
	
	return $new_val;
}

function upload_my_file($upload_file, $destination) {

    //move_uploaded_file

    if (move_uploaded_file($upload_file, $destination)) {

        return true;
    } else {

        return false;
    }
}

function create_thumb($path, $size, $save_path) {
	
    if (file_exists($path)) {
		
        $thumb = new my_thumbnail($path); // generate image_file, set filename to resize
        $thumb->size_width(500);  // set width for thumbnail, or
        $thumb->size_height(500);  // set height for thumbnail, or
        $width = $thumb->img["lebar"];
        $height = $thumb->img["tinggi"];
        if ($width > $size || $height > $size) {
            $size = $size;
        } else {
            $size = $width;
        }
		
        $thumb->size_auto($size);  // set the biggest width or height for thumbnail
        $thumb->jpeg_quality(100);  // [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
        $thumb->save($save_path);  // save your thumbnail to file
    } else {
       return false;
    }
}

/* ---------------------------------------------- */

class my_thumbnail {

    var $img;

    function my_thumbnail($imgfile) {

        //
        //detect image format

        $this->img["format"] = ereg_replace(".*\.(.*)$", "\\1", $imgfile);

        $this->img["format"] = strtoupper($this->img["format"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG



            $this->img["format"] = "JPEG";

            $this->img["src"] = ImageCreateFromJPEG($imgfile);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            $this->img["format"] = "PNG";

            $this->img["src"] = ImageCreateFromPNG($imgfile);
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            $this->img["format"] = "GIF";

            $this->img["src"] = ImageCreateFromGIF($imgfile);
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            $this->img["format"] = "WBMP";

            $this->img["src"] = ImageCreateFromWBMP($imgfile);
        } else {

            //DEFAULT

            echo "error|Not Supported File";

            return;
        }



        @$this->img["lebar"] = imagesx($this->img["src"]);

        @$this->img["tinggi"] = imagesy($this->img["src"]);



        //default quality jpeg

        $this->img["quality"] = 100;
    }

    function size_height($size=100) {

        //height

        $this->img["tinggi_thumb"] = $size;



        @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
    }

    function size_width($size=100) {

        //width

        $this->img["lebar_thumb"] = $size;

        @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
    }

    function size_auto($size=100) {

        //size

        if ($this->img["lebar"] >= $this->img["tinggi"]) {

            $this->img["lebar_thumb"] = $size;

            @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
        } else {

            $this->img["tinggi_thumb"] = $size;

            @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
        }
    }

    function jpeg_quality($quality) {

        //jpeg quality

        $this->img["quality"] = $quality;
    }

    function show() {

        //show thumb

        @Header("Content-Type: image/" . $this->img["format"]);



        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */

        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

        imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);



        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG

            imageJPEG($this->img["des"], "", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            imagePNG($this->img["des"]);
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            imageGIF($this->img["des"]);

//			echo "$path";
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            imageWBMP($this->img["des"]);
        }
    }

    function save($save="") {

        //save thumb

        if (empty($save))
            $save = strtolower("./thumb." . $this->img["format"]);

        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */

        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

        @imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);



        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG

            imageJPEG($this->img["des"], "$save", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            imagePNG($this->img["des"], "$save");
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            imageGIF($this->img["des"], "$save");
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            imageWBMP($this->img["des"], "$save");
        }
    }

}

function DownloadImageFromUrl($imagepath)
{
	$partofimage=pathinfo($imagepath);
	$basename=str_replace(' ','%20',$partofimage['basename']);
	if(isset($partofimage['dirname']))
	{
	$url=$partofimage['dirname'].'/'.$basename;
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_POST, 0);	
	curl_setopt($ch,CURLOPT_URL, $url);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
	$result=curl_exec($ch);	
	curl_close($ch);	
	return $result;
	}else{
		return;	
	}
	
} 



?>