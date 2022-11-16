<?php

namespace app\controller;

use Intervention\Image\ImageManagerStatic as Image;

use support\Request;

use function base_path;

/**
 * 上传
 *
 * @create 2022-11-8
 * @author deatil
 */
class Upload extends Base
{
    /**
     * 头像
     */
    public function avatar(Request $request)
    {
        $file = current($request->file());
        
        if (! ($file && $file->isValid())) {
            return $this->json(1, 'file not found');
        }
        
        $ext = strtolower($file->getUploadExtension());
        if (! in_array($ext, ['jpg', 'jpeg', 'gif', 'png'])) {
            return $this->json(2, '仅支持 jpg jpeg gif png格式');
        }
        
        $image = Image::make($file);
        $width = $image->width();
        $height = $image->height();
        
        $size = $width > $height ? $height : $width;
        
        $avatar_path = 'avatar/' . date('Ym');

        $relative_path = 'upload/' . $avatar_path;
        $real_path = public_path($relative_path);
        if (! is_dir($real_path)) {
            mkdir($real_path, 0777, true);
        }
        
        $name = bin2hex(pack('Nn',time(), random_int(1, 65535)));
        $ext = $file->getUploadExtension();

        $image->crop($size, $size)->resize(120, 120);
        $path = $real_path . "/$name.$ext";
        $image->save($path);
        
        $url = "/$relative_path/$name.$ext";
        $avatar = "$avatar_path/$name.$ext";

        return $this->json(0, '上传成功', [
            'url' => $url,
            'avatar' => $avatar,
        ]);
    }
    
}