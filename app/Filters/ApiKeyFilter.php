<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Kunci rahasia API kita (Dalam praktek nyata, ini disimpan di .env)
        $secretKey = 'Librify-Super-Secret-Key-2026';

        // Cek header X-API-KEY dari client
        $clientKey = $request->getHeaderLine('X-API-KEY');

        if (empty($clientKey) || $clientKey !== $secretKey) {
            // Jika token salah atau tidak ada, tolak dengan JSON 401 Unauthorized
            $response = service('response');
            return $response->setJSON([
                'status' => false,
                'message' => 'Akses ditolak. API Key tidak valid atau tidak ditemukan.'
            ])->setStatusCode(401);
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
