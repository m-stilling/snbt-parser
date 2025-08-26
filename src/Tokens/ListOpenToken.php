<?php

namespace Stilling\SNBTParser\Tokens;

class ListOpenToken extends Token {
	public function getPossibleNeighbors(): array {
		return [
			CompoundOpenToken::class,
			ListCloseToken::class,
			ListOpenToken::class,
			StringToken::class,
			NumberToken::class,
		];
	}

	public function satisfiesConstraints(string $token): int {
		$trimmedToken = mb_trim($token);
		return str_starts_with($trimmedToken, "[") ? mb_strlen($token) - mb_strlen($trimmedToken) + 1 : 0;
	}

	public function toJsonToken(): string {
		return "[";
	}
}
