<?php

namespace Stilling\SNBTParser\Tokens;

class InitialToken extends Token {
	public function getPossibleNeighbors(): array {
		return [
			NumberArrayToken::class,
			CompoundOpenToken::class,
			ListOpenToken::class,
			NumberToken::class,
			StringToken::class,
			BooleanToken::class,
		];
	}

	public function satisfiesConstraints(string $token): int {
		throw new \Exception("Not implemented.");
	}

	public function toJsonToken(): string {
		throw new \Exception("Not implemented.");
	}
}
