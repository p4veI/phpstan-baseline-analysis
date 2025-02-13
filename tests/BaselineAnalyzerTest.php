<?php

namespace staabm\PHPStanBaselineAnalysis\Tests;

use PHPUnit\Framework\TestCase;
use staabm\PHPStanBaselineAnalysis\Baseline;
use staabm\PHPStanBaselineAnalysis\BaselineAnalyzer;

class BaselineAnalyzerTest extends TestCase
{
    function testAllInComplexity():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/all-in.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(70, $result->classesComplexity);
    }

    function testClassComplexity():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/class-complexity.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(50, $result->classesComplexity);
    }

    function testMethodComplexityIgnored():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/method-complexity.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(0, $result->classesComplexity);
    }

    function testDeprecations():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/deprecations.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(12, $result->deprecations);
    }

    function testInvalidPhpdocs():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/invalid-phpdocs.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(8, $result->invalidPhpdocs);
    }

    function testUnknownTypes():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/unknown-types.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(7, $result->unknownTypes);
    }

    function testAnonymousVariables():void
    {
        $analyzer = new BaselineAnalyzer(Baseline::forFile(__DIR__ . '/fixtures/anonymous-variables.neon'));
        $result = $analyzer->analyze();

        $this->assertSame(4, $result->anonymousVariables);
    }

}
