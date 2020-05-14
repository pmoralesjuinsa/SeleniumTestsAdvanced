Feature: Buy on webs feature

  @javascript @comprara
  Scenario Outline: Buy a product on our webs
    Given I am on "<web>"
    And I click on the element with css selector ".header__top--right > .account-buttons > a:nth-child(1)"
    Then I wait for 2 second
    And I fill in "email" with "pedromorales@grupojuinsa.es"
    And I fill in "pass" with "pemo2712"
    Then I press "send2"
    And I wait for 2 second
    Then I should see "Mi panel de control"
    Then I wait for 2 second
    Then I hover over the element with css selector "header ul.navigation-secondary:nth-child(1) > li:nth-child(1) > a:nth-child(1)"
    Then I wait for 2 second
    And I hover over the element with css selector "header nav.navigation > ul.ui-menu:nth-child(1) > li.level0:nth-child(1) > a"
    Then I wait for 2 second
    And I click on the element with css selector "header nav.navigation > ul.ui-menu:nth-child(1) > li.level0:nth-child(1) > ul.level0.submenu > li.level1:nth-child(1) > a"
    Then I wait for 4 second
    And I click on the element with css selector ".product-items .product-item:nth-child(1) .product-item-actions form div.tocart-container button.btn.tocart"
    Then I wait for 4 second
    And I should see "Has añadido"
    Then I wait for 2 second
    And I click on the element with css selector ".header__right .header__minicart a.showcart"
    Then I wait for 2 second
    And I click on the element with css selector "#top-cart-btn-checkout"
    Then I wait for 2 second
    Then I should see "Realizar pedido"
    And I click on the element with css selector ".field.addresses .shipping-address-item button.action-select-shipping-item"
    Then I wait for 4 second
    And I click on the element with css selector "#checkout-shipping-method-load tr:nth-child(1) > td:nth-child(1) > label:nth-child(1) > span:nth-child(2)"
    Then I wait for 2 second
    And I fill in "delivery_comment" with "JuinsaTech - Pedido de prueba desde Mink Selenium"
    And I click on the element with css selector "#shipping-method-buttons-container button.continue"
    Then I wait for 8 second
    And I click on the element with css selector "#checkout-payment-method-load div.payment-method:nth-child(2) > div:nth-child(1) > label:nth-child(1) > span:nth-child(2)"
    Then I wait for 4 second
    And I click on the element with css selector ".payment-method-content .checkout-agreement label.custom-checkbox > span:nth-child(2)"
    And I click on the element with css selector ".actions-toolbar .primary button.checkout"
    Then I wait for 15 second
    And I should see "¡Gracias por tu compra!"

    Examples:
    | web                      |
    | https://ixia.es/         |
    | https://unimasa.es/      |
    | https://bestproducts.es/ |