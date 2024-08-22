<?php

namespace App\RestfulApi;

class ApiResponse
{
    private ?string $message = null;
    private mixed $data = null;
    private int $status = 200;

    private array $appends = [];

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param array $appends
     */
    public function setAppends(array $appends): void
    {
        $this->appends = $appends;
    }

    public function response()
    {
        $body = [];
        !is_null($this->message) && $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        $body = $body + $this->appends;
        return response()->json($body, $this->status);
    }

}
