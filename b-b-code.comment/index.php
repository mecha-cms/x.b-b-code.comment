<?php namespace _\lot\x\b_b_code;

function comment($any) {
    foreach ($_POST['comment'] ?? [] as $k => $v) {
        if (!\is_string($v)) {
            continue;
        }
        if (false !== \strpos($v, '[/code]')) {
            $parts = \preg_split('/(\[code(=[\w-:.]+)?\][\s\S]*?\[\/code\])/', $v, null, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);
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
}

\Route::hit('.comment/*', __NAMESPACE__ . "\\comment", 0);

// Optional `comment.hint` extension
if (null !== \State::get("x.comment\\.hint")) {
    \State::set("x.comment\\.hint.hint", 'All HTML tags will be removed. Use <a href="https://github.com/mecha-cms/x.b-b-code" target="_blank">BBCode</a> syntax to style your comment body.');
}
