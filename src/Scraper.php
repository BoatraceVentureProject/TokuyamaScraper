<?php

declare(strict_types=1);

namespace BVP\TokuyamaScraper;

/**
 * @author shimomo
 */
class Scraper implements ScraperInterface
{
    /**
     * @var \BVP\TokuyamaScraper\ScraperInterface
     */
    private static ?ScraperInterface $instance;

    /**
     * @param  \BVP\TokuyamaScraper\ScraperCoreInterface  $scraper
     * @return void
     */
    public function __construct(private readonly ScraperCoreInterface $scraper) {}

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return array
     */
    public function __call(string $name, array $arguments): array
    {
        return $this->scraper->$name(...$arguments);
    }

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return array
     */
    public static function __callStatic(string $name, array $arguments): array
    {
        return self::getInstance()->$name(...$arguments);
    }

    /**
     * @param  \BVP\TokuyamaScraper\ScraperCoreInterface
     * @return \BVP\TokuyamaScraper\ScraperInterface
     */
    public static function getInstance(?ScraperCoreInterface $scraperCore = null): ScraperInterface
    {
        return self::$instance ??= new self($scraperCore ?? new ScraperCore());
    }

    /**
     * @param  \BVP\TokuyamaScraper\ScraperCoreInterface
     * @return \BVP\TokuyamaScraper\ScraperInterface
     */
    public static function createInstance(?ScraperCoreInterface $scraperCore = null): ScraperInterface
    {
        return self::$instance = new self($scraperCore ?? new ScraperCore());
    }

    /**
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
