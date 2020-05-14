Feature: Webs online feature
  @pings
  Scenario Outline: All webs are online
    Given I am on "<web>"
    Then the response status code should be 200

    Examples:
    | web                      |
    | https://ixia.es/         |
    | https://unimasa.es/      |
    | https://bestproducts.es/ |
