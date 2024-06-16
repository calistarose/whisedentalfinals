<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $receiptData;
    protected $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;

        $this->receiptData = [
            'payment_id' => $payment->id,
            'patient_name' => $payment->patient->full_name, // Assuming 'full_name' is a method or attribute in the Patient model
            'appointment_type' => $payment->appointment_type,
            'debit' => $payment->debit,
            'credit' => $payment->credit,
            'balance' => $payment->balance,
            'date' => $payment->created_at->toDateString(), // Format date as needed
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('payment/receipt')
                    ->subject('Payment Receipt')
                    ->to($this->payment->patient->email); // Specify recipient email address here
    }
}
