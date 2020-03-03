<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Base\Helper\CurlHelper;
use App\Entity\ItemType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ItemTypeController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(ItemType::class);
    }

    public function listItemAction(Request $request, $id)
    {
        // return new JsonResponse([
            // 'ABC',
            // 'DEF',
            // 'GHI',
            // 'JKL',
            // 'MNO',
            // 'PQR',
            // 'STU',
            // 'VXZ',
        // ]);

        $filtersRequest = $this->translateFilters($request);

        $response = json_decode((new CurlHelper('http://35.232.23.184:1204/api/item?filters='.base64_encode(json_encode([
            'equipments' => $filtersRequest['equipments'],
            'itemType' => $id,
            'item' => $filtersRequest['item'],
        ]))))->send()->getResponse()['data']);

        return new JsonResponse($response ? $response : []);
    }
}
