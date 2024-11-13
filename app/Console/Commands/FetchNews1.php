<?php

namespace App\Console\Commands;

use Http;
use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Support\Carbon;

class FetchNews1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news1 {category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Fetching ' . $this->argument('category') . ' news...');

            $response = Http::get('https://newsapi.org/v2/top-headlines', [
                'apiKey' => env('NEWS_API_KEY1'),
                'sortBy' => 'popularity',
                'q' => 'news',
                'category' => $this->argument('category'),
            ]);

            if ($response->failed()) {
                $this->error('API request failed: ' . $response->status());
                return $this::FAILURE;
            }

            $data = $response->json();

            if (!isset($data['articles']) || !is_array($data['articles'])) {
                $this->error('Invalid response format: articles not found');
                return $this::FAILURE;
            }

            $count = 0;
            collect($data['articles'])->each(function ($article) use (&$count) {
                try {
                    // Skip articles with no title or duplicate titles
                    if (Article::where('title', $article['title'])->exists()
                        || $article['title'] === null || $article['title'] === '' || $article['title'] === '[Removed]') {
                        return;
                    }

                    Article::create([
                        'title' => $article['title'] ?? null,
                        'source' => $article['source']['name'] ?? null,
                        'category' => $this->argument('category'),
                        'author' => $article['author'] ?? null,
                        'description' => $article['description'] ?? null,
                        'content' => $article['content'] ?? null,
                        'published_at' => $article['publishedAt'] ? Carbon::parse($article['publishedAt']) : null,
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    $this->warn("Failed to save article: {$article['title']} - {$e->getMessage()}");
                }
            });

            $this->info("Successfully imported {$count} articles");
            return $this::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error fetching news: ' . $e->getMessage());
            return $this::FAILURE;
        }
    }
}
