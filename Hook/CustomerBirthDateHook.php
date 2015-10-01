<?php

namespace CustomerBirthDate\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class CustomerBirthDateHook
 * @package CustomerBirthDate\Hook
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class CustomerBirthDateHook extends BaseHook
{
    public function onRegister(HookRenderEvent $event)
    {
        $event->add($this->render('birthdate-input.html'));
    }

    public function onRegisterAddJs(HookRenderEvent $event)
    {
        $event->add($this->render('assets/js/move-birthdate-input.html'));
    }
}