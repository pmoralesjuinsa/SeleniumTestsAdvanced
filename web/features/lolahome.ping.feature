Feature: LolaHome feature
  @ping
  Scenario: LolaHome is online
    Given I am on "https://lolahome.es/"
    Then the response status code should be 200