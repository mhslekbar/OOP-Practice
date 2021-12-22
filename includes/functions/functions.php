<?php

    function validateImage($imgName,$imgType,$imgSize){
        $extAllowed = ["png","jpeg","jpg"];
        $errors = [];

        if(empty($imgName)){
            $errors[] = "Image <strong>Can't Be Empty</strong>";
        }else {
            $extension = strtolower(explode(".",$imgName)[1]);
            
            if(!in_array($extension,$extAllowed)){
                $errors[] = "This Image Extension <strong>doesn't Allowed</strong>";
            }
            
            if($imgSize > 4194304){
                $errors[] = "Size <strong>Can't be great than 4MB</strong>";
            }
    
            $type = strtolower($imgType);
            $typeAllowed = ["image/jpeg","image/jpg","image/png"];
            if(!in_array($type,$typeAllowed) && in_array($extension,$extAllowed)){
                $errors[] = "This Image Type <strong>doesn't Allowed</strong>";
            }    
        }
        return $errors;
    }


?>