<?php namespace x\b_b_code__comment;

function route__comment($content, $path, $query, $hash) {
    if ('POST' !== $_SERVER['REQUEST_METHOD']) {
        return $content;
    }
    foreach ($_POST['comment'] ?? [] as $k => $v) {
        if (!\is_string($v)) {
            continue;
        }
        if (false !== \strpos($v, '[/code]')) {
            $parts = \preg_split('/(\[code(?:=[-.:\w]+)?\][\s\S]*?\[\/code\])/', $v, -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);
            $v = ""; // Reset!
            foreach ($parts as $part) {
                if ('[/code]' === \substr($part, -7)) {
                    $v .= $part; // Preserve HTML…
                } else {
                    $v .= \strip_tags($part);
                }
            }
        } else {
            $v = \strip_tags($v);
        }
        $_POST['comment'][$k] = $v;
    }
    // Force comment type to `BBCode`
    $_POST['comment']['type'] = 'BBCode';
    return $content;
}

\Hook::set('route.comment', __NAMESPACE__ . "\\route__comment", 90);

// Optional `comment.hint` extension
if (isset($state->x->{'comment.hint'})) {
    \State::set("x.comment\\.hint.content", 'All HTML tags will be removed. Use <a href="https://www.bbcode.org/reference.php" target="_blank">BBCode</a> syntax to style your comment body.');
}

if (\defined("\\TEST") && 'x.b-b-code.comment' === \TEST && \is_file($test = __DIR__ . \D . 'test.php')) {
    require $test;
}