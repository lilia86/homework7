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
         return $this->json($path);

    }

    /**
     * @Route("/post", name="post")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
        $array['id'] = $request->request->get('id');
        $array['name'] = $request->request->get('name');
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($array));
        fclose($fp);
        return $this->json($array);
    }

    /**
     * @Route("/put", name="put")
     * @Method({"PUT"})
     */
    public function putAction(Request $request)
    {
        $content = $request->getContent();
        parse_str($content, $result);
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return $this->json($result);

    }

    /**
     * @Route("/patch", name="patch")
     * @Method({"PATCH"})
     */
    public function patchAction(Request $request)
    {
        $content = $request->getContent();
        parse_str($content, $result);
        $filename = 'file.json';
        if (file_exists($filename)){
            chmod($filename, 0777);
            $old_content = file_get_contents($filename);
            $decode = json_decode($old_content, true);
            $result = array_merge($decode, $result);
        }
        $fp = fopen("file.json", "w");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return $this->json($result);
    }

    /**
     * @Route("/delete", name="delete")
     * @Method({"DELETE"})
     */
    public function deleteAction()
    {
        $filename = 'file.json';
        if (file_exists($filename)){
            unlink($filename);
            return new Response(
                '<html><body>The file was deleted</body></html>'
            );

        }else{
            return new Response(
                '<html><body>The file was deleted</body></html>'
            );
        }

    }
}
