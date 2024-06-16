<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body>
    <h2>Payment Receipt</h2>
    <p>Payment ID: {{ $receiptData['payment_id'] }}</p>
    <p>Patient Name: {{ $receiptData['patient_name'] }}</p>
    <p>Appointment Type: {{ $receiptData['appointment_type'] }}</p>
    <p>Debit: {{ $receiptData['debit'] }}</p>
    <p>Credit: {{ $receiptData['credit'] }}</p>
    <p>Balance: {{ $receiptData['balance'] }}</p>
    <p>Date: {{ $receiptData['date'] }}</p>
</body>
</html>
