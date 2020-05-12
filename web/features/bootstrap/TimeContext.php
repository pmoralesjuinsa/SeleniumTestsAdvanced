<?php

use Behat\MinkExtension\Context\RawMinkContext;

class TimeContext extends RawMinkContext
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
     * @Then /^(?:|I )wait for (?P<time>\d+) (?P<unit>millisecond|second)(?:|s)$/
     */
    public function iWaitForSecond($time, $unit)
    {
        $waitTime = $time;
        if ($unit == 'second') {
            $waitTime = $waitTime * 1000;
        }
        $this->getSession()->wait($waitTime);
    }
}