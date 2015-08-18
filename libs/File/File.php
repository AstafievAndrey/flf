<?php
namespace File;
    
class File {
    
    private $_whitelist_image = array("jpg","png","jpeg");


    public function __construct() {
        
    }
    
    public function getFile($name){
        if(isset($_FILES[$name])){
	    return $_FILES[$name];
	}else{
	    return 0;
	}
    }
    
    //проверим и сохраним изображение на сервер
    public function saveImage($file){ 
        $mass = explode(".",$file["name"]);
        $expension  = $mass[count($mass)-1];
        if($file['size']/1024<3000){
            if($file['type'] == "image/png" || $file['type'] == "image/jpg" || $file['type'] == "image/jpeg"){
                foreach ($this->_whitelist_image as $exp){
                    if($exp==$expension){
                        $res = 1;
                        break;
                    }
                }
            } else {
                return 0;
            }
        }else{
            return 0;
        }
        if($res===1){
            $file["name"]=time().".".$expension;
            if(move_uploaded_file($file['tmp_name'],
                    str_replace("/libs/File", "", __DIR__)."/resourses/uploads/images/".$file["name"])){
                return $file["name"];
            }else {
                return 0;
            }
        }else{
           return 0; 
        }     
    }
    
    //удалим файл с сервера
    public function deleteFile($type,$name){
        switch ((string)$type){
            case "image": 
                return unlink(str_replace("/libs/File", "", __DIR__)."/resourses/uploads/images/".$name);    
            case "doc": return 1;
                
            default : return 0;
        }
    }
}
