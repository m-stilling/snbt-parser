<?php

namespace Stilling\SNBTParser\Tokens;

class CommaToken extends Token {
	public function getPossibleNeighbors(): array {
		return [
			NumberArrayToken::class,
			ListOpenToken::class,
			CompoundOpenToken::class,
			CompoundCloseToken::class,
			CompoundKeyToken::class,
			StringToken::class,
			NumberToken::class,
		];
	}

	public function satisfiesConstraints(string $token): int {
		$trimmedToken = mb_trim($token);
		return str_starts_with($trimmedToken, ",") ? mb_strlen($token) - mb_strlen($trimmedToken) + 1 : 0;
	}

	public function toJsonToken(): string {
		return ",";
	}
}
