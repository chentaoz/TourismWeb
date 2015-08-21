<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH . '../lib/ImageCache/ImageCache.php';
class Avatar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 头像输出
     */
    public function index($uid)
    {
//        $imagecache = new ImageCache();
//        $imagecache->cached_image_directory = APPPATH . '../cached';

        header('Content-type: text/html; charset=utf-8');//设置编码
        // 文件路径
        $avatar_path = FCPATH . $this->config->item('upload_avatar');
        $file_extension = 'png';
        $file_extensions = array('jpg', 'png', 'jpeg', 'gif');
        foreach ($file_extensions as $ext) {
            $filename = $avatar_path . '/' . $uid . '.' . $ext;
            if (is_file($filename)) {
                $file_extension = $ext; // 存在
                break;
            }
        }
        if (!is_file($filename)) {
            $filename = FCPATH . $this->config->item('upload_avatar') . '/avatar.png'; //默认头像
            $file_extension = 'png'; //
        }

        $thumb_path = FCPATH . str_ireplace('upload', 'thumb', $this->config->item('upload_avatar'));
        if (!is_dir($thumb_path)) {
            mkdir($thumb_path, 0777, true);
        }
        $filename_new = str_ireplace('upload', 'thumb', $filename);
//        $path_info = pathinfo($filename);
//        $file_extension = $path_info["extension"];#echo $file_extension;exit;
        //生成缩略图
        // 最大宽高
        $width = 100;
        $height = 100;
        $cache_key_user_avatar_thumb='user_avatar_thumb_' . $uid;
        if (!ci_get_cache($cache_key_user_avatar_thumb) || !is_file($filename_new)) {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $filename;
            $config['new_image'] = $filename_new;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['master_dim'] = TRUE;
            $config['quality'] = 95;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['thumb_marker'] = '';
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();#echo $filename_new;exit;
            ci_set_cache($cache_key_user_avatar_thumb,true,60*60*24*90);
        }

        if ($file_extension == 'jpg' || $file_extension == 'jpeg') {
            header('Content-type: image/jpeg');
            $image = imagecreatefromjpeg($filename_new);
            imagejpeg($image, null, 100);//输出
        } elseif ($file_extension == 'png') {#echo $filename_new;exit;
            header('Content-type: image/png');
            $image = imagecreatefrompng($filename_new);
            imagesavealpha($image, true);//这里很重要;
            imagepng($image, null, 9);
        } elseif ($file_extension == 'gif') {#echo $filename_new;exit;
            header('Content-type: image/gif');
            $image = imagecreatefromgif($filename_new);
            imagesavealpha($image, true);//这里很重要;
            imagegif($image, null);
        }
        imageDestroy($image);//销毁临时资源
    }

}