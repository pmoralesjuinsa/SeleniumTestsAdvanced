Feature: Denzzo feature
  @ping
  Scenario: Denzzo is online
    Given I am on "https://denzzo.es/"
    Then the response status code should be 200