<?php

namespace App\Tests\Unit\Form;

use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Hospital;
use App\Form\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactTypeTest extends TypeTestCase
{

    /** @var Hospital $hospital */
    private $hospital;

    protected function setUp(): void
    {

        $address = new Address();
        $address
            ->setStreet('4141 Elanore Parkway')
            ->setCity('Nowhere')
            ->setState('TN')
            ->setZip(21214)
        ;

        $this->hospital = new Hospital();
        $this->hospital
            ->setName('Mercy General')
            ->setAddress($address)
            ->setPhone('555-1212')
        ;
        parent::setUp();
    }

    public function testSubmitValidData()
    {
        $formData = [
            'Subject' => 'test',
            'Email' => 'noone@nowhere.com',
            'Message' => 'test2'
        ];

        $actual = new Contact();
        $expected = new Contact();

        $form = $this->factory->create(ContactType::class, $actual);

        foreach ($formData as $key => $value) {
            $setter = "set" . ucfirst($key);
            $expected->{$setter}($value);
        }

        $form->submit($formData);
        $this->assertEquals(true, $form->isValid());
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $actual);
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
