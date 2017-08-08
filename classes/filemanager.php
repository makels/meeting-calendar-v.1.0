<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 17.06.2017
 * Time: 7:50
 */
class FileManager {

    public static function upload($file) {
        $upload_file = UPLOAD_DIR . basename($file['name']);
        if(move_uploaded_file($file['tmp_name'], $upload_file)) {
            return basename($file['name']);
        } else {
            return null;
        }
    }


}