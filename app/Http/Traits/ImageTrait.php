<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use App\User;
use App\RegistrationRequest;
use App\RegistrationRequestGuardian;

trait ImageTrait {


    
   public function saveImageSerialized($request,$id,$parent,$filename){

    $data= $request['cropped'];

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);

    $data = base64_decode($data);

    if($parent){
        $path_to_save = "public/register_images_parent/" . $id . "/" . $filename;
    }else{
        $path_to_save = "public/register_images_scout/" . $id . "/" . $filename;
    }

    
    Storage::put($path_to_save, $data); 

    }

    public function saveImage($request, $id, $parent){
        //TO-DO find way to get filename and send only that instead of the original file
        $originalFile = $request['originalFile'];
        $filename  = $originalFile->getClientOriginalName();

        $this->saveImageSerialized($request,$id,$parent,$filename);
        
    }

    public function updateImage(User $user, $request){
        $targetDir = 'public/' . $user->id;

        // Delete Files in directory
        $files =   Storage::allFiles($targetDir);
        Storage::delete($files);

        //TO-DO find way to get filename and send only that instead of the original file
        $originalFile = $request['originalFile'];
        $filename  = $originalFile->getClientOriginalName();

        $data= $request['cropped'];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
    
        $data = base64_decode($data);
    
        $path_to_save = $targetDir . "/" . $filename;    
        
        Storage::put($path_to_save, $data);

    }

    public function getProfileImageRegistrations($parent,$id){

        if($parent){
            $path="public/register_images_parent/" . $id;
        }else{
            $path="public/register_images_scout/" . $id;
        }

        $files = Storage::files($path);
        
        if(!empty($files)){
            if($parent){
                return  "storage/register_images_parent/" . $id . "/" . $this->removePath($files[0]);   
            }else{
                return  "storage/register_images_scout/" . $id . "/" . $this->removePath($files[0]);   
            }
        }
        else 
            return "storage/default.png";   
    }

    public function removePath($file){
        $info = explode('/',$file);
        return end($info);
    }

    public function moveImageIfExists($registration_id,$user_id,$parent){

        if($parent){
            $old_directory = 'public/register_images_parent/'. $registration_id ;
        }else{
            $old_directory = 'public/register_images_scout/'. $registration_id ;
        }
        $files = Storage::files($old_directory);
        
        if(empty($files))
            return ;

        $filename = $this->removePath($files[0]);

        $path= "public/" . $user_id . "/" . $filename;   

        $data = Storage::get($old_directory . "/" . $filename);

        Storage::deleteDirectory($old_directory);

        Storage::put($path,$data);
        
    }


    public function getProfileImage(){
        
        $files = Storage::files('public/' . $this->id);
        
        if(!empty($files))
            $this['profile_image'] = "storage/" . $this->id . "/" . $this->removePath($files[0]);   
        else 
            $this['profile_image'] ="storage/default.png";   

    }
}

?>