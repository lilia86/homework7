<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/get", name="get")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {

         $array['method'] = $request->query->get('method');
         return $this->json($array);

    }

    /**
     * @Route("/post", name="post")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
        $array[0]['id'] = $request->request->get('id');
        $array[0]['name'] = $request->request->get('name');
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($array));
        fclose($fp);
        return $this->json($array);
    }

    /**
     * @Route("/put/{id}", name="put", requirements={"id": "\d+"})
     * @Method({"PUT"})
     */
    public function putAction(Request $request, $id)
    {
        $content = $request->getContent();
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
        return $this->json($result);

    }

    /**
     * @Route("/patch/{id}", name="patch", requirements={"id": "\d+"})
     * @Method({"PATCH"})
     */
    public function patchAction(Request $request, $id)
    {
        $content = $request->getContent();
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
        return $this->json($decode);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"page": "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $content = $request->getContent();
        parse_str($content, $array);
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
            return $this->json($decode);

        }

    }
}
