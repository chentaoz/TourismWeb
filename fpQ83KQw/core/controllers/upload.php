<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->uid==0) {
            echo -1;
            exit;
        }
    }

    /*
     * 上传操作
     * */
    public function do_upload(){
        $POST_MAX_SIZE = ini_get('post_max_size');
        $unit = strtoupper(substr($POST_MAX_SIZE, -1));
        $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));
        if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier * (int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "POST exceeded maximum allowed size.";
            exit(0);
        }
        $save_path='/upload/tmp/'; //上传文件存放的临时目录
        $upload_name = "Filedata";
        $max_file_size_in_bytes = 1024*1024*4;
        $uptype=isset($_POST['uptype'])?$_POST['uptype']:'';
        // Settings
        if ($uptype == 'avatar') {
            $extension_whitelist = array("jpg","jpeg", "gif", "png");    //头像
        }elseif($uptype == 'guide') {
            $extension_whitelist = array("doc", "txt", "pdf");    //攻略文档
            $max_file_size_in_bytes = 1024*1024*10;
        }elseif($uptype == 'question') {
            $extension_whitelist = array("jpg","jpeg", "gif", "png");    //图片
            $save_path='/upload/question/'.date('Ymd').'/'; //上传文件存放的临时目录
        }else{
            $extension_whitelist = array("jpg","jpeg", "gif", "png");    //图片
        }

        if(!is_dir(FCPATH.$save_path)){
            mkdir(FCPATH.$save_path,0777,true);
        }

        $valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';                //允许的文件名字符
        // Other variables
        $MAX_FILENAME_LENGTH = 260;
        $file_name = "";
        $file_extension = "";
        $uploadErrors = array(
            0 => "文件上传成功",
            1 => "上传的文件超过了 php.ini 文件中的 upload_max_filesize directive 里的设置",
            2 => "上传的文件超过了 HTML form 文件中的 MAX_FILE_SIZE directive 里的设置",
            3 => "上传的文件仅为部分文件",
            4 => "没有文件上传",
            6 => "缺少临时文件夹"
        );

        if (!isset($_FILES[$upload_name])) {
            $this->HandleError("No upload found in \$_FILES for " . $upload_name);
            exit(0);
        } else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
            $this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
            exit(0);
        } else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
            $this->HandleError("Upload failed is_uploaded_file test.");
            exit(0);
        } else if (!isset($_FILES[$upload_name]['name'])) {
            $this->HandleError("File has no name.");
            exit(0);
        }
        $file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            $this->HandleError("File exceeds the maximum allowed size");
            exit(0);
        }
        if ($file_size <= 0) {
            $this->HandleError("File size outside allowed lower bound");
            exit(0);
        }
        $file_name = preg_replace('/[^' . $valid_chars_regex . ']|\.+$/i', '', basename($_FILES[$upload_name]['name']));
        if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
            $this->HandleError("Invalid file name");
            exit(0);
        }


        if (file_exists($save_path . $file_name)) {
            $this->HandleError("File with this name already exists");
            exit(0);
        }

        // Validate file extension
        $path_info = pathinfo($_FILES[$upload_name]['name']);
        $file_extension = $path_info["extension"];
        $is_valid_extension = false;
        foreach ($extension_whitelist as $extension) {
            if (strcasecmp($file_extension, $extension) == 0) {
                $is_valid_extension = true;
                break;
            }
        }
        if (!$is_valid_extension) {
            $this->HandleError("Invalid file extension");
            exit(0);
        }

        //修改文件名
        $file_name = time() . rand(1000, 9999) .'.'.$file_extension;

        if (!move_uploaded_file($_FILES[$upload_name]["tmp_name"], FCPATH.$save_path . $file_name)) {
            $this->HandleError("文件无法保存.");
            exit(0);
        } else {
            $exif = exif_read_data(FCPATH . $save_path . $file_name);
            $ort = $exif["Orientation"];
            $image = imagecreatefromjpeg(FCPATH . $save_path . $file_name);
            switch($ort)
            {

                case 3: // 180 rotate left
                    $new = imagerotate($image, 180, 0);
                    break;


                case 6: // 90 rotate right
                    $new = imagerotate($image, -90, 0);
                    break;

                case 8:    // 90 rotate left
                    $new = imagerotate($image, 90, 0);
                    break;
            }
            $exif["Orientation"] = 1;
            imagejpeg($new,FCPATH . $save_path . $file_name);
//            上传成功 插入数据库
        }
        $src = $save_path . $file_name;
        $data['filename']=$file_name;
        $data['src']=$src;
        echo json_encode($data);
        exit(0);
    }

    function HandleError($message)
    {
        header("HTTP/1.1 500 Internal Server Error");
        echo $message;
    }
//    function autoRotateImage($image) {
//        $orientation = $image->getImageOrientation();
//
//        switch($orientation) {
//            case imagick::ORIENTATION_BOTTOMRIGHT:
//                $image->rotateimage("#000", 180); // rotate 180 degrees
//                break;
//
//            case imagick::ORIENTATION_RIGHTTOP:
//                $image->rotateimage("#000", 90); // rotate 90 degrees CW
//                break;
//
//            case imagick::ORIENTATION_LEFTBOTTOM:
//                $image->rotateimage("#000", -90); // rotate 90 degrees CCW
//                break;
//        }
//
//        // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
//        $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
//    }
}