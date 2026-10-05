<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SecurityChecklist implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $errors = [];
        $warnings = [];

        // 1. Cek environment
        if (ENVIRONMENT !== 'production') {
            $warnings[] = "Environment saat ini: " . ENVIRONMENT . " (gunakan 'production' saat di hosting).";
        }

        // Kalau production → cek lebih ketat
        if (ENVIRONMENT === 'production') {
            // 2. Cek CSRF protection
            $security = config('Security');
            if (!$security->csrfProtection) {
                $errors[] = "CSRF protection tidak aktif.";
            }

            // 3. Cek session
            if (!ini_get('session.cookie_httponly')) {
                $errors[] = "session.cookie_httponly tidak aktif.";
            }
            if ($request->isSecure() && !ini_get('session.cookie_secure')) {
                $errors[] = "session.cookie_secure tidak aktif padahal HTTPS digunakan.";
            }

            // 4. Cek HTTPS
            if (!$request->isSecure()) {
                $errors[] = "Koneksi tidak menggunakan HTTPS.";
            }

            // 5. Cek .env file exposure
            if (is_file(ROOTPATH . '.env')) {
                $errors[] = "Pastikan file .env tidak ada di folder public_html.";
            }
        }

        // Tulis log sesuai level
        if (!empty($warnings)) {
            log_message('warning', "[SECURITY CHECKLIST] " . implode(' | ', $warnings));
        }
        if (!empty($errors)) {
            log_message('critical', "[SECURITY CHECKLIST] " . implode(' | ', $errors));
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tambahkan Security Headers universal
        $response->setHeader('X-Frame-Options', 'DENY');
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        $response->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->setHeader('Content-Security-Policy', "default-src 'self'");

        return $response;
    }
}
