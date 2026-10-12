<?php
/**
 * Deliberately vulnerable DAST test target.
 * For LOCAL or AUTHORIZED test environments ONLY.
 * Do not deploy on an internet-facing production server.
 *
 * Start: php -S 127.0.0.1:8000 index.php
 * Visit: http://127.0.0.1:8000/
 *
 * Reflected Cross-Site Scripting (XSS) protected by HTML escaping.
 * - User input is escaped at the sink before being rendered.
 */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    header('Allow: GET, HEAD, OPTIONS');
    header('Content-Length: 0');
    http_response_code(204);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$requestBody = file_get_contents('php://input');
if ($requestBody !== false && $requestBody !== '') {
    header('Allow: GET, HEAD, OPTIONS');
    header('Content-Length: 0');
    http_response_code(400);
    exit;
}

if (!in_array($method, ['GET', 'HEAD'], true)) {
    header('Allow: GET, HEAD, OPTIONS');
    header('Content-Length: 0');
    http_response_code(405);
    exit;
}

$rawName = $_GET['name'] ?? 'visitor';
$name = is_string($rawName) && preg_match('/^[\p{L}\p{N} .\'-]+$/u', $rawName)
    ? trim($rawName)
    : 'visitor';


header("Content-Security-Policy: default-src 'self'; script-src 'none'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; style-src 'self'; style-src-elem 'self'; style-src-attr 'none'");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bright DAST - Tiny Test App</title>
  <link rel="stylesheet" href="/styles.css">
</head>
<body>
  <h1>Tiny Bright DAST Test</h1>
  <p>Enter a name and submit the form.</p>
  <form method="get" action="/">
    <label for="name">Name</label><br>
    <input id="name" name="name" type="text" placeholder="Your name">
    <button type="submit">Greet me</button>
  </form>
  <div class="result">
    Hello, <?php echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>!
  </div>
  <p><small>Intentionally vulnerable training application. Never deploy publicly.</small></p>
</body>
</html>
