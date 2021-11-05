<?php

require 'classes/hub_supervisor_classes/HubSupervisorClasses.php';

$db = NEW HubSupervisorClasses;

// foreach ($array as $aray){
   
// }
// foreach ($array as $row){
//     $id = $row['id'];
//     $order_date = $row['order_date'];
//     $order_number = $row['order_number'];
//     $c_fullname = $row['c_fullname'];
//     $c_pnumber_primary = $row['c_pnumber_primary'];
//     echo(var_dump($id));
//     echo(var_dump($order_number ));
// }
// echo(var_dump($array));

// $i = 0;
// while ($i < count($array)){
//     // echo(var_dump($array[$i]));;
//     // echo '<br/>';

//     if ($array[$i]['id'] == '191'){
//         echo "same";
//         echo '<br/>';
//     }else {
//         echo "not same";
//         echo '<br/>';
//     };

//     $i++;
// }



// $products = [
//     ['name' => 'shiny star', 'price' => 20],
//     ['name' => 'green shell', 'price' => 10],
//     ['name' => 'red shell', 'price' => 17],
//     ['name' => 'gold coin', 'price' => 16],
//     ['name' => 'lightning bolt', 'price' => 10],
//     ['name' => 'banana skin', 'price' => 2],
// ];

// foreach ($products as $product){
    
//     if ($product['price'] < 15){
//         continue;
//     }
//     // if ($product['name'] == 'lightning bolt'){
//     // break;
//     // }

//     echo $product['name'] . '<br/>';
// }

// foreach ($rOrderData as $row){
//     $id = $row['id'];
//     $order_date = $row['order_date'];
//     $order_number = $row['order_number'];
//     $c_fullname = $row['c_fullname'];
//     $c_pnumber_primary = $row['c_pnumber_primary'];

// $o_count_details = $db->checkOrderCount($order_number);

// echo(var_dump($o_count_details));

// }


// $rOrderData = $db->readAllOrderData();

// $foNumberArray = [];

// $order_number = '';

// foreach ($rOrderData as $row){

//     $order_number = $row['order_number'];
 

//     if (in_array($order_number, $foNumberArray, TRUE)){
//         continue;
//     }else{
//         echo 'one copy only';
//         $foNumberArray[] = $order_number;
//         var_dump( $foNumberArray);
//     }
// }

// echo "ARRAY COUNT";
// $people = array("Peter", "Joe", "Glenn", "Cleveland", 23);

// if (in_array("23", $people, TRUE))
//   {
//   echo "Match found<br>";
//   }
// else
//   {
//   echo "Match not found<br>";
//   }
// if (in_array("Glenn",$people, TRUE))
//   {
//   echo "Match found<br>";
//   }
// else
//   {
//   echo "Match not found<br>";
//   }

// if (in_array(23,$people, TRUE))
//   {
//   echo "Match found<br>";
//   }
// else
//   {
//   echo "Match not found<br>";
//   }

// $zipcodeGroup = ["2222","21231","21312","121230"];
// $zipcodeTrimGroup = trim($zipcodeGroup);
// $zipcodePieces = explode(",", $zipcodeTrimGroup);

// $implodedZip = implode(",", $zipcodeGroup);

// echo $implodedZip;
// var_dump(explode(",", $implodedZip));
//  var_dump($zipcodeGroup);
// echo $zipcodePieces[0];

    $wholeZip = '';
    $qResult = $db->getZipByHubNumber('FO102');

    var_dump($qResult);
    
    foreach($qResult as $result){
        $wholeZip = $result['zip_code'];
    }

    $zipPieces = explode(",", $wholeZip);

    var_dump($wholeZip);

    var_dump($zipPieces);

    foreach($zipPieces as $zipPc){
        echo $zipPc;
    }

    


// echo count($zipExploded);



?>
