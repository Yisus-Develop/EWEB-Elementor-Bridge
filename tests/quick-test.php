#!/usr/bin/env php
<?php
/**
 * Quick Converter Validation
 */

echo "=== EWEB Converter Validation ===\n\n";

// Define ABSPATH for local testing
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/../');
}

// Load converter
$converter_path = __DIR__ . '/../src/includes/class-eweb-eb-converter.php';
if (!file_exists($converter_path)) {
    die("ERROR: Converter file not found at: $converter_path\n");
}

// Mock WP function
function wp_generate_password($l, $s, $e) { return substr(md5(rand()), 0, $l); }

require_once $converter_path;

// Test 1: Simple widget
echo "TEST 1: Simple Widget\n";
$input = [['type' => 'heading', 'settings' => ['title' => 'Test']]];
$result = EWEB_EB_Converter::convert($input);
$json = json_encode($result);

if (strpos($json, '"elType":null') !== false) {
    die("FAIL: Found elType:null in output!\n");
}
if (empty($result)) {
    die("FAIL: Empty result!\n");
}
echo "✓ PASS\n\n";

// Test 2: Services widget
echo "TEST 2: Services Widget\n";
$input = [['type' => 'cps_services_asymmetric', 'settings' => ['main_title' => 'Test']]];
$result = EWEB_EB_Converter::convert($input);
$json = json_encode($result, JSON_PRETTY_PRINT);

echo "DEBUG: Result structure:\n";
echo $json . "\n\n";

if (strpos($json, '"elType":null') !== false) {
    die("FAIL: Found elType:null in Services widget!\n");
}
if (empty($result)) {
    die("FAIL: Empty result for Services!\n");
}

// Check for widgetType in the wrapped structure
$widget = null;
if (isset($result[0]['elements'][0]['elements'][0])) {
    $widget = $result[0]['elements'][0]['elements'][0]; // Triple nested
} elseif (isset($result[0]['elements'][0])) {
    $widget = $result[0]['elements'][0]; // Double nested
}

if (!$widget || !isset($widget['widgetType'])) {
    echo "FAIL: Missing widgetType! Widget structure: " . json_encode($widget) . "\n";
    die();
}
echo "✓ PASS (widgetType: {$widget['widgetType']})\n\n";

// Test 3: Nested structure
echo "TEST 3: Nested Structure\n";
$input = [[
    'type' => 'container',
    'children' => [
        ['type' => 'heading', 'settings' => ['title' => 'Nested']],
        ['type' => 'text', 'settings' => ['editor' => 'Content']]
    ]
]];
$result = EWEB_EB_Converter::convert($input);
$json = json_encode($result);

if (strpos($json, '"elType":null') !== false) {
    die("FAIL: Found elType:null in nested structure!\n");
}
echo "✓ PASS\n\n";

echo "=== ALL TESTS PASSED ===\n";
echo "Converter is SAFE to deploy!\n\n";

// Output sample for verification
echo "Sample Output (Services Widget):\n";
$sample = [['type' => 'cps_services_asymmetric', 'settings' => ['main_title' => 'Manutenção Industrial']]];
$sample_result = EWEB_EB_Converter::convert($sample);
echo json_encode($sample_result, JSON_PRETTY_PRINT) . "\n";

exit(0);
