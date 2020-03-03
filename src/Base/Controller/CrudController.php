<?php

namespace App\Base\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class CrudController extends BaseController
{
    abstract protected function getRepository();

    public function listAction(Request $request)
    {
        $this->defaultFilters($request);

        return new JsonResponse(
            $this->getRepository()
                ->findAll()
                ->withFilters($this->translateFilters($request))
                ->toArray($this->getToArray($request))
        );
    }

    public function showAction(Request $request, $id)
    {
        $this->defaultFilters($request);

        return new JsonResponse(
            $this->getRepository()
                ->find($id)
                ->toArray($this->getToArray($request))
        );
    }

    public function newAction(Request $request)
    {
        $this->defaultFilters($request);

        $repository = $this->getRepository();
        $em = $repository->getManager();

        $entity = $repository->createEntity();

        $repository->setPropertiesEntity($this->filterRequest($request->request->all(), $entity->getOnlyStore()), $entity);

        $em->persist($entity);
        $em->flush();

        return new JsonResponse($entity->toArray($this->getToArray($request)));
    }

    public function editAction(Request $request, $id)
    {
        $this->defaultFilters($request);

        $repository = $this->getRepository();
        $em = $repository->getManager();

        $entity = $repository->find($id);

        $repository->setPropertiesEntity($this->filterRequest($request->request->all(), $entity->getOnlyStore()), $entity);

        $em->persist($entity);
        $em->flush();

        return new JsonResponse($entity->toArray($this->getToArray($request)));
    }

    public function deleteAction(Request $request, $id)
    {
        $this->defaultFilters($request);

        $repository = $this->getRepository();
        $em = $repository->getManager();

        $entity = $repository->find($id);

        $em->remove($entity);
        $em->flush();

        return new JsonResponse(null, 204);
    }
}
