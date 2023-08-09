
<?php
if (isset($_POST["imageData"])) {
    $imageData = $_POST["imageData"];

    // Convert the base64-encoded image data to binary
    $data = substr($imageData, strpos($imageData, ',') + 1);
    $decodedData = base64_decode($data);

    // Save the image data to a file on the server
    $filename = uniqid() . '.png'; // Generate a unique filename for the image
    $targetFilePath = "imageuploaded/" . $filename;
    file_put_contents($targetFilePath, $decodedData);

    // Now, you can save the $targetFilePath to the database or process it further as needed
    // For example, you can add it to the INSERT query or update an existing record with the image file path.
    // Make sure to include the necessary database connection and INSERT/UPDATE logic here.

    // For simplicity, we'll just echo the image file path back to the client
    echo $targetFilePath;
}
?>
