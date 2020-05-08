<?php

use src\Routes\AbstractRoute;

require_once './lib/global.php';

try {
    \src\Dispatch\DefaultDispatcher::getInstance()->dispatch();
} catch (\src\Model\Exceptions\NotFoundException $e) {
    redirect(AbstractRoute::get("e404")->generate());
}
