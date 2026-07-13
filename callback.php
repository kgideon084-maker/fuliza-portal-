<?php
// This receives payment data from PayHero
$data = json_decode(file_get_contents('php://input'), true);

// This saves every payment to a file called payments.log
// So we can check if it's working
$log_entry = date('Y-m-d H:i:s') . " => " . json_encode($data) . "\n";
file_put_contents('payments.log', $log_entry, FILE_APPEND);

// If payment was successful
if(isset($data['status']) && $data['status'] == 'Success'){
    $amount = $data['amount'];
    $phone = $data['phone_number'];
    $reference = $data['external_reference'];
    
    // Later we will save this to database
    // For now we just write to log file
    $success_message = "✅ PAYMENT RECEIVED: Ksh".$amount." from ".$phone." Ref: ".$reference."\n";
    file_put_contents('payments.log', $success_message, FILE_APPEND);
}

// Important: We must return "200 OK" to PayHero
http_response_code(200);
echo "OK";
?>
