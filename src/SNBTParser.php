<?php

namespace Stilling\SNBTParser;

use Stilling\SNBTParser\Tokens\InitialToken;
use Stilling\SNBTParser\Tokens\Token;

class SNBTParser {
	public static function parse(string $input): array|float|int|string|object|bool {
		$tokens = static::readTokens(mb_trim($input));

		return static::jsonParseTokens($tokens);
	}

	/**
	 * @param string $token
	 * @param Token[] $tokens
	 * @return Token[]
	 * @throws \Exception
	 */
	protected static function readTokens(string $token, array $tokens = []): array {
		if (count($tokens) === 0) {
			$currentToken = new InitialToken();
		} else {
			$currentToken = end($tokens);
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

		$tokens[] = $nextToken;

		if (mb_strlen($remaining) > 0) {
			return static::readTokens($remaining, $tokens);
		}

		return $tokens;
	}

	/**
	 * @param Token[] $tokens
	 * @return array|float|int|string|object|bool
	 * @throws \Exception
	 */
	protected static function jsonParseTokens(array $tokens): array|float|int|string|object|bool {
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
