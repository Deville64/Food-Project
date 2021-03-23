<?php
function getIngredients()
{
  $db = new PDO('mysql:host=localhost;dbname=onylia_laravel', 'root', '');
  $sql = 'SELECT id, name FROM ingredients';
  $request = $db->prepare($sql);
  $request->execute();
  $results = $request->fetchAll();

  // get the q parameter from URL
  $q = $_REQUEST["q"];
  $hint = "";

  // lookup all hints from array if $q is different from ""
  if ($q !== "") {
    $len = strlen($q);
    foreach ($results as $ingredient) {
      if (stristr($q, substr($ingredient["name"], 0, $len))) {
        $hint = $hint . "<div onclick =selectHint(event," . $ingredient["id"] .")>" . $ingredient["name"] . "</div>";
      }
    }
  }
  // Output "no suggestion" if no hint was found or output correct values
  echo $hint === "" ? "Pas de suggestion" : $hint;
};
getIngredients();
