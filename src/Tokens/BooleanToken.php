<?php

namespace Stilling\SNBTParser\Tokens;


class BooleanToken extends Token {
	protected bool $value;

	public function getPossibleNeighbors(): array {
		return [
			CompoundCloseToken::class,
			ListCloseToken::class,
			CommaToken::class,
		];
	}

	public function satisfiesConstraints(string $token): int {
		$trimmedToken = mb_trim($token);

		if (str_starts_with($trimmedToken, "true")) {
			$this->value = true;
			return mb_strlen($token) - mb_strlen($trimmedToken) + 4;
		}

		if (str_starts_with($trimmedToken, "false")) {
			$this->value = false;
			return mb_strlen($token) - mb_strlen($trimmedToken) + 5;
		}

		return 0;
	}

	public function toJsonToken(): string {
		return $this->value ? "true" : "false";
	}
}
