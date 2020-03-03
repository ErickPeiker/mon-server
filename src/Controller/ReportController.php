<?php

namespace App\Controller;

use App\Base\Controller\BaseController;
use App\Base\Helper\CurlHelper;
use App\Document\History;
use App\Entity\ItemType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends BaseController
{
    public function syntheticAction(Request $request)
    {
        $filters = base64_encode(json_encode($this->translateFilters($request)));

        $response = json_decode((new CurlHelper('http://146.148.62.10:1204/api/synthetic?filters='.$filters))
            ->send()
            ->getResponse()['data']);

        return new JsonResponse($response ? $response : []);
    }

    public function analyticAction(Request $request)
    {
        $filters = base64_encode(json_encode($this->translateFilters($request)));

        $response = json_decode((new CurlHelper('http://146.148.62.10:1204/api/analytic?filters='.$filters))
            ->send()
            ->getResponse()['data']);

        return new JsonResponse($response ? $response : []);
    }
}
