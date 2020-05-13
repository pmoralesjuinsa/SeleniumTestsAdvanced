<?php

use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Hook\Scope\AfterStepScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext
{
    const INCOMING_WEBHOOK_URL = "https://outlook.office.com/webhook/8021965b-be03-4db1-86b0-86f119a04aab@bc76e231-c566-4b3a-84f1-18fc504b041d/IncomingWebhook/fe1e88ded8304a88a59e13c900c65b1e/eb4754e8-89ee-4d89-b478-906f3b4b4aa5";

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
            $filePath = $this->iTakeAScreenshot('failStep');
            $this->sendNotifyToTeams($filePath, $scope->getFeature()->getTitle(), $scope->getStep()->getText());
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
            file_put_contents(sprintf('%s-%s', $screenFolder, $fileName . $fileExtension),
                $this->getSession()->getPage()->getOuterHtml());
            return;
        }

        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $file_and_path = $screenFolder . $fileName . '_screenshot' . $fileExtension;
        $fileCreated = file_put_contents($file_and_path, $image_data);

//        $this->mailNotify($fileCreated, $file_and_path, $fileName . $fileExtension);

        return $file_and_path;
    }

    public function mailNotify($fileCreated, $fileAndPath, $filename)
    {
        $to = 'pedromorales@grupojuinsa.es';
        $title = 'Fallo de algún test';
        $message = 'Ha ocurrido un error en algún test. Adjunto archivo con captura.';
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

    public function sendNotifyToTeams($imagePath, $feature, $step)
    {
        $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($imagePath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // create connector instance
        $connector = new \Sebbmyr\Teams\TeamsConnector(self::INCOMING_WEBHOOK_URL);
        // create card
        $card = new CustomCard([
            'title' => 'Simple custom card title',
            'sections' => [
                'text' => 'Ha ocurrido un error en el siguiente test:',
                'facts' => [
                    'feature' => $feature,
                    'step' => $step,
                    'image' => $base64
                ]
            ]
        ]);
        // send card via connector
        $connector->send($card);
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        if ($this->getSession()->getDriver() instanceof Selenium2Driver) {
            $this->getMink()->getSession()->start();
            $this->getSession()->resizeWindow(420, 390, 'current');
        }
    }

}
