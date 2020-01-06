<?php

class Game{
    /*Class file includes the $phrase and $lives properties.
    
    An instance of the Phrase class to use with the game:*/
    public $phrase;
    //An integer for the number of wrong chances to guess the phrase:
    public $lives = 5;

    //Class file includes a constructor which accepts a Phrase object and sets the property.
    public function __construct($phrase){
        $this->phrase =$phrase;
    }

    public function checkForWin(){
        //This method checks to see if the player has selected all of the letters.
        if (count(array_intersect($this->phrase->selected, $this->phrase->getLetterArray()))== count($this->phrase->getLetterArray())){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function checkForLose(){
        //This method checks to see if the player has guessed too many wrong letters.
        if($this->phrase->getLost() == $this->lives){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function gameOver(){
        /*This method displays one message if the player wins and another message if they lose. 
        It returns false if the game has not been won or lost.*/
        if ($this->checkForLose() == TRUE){
            return '<h1> Your answers were highly illogical... <br> Your Star Trek character was '. $this->phrase->currentPhrase .'<h1>
            <form action="play.php" method="POST">
            <div id="overlay">
            <input id="btn__reset" type="submit" name="new" value="Re-engage?"/>
            </form>
            </div>';
        
        }
        elseif ($this->checkForWin() == TRUE){
            return '<h1> You made it so, Number One! <br> Your Star Trek character was '. $this->phrase->currentPhrase .'<h1>
            <form action="play.php" method="POST">
            <div id="overlay">
            <input id="btn__reset" type="submit" name="new" value="Re-engage?"/>
            </form>
            </div>';
        }
        else{
            return FALSE;
        }
    }

    public function displayKeyboard(){
        /*Create a onscreen keyboard to form. 
        If the letter has been selected the button should be disabled.
        Additionally, the class "correct" or "incorrect" should be added based on the checkLetter() method of the Phrase object. 
        Return a string of HTML form for keyboard.*/
        $buttons = [
            ['q','w','e','r','t','y','u','i','o','p'],
            ['a','s','d','f','g','h','j','k','l'],
            ['z','x','c','v','b','n','m', '-', '\'']
        ];

        $keyboard = '<form method="POST" action="play.php">';
        $keyboard .= '<div id="qwerty" class="section">';
        foreach ($buttons as $rows){
            $keyboard .= '<div class="keyrow">';

            foreach($rows as $indvidualButton){
                if(!in_array($indvidualButton, $this->phrase->selected)){
                    $keyboard .= "<button input id='" . $indvidualButton ." type='submit' name='key' value='" . $indvidualButton ."' class='key'>";
                }
                else{
                    if($this->phrase->checkLetter($indvidualButton)){
                        $keyboard .= "<button input id='" . $indvidualButton ." type='submit' name='key' value='" . $indvidualButton ."' class='key correct' disabled>";
                    }
                    else{
                        $keyboard .= "<button input id='" . $indvidualButton ." type='submit' name='key' value='" . $indvidualButton ."' class='key incorrect' disabled>";
                    }
                }
                $keyboard.='</button>';
            }
            $keyboard.='</div>';
        }
        $keyboard.='</div>';
        return $keyboard;
    }

    public function displayScore(){
        /*Display the number of guesses available.
        Return string HTML of Scoreboard.*/
        $health='<div id="scoreboard" class="section">';

        for ($i= 1; $i <= $this->phrase->getLost(); $i++){
            $health.='<li class="tries"><img src="images/lostHeart.png" height="35px" width="30px"></li>';
        }
        for ($i=1; $i<= ($this->lives - $this->phrase->getLost()); $i++){
            $health.='<li class="tries"><img src="images/liveHeart.png" height="35px" width="30px"></li>';
        }
        $health.='</div>';
        return $health;
    }
}