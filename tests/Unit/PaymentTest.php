<?php

namespace Cmercado93\ChronospayApiBusiness\Tests\Unit;

use Cmercado93\ChronospayApiBusiness\Auth;
use Cmercado93\ChronospayApiBusiness\Payment;
use Cmercado93\ChronospayApiBusiness\Tests\TestCase;

class HttpTest extends TestCase
{
    public function test_getById()
    {
        $auth = new Auth(env('BASE_URL'));

        $auth->login(env('USERNAME'), env('PASSWORD'));

        $payment = new Payment($auth);

        $pay = $payment->getById(1);

        $this->assertIsArray($pay);
        $this->assertNotEmpty($pay);
    }

    public function test_obtainTheReceiptOfATransferPayment()
    {
        $auth = new Auth(env('BASE_URL'));

        $auth->login(env('USERNAME'), env('PASSWORD'));

        $payment = new Payment($auth);

        $filePath = __DIR__.'/receipt_of_a_transfer_payment.pdf';

        $payment->obtainTheReceiptOfATransferPayment(1, $filePath);

        $this->assertTrue(file_exists($filePath));
    }

    public function test_confirmPaymentReceivedByTransfer()
    {
        $auth = new Auth(env('BASE_URL'));

        $auth->login(env('USERNAME'), env('PASSWORD'));

        $payment = new Payment($auth);

        $pay = $payment->confirmPaymentReceivedByTransfer(1, 1);

        $this->assertIsArray($pay);
    }
}