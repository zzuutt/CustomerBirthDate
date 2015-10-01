<?php

namespace CustomerBirthDate\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Customer\CustomerEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\HttpFoundation\Request;

/**
 * Class CustomerBirthDateEventListener
 * @package CustomerBirthDate\EventListeners
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class CustomerBirthDateEventListener implements EventSubscriberInterface
{
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::FORM_AFTER_BUILD . '.thelia_customer_create' => ['addBirthDateInput', 128],
            TheliaEvents::BEFORE_CREATECUSTOMER => ['getBirthDate', 128]
        ];
    }

    /**
     * Add birth date inputs to register form
     * @param TheliaFormEvent $event
     */
    public function addBirthDateInput(TheliaFormEvent $event)
    {
        $event->getForm()->getFormBuilder()
        ->add(
            'birth_year',
            'choice',
            [
                'required' => true,
                'choices' => range(date('Y', strtotime('now')), date('Y', strtotime('now'))-120)
            ]
        )
        ->add(
            'birth_month',
            'choice',
            [
                'required' => true,
                'choices' => [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December'
                ]
            ]
        )
        ->add(
            'birth_day',
            'choice',
            [
                'required' => true,
                'choices' => range(1, 31)
            ]
        );
    }

    public function getBirthDate(CustomerEvent $event)
    {
        $birthDate = $this->request->get('thelia_customer_create')['birth_date'];
    }
}