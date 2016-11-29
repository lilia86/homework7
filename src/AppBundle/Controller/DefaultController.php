<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \AppBundle\Model\PostModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class DefaultController extends Controller
{
    /**
     * @Route("/posts", name="get")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {

         $array['method'] = $request->query->get('method');

         return $this->json($array);

    }

    /**
     * @Route("/posts/{id}", name="get_id", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function getIdAction($id)
    {

        $model = new PostModel();
        $name = $model->getName($id);
        return new Response(
            '<html><body>Hello '.$name.'</body></html>'
        );

    }

    /**
     * @Route("/posts", name="post")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
        $array[0]['name'] = $request->request->get('name');
        $array[0]['email'] = $request->request->get('email');
        $file_name = $this->container->getParameter('storage');
        $fp = fopen($file_name, "w");
        fwrite($fp, json_encode($array));
        fclose($fp);
        return $this->json($file_name);
    }

    /**
     * @Route("/posts/{id}", name="put", requirements={"id": "\d+"})
     * @Method({"PUT"})
     */
    public function putAction(Request $request, $id)
    {
        $content = $request->getContent();
        $file_name = $this->container->getParameter('storage');
        $model = new PostModel();
        $result = $model->put($content, $id, $file_name);
        return $this->json($result);

    }

    /**
     * @Route("/posts/{id}", name="patch", requirements={"id": "\d+"})
     * @Method({"PATCH"})
     */
    public function patchAction(Request $request, $id)
    {
        $content = $request->getContent();
        $file_name = $this->container->getParameter('storage');
        $model = new PostModel();
        $decode = $model->patch($content, $id, $file_name);
        return $this->json($decode);
    }

    /**
     * @Route("/posts/{id}", name="delete", requirements={"page": "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $file_name = $this->container->getParameter('storage');
        $model = new PostModel();
        $decode = $model->delete($id, $file_name);
        return $this->json($decode);

    }
}
