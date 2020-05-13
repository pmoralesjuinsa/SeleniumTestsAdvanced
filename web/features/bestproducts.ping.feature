Feature: BestProducts feature
  @ping
  Scenario: BestProducts is online
    Given I am on "https://bestproducts.es/"
    Then the response status code should be 200