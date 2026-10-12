<?php
/**
 * Deliberately vulnerable DAST test target.
 * For LOCAL or AUTHORIZED test environments ONLY.
 * Do not deploy on an internet-facing production server.
 *
 * Start: php -S 127.0.0.1:8000 index.php
 * Visit: http://127.0.0.1:8000/
 *
 * Intentional vulnerability: Reflected Cross-Site Scripting (XSS)
 * - The `name` GET parameter is printed into HTML without escaping.
 * - Remediation: use htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').
 */
$name = $_GET['name'] ?? 'visitor';
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
    <!-- INTENTIONALLY UNSAFE: reflected XSS for authorized security testing -->
    Hello, <?php echo $name; ?>!
  </div>
  <p><small>Intentionally vulnerable training application. Never deploy publicly.</small></p>
</body>
</html>
