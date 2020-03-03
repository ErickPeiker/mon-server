<?php

declare(strict_types=1);

namespace App\Base\Util;

use Firebase\JWT\JWT;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JwtUtil
{
    private $jwtAlgorithm;
    private $jwtKey;

    public function __construct(
        string $jwtAlgorithm,
        string $jwtKey
    ) {
        $this->jwtAlgorithm = $jwtAlgorithm;
        $this->jwtKey = $jwtKey;
    }

    public function encode(iterable $tokenData): string
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        $json = $serializer->serialize($tokenData, 'json', [
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ]);

        return JWT::encode(json_decode($json), $this->jwtKey, $this->jwtAlgorithm);
    }

    public function decode(string $tokenString): stdClass
    {
        return JWT::decode($tokenString, $this->jwtKey, [$this->jwtAlgorithm]);
    }
}
