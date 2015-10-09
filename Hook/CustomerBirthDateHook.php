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
    /* FRONT - CREATE */
    public function onRegister(HookRenderEvent $event)
    {
        $event->add($this->render('register-birthdate-input.html'));
    }

    public function onRegisterAddJs(HookRenderEvent $event)
    {
        $event->add($this->render('assets/js/register-move-birthdate-input.html'));
    }

    /* FRONT - UPDATE */
    public function onFrontUpdate(HookRenderEvent $event)
    {
        $event->add($this->render('update-birthdate-input.html'));
    }

    public function onFrontUpdateAddJs(HookRenderEvent $event)
    {
        $event->add($this->render('assets/js/update-move-birthdate-input.html'));
    }

    /* BACK - CREATE */
    public function onBackCreate(HookRenderEvent $event)
    {
        $event->add($this->render('create-customer-birthdate-input.html'));
    }

    public function onBackCreateAddJs(HookRenderEvent $event)
    {
        $event->add($this->render('assets/js/create-customer-move-birthdate-input.html'));
    }

    /* BACK - UPDATE */
    public function onBackUpdate(HookRenderEvent $event)
    {
        $event->add($this->render('update-customer-birthdate-input.html'));
    }

    public function onBackUpdateAddJs(HookRenderEvent $event)
    {
        $event->add($this->render('assets/js/update-customer-move-birthdate-input.html'));
    }
}