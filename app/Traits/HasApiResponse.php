<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HasApiResponse
{
    private function parseGivenData(array $response = [], $status = 200, $headers = [])
    {
        $content = [
            'success' => $response['success'] ?? true,
            'message' => $response['message'] ?? null,
            'data'    => $response['data']    ?? null
        ];

        return [
            'content' => $content,
            'status' => $status,
            'headers' => $headers
        ];
    }

    private function apiResponse(array $response = [], int $status = 200, array $headers = [])
    {
        $result = $this->parseGivenData($response, $status, $headers);

        return response()->json(
            $result['content'],
            $result['status'],
            $result['headers']
        );
    }

    public function respondOk(array $response)
    {
        return $this->apiResponse($response, Response::HTTP_OK);
    }

    public function respondCreated(array $response)
    {
        return $this->apiResponse($response, Response::HTTP_CREATED);
    }

    public function respondNoContent(array $response)
    {
        $response['success'] = true;

        return $this->apiResponse($response, Response::HTTP_NO_CONTENT);
    }

    public function respondNotFound(array $response)
    {
        $response['success'] = true;

        return $this->apiResponse($response, Response::HTTP_NOT_FOUND);
    }

    public function respondBadRequest(array $response)
    {
        $response['success'] = false;

        return $this->apiResponse($response, Response::HTTP_BAD_REQUEST);
    }

    public function respondUnAuthorized(array $response)
    {
        $response['success'] = false;

        return $this->apiResponse($response, Response::HTTP_UNAUTHORIZED);
    }

    public function respondUnprocessableContent(array $response)
    {
        $response['success'] = false;

        return $this->apiResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function respondInternalServerError(array $response)
    {
        $response['success'] = false;

        return $this->apiResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}