<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.11.16
 * Time: 14:59
 */

namespace AppBundle\Model;

/**
 * Class PostModel
 * @package AppBundle\Model
 */
class PostModel
{
    /**
     * Getting user name by id
     *
     * @param integer $id - user id
     * @return string user name
     */
    public function getName($id)
    {

        $filename = tempnam(sys_get_temp_dir(), 'file.json');
        if (file_exists($filename)){
            chmod($filename, 0777);
            $content = file_get_contents($filename);
            $decode = json_decode($content, true);
            if(isset($decode[0][$id])){
                $user = $decode[0][$id];
                $name = $user['name'];
            }
        }else {
            $name ='friend';
        }
        return $name;
    }

    /**
     * Adding new user
     *
     * @param string $content - user inf
     * @param integer $id - user id
     * @return array
     */
    public function put($content, $id, $filename)
    {
        parse_str($content, $array);
        $result[0][$id] = $array;
        if (file_exists($filename)){
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            if($old_content !== '') {
                $decode = json_decode($old_content, true);
                $result = array_replace_recursive($decode, $result);
            }
        }
        $fp = fopen($filename, "w");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return $result;

    }

    /**
     * Adding some new inf about user
     *
     * @param string $content - user inf
     * @param integer $id - user id
     * @return array|mixed
     */
    public function patch($content, $id, $filename)
    {
        parse_str($content, $array);
        if (file_exists($filename)){
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            if($old_content !== '') {
                if (isset($decode[0][$id])) {
                    $decode[0][$id] = array_merge($decode[0][$id], $array);
                } else {
                    $result[0][$id] = $array;
                    $decode = array_merge($decode, $result);
                }

            }
        }else {
            $decode[0][$id] = $array;
        }
        $fp = fopen($filename, "w");
        fwrite($fp, json_encode($decode));
        fclose($fp);
        return $decode;
    }

    /**
     * Deleting user by id
     *
     * @param integer $id - user id
     * @return mixed
     */
    public function delete($id, $filename)
    {

        if (file_exists($filename)) {
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            if($old_content !== '') {
                for ($i = 0; $i < count($decode); $i++) {
                    if (array_key_exists($id, $decode[$i])) {
                        unset($decode[$i][$id]);
                    }

                }
            }
            $fp = fopen($filename, "w");
            fwrite($fp, json_encode($decode));
            fclose($fp);
            return $decode;

        }

    }
}