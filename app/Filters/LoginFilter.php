<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    protected $timeout = 86400; // contoh: 30 menit (1800 detik)

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Kalau belum login → redirect ke login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Global timeout
        $lastActivity = $session->get('last_activity');
        $currentTime  = time();

        if ($lastActivity && ($currentTime - $lastActivity > $this->timeout)) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda berakhir, silakan login kembali.');
        }

        // Update timestamp setiap request
        $session->set('last_activity', $currentTime);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
