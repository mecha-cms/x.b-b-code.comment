<?php

$content = file_get_contents(__DIR__ . D . 'test');

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    fire("x\\b_b_code__comment", [null, null, null, null], (object) []);
    echo '<pre style="background:#ccc;border:1px solid rgba(0,0,0,.25);color:#000;font:normal normal 100%/1.25 monospace;padding:.5em .75em;white-space:pre-wrap;word-wrap:break-word;">' . htmlspecialchars($content) . '</pre>';
    echo '<pre style="background:#cfc;border:1px solid rgba(0,0,0,.25);color:#000;font:normal normal 100%/1.25 monospace;padding:.5em .75em;white-space:pre-wrap;word-wrap:break-word;">' . htmlspecialchars($_POST['comment']['content'] ?? "") . '</pre>';
    exit;
}

echo '<form method="post">';
echo '<p>';
echo '<textarea name="comment[content]" rows="' . (substr_count($content, "\n") + 1) . '" style="box-sizing: border-box; resize: vertical; width: 100%;">';
echo From::HTML($content);
echo '</textarea>';
echo '</p>';
echo '<p>';
echo '<button type="submit">';
echo 'Test';
echo '</button>';
echo '</p>';
echo '</form>';

exit;