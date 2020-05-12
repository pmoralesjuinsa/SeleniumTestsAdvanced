Feature: Ixia feature
  Scenario: Web is online
    Given I am on "https://ixia.es/"
    Then the response status code should be 200

  @javascript
  Scenario: Menu navigation
    Given I am on "https://ixia.es/"
      And I hover over the element with css selector ".header__content .header__secondary .list-inline > *:first-child"
      Then I wait for 1 second
      Then I click on the element with css selector ".ui-menu .ui-menu-item.first > a"
