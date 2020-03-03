<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Base\Helper\CurlHelper;
use App\Document\History;
use App\Entity\ItemType;
use App\Entity\Widget;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Widget::class);
    }

    public function chartDataAction(Request $request, $id)
    {
        $widget = $this->getRepository()->find($id);

        $filters = [
            'startDate' => (new DateTime())
                ->sub(date_interval_create_from_date_string("{$widget->getParameters()['historyLimiter']} minutes"))
                ->format('Y-m-d H:i:sP'),
            'itemType' => $widget->getParameters()['itemType'],
            'limit' => (int)$widget->getParameters()['itemLimiter'],
            'showOthers' => $widget->getParameters()['showOthers'],
        ];

        if ($widget->getParameters()['equipments']) {
            $filters['equipments'] = $widget->getParameters()['equipments'];
        }

        $response = json_decode(
            (new CurlHelper('http://35.232.23.184:1204/api/summarized?filters='.base64_encode(json_encode($filters))))
                ->send()
                ->getResponse()['data']
        );

        return new JsonResponse($response ? $response : []);
    }
}
