<?php

require 'inc/wordbank.php';

class Phrase{
    /*Class file includes the $currentPhrase and $selected properties.
    
    The Star Trek character our player is guessing:*/
    public $currentPhrase = "";
    //An array of letters our player has already selected:
    public $selected = [];

    /*Class file includes a constructor which accepts two optional parameters 
    for a phrase string and a selected array.*/
    public function __construct($phrase = null, $selected=null){
        //If a phrase is not passed, a phrase is randomly selected from a list.
        if($phrase == null){
            $this->currentPhrase = wordBankRandomizer();
        }
        if ($selected !=null){
            $this->selected = $selected;
        }
    }

    public function getPhrase(){
        return $this->currentPhrase;
    }

    public function getSelected(){
        return $this->selected;
    }

    public function getLetterArray(){
        array_unique(str_split(str_replace(" ", "", strtolower($this->currentPhrase))));
    }

    public function getLost(){
        return count(array_diff($this->selected, $this->getLetterArray()));
    }

    public function addPhraseToDisplay(){
        /*Builds the HTML for the letters of the phrase.
        Each letter is presented by an empty box, one list item for each letter.*/
         
        $phraseToDisplay = "<div class='section' id='phrase'>";
        $splitLetters = str_split(strtolower($this->currentPhrase));
        
        /*When the player correctly guesses a letter, the empty box is replaced with the matched letter. 
        Use the class "hide" to hide a letter and "show" to show a letter.*/
        foreach ($splitLetters as $splitLetter){
            if(in_array($splitLetter, $this->selected)){
                $phraseToDisplay.= '<li class="show letter">' . $splitLetter . "</li>";
            }
            elseif ($letter = " "){
                $phraseToDisplay.= '<li class="space">' . $splitLetter. "</li>";
            }
            else{
                $phraseToDisplay.= '<li class="hide letter">' . $splitLetter . "</li>";
            }
        }
        $phraseToDisplay.= "</div>";
        return $phraseToDisplay;
    }

    public function checkLetter($indvidualButton){
        /*Checks to see if a letter matches a letter in the phrase. 
        Accepts a single letter to check against the phrase. 
        Returns true or false.*/
        if(in_array($indvidualButton, $this->getLetterArray())){
            return true;
        }
        else{
            return false;
        }
    }

}