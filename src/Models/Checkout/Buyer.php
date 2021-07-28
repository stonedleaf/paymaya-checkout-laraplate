<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout;

use JsonSerializable;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\General\Address;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\General\Contact;

class Buyer implements JsonSerializable
{
    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $middleName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var Contact
     */
    protected $contact;

    /**
     * @var Address
     */
    protected $billingAddress;

    /**
     * @var Address
     */
    protected $shippingAddress;

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function setBillingAddress(Address $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function setShippingAddress(Address $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function jsonSerialize()
    {
        return [
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'contact' => $this->contact,
            'billingAddress' => $this->billingAddress,
            'shippingAddress' => $this->shippingAddress,
        ];
    }
}
