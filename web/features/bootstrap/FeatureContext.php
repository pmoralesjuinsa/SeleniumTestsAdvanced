<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Hook\Scope\AfterStepScope;

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

    /**
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function takeScreenshotAfterFailedStep(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $this->iTakeAScreenshot('failStep');
        }
    }

    protected function driverSupportsJavascript()
    {
        $driver = $this->getSession()->getDriver();
        return ($driver instanceof \Behat\Mink\Driver\Selenium2Driver || $driver instanceof \Behat\MinkExtension\ServiceContainer\Driver\SahiFactory);
    }

    /**
     * @Then I take a screenshot
     * @Then I take a screenshot with :arg1
     */
    public function iTakeAScreenshot($name = '')
    {
        $screenFolder = __DIR__ . '/../../screenshots/';
        $fileName = $name . date('YmdHis');
        $fileExtension = '.png';

        if (!$this->driverSupportsJavascript()) {
            $fileExtension = '.txt';
            file_put_contents(sprintf('%s-%s', $screenFolder, $fileName . $fileExtension), $this->getSession()->getPage()->getOuterHtml());
            return;
        }

        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $file_and_path = $screenFolder . $fileName . '_screenshot' . $fileExtension;
        $fileCreated = file_put_contents($file_and_path, $image_data);

        $this->mailNotify($fileCreated, $file_and_path, $fileName . $fileExtension);
    }

    public function mailNotify($fileCreated, $fileAndPath, $filename)
    {
        $to      = 'pedromorales@grupojuinsa.es';
        $title    = 'Fallo de algún test';
        $message   = 'Ha ocurrido un error en algún test. Adjunto archivo con captura.';
        $headers = 'From: pedromorales@grupojuinsa.es' . "\r\n" .
            'Reply-To: pedromorales@grupojuinsa.es' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

//        if($fileCreated !== false) {
//            $semi_rand = md5(time());
//            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
//
//            // preparing attachments
//            $file = fopen($fileAndPath,"rb");
//            $data = fread($file,filesize($fileAndPath));
//            fclose($file);
//            $data = chunk_split(base64_encode($data));
//            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"".$filename."\"\n" .
//                "Content-Disposition: attachment;\n" . " filename=\"$filename\"\n" .
//                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
//            $message .= "--{$mime_boundary}--\n";
//        }

        @mail($to, $title, $message, $headers);
    }

}
