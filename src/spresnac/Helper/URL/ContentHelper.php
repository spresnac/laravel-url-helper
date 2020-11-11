<?php

namespace spresnac\Helper\URL;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ContentHelper
{
    protected string $content;

    /**
     * ContentHelper constructor.
     *
     * @param string|null $content
     */
    public function __construct(string $content = null)
    {
        if ($content !== null) {
            $this->setContent($content);
        }
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getHrefsAsArray(): array
    {
        return $this->getHrefs()->toArray();
    }

    public function getHrefs(): Collection
    {
        $data = collect();
        $content = Str::of($this->content)->trim();
        if ($content->length() > 0) {
            $data = $content->matchAll('/href=["\']([^"\']*)["\']/');
        }

        return $data;
    }
}
