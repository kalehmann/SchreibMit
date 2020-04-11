<?php

namespace DrkDD\SchreibMit\Tests;

use DrkDD\SchreibMit\Entity\Pflegeheim;
use DrkDD\SchreibMit\Entity\PostalCode;
use DrkDD\SchreibMit\Entity\User;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Define custom actions here
     */

    /**
     * @Given I am on page :page
     */
    public function iAmOnPage($page)
    {
        $this->amOnPage($page);
    }

    /**
     * @Given I fill :field with :value
     */
    public function iFillField($field, $value)
    {
        $this->fillField($field, $value);
    }

    /**
     * @Given I select :option for :select
     */
    public function iSelectOption($option, $select)
    {
        $this->selectOption($select, $option);
    }

    /**
     * @Given I click :button
     */
    public function iClick($button)
    {
        $this->click($button);
    }

    /**
     * @Given I see the user :user_mail was assigned to the retirement home :name
     */
    public function iSeeTheUserWasAssignedToTheRetirementHome($userMail, $retirementHomeName)
    {
        /** @var User $user */
        $user = $this->grabEntityFromRepository(User::class, ['email' => $userMail]);

        $this->seeEmailIsSent(1);
        $this->assertEquals($retirementHomeName, $user->getPflegeheim()->getName());
    }

    /**
     * @Given  I have the postal code :postalCode with the longitude :lon and the latitude :lat in the database
     */
    public function iHaveAPostalCode($postalCode, $lon, $lat)
    {
        $this->haveInRepository(
            PostalCode::class,
            [
                'postalCode' => $postalCode,
                'longitude' => $lon,
                'latitude' => $lat,
            ]
        );
    }

    /**
     * @Given I have a retirement home named :name in the city :city with the postal code :postalCode at :street with the longitude :lon, the latitude :lat and a maximum of :maxContacts contacts
     */
    public function iHaveAReteirementHome($name, $city, $postalCode, $street, $lon, $lat, $maxContacts)
    {
        $this->haveInRepository(
            Pflegeheim::class,
            [
                'name' => $name,
                'city' => $city,
                'postalCode' => $postalCode,
                'street' => $street,
                'longitude' => $lon,
                'latitude' => $lat,
                'maxContacts' => $maxContacts,
                'contactPerson' => '',
            ]
        );
    }
}
