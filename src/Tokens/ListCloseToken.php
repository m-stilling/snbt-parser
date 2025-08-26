<?php

namespace Stilling\SNBTParser\Tokens;

class ListCloseToken extends Token {
	public function getPossibleNeighbors(): array {
		return [
			CompoundCloseToken::class,
			ListCloseToken::class,
			CommaToken::class,
		];
	}

	public function satisfiesConstraints(string $token): int {
		$trimmedToken = mb_trim($token);
		return str_starts_with($trimmedToken, "]") ? mb_strlen($token) - mb_strlen($trimmedToken) + 1 : 0;
	}

	public function toJsonToken(): string {
		return "]";
	}
}
