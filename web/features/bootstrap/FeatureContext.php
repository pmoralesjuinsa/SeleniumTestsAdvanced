<?php

use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Then /^(?:|I )click on the element with css selector "(?P<selector>.*)"$/
     */
    public function iClickOnTheElementWithCssSelector($selector)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'css',
            $selector
        );

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $selector));
        }

        $element->click();
    }
    /**
     * @Given /^(?:|I )hover over the element with css selector "(?P<selector>.*)"$/
     */
    public function iHoverOverTheElement($selector)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'css',
            $selector
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $selector));
        }
        $element->mouseOver();
    }
}
