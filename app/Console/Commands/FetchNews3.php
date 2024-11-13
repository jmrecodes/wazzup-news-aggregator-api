<?php

namespace App\Console\Commands;

use Http;
use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Support\Carbon;

class FetchNews3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news3 {category}';

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

            $response = Http::get('https://api.nytimes.com/svc/topstories/v2/' . $this->argument('category') . '.json', [
                'api-key' => env('NEWS_API_KEY3'),
            ]);

            if ($response->failed()) {
                $this->error('API request failed: ' . $response->status());
                return $this::FAILURE;
            }

            $data = $response->json();

            if (!isset($data['results']) || !is_array($data['results'])) {
                $this->error('Invalid response format: articles not found');
                return $this::FAILURE;
            }

            $count = 0;
            collect($data['results'])->each(function ($article) use (&$count) {
                try {
                    // Skip articles with no title or duplicate titles
                    if (Article::where('title', $article['title'])->exists()
                        || $article['title'] === null || $article['title'] === '' || $article['title'] === '[Removed]') {
                        return;
                    }

                    Article::create([
                        'title' => $article['title'] ?? null,
                        'source' => 'New York Times',
                        'category' => $article['section'] ? $article['section'] : $this->argument('category'),
                        'author' => $article['byline'] ?? null,
                        'description' => $article['abstract'] ?? null,
                        'content' => $article['url'] ?? null,
                        'published_at' => $article['published_date'] ? Carbon::parse($article['published_date']) : null,
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
