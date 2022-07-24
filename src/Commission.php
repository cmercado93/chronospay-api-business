<?php

namespace Cmercado93\ChronospayApiBusiness;

use Cmercado93\ChronospayApiBusiness\Common\BaseElement;

class Commission extends BaseElement
{
    public function list() : array
    {
        return $this->getHttp()->get('/api-business/services/available-days');
    }
}
