<?php

namespace CustomerBirthDate\EventListeners;

use CustomerBirthDate\Model\CustomerBirthDate;
use CustomerBirthDate\Model\CustomerBirthDateQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
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
            TheliaEvents::FORM_AFTER_BUILD . '.thelia_customer_create' => ['birthDateInput', 128],
            TheliaEvents::AFTER_CREATECUSTOMER => ['createBirthDate', 128],

            TheliaEvents::FORM_AFTER_BUILD . '.thelia_customer_profile_update' => ['birthDateInput', 128],
            TheliaEvents::CUSTOMER_UPDATEPROFILE => ['updateBirthDate', 128],

            TheliaEvents::FORM_AFTER_BUILD . '.thelia_customer_update' => ['birthDateInput', 128],
            TheliaEvents::CUSTOMER_UPDATEACCOUNT => ['updateBirthDate', 128]
        ];
    }

    public function birthDateInput(TheliaFormEvent $event)
    {
        if ($this->request->fromApi() === false) {
            $event->getForm()->getFormBuilder()
                ->add(
                    'birth_date',
                    'birthday',
                    [
                        'label' => 'Birth date',
                        'required' => true,
                        'widget' => 'choice',
                        'format' => 'yyyy-MM-dd',
                        'input' => 'string'
                    ]
                );
        }
    }

    public function createBirthDate(CustomerEvent $event)
    {
        if($this->request->fromApi() === false) {
            // Get date from input & format it
            $birthDate = $this->request->get('thelia_customer_create')['birth_date'];
            $birthDate = new \DateTime($birthDate['year'] . '-' . $birthDate['month'] . '-' . $birthDate['day']);

            // Create a new birth date & save it
            $this->doCreateBirthDate($event, $birthDate);
        }
    }

    public function doCreateBirthDate(CustomerEvent $event, \DateTime $birthDate)
    {
        (new CustomerBirthDate())
            ->setId($event->getCustomer()->getId())
            ->setBirthDate($birthDate)
            ->save();
    }

    public function updateBirthDate(CustomerEvent $event)
    {
        if($this->request->fromApi() === false) {
            // Get date from input depending on request origin (front or back)
            if ($this->request->fromFront() === true) {
                $birthDate = $this->request->get('thelia_customer_profile_update')['birth_date'];
            } elseif ($this->request->fromAdmin() === true) {
                $birthDate = $this->request->get('thelia_customer_update')['birth_date'];
            } else {
                throw new Exception('No form found');
            }

            // Format birth date
            $birthDate = new \DateTime($birthDate['year'] . '-' . $birthDate['month'] . '-' . $birthDate['day']);

            // Check if the customer already have a birth date
            if (null === $customerBirthDate = CustomerBirthDateQuery::create()->findOneById($event->getCustomer()->getId())) {
                // Create a new birth date
                $this->doCreateBirthDate($event, $birthDate);
            } else {
                // Save it
                $customerBirthDate
                    ->setBirthDate($birthDate)
                    ->save();
            }
        }
    }
}