<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connection to the SQLite database
try {
    $db = new PDO('sqlite:database.db'); // Adjust the path as needed
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    log_error("Database connection failed: " . $e->getMessage());
    exit;
}

// Function to log errors
function log_error($message) {
    $log_file = 'error_log.txt';
    $current_time = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$current_time] $message\n", FILE_APPEND);
}

// Function to download and save the image with signed URL
function download_and_save_image($url, $save_path) {
    $ch = curl_init($url);
    if (!$ch) {
        log_error("cURL initialization failed for URL: $url");
        return false;
    }
    $fp = fopen($save_path, 'wb');
    if (!$fp) {
        log_error("Failed to open file pointer for path: $save_path");
        curl_close($ch);
        return false;
    }

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Ensure cURL fails on HTTP errors

    $success = curl_exec($ch);

    if (!$success) {
        log_error("cURL error: " . curl_error($ch) . " for URL: $url");
    }

    curl_close($ch);
    fclose($fp);

    if (filesize($save_path) === 0) {
        log_error("Downloaded file is empty for URL: $url");
        unlink($save_path); // Remove the empty file
        return false;
    }

    return $success;
}

// Get the JSON input from the webhook
$input = file_get_contents('php://input');
$event = json_decode($input, true);

if (!$event) {
    log_error("Invalid JSON input.");
    exit;
}

// Handle different types of events
try {
    switch ($event['type']) {
        case 'records.after.insert':
        case 'records.after.update':
            foreach ($event['data']['rows'] as $record) {
                $image_path = null;
                if (!empty($record['Obrazek'][0]['signedUrl'])) {
                    $image_url = $record['Obrazek'][0]['signedUrl'];
                    $parsed_url = parse_url($image_url);
                    $image_name = basename($parsed_url['path']);
                    $image_path = 'uploads/' . $image_name;
                    if (!download_and_save_image($image_url, $image_path)) {
                        $image_path = null; // Reset image path if download failed
                    }
                }

                if ($record['Publikacja'] === true) {
                    $stmt = $db->prepare("REPLACE INTO posts (Id, Tytul, Tresc, Obrazek, Kategoria, Publikacja, Data_utworzenia) VALUES (:Id, :Tytul, :Tresc, :Obrazek, :Kategoria, :Publikacja, :Data_utworzenia)");
                    $stmt->bindParam(':Id', $record['Id']);
                    $stmt->bindParam(':Tytul', $record['Tytuł']);
                    $stmt->bindParam(':Tresc', $record['Treść']);
                    $stmt->bindParam(':Obrazek', $image_path);
                    $stmt->bindParam(':Kategoria', $record['Kategoria']);
                    $stmt->bindParam(':Publikacja', $record['Publikacja'], PDO::PARAM_BOOL);
                    $stmt->bindParam(':Data_utworzenia', $record['Data utworzenia']);
                    $stmt->execute();
                } else {
                    $stmt = $db->prepare("DELETE FROM posts WHERE Id = :Id");
                    $stmt->bindParam(':Id', $record['Id']);
                    $stmt->execute();
                }
            }
            break;

        case 'records.after.delete':
            foreach ($event['data']['rows'] as $record) {
                $stmt = $db->prepare("DELETE FROM posts WHERE Id = :Id");
                $stmt->bindParam(':Id', $record['Id']);
                $stmt->execute();
            }
            break;
    }

    echo "Webhook handled successfully.";
} catch (PDOException $e) {
    log_error("Database error: " . $e->getMessage());
    exit;
} catch (Exception $e) {
    log_error("General error: " . $e->getMessage());
    exit;
}
?>
