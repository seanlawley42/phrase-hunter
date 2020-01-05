<?php

session_start();

require "inc/Phrase.php";
require "inc/Game.php";

if(isset($_POST['engage'])) {
    unset($_SESSION['selected']);
    unset($_SESSION['phrase']);
    $phrase = new Phrase();
  }
$phrase = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
 if (!empty($phrase)) {
   session_destroy();
 }
 if (isset($_SESSION['selected']) && isset($_POST['key'])) {
     $_SESSION['selected'][] = $_POST['key'];
 } else {
     $_SESSION['selected'] = [];
 }
$phrase = new Phrase($_SESSION['phrase'], $_SESSION['selected']);
$_SESSION['phrase'] = $phrase->currentPhrase;
$game = new Game($phrase);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phrase Hunter: <br> Set Phrasers to Stun!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
<div class="main-container">
    <div id="banner" class="section">
        <h2 class="header">Phrase Hunter: <br> Set Phrasers to Stun!</h2>
    </div>
</div>
<?php
    echo $phrase->addPhrasetoDisplay();
    echo $game->displayKeyboard();
    echo $game->displayScore();
    echo $game->gameOver();
    ?>

</body>
</html>
