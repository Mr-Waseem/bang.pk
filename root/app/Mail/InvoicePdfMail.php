<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoicePdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceNo;
    public $companyName;

    protected $pdfBinary;
    protected $filename;

    public function __construct($pdfBinary, $filename, $invoiceNo, $companyName = null)
    {
        $this->pdfBinary = $pdfBinary;
        $this->filename = $filename;
        $this->invoiceNo = $invoiceNo;
        $this->companyName = $companyName ?: session()->get('company_name');
    }

    public function build()
    {
        return $this->subject('Invoice #' . $this->invoiceNo)
            ->view('emails.invoice-pdf')
            ->attachData($this->pdfBinary, $this->filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
