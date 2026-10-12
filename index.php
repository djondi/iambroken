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

if (!in_array($method, ['GET', 'HEAD'], true)) {
    header('Allow: GET, HEAD, OPTIONS');
    header('Content-Length: 0');
    http_response_code(405);
    exit;
}

$name = $_GET['name'] ?? 'visitor';

header("Content-Security-Policy: default-src 'self'; script-src 'none'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; style-src 'self' 'unsafe-inline'");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bright DAST - Tiny Test App</title>
  <style>
    body { font: 16px system-ui, sans-serif; max-width: 580px; margin: 70px auto; padding: 0 20px; line-height: 1.6; }
    input, button { font: inherit; padding: 8px 12px; }
    input { width: 60%; }
    button { cursor: pointer; }
    .result { background: #f1f5f9; padding: 16px; border-radius: 8px; margin-top: 20px; }
    small { color: #666; }
  </style>
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
