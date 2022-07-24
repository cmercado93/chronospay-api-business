<?php

namespace Cmercado93\ChronospayApiBusiness;

use Cmercado93\ChronospayApiBusiness\Common\BaseElement;

class PaymentLink extends BaseElement
{
    public function find(array $filters = []) : array
    {
        return $this->getHttp()->get('/api-business/services/payment-links', $filters);
    }

    public function getById(string $id) : ?array
    {
        $id = trim($id);

        if ($id == '') {
            return null;
        }

        return $this->getHttp()->post('/api-business/services/payment-links/' . $id);
    }

    public function create(array $data) : array
    {
        return $this->getHttp()->post('/api-business/services/payment-links', $data);
    }

    public function cancel()
    {
        return $this->getHttp()->put('/api-business/services/payment-links/cancel');
    }
}
