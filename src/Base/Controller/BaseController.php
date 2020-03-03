<?php

namespace App\Base\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function translateFilters($filters)
    {
        if ($filters instanceof Request) {
            if ($filters->query->has('filters')) {
                $filters = json_decode(base64_decode($filters->query->get('filters')), true);
            } else {
                $filters = [];
            }
        }

        return $filters;
    }

    public function filterRequest($allInputs, $only)
    {
        return array_intersect_key($allInputs, array_flip($only));
    }

    public function getToArray(Request $request, array $default = [])
    {
        if ($request->query->has('toArray')) {
            if ($toArray = json_decode(base64_decode($request->query->get('toArray')), true)) {
                $default = $toArray;
            }
        }

        return $default;
    }

    public function defaultFilters(Request $request)
    {
        if ($request->query->has('defaultFilters') && $filters = json_decode(base64_decode($request->query->get('defaultFilters')), true)) {
            foreach ($filters as $filter => $enable) {
                $classFilter = $this->getDoctrine()->getManager()->getFilters()->getFilter($filter);

                if ($enable) {
                    abortIf(
                        (method_exists($classFilter, 'canEnnable') && !$classFilter->canEnnable()),
                        401,
                        "Você não tem permissão para habilitar o filtro '{$filter}'"
                    );
                    if (!$this->getDoctrine()->getManager()->getFilters()->isEnabled($filter)) {
                        $this->getDoctrine()->getManager()->getFilters()->enable($filter);
                    }
                } else {
                    abortIf(
                        (method_exists($classFilter, 'canDisabled') && !$classFilter->canDisabled()),
                        401,
                        "Você não tem permissão para desabilitar o filtro '{$filter}'"
                    );
                    if ($this->getDoctrine()->getManager()->getFilters()->isEnabled($filter)) {
                        $this->getDoctrine()->getManager()->getFilters()->disable($filter);
                    }
                }
            }
        }
    }
}
