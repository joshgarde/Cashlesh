<?php
  $quotesArray = [
    [
      'quote' => 'You sure can avoid taxes, but you can\'t avoid death.',
      'subquote' => 'man who avoided taxes'
    ],
    [
      'quote' => 'Money laundering is only illegal if you get caught.',
      'subquote' => 'uncaught money launderer'
    ],
    [
      'quote' => 'This bank is as secure as Fort Nox! Unhackable!',
      'subquote' => 'man who\'s bank was hacked'
    ],
    [
      'quote' => 'Have you tried Quibi yet? Next big thing in TV!',
      'subquote' => 'majority investor in Quibi'
    ],
    [
      'quote' => 'Perception is reality.',
      'subquote' => 'man who lacks both'
    ]
  ];

  function getRandomQuote() {
    global $quotesArray;
    return $quotesArray[rand(0, count($quotesArray) - 1)];
  }
?>
