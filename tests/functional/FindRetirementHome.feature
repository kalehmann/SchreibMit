Feature: Find retirement home
  In order to send a letter to a retirement home
  As a user of the application
  I need to get the address of the retirement home from the application

  Background:
    Given I have the postal code 01097 with the longitude 13.7439674110642 and the latitude 51.0667452412037 in the database
    And I have the postal code 01099 with the longitude 13.8289798683304 and the latitude 51.0926193047084 in the database
    And I have the postal code 01217 with the longitude 13.7445163387362 and the latitude 51.0171437482078 in the database
    And I have the postal code 01219 with the longitude 13.767050572669 and the latitude 51.0223236798061 in the database

  Scenario: find retirement home
    Given I have a retirement home named "Musterpflegeheim" in the city "Dresden" with the postal code "01097" at "Carolaplatz 1" with the longitude 13.744599, the latitude 51.056809 and a maximum of 10 contacts

    And I am on page "/"
    And I fill "Name oder Synonym" with "Günther Meyer"
    And I fill "E-Mail Adresse" with "mail@meyer.de"
    And I fill "Postleitzahl" with "01099"
    And I select ">27" for "Alter (optional)"
    And I click "Abschicken"
    And I see the user "mail@meyer.de" was assigned to the retirement home "Musterpflegeheim"

  Scenario: find nearest retirement home
    Given I have a retirement home named "Pflegeheim1" in the city "Dresden" with the postal code "01097" at "Carolaplatz 1" with the longitude 13.744599, the latitude 51.056809 and a maximum of 10 contacts
    Given I have a retirement home named "Pflegeheim2" in the city "Dresden" with the postal code "01219" at "Strehlener Platz 2" with the longitude 13.748156, the latitude 51.033851 and a maximum of 10 contacts

    And I am on page "/"
    And I fill "Name oder Synonym" with "Günther Meyer"
    And I fill "E-Mail Adresse" with "mail@meyer.de"
    And I fill "Postleitzahl" with "01217"
    And I select ">27" for "Alter (optional)"
    And I click "Abschicken"
    And I see the user "mail@meyer.de" was assigned to the retirement home "Pflegeheim2"

    And I am on page "/"
    And I fill "Name oder Synonym" with "Maria Müller"
    And I fill "E-Mail Adresse" with "mail@mueller.de"
    And I fill "Postleitzahl" with "01099"
    And I select "17-27" for "Alter (optional)"
    And I click "Abschicken"
    And I see the user "mail@mueller.de" was assigned to the retirement home "Pflegeheim1"

  Scenario: assignment to another retirement home when the nearest has reached its maximum contacts
    Given I have a retirement home named "Pflegeheim1" in the city "Dresden" with the postal code "01097" at "Carolaplatz 1" with the longitude 13.744599, the latitude 51.056809 and a maximum of 1 contacts
    Given I have a retirement home named "Pflegeheim2" in the city "Dresden" with the postal code "01219" at "Strehlener Platz 2" with the longitude 13.748156, the latitude 51.033851 and a maximum of 1 contacts

    And I am on page "/"
    And I fill "Name oder Synonym" with "Günther Meyer"
    And I fill "E-Mail Adresse" with "mail@meyer.de"
    And I fill "Postleitzahl" with "01099"
    And I select ">27" for "Alter (optional)"
    And I click "Abschicken"
    And I see the user "mail@meyer.de" was assigned to the retirement home "Pflegeheim1"

    And I am on page "/"
    And I fill "Name oder Synonym" with "Maria Müller"
    And I fill "E-Mail Adresse" with "mail@mueller.de"
    And I fill "Postleitzahl" with "01099"
    And I select "17-27" for "Alter (optional)"
    And I click "Abschicken"
    And I see the user "mail@mueller.de" was assigned to the retirement home "Pflegeheim2"