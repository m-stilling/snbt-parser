<?php

use Stilling\SNBTParser\SNBTParser;

test("ints to uuid", function () {
	$ints = [
		110787060,
		1156138790,
		-1514210135,
		238594805,
	];

	expect(SNBTParser::intsToUuid($ints))->toEqual("069a79f4-44e9-4726-a5be-fca90e38aaf5")
		->and(fn () => SNBTParser::intsToUuid([]))->toThrow(InvalidArgumentException::class)
		->and(fn () => SNBTParser::intsToUuid([ 1, 2, 3 ]))->toThrow(InvalidArgumentException::class)
		->and(fn () => SNBTParser::intsToUuid([ 1, 2, 3, "4" ]))->toThrow(InvalidArgumentException::class)
		->and(fn () => SNBTParser::intsToUuid([ ...$ints, 1 ]))->toThrow(InvalidArgumentException::class);
});
