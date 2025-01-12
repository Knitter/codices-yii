<?php

namespace App;

final class ApplicationParameters {

    /** @var string */
    private string $charset = 'UTF-8';
    /** @var string */
    private string $name = 'Codices';

    public function getCharset(): string {
        return $this->charset;
    }

    public function getName(): string {
        return $this->name;
    }

    public function charset(string $value): self {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function name(string $value): self {
        $new = clone $this;
        $new->name = $value;
        return $new;
    }
}
