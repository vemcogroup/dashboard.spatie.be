<?php

namespace App\ApiIntegration\Web;

use Exception;
use App\ApiIntegration\ApiIntegration;
use Spatie\SslCertificate\SslCertificate;

class CertificateStatus extends ApiIntegration
{
    protected $domains = [
        'vemcogroup.com',
        'conteo.contarpersonas.com',
    ];

    public function getStatus($domain)
    {
        return SslCertificate::createForHostName($domain);
    }

    public function getValue()
    {
        $results = [];
        foreach ($this->domains as $domain) {
            try {
                $certificate = $this->getStatus($domain);
                $days = $certificate->expirationDate()->diffInDays();
            } catch (Exception $e) {
                $days = 0;
            }

            $results[$domain] = $days;
        }

        return $results;
    }
}
