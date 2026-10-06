<?php

namespace App\Services;

use App\Mail\InvoicePdfMail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;

class InvoicePdfMailer
{
    public static function fileSrc($relativePath)
    {
        $relativePath = str_replace('\\', '/', ltrim((string) $relativePath, '/'));
        if ($relativePath === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $relativePath)) {
            return $relativePath;
        }

        $absolute = public_path($relativePath);
        if (is_file($absolute)) {
            return 'file:///' . str_replace('\\', '/', $absolute);
        }

        return asset($relativePath);
    }

    protected function sanitizeHtml($html)
    {
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', (string) $html);
        return preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\')/i', '', $html);
    }

    protected function renderPdf($html)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->setChroot([public_path(), base_path()]);

        $dompdf = new Dompdf($options);
        $dompdf->setBasePath(public_path());
        $dompdf->loadHtml($this->sanitizeHtml($html));
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    public function send($email, $html, $invoiceNo, $companyName = null)
    {
        $filename = 'Invoice-' . $invoiceNo . '.pdf';
        Mail::to($email)->send(new InvoicePdfMail($this->renderPdf($html), $filename, $invoiceNo, $companyName));
    }

    public function downloadResponse($html, $invoiceNo)
    {
        $filename = 'Invoice-' . $invoiceNo . '.pdf';

        return response($this->renderPdf($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
