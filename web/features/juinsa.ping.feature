Feature: Juinsa feature
  @ping
  Scenario: Juinsa is online
    Given I am on "https://juinsa.es/"
    Then the response status code should be 200