<?php

namespace App;

final class ApplicationParameters {

    /** @var string */
    public string $charset = 'UTF-8' {
        get {
            return $this->charset;
        }
    }
    /** @var string */
    public string $name = 'Codices' {
        get {
            return $this->name;
        }
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
