<?php

namespace Stilling\SNBTParser;

use Stilling\SNBTParser\Tokens\InitialToken;
use Stilling\SNBTParser\Tokens\Token;

class SNBTParser {
	/** @var Token[] */
	protected array $tokens = [];

	public function parse(string $input): array|float|int|string|object {
		$this->tokens = [];
		$this->readToken(mb_trim($input));

		return $this->jsonParseTokens($this->tokens);
	}

	protected function readToken(string $token): void {
		if (count($this->tokens) === 0) {
			$currentToken = new InitialToken();
		} else {
			$currentToken = end($this->tokens);
		}

		[ $nextToken, $remaining ] = $currentToken->parseNextToken($token);

		if (
			!isset($nextToken)
			|| !($nextToken instanceof Token)
			|| !isset($remaining)
			|| !is_string($remaining)
		) {
			throw new \Exception("Invalid parseNextToken result");
		}

		$this->tokens[] = $nextToken;

		if (mb_strlen($remaining) > 0) {
			$this->readToken($remaining);
		}
	}

	protected function jsonParseTokens(array $tokens): array|float|int|string|object {
		$json = "";

		foreach ($tokens as $token) {
			$json .= $token->toJsonToken();
		}

		$array = json_decode($json, true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new \Exception("SNBT is malformed, failed to decode JSON: " . json_last_error_msg());
		}

		return $array;
	}
}
