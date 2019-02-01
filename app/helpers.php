<?php

function markdownToHtml(string $markdown)
{
    return (new Parsedown)->text($markdown);
}
