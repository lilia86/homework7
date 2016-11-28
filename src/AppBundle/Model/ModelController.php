<?php

namespace AppBundle\Model;

class ModelController
{
    public function put($content, $id)
    {
        parse_str($content, $array);
        $result[0][$id] = $array;
        $filename = 'file.json';
        if (file_exists($filename)){
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            $result = array_replace_recursive($decode, $result);
        }
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return $result;

    }

    public function patch($content, $id)
    {
        parse_str($content, $array);
        $filename = 'file.json';
        if (file_exists($filename)){
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            if(isset($decode[0][$id])){
                $decode[0][$id] = array_merge($decode[0][$id], $array);
            }else{
                $result[0][$id] = $array;
                $decode = array_merge($decode, $result);
            }

        }else {
            $decode[0][$id] = $array;
        }
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($decode));
        fclose($fp);
        return $decode;
    }

    public function delete($id)
    {
        $filename = 'file.json';
        if (file_exists($filename)) {
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            for ($i = 0; $i < count($decode); $i++) {
                if (array_key_exists($id, $decode[$i])) {
                    unset($decode[$i][$id]);
                }

            }

            $fp = fopen("file.json", "w");
            fwrite($fp, json_encode($decode));
            fclose($fp);
            return $decode;

        }

    }

}