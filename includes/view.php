<?php

declare(strict_types=1);

function renderView(string $template, array $data = []): void
{
    include TEMPLATES_DIR . '/header.php';
    include TEMPLATES_DIR . '/' . $template . '.php';
    include TEMPLATES_DIR . '/footer.php';
}

function renderView2(string $template, array $data = []): void
{
    include TEMPLATES_DIR . '/header2.php';
    include TEMPLATES_DIR . '/' . $template . '.php';
    include TEMPLATES_DIR . '/footer.php';
}

function renderView3(string $template, array $data = []): void
{
    include TEMPLATES_DIR . '/header3.php';
    include TEMPLATES_DIR . '/' . $template . '.php';
    include TEMPLATES_DIR . '/footer.php';
}
// includes/view.php 