<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext
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
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * @When I wait for AJAX to finish
     */
    public function iWaitForAjaxToFinish()
    {
        $this->getSession()->wait(3000, "window.__behatAjax === false && (0 === jQuery.active && !jQuery(':animated').length)");
    }

      /**
     * @When I fill in search field with :query
     */
    public function iFillInSearchFieldWith($query)
    {
        $searchField = $this->getPage()->find('css', '#edit-query');
        $searchField->setValue($query);
    }

    /**
     * @When I wait for :time seconds
     */
    public function iWaitForSeconds($time)
    {
        sleep($time);
    }

    /**
     * @Then I should see :number block elements
     */
    public function iShouldSeeBlockElements($number)
    {
        $singlePosts = $this->getPage()->findAll('css', '.single-post');
        $actualNumber = count($singlePosts);
        assert($actualNumber == $number, 'The number of elements does not equal ' . $number);
    }

    /**
     * @Then I click button to load more results
     */
    public function iClickButtonToLoadMoreResults()
    {
        $loadMoreBtn = $this->getPage()->find('css', '.pager-next a');
        if($loadMoreBtn) {
            $loadMoreBtn->click();
        } else {
            echo "Could not find load more button and click on it!";
        }
    }
}
