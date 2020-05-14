Feature: Unimasa feature
  @ping @javascript
  Scenario: Unimasa is online
    Given I am on "https://unimasa.es/"
    Then the response status code should be 200