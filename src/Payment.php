<?php

namespace Cmercado93\ChronospayApiBusiness;

use Cmercado93\ChronospayApiBusiness\Common\BaseElement;

class Payment extends BaseElement
{
    public function getById(string $id) : ?array
    {
        $id = trim($id);

        if ($id == '') {
            return null;
        }

        return $this->getHttp()->get('/api-business/services/payments/' . $id);
    }

    public function obtainTheReceiptOfATransferPayment(string $id, $filename) : bool
    {
        $id = trim($id);

        if ($id == '') {
            return false;
        }

        return $this->getHttp()->downloadFile('/api-business/services/payments/' . $id . '/ticket', $filename);
    }

    public function confirmPaymentReceivedByTransfer(int $id, int $bankTransferCode) : array
    {
        return $this->getHttp()->put('/api-business/services/payments/' . $id . '/commit-bank-transfer', [], [
            'bank_transfer_code' => $bankTransferCode,
        ]);
    }
}
