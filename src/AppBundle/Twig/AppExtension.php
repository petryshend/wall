<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter(
                'markdown',
                [$this, 'parseMarkdown'],
                ['is_safe' => ['html']]
                ),
        ];
    }

    public function parseMarkdown(string $markdown): string
    {
        $parseDown = new \Parsedown();
        return $parseDown->text($markdown);
    }

    public function getName(): string
    {
        return 'app_extension';
    }
}