<?php

namespace Cmercado93\ChronospayApiBusiness;

use Cmercado93\ChronospayApiBusiness\Common\BaseElement;

class Transaction extends BaseElement
{
    public function list(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo) : array
    {
        return $this->getHttp()->get('/api-business/services/transactions', [
            'date_from' => $dateFrom->format('Y-m-d H:i:s'),
            'date_to' => $dateTo->format('Y-m-d H:i:s'),
        ]);
    }
}
