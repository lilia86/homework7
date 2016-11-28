<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \AppBundle\Model\ModelController;

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
        $model = new ModelController();
        $result = $model->put($content, $id);
        return $this->json($result);

    }

    /**
     * @Route("/patch/{id}", name="patch", requirements={"id": "\d+"})
     * @Method({"PATCH"})
     */
    public function patchAction(Request $request, $id)
    {
        $content = $request->getContent();
        $model = new ModelController();
        $decode = $model->patch($content, $id);
        return $this->json($decode);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"page": "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $model = new ModelController();
        $decode = $model->delete($id);
        return $this->json($decode);

    }
}
